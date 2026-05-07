@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-10">
    <div>
        <h1 class="text-4xl font-bold tracking-tight">Mon Profil</h1>
        <p class="text-slate-400 mt-2 text-sm uppercase tracking-widest">Informations affichees sur le portfolio</p>
    </div>

    @if(session('success'))
        <div class="p-4 bg-accent-primary/20 border border-accent-primary/30 text-accent-primary rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    <x-glass-card :hover="false">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="flex flex-col sm:flex-row gap-8 items-start">
                {{-- Photo de profil avec apercu instantane --}}
                <div class="space-y-3">
                    <label class="block text-xs text-slate-400 uppercase tracking-widest">Photo de profil</label>
                    <div class="relative group w-40 h-40">
                        <div class="w-40 h-40 rounded-2xl overflow-hidden bg-slate-900 border border-white/10">
                            <img id="profile-preview"
                                 src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) . '?v=' . ($user->updated_at?->timestamp ?? time()) : '' }}"
                                 alt="Photo"
                                 class="{{ $user->profile_photo ? 'block' : 'hidden' }} w-full h-full object-cover">
                            <div id="profile-placeholder"
                                 class="{{ $user->profile_photo ? 'hidden' : 'flex' }} w-full h-full items-center justify-center text-4xl font-bold text-slate-700 uppercase">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                        </div>
                        <label for="profile_photo"
                               class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer rounded-2xl gap-1">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-[10px] text-white font-medium">Changer</span>
                        </label>
                        <input type="file" id="profile_photo" name="profile_photo" class="hidden" accept="image/*">
                    </div>
                    <p class="text-[10px] text-slate-600 leading-relaxed">JPG, PNG, WEBP - Max 3Mo<br>Apercu instantane avant enregistrement</p>
                    @error('profile_photo') <p class="text-red-400 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Champs --}}
                <div class="flex-1 space-y-5 w-full">
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Nom complet *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="contact-input">
                            @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Email *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="contact-input">
                            @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="border-t border-white/5 pt-5">
                        <p class="text-xs text-slate-500 mb-4 uppercase tracking-wide">Mot de passe (optionnel)</p>
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Nouveau mot de passe</label>
                                <input type="password" name="password" placeholder="Laisser vide = inchange" class="contact-input">
                                @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Confirmer</label>
                                <input type="password" name="password_confirmation" class="contact-input">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-white/5">
                <button type="submit" class="neon-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </x-glass-card>
</div>

<script>
document.getElementById('profile_photo')?.addEventListener('change', function() {
    const file = this.files[0];
    if (!file || !file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('profile-preview');
        const placeholder = document.getElementById('profile-placeholder');
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(file);
});
</script>
@endsection
