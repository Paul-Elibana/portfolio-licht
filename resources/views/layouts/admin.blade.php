<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — HubFolio</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">

<div class="flex">
    {{-- ── Sidebar ──────────────────────────────────────── --}}
    <aside class="w-64 fixed h-screen glass border-r border-white/10 p-6 flex flex-col justify-between z-40">
        <div class="space-y-8">

            {{-- Logo --}}
            <a href="{{ route('home') }}" target="_blank"
               class="text-xl font-bold gradient-text tracking-tighter flex items-center gap-1">
                <span class="text-accent-primary text-glow">&lt;</span>PE<span class="text-accent-secondary">/</span><span class="text-accent-primary text-glow">&gt;</span>
                <span class="text-xs text-slate-600 font-normal ml-1 normal-case">↗</span>
            </a>

            {{-- Navigation --}}
            <nav class="space-y-1">
                @php
                $links = [
                    ['route' => 'admin.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Tableau de bord'],
                    ['route' => 'admin.profile',   'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'label' => 'Mon Profil'],
                    ['route' => 'admin.projects',  'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', 'label' => 'Projets'],
                    ['route' => 'admin.skills',    'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'label' => 'Compétences'],
                    ['route' => 'admin.timeline',  'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Parcours'],
                    ['route' => 'admin.services',  'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'label' => 'Services'],
                    ['route' => 'admin.documents', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => 'Assets du site'],
                ];
                @endphp

                @foreach($links as $link)
                    @php $active = request()->routeIs($link['route']) || request()->routeIs($link['route'] . '.*'); @endphp
                    <a href="{{ route($link['route']) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm
                              {{ $active ? 'bg-accent-primary/10 text-accent-primary border border-accent-primary/20' : 'text-slate-400 hover:bg-white/5 hover:text-slate-200' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $link['icon'] }}"/>
                        </svg>
                        <span>{{ $link['label'] }}</span>
                        @if($link['route'] === 'admin.dashboard' && isset($unreadCount) && $unreadCount > 0)
                            <span class="ml-auto w-5 h-5 rounded-full bg-accent-primary text-slate-900 text-[10px] font-bold flex items-center justify-center">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>
                @endforeach

                <div class="border-t border-white/5 pt-2 mt-2">
                    <a href="{{ route('carte') }}" target="_blank"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-slate-400 hover:bg-white/5 hover:text-accent-secondary transition-all">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                        Carte de visite ↗
                    </a>
                </div>
            </nav>
        </div>

        {{-- Footer sidebar --}}
        <div class="space-y-3">
            <div class="px-3 py-2.5 rounded-xl bg-white/3 text-xs text-slate-500 font-mono">
                <span class="text-accent-secondary">{{ Auth::user()->name }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="w-full text-left flex items-center gap-3 px-3 py-2.5 text-sm text-red-400 hover:bg-red-400/10 rounded-xl transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    {{-- ── Main ─────────────────────────────────────────── --}}
    <main class="flex-1 ml-64 p-10 min-h-screen">
        @yield('content')
    </main>
</div>

</body>
</html>
