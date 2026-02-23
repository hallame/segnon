<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Route, Storage};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use App\Support\CurrentAccount;
use App\Models\{Hotel, Room, Booking, Product, Order, User};


class PartnerController extends Controller {


    private function accountId(): int {
        return (int) app(CurrentAccount::class)->id();
    }

    /** Clause réutilisable: items appartenant au compte courant (order_items.account_id || fallback product.account_id) */
    private function itemsBelongingToAccount($q, int $accountId): void {
        $q->where(function ($w) use ($accountId) {
            $w->where('order_items.account_id', $accountId)
              ->orWhere(function ($x) use ($accountId) {
                  $x->whereNull('order_items.account_id')
                    ->whereHas('product', fn($p) => $p->where('account_id', $accountId));
              });
        });
    }





    public function dashboard(Request $request, CurrentAccount $ctx) {
        $user    = $request->user();
        $account = $ctx->get();


        // KPIs scoppés (compte courant)
        $aid = $this->accountId();
        $kbase = Order::query()
            ->where(function ($scoped) use ($aid) {
                $scoped->where('account_id', $aid)
                       ->orWhereHas('items', function ($i) use ($aid) {
                           $this->itemsBelongingToAccount($i, $aid);
                       });
            });



        if (!$account) {
            return redirect()->route('partners.pending')->with('warning', "Votre compte est en attente.");
        }

        // Scope Spatie sur la team courante
        app(PermissionRegistrar::class)->setPermissionsTeamId($account->id);

        // 1) Modules activés via pivot (préféré)
        $mods = $account->modules()
            ->wherePivot('is_enabled', 1)
            ->pluck('modules.slug')   // ⚠️ précise la table
            ->toArray();

        // 2) Fallback : rôles du user dans CET account (si pivot modules vide)
        $roleNames = DB::table('model_has_roles')
            ->join('roles','roles.id','=','model_has_roles.role_id')
            ->where('model_has_roles.model_type', \App\Models\User::class)
            ->where('model_has_roles.model_id', $user->id)
            ->where('model_has_roles.account_id', $account->id)
            ->pluck('roles.name')
            ->toArray();

        $hasHotel   = in_array('hotel', $mods, true)   || collect($roleNames)->contains(fn($r) => str_starts_with($r,'hotel_'));
        $hasArtisan = in_array('artisan', $mods, true) || collect($roleNames)->contains(fn($r) => str_starts_with($r,'artisan_'));

        // -------- HÔTELLERIE --------
        $totalHotels = $totalRooms = $totalBookings = 0;
        $latestBookings = collect();
        $pendingBookings = $confirmedBookings = $canceledBookings = $completedBookings = 0;
        $pendingBookingsPct = $confirmedBookingsPct = $canceledBookingsPct = 0;

        if ($hasHotel) {
            $totalHotels   = \App\Models\Hotel::where('account_id', $account->id)->count();
            $totalRooms    = \App\Models\Room::where('account_id', $account->id)->count();
            $totalBookings = \App\Models\Booking::where('account_id', $account->id)->count();

            $latestBookings = \App\Models\Booking::with(['hotel:id,name','room:id,name'])
                ->where('account_id', $account->id)->latest()->limit(10)->get();

            $pendingBookings   = \App\Models\Booking::where('account_id',$account->id)->whereIn('status',['pending',0,'PENDING'])->count();
            $confirmedBookings = \App\Models\Booking::where('account_id',$account->id)->whereIn('status',['confirmed',1,'CONFIRMED'])->count();
            $canceledBookings  = \App\Models\Booking::where('account_id',$account->id)->whereIn('status',['cancelled','canceled',2,'CANCELLED'])->count();
            $completedBookings = \App\Models\Booking::where('account_id',$account->id)->whereIn('status',['completed',3,'COMPLETED'])->count();

            if ($totalBookings > 0) {
                $pendingBookingsPct   = (int) round(($pendingBookings   / $totalBookings) * 100);
                $confirmedBookingsPct = (int) round(($confirmedBookings / $totalBookings) * 100);
                $canceledBookingsPct  = (int) round(($canceledBookings  / $totalBookings) * 100);
            }
        }

        // -------- BOUTIQUE D’ART --------
        $totalProducts = $totalOrders = 0;
        $totalRevenue  = 0.0;
        $latestOrders  = collect();

        if ($hasArtisan) {
            $totalProducts = \App\Models\Product::where('account_id', $account->id)->count();
            $totalOrders   = (clone $kbase)->count();
            $totalRevenue  = (float) \App\Models\Order::where('account_id', $account->id)
                ->whereIn('status', ['paid','PAID',1])->sum('total');
            $latestOrders = \App\Models\Order::where('account_id', $account->id)->latest()->limit(10)->get();
        }

        return view('backend.partners.dashboard', compact(
            'totalHotels','totalRooms','totalBookings','latestBookings',
            'pendingBookings','confirmedBookings','canceledBookings','completedBookings',
            'pendingBookingsPct','confirmedBookingsPct','canceledBookingsPct',
            'totalProducts','totalOrders','totalRevenue','latestOrders',
        ));
    }


