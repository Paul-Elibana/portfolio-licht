@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-10">
    <div>
        <h1 class="text-4xl font-bold tracking-tight">Mon Profil</h1>
        <p class="text-slate-400 mt-2 text-sm uppercase tracking-widest">Gérez vos informations personnelles et votre photo</p>
    </div>

    @if(session('success'))
        <div class="p-4 bg-accent-primary/20 border border-accent-primary/30 text-accent-primary rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <x-glass-card :hover="false">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <!-- Avatar Section -->
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-slate-300 uppercase tracking-widest">Photo de profil</label>
                    <div class="relative group">
                        <div class="w-40 h-40 rounded-2xl bg-slate-900 border border-white/10 overflow-hidden flex items-center justify-center">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl text-slate-700 font-bold uppercase tracking-tighter">{{ substr($user->name, 0, 2) }}</span>
                            @endif
                        </div>
                        <label for="profile_photo" class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer rounded-2xl">
                            <span class="text-xs font-bold uppercase tracking-widest">Changer</span>
                        </label>
                        <input type="file" id="profile_photo" name="profile_photo" class="hidden" accept="image/*">
                    </div>
                    @error('profile_photo') <p class="text-red-400 text-xs">{{ $message }}</p> @enderror
                </div>

                <!-- Fields Section -->
                <div class="flex-1 w-full space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Nom complet</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent-primary transition-colors">
                            @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent-primary transition-colors">
                            @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <hr class="border-white/5">

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Nouveau mot de passe</label>
                            <input type="password" name="password" placeholder="Laisser vide pour ne pas changer" class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent-primary transition-colors">
                            @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent-primary transition-colors">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-white/5">
                <button type="submit" class="neon-btn">
                    ENREGISTRER LES MODIFICATIONS
                </button>
            </div>
        </form>
    </x-glass-card>
</div>
@endsection
