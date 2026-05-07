<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard | HubFolio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 fixed h-screen glass border-r border-white/10 p-6 flex flex-col justify-between">
            <div class="space-y-8">
                <div class="text-xl font-bold text-glow text-accent-primary uppercase tracking-tighter">
                    HUBFOLIO.ADMIN
                </div>
                
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-accent-primary' : 'text-slate-400' }}">
                        <span>🏠</span> Tableau de bord
                    </a>
                    <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all {{ request()->routeIs('admin.profile') ? 'bg-white/10 text-accent-primary' : 'text-slate-400' }}">
                        <span>👤</span> Mon Profil
                    </a>
                    <a href="{{ route('admin.projects') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all {{ request()->routeIs('admin.projects') ? 'bg-white/10 text-accent-primary' : 'text-slate-400' }}">
                        <span>🚀</span> Gérer les projets
                    </a>
                    <a href="{{ route('admin.skills') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all {{ request()->routeIs('admin.skills') ? 'bg-white/10 text-accent-primary' : 'text-slate-400' }}">
                        <span>⚡</span> Gérer les compétences
                    </a>
                    <a href="{{ route('admin.documents') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all {{ request()->routeIs('admin.documents') ? 'bg-white/10 text-accent-primary' : 'text-slate-400' }}">
                        <span>📁</span> Documents sécurisés
                    </a>
                </nav>
            </div>

            <div class="space-y-4">
                <div class="p-4 rounded-xl bg-white/5 text-xs text-slate-500 font-mono uppercase">
                    LOGGED AS: <span class="text-accent-secondary">{{ Auth::user()->name }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left p-3 text-red-400 hover:bg-red-400/10 rounded-xl transition-all">
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-10">
            @yield('content')
        </main>
    </div>

</body>
</html>