    public function myProfile(Request $request) {
        $user = $request->user();
        return view('backend.partners.account.profile', compact('user'));
    }


    public function updateMyProfile(Request $request) {
        $user = $request->user();

        $validated = $request->validate([
            'firstname' => ['required','string','max:255'],
            'lastname'  => ['required','string','max:255'],
            'email'     => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'phone'     => ['nullable','string','max:20'],
            'address'   => ['nullable','string','max:255'],
            'country'   => ['nullable','string','max:255'],
            'city'      => ['nullable','string','max:255'],
            'postal_code'=>['nullable','string','max:20'],
            'avatar'    => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'current_password' => ['nullable','string','min:6'],
            'new_password'     => ['nullable','string','min:6','confirmed'],
        ]);

        $user->firstname   = $validated['firstname'];
        $user->lastname    = $validated['lastname'];
        $user->email       = $validated['email'];
        $user->phone       = $validated['phone']       ?? $user->phone;
        $user->address     = $validated['address']     ?? $user->address;
        $user->country     = $validated['country']     ?? $user->country;
        $user->city        = $validated['city']        ?? $user->city;
        $user->postal_code = $validated['postal_code'] ?? $user->postal_code;

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('profiles/users', 'public');
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $path;
        }

        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (! Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Le mot de passe actuel est incorrect.');
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();
        return redirect()->route('partners.account.profile')->with('success', 'Profil mis à jour avec succès.');
    }


    public function bookingsIndex(CurrentAccount $ctx) {
        $account = $ctx->account;
        app(PermissionRegistrar::class)->setPermissionsTeamId($account?->id);

        $q = Booking::with(['hotel:id,name','room:id,name'])
            ->where('account_id', $account->id)
            ->latest();

        if (request('status')) {
            $status = request('status');
            $q->where('status', $status);
        }

        $bookings = $q->paginate(20);
        return view('backend.partners.bookings.index', compact('bookings'));
    }

    public function bookingsShow(CurrentAccount $ctx, Booking $booking) {
        $account = $ctx->account;
        abort_unless($booking->account_id === $account?->id, 404);

        $booking->load(['hotel','room']);
        return view('backend.partners.bookings.show', compact('booking'));
    }


    public function ordersIndex(CurrentAccount $ctx) {
        $account = $ctx->account;
        app(PermissionRegistrar::class)->setPermissionsTeamId($account?->id);

        $q = Order::where('account_id', $account->id)->latest();

        if ($status = request('status')) {
            $q->where('status', $status);
        }

        if ($qstr = request('q')) {
            $q->where(function($qq) use ($qstr) {
                $qq->where('reference','like',"%$qstr%")
                   ->orWhere('customer_name','like',"%$qstr%")
                   ->orWhere('customer_email','like',"%$qstr%");
            });
        }

        $orders = $q->paginate(20);
        return view('backend.partners.orders.index', compact('orders'));
    }

    public function ordersShow(CurrentAccount $ctx, Order $order) {
        $account = $ctx->account;
        abort_unless($order->account_id === $account?->id, 404);

        if (method_exists($order, 'items')) {
            $order->load('items.product');
        }
        return view('backend.partners.orders.show', compact('order'));
    }


}
