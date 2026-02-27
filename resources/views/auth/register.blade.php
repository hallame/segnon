@extends('auth.layouts.master')
@section('content')
    <header class="relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 text-center">
            <span class="inline-flex items-center gap-2 text-[11px] tracking-[0.18em] uppercase px-3 py-1 rounded-full bg-white/10 ring-1 ring-white/15 text-white/90">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[14px] w-[14px]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-width="2" d="M12 3l2.3 4.7L20 9l-4 3.9L17 20l-5-2.6L7 20l1-7.1L4 9l5.7-1.3L12 3z"/>
                </svg>
                Je crée mon compte
            </span>
            <!-- petits avantages -->
            <div class="mt-6 flex flex-wrap items-center justify-center gap-2">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs text-white/90">
                    ✔ Gratuit
                </span>
                <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs text-white/90">
                    ⚡ Rapide
                </span>
                <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs text-white/90">
                    🔒 Sécurisé
                </span>
            </div>
        </div>
    </header>
    <main class="relative pb-12">
      <div class="max-w-4xl mx-auto px-4 sm:px-6">
        @if ($errors->any())
          <div class="mb-4 rounded-xl border border-amber-300/40 bg-amber-100/10 text-amber-100 px-4 py-3">
            Merci de corriger les champs indiqués ci-dessous.
          </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}" class="card overflow-hidden">
          @csrf

          <div class="grid sm:grid-cols-2 gap-4 p-6 sm:p-8">
            <div>
              <label for="firstname" class="lbl">Prénom</label>
              <input id="firstname" name="firstname" type="text" class="inp" placeholder="Votre prénom" value="{{ old('firstname') }}" required>
              @error('firstname') <div class="err">{{ $message }}</div> @enderror
            </div>
            <div>
              <label for="lastname" class="lbl">Nom</label>
              <input id="lastname" name="lastname" type="text" class="inp" placeholder="Votre nom" value="{{ old('lastname') }}" required>
              @error('lastname') <div class="err">{{ $message }}</div> @enderror
            </div>

            <div>
              <label for="email" class="lbl">Email</label>
              <input id="email" name="email" type="email" class="inp" placeholder="mon@email.com" value="{{ old('email') }}" required>
              @error('email') <div class="err">{{ $message }}</div> @enderror
            </div>
            <div>
              <label for="phone" class="lbl">Téléphone (optionnel)</label>
              <input id="phone" name="phone" type="tel" class="inp" placeholder="Ex: +123" value="{{ old('phone') }}">
              @error('phone') <div class="err">{{ $message }}</div> @enderror
            </div>

            <div>
              <label for="password" class="lbl">Mot de passe</label>
              <div class="relative">
                <input id="password" name="password" type="password" class="inp pr-10" placeholder="••••••••" minlength="6" required>
                <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 px-2 py-1 text-white/80" data-toggle="#password" aria-label="Afficher/Masquer">👁️</button>
              </div>
              @error('password') <div class="err">{{ $message }}</div> @enderror
            </div>
            <div>
              <label for="password_confirmation" class="lbl">Confirmer</label>
              <input id="password_confirmation" name="password_confirmation" type="password" class="inp" placeholder="Répétez le mot de passe" required>
            </div>
          </div>

          <div class="px-6 sm:px-8 pb-6 sm:pb-8">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:justify-between">
              <div class="text-white/70 text-sm">En créant votre compte, vous acceptez nos conditions d’utilisation.</div>
              <div class="flex gap-2">
                <a href="{{ url('/') }}" class="btn-ghost">← </a>
                <button type="submit" class="btn">Créer mon compte</button>
              </div>
            </div>
            <div class="mt-3 text-sm">
              <span class="text-white/70">Déjà inscrit ?</span>
              <a href="{{ route('login') }}" class="font-semibold underline decoration-emerald-400/60 hover:decoration-emerald-300">Se connecter</a>
            </div>
          </div>
        </form>
      </div>
    </main>
@endsection