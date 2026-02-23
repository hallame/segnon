<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Account;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminFaqController extends Controller {

    public function index(Request $request) {
        $q          = (string) $request->get('q', '');
        $active     = $request->get('active');        // '1' | '0' | null
        $categoryId = $request->get('category_id');   // id | null
        $accountId  = $request->get('account_id');    // id | null

        $faqs = Faq::query()
            ->with(['category','account']) // <- important
            // ->search($q) si tu veux réutiliser ton scope :
            ->when($q !== '', fn($qq) => $qq->where(fn($w) => $w
                ->where('question','like',"%{$q}%")
                ->orWhere('answer','like',"%{$q}%")
                ->orWhere('slug','like',"%{$q}%")
            ))
            ->when($accountId,  fn($qq) => $qq->where('account_id', $accountId))
            ->when($categoryId, fn($qq) => $qq->where('category_id', $categoryId))
            ->when($active !== null && $active !== '', fn($qq) =>
                $qq->where('active', filter_var($active, FILTER_VALIDATE_BOOLEAN))
            )
            ->orderBy('position')->orderByDesc('id')
            ->paginate(18)->withQueryString();

        $categories = Category::query()->orderBy('name')->pluck('name', 'id');
        $accounts   = Account::query()->orderBy('name')->pluck('name', 'id');

        return view('backend.admin.faqs.index', compact(
            'faqs', 'categories', 'accounts', 'q', 'active', 'categoryId', 'accountId'
        ));
    }

    public function create() {
        $faq        = new Faq();
        $categories = Category::query()->orderBy('name')->pluck('name', 'id');
        $accounts   = Account::query()->orderBy('name')->pluck('name', 'id');

        return view('backend.admin.faqs.create', compact('faq', 'categories', 'accounts'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'question'    => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:faqs,slug'],
            'answer'      => ['required', 'string', 'min:3'],
            'account_id'  => ['nullable', 'integer', 'exists:accounts,id'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'position'    => ['nullable', 'integer', 'min:0'],
            'active'      => ['nullable', 'boolean'],
        ]);

        // Defaults
        $data['active']   = $request->has('active') ? $request->boolean('active') : true;
        $data['position'] = (int)($data['position'] ?? 0);

        // Slug auto si vide
        if (empty($data['slug'])) {
            $data['slug'] = $this->uniqueSlug($data['question']);
        }

        Faq::create($data);

        return redirect()
            ->route('admin.faqs.index')
            ->with('success', 'FAQ créée avec succès.');
    }

    public function edit(Faq $faq) {
        $categories = Category::query()->orderBy('name')->pluck('name', 'id');
        $accounts   = Account::query()->orderBy('name')->pluck('name', 'id');

        return view('backend.admin.faqs.edit', compact('faq', 'categories', 'accounts'));
    }

    public function update(Request $request, Faq $faq) {
        $data = $request->validate([
            'question'    => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', Rule::unique('faqs', 'slug')->ignore($faq->id)],
            'answer'      => ['required', 'string', 'min:3'],
            'account_id'  => ['nullable', 'integer', 'exists:accounts,id'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'position'    => ['nullable', 'integer', 'min:0'],
            'active'      => ['nullable', 'boolean'],
        ]);

        $data['active']   = $request->has('active') ? $request->boolean('active') : $faq->active;
        $data['position'] = (int)($data['position'] ?? $faq->position ?? 0);

        if (empty($data['slug'])) {
            $data['slug'] = $this->uniqueSlug($data['question'], $faq->id);
        }

        $faq->update($data);

        return redirect()
            ->route('admin.faqs.index')
            ->with('success', 'FAQ mise à jour.');
    }

    public function destroy(Faq $faq) {
        $faq->delete();

        return redirect()
            ->route('admin.faqs.index')
            ->with('success', 'FAQ supprimée.');
    }

    public function reorder(Request $request) {
        $data = $request->validate(['items' => ['required','array']]);
        // items = [5,12,3,...]
        $position = 0;
        $rows = collect($data['items'])->map(fn($id) => ['id' => (int)$id, 'position' => $position++])->all();
        // upsert = 1 requête
        Faq::upsert($rows, ['id'], ['position']);
        return response()->json(['success' => true]);
    }


    public function toggle(Request $request, Faq $faq) {
        // Si 'active' est posté => on prend la valeur ; sinon on inverse
        if ($request->has('active')) {
            $faq->active = (bool) $request->boolean('active');
        } else {
            $faq->active = ! $faq->active;
        }
        $faq->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'id'      => $faq->id,
                'active'  => $faq->active,
            ]);
        }

        return back()->with('success', 'Statut mis à jour.');
    }



    /**
     * Génère un slug unique à partir d'un texte (question ou slug fourni).
     */


    private function uniqueSlug(string $source, ?int $ignoreId = null): string {
        $base = Str::slug(Str::limit($source, 60, '')) ?: Str::random(6);
        $slug = $base; $i = 2;

        while (
            Faq::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '<>', $ignoreId)) // <- corrige ici
                ->exists()
        ) {
            $slug = $base.'-'.$i++;
            if ($i > 200) { $slug = $base.'-'.Str::random(3); break; }
        }
        return $slug;
    }
    
}
