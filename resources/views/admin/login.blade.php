<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | HubFolio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-glow text-accent-primary uppercase tracking-widest">ADMIN ACCESS</h1>
            <p class="mt-2 text-slate-400">HubFolio Management System</p>
        </div>

        <a href="{{ url('/') }}" class="text-center text-sm text-accent-primary hover:underline mb-6 block">
            Retour au portfolio public
        </a>

        <x-glass-card :hover="false">
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent-primary transition-colors">
                    @error('email') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Mot de passe</label>
                    <input type="password" name="password" required class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent-primary transition-colors">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-white/10 bg-slate-900 text-accent-primary focus:ring-accent-primary">
                    <label for="remember" class="ml-2 text-sm text-slate-400 text-slate-400">Se souvenir de moi</label>
                </div>

                <button type="submit" class="w-full neon-btn">
                    DÉVERROUILLER
                </button>
            </form>
        </x-glass-card>

        <p class="text-center text-xs text-slate-600 font-mono uppercase tracking-tighter">
            SECURITY LEVEL 01 // {{ date('Y') }}
        </p>
    </div>

</body>
</html>
