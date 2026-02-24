@extends('frontend.layouts.master')

@section('title', 'Contact • MYLMARK')
@section('meta_title', 'Contactez-nous • MYLMARK')
@section('meta_description', "Une question, une demande de partenariat ou besoin d'aide ? Contactez l'équipe MYLMARK.")
@section('meta_image', asset('assets/images/contact.jpg'))
@section('meta_url', route('contact'))

@section('content')
<!-- ═══════════════════════════════════
     CONTACT
═══════════════════════════════════ -->
<section class="py-28 px-6 md:px-14 bg-ivory grid grid-cols-1 lg:grid-cols-2 gap-20" id="contact">

    <!-- Info -->
    <div class="reveal">
      <div class="flex items-center gap-2 mb-4">
        <span class="w-6 h-0.5 bg-amber rounded-full"></span>
        <span class="text-xs font-bold tracking-[.18em] uppercase text-amber">Contact</span>
      </div>
      <h2 class="font-display font-black text-ink leading-none tracking-tight mb-5" style="font-size:clamp(36px,4vw,64px)">
        Parlons de<br>votre <em class="italic text-amber">projet.</em>
      </h2>
      <p class="text-ink-muted text-base leading-relaxed mb-10 font-light max-w-md">Une question, une commande spéciale ou un devis sur-mesure ? Notre équipe vous répond rapidement.</p>
  
      <div class="flex flex-col gap-4">
        <div class="flex items-center gap-4 p-5 rounded-2xl border border-ivory-dark bg-white hover:border-amber hover:bg-amber-pale transition-all group cursor-pointer">
          <div class="w-12 h-12 rounded-xl bg-emerald-light flex items-center justify-center text-xl group-hover:scale-110 transition-transform">💬</div>
          <div>
            <div class="text-[11px] font-bold uppercase tracking-wider text-ink-muted">WhatsApp</div>
            <div class="font-semibold text-ink-soft mt-0.5">+229 00 00 00 00</div>
          </div>
        </div>
        <div class="flex items-center gap-4 p-5 rounded-2xl border border-ivory-dark bg-white hover:border-amber hover:bg-amber-pale transition-all group cursor-pointer">
          <div class="w-12 h-12 rounded-xl bg-amber-pale flex items-center justify-center text-xl group-hover:scale-110 transition-transform">📞</div>
          <div>
            <div class="text-[11px] font-bold uppercase tracking-wider text-ink-muted">Téléphone</div>
            <div class="font-semibold text-ink-soft mt-0.5">+229 00 00 00 00</div>
          </div>
        </div>
        <div class="flex items-center gap-4 p-5 rounded-2xl border border-ivory-dark bg-white hover:border-amber hover:bg-amber-pale transition-all group cursor-pointer">
          <div class="w-12 h-12 rounded-xl bg-gold-pale flex items-center justify-center text-xl group-hover:scale-110 transition-transform">📍</div>
          <div>
            <div class="text-[11px] font-bold uppercase tracking-wider text-ink-muted">Adresse</div>
            <div class="font-semibold text-ink-soft mt-0.5">Cotonou, Bénin</div>
          </div>
        </div>
        <div class="flex items-center gap-4 p-5 rounded-2xl border border-ivory-dark bg-white hover:border-amber hover:bg-amber-pale transition-all group cursor-pointer">
          <div class="w-12 h-12 rounded-xl bg-emerald-light flex items-center justify-center text-xl group-hover:scale-110 transition-transform">🕐</div>
          <div>
            <div class="text-[11px] font-bold uppercase tracking-wider text-ink-muted">Horaires</div>
            <div class="font-semibold text-ink-soft mt-0.5">Lun – Sam : 8h00 – 19h00</div>
          </div>
        </div>
      </div>
    </div>
  
    <!-- Form -->
    <div class="reveal delay-1">
      <div class="bg-white border border-ivory-dark rounded-3xl p-10 shadow-sm">
        <div class="font-display font-bold text-2xl text-ink mb-8">Envoyer un message ✉️</div>
        <form onsubmit="submitForm(event)">
          <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
              <label class="text-[11px] font-bold uppercase tracking-wider text-ink-muted block mb-2">Prénom & Nom</label>
              <input type="text" placeholder="Aminata Coulibaly" required class="form-field w-full px-4 py-3 bg-ivory rounded-xl border border-ivory-dark text-ink text-sm outline-none placeholder-ink-faint">
            </div>
            <div>
              <label class="text-[11px] font-bold uppercase tracking-wider text-ink-muted block mb-2">Téléphone</label>
              <input type="tel" placeholder="+229 XX XX XX" required class="form-field w-full px-4 py-3 bg-ivory rounded-xl border border-ivory-dark text-ink text-sm outline-none placeholder-ink-faint">
            </div>
          </div>
          <div class="mb-4">
            <label class="text-[11px] font-bold uppercase tracking-wider text-ink-muted block mb-2">Email</label>
            <input type="email" placeholder="votre@email.com" class="form-field w-full px-4 py-3 bg-ivory rounded-xl border border-ivory-dark text-ink text-sm outline-none placeholder-ink-faint">
          </div>
          <div class="mb-4">
            <label class="text-[11px] font-bold uppercase tracking-wider text-ink-muted block mb-2">Catégorie</label>
            <select class="form-field w-full px-4 py-3 bg-ivory rounded-xl border border-ivory-dark text-ink text-sm outline-none appearance-none">
              <option value="">Choisir une catégorie</option>
              <option>Rideaux</option><option>Draps</option>
              <option>Quincaillerie</option><option>Décoration</option>
              <option>Plusieurs catégories</option>
            </select>
          </div>
          <div class="mb-6">
            <label class="text-[11px] font-bold uppercase tracking-wider text-ink-muted block mb-2">Message</label>
            <textarea rows="4" placeholder="Décrivez votre projet, dimensions, couleurs souhaitées..." class="form-field w-full px-4 py-3 bg-ivory rounded-xl border border-ivory-dark text-ink text-sm outline-none placeholder-ink-faint resize-none"></textarea>
          </div>
          <button type="submit" id="formBtn" class="w-full py-4 bg-ink text-white font-bold rounded-xl text-sm flex items-center justify-center gap-3 hover:bg-amber transition-colors duration-300 shadow-lg">
            <span>✉️</span> Envoyer le message
          </button>
        </form>
      </div>
    </div>
  </section>
  
@endsection
