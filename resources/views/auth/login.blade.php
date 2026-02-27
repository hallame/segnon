@extends('auth.layouts.master')
@section('content')

  <main class="relative flex-1 flex items-center justify-center py-10">
    <div class="max-w-xl mx-auto px-4 sm:px-6 w-full">
      @if (session('status'))
        <div class="mb-4 rounded-xl border border-emerald-300/40 bg-emerald-100/10 text-emerald-100 px-4 py-3">
          {{ session('status') }}
        </div>
      @endif
      @if ($errors->any())
        <div class="mb-4 rounded-xl border border-amber-300/40 bg-amber-100/10 text-amber-100 px-4 py-3">
          Merci de vérifier vos identifiants.
        </div>
      @endif

      <form method="POST" action="{{ route('login.store') }}" novalidate class="card overflow-hidden">
        @csrf

        <div class="p-6 sm:p-8 space-y-4">
          <div>
            <label for="email" class="lbl">Email</label>
            <input id="email" type="email" name="email" class="inp" placeholder="exemple@email.com"
                  value="{{ old('email') }}" autocomplete="email" required autofocus>
            @error('email') <div class="err">{{ $message }}</div> @enderror
          </div>

          <div>
            <label for="password" class="lbl">Mot de passe</label>
            <div class="relative">
              <input id="password" type="password" name="password" class="inp pr-10" placeholder="••••••••"
                    autocomplete="current-password" required>
              <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 px-2 py-1 text-white/80"
                      data-toggle="#password">👁️</button>
            </div>
            @error('password') <div class="err">{{ $message }}</div> @enderror
          </div>

          <div class="flex items-center justify-between gap-3 flex-wrap">
            <label class="inline-flex items-center gap-2 text-sm text-white/80 select-none">
              <input id="remember" type="checkbox" name="remember" class="rounded border-white/30 bg-white/10 text-emerald-500 focus:ring-emerald-500" @checked(old('remember'))>
              Se souvenir de moi
            </label>

            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="text-sm underline decoration-emerald-400/60 hover:decoration-emerald-300">Mot de passe oublié ?</a>
            @endif
          </div>
        </div>

        <div class="px-6 sm:px-8 pb-6 sm:pb-8">
            <div class="flex items-center justify-between gap-3">
                <a href="{{ url()->previous() }}" class="btn-ghost shrink-0">← Retour</a>
                <button class="btn shrink-0 whitespace-nowrap" type="submit">Se connecter</button>
            </div>
        </div>
      </form>
    </div>
  </main>
@endsection