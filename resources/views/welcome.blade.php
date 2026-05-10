<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Paul Edwen Elibana Mbadinga — Développeur Full-Stack</title>
    <meta name="description" content="Portfolio de Paul Edwen Elibana Mbadinga, développeur Full-Stack basé à Libreville, Gabon. Spécialisé en Laravel, Vue.js et interfaces futuristes.">

    {{-- Open Graph --}}
    <meta property="og:title" content="Paul Edwen Elibana Mbadinga — Développeur Full-Stack">
    <meta property="og:description" content="Portfolio full-stack — Laravel, Vue.js, Tailwind CSS. Disponible pour missions depuis Libreville, Gabon.">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:url" content="{{ url('/') }}">
    @if(isset($adminUser) && $adminUser->profile_photo)
        <meta property="og:image" content="{{ asset('storage/'.$adminUser->profile_photo) }}">
    @elseif(isset($assets['hero']) && $assets['hero']->first())
        <meta property="og:image" content="{{ asset('storage/'.$assets['hero']->first()->document_path) }}">
    @endif
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Paul Edwen Elibana Mbadinga — Développeur Full-Stack">
    <meta name="twitter:description" content="Portfolio full-stack — Laravel, Vue.js, Tailwind CSS.">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen text-slate-200 overflow-x-hidden">

{{-- ═══════════════════════════════════ NAV ═══════════════════════════════════ --}}
<nav id="main-nav" class="nav-base">
    <div class="max-w-7xl mx-auto flex justify-between items-center">

        {{-- Logo --}}
        <a href="{{ route('login') }}" class="text-xl font-bold gradient-text tracking-tighter flex items-center gap-2 shrink-0">
            <span class="text-accent-primary text-glow">&lt;</span>PE<span class="text-accent-secondary">/</span><span class="text-accent-primary text-glow">&gt;</span>
        </a>

        {{-- Desktop menu --}}
        <div class="hidden md:flex items-center gap-1 glass px-6 py-2.5 rounded-full">
            @foreach(['about' => 'À propos', 'timeline' => 'Parcours', 'skills' => 'Skills', 'projects' => 'Projets', 'services' => 'Services', 'contact' => 'Contact'] as $id => $label)
                <a href="#{{ $id }}" class="nav-link text-slate-300 hover:text-accent-primary transition-colors px-4 py-1.5 rounded-full text-sm font-medium hover:bg-white/5">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Right side --}}
        <div class="hidden md:flex items-center gap-4">
            <div class="text-xs font-mono text-slate-500">
                <span class="text-accent-primary counter-value" data-target="{{ $stats['views'] }}">0</span> VIEWS
            </div>
            <a href="{{ route('carte') }}" target="_blank" class="neon-btn text-sm py-2 px-5">Me contacter</a>
        </div>

        {{-- Hamburger --}}
        <button id="hamburger-btn" aria-label="Menu" aria-expanded="false" class="md:hidden flex flex-col gap-1.5 p-2">
            <span class="hamburger-line w-6"></span>
            <span class="hamburger-line w-4"></span>
            <span class="hamburger-line w-6"></span>
        </button>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="md:hidden overflow-hidden max-h-0 transition-all duration-500" style="max-height:0">
        <div class="glass-strong mx-4 my-2 rounded-2xl p-5 flex flex-col gap-2">
            @foreach(['about' => 'À propos', 'timeline' => 'Parcours', 'skills' => 'Skills', 'projects' => 'Projets', 'services' => 'Services', 'contact' => 'Contact'] as $id => $label)
                <a href="#{{ $id }}" class="nav-link text-slate-300 hover:text-accent-primary transition-colors py-2.5 px-4 rounded-xl hover:bg-white/5 text-sm font-medium">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-6">

    {{-- ══════════════════════════ HERO ══════════════════════════ --}}
    <section id="hero" class="relative min-h-screen flex items-center pt-24 pb-16 overflow-hidden">

        {{-- ░░ ZONE ASSET : hero / bannière ░░ — Uploader un asset de type "Hero / Bannière" dans Assets du site --}}
        @if(isset($assets['hero']) && $assets['hero']->first())
            <div class="absolute inset-0 pointer-events-none" style="z-index:0">
                <img src="{{ $assets['hero']->first()->url }}" alt="Hero"
                     class="w-full h-full object-cover opacity-15">
                <div class="absolute inset-0 bg-gradient-to-b from-slate-950/80 via-slate-950/60 to-slate-950"></div>
            </div>
        @endif

        {{-- Canvas particles --}}
        <canvas id="hero-canvas" class="absolute inset-0 w-full h-full pointer-events-none" style="z-index:1"></canvas>

        {{-- Decorative blobs --}}
        <div class="absolute top-1/4 left-0 w-96 h-96 bg-accent-primary/5 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-0 w-96 h-96 bg-accent-secondary/5 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="relative z-10 grid lg:grid-cols-2 gap-16 items-center w-full">

            {{-- Text --}}
            <div class="space-y-8">
                @if(!isset($adminUser) || $adminUser->is_available !== false)
                <div class="flex items-center gap-3">
                    <x-badge variant="primary">DISPONIBLE POUR MISSIONS</x-badge>
                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse inline-block"></span>
                </div>
                @endif

                <div class="space-y-3">
                    <p class="text-slate-400 text-sm uppercase tracking-[0.25em] font-medium">Bonjour, je suis</p>
                    <h1 class="text-5xl md:text-6xl xl:text-7xl font-bold leading-[1.05]">
                        Paul Edwen<br>
                        <span class="gradient-text-animated">Elibana Mbadinga</span>
                    </h1>
                    <div class="text-2xl md:text-3xl font-semibold text-slate-300 h-10 flex items-center">
                        <span id="typing-text" class="typing-cursor text-accent-primary"></span>
                    </div>
                </div>

                <p class="text-base text-slate-400 max-w-lg leading-relaxed">
                    Basé à <span class="text-slate-300 font-medium">Libreville, Gabon</span>, je conçois des applications web
                    performantes et des interfaces haut de gamme. Mon obsession : transformer des idées complexes
                    en expériences digitales élégantes et mémorables.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="#projects" class="neon-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Voir mes projets
                    </a>
                    <a href="{{ route('carte') }}" target="_blank" class="ghost-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Me contacter
                    </a>
                </div>

                {{-- Social quick links --}}
                <div class="flex items-center gap-5 pt-2">
                    @if($adminUser?->github_url)
                    <a href="{{ $adminUser->github_url }}" target="_blank" rel="noopener" class="text-slate-500 hover:text-accent-primary transition-colors" aria-label="GitHub">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.745.083-.729.083-.729 1.205.084 1.84 1.237 1.84 1.237 1.07 1.834 2.807 1.304 3.492.997.108-.775.418-1.305.762-1.604-2.665-.305-5.467-1.332-5.467-5.93 0-1.31.47-2.38 1.235-3.22-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.3 1.23A11.51 11.51 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.91 1.235 3.22 0 4.61-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222 0 1.606-.015 2.896-.015 3.286 0 .322.216.694.825.576C20.565 21.796 24 17.3 24 12c0-6.63-5.37-12-12-12z"/></svg>
                    </a>
                    @endif
                    @if($adminUser?->phone)
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $adminUser->phone) }}" target="_blank" rel="noopener" class="text-slate-500 hover:text-green-400 transition-colors" aria-label="WhatsApp">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                    @endif
                    <span class="text-white/10">|</span>
                    <span class="text-xs font-mono text-slate-600">{{ $adminUser?->location ?? 'Libreville, Gabon' }} 🌍</span>
                </div>
            </div>

            {{-- Avatar --}}
            <div class="relative flex justify-center lg:justify-end">
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="w-72 h-72 rounded-full border border-accent-primary/10 animate-spin-slow"></div>
                    <div class="absolute w-56 h-56 rounded-full border border-accent-secondary/10 animate-spin-reverse"></div>
                </div>
                <div class="relative avatar-float">
                    <div class="absolute inset-0 bg-accent-primary/20 blur-[80px] rounded-full"></div>
                    <div class="relative w-72 h-72 md:w-80 md:h-80 rounded-full overflow-hidden bg-slate-950 border-2 border-white/10">
                        @if($adminUser && $adminUser->profile_photo)
                            {{-- ░░ ZONE : photo de profil admin ░░ --}}
                            <img src="{{ asset('storage/' . $adminUser->profile_photo) }}?v={{ $adminUser->updated_at?->timestamp ?? time() }}"
                                 alt="Photo de profil de {{ $adminUser->name }}"
                                 class="w-full h-full object-cover">
                        @elseif(isset($assets['profil']) && $assets['profil']->first())
                            {{-- ░░ ZONE ASSET : profil ░░ — Uploader un asset de type "Photo de profil" dans Assets du site --}}
                            <img src="{{ $assets['profil']->first()->url }}"
                                 alt="{{ $adminUser->name ?? 'Profil' }}"
                                 class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/default-avatar.svg') }}"
                                 alt="Avatar par défaut"
                                 class="w-full h-full object-cover">
                        @endif
                    </div>
                    {{-- Badge flottant --}}
                    <div class="absolute -bottom-4 -right-4 glass rounded-2xl px-4 py-3 text-center border border-accent-primary/20">
                        <div class="text-2xl font-bold text-accent-primary counter-value" data-target="2" data-suffix="+">0</div>
                        <div class="text-xs text-slate-500 uppercase tracking-wide">Ans d'exp.</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-slate-600 animate-bounce">
            <span class="text-xs uppercase tracking-widest">Scroll</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>
    </section>

    {{-- ══════════════════════════ STATS ══════════════════════════ --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-8 section-reveal">
        @foreach([
            ['value' => count($projects), 'suffix' => '+', 'label' => 'Projets réalisés'],
            ['value' => 2,  'suffix' => '+', 'label' => 'Années d\'expérience'],
            ['value' => $stats['views'], 'suffix' => '', 'label' => 'Visites totales'],
            ['value' => $stats['unique'], 'suffix' => '', 'label' => 'Visiteurs uniques'],
        ] as $stat)
            <x-glass-card :hover="false" class="text-center py-6">
                <div class="text-3xl font-bold text-accent-primary mb-1 counter-value" data-target="{{ $stat['value'] }}" data-suffix="{{ $stat['suffix'] }}">0</div>
                <div class="text-xs uppercase tracking-widest text-slate-500">{{ $stat['label'] }}</div>
            </x-glass-card>
        @endforeach
    </div>

    <div class="section-divider"></div>

    {{-- ══════════════════════════ À PROPOS ══════════════════════════ --}}
    <section id="about" class="py-20">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <div class="space-y-6 section-reveal">
                <x-badge variant="secondary">À PROPOS</x-badge>
                <h2 class="text-4xl md:text-5xl font-bold leading-tight">
                    Construire le web <br><span class="gradient-text">de demain</span>
                </h2>
                <p class="text-slate-400 leading-relaxed">
                    Passionné par l'intersection entre technologie et design, je développe des applications web qui marient
                    performance technique et esthétique soignée. Chaque projet est pour moi une opportunité de repousser les
                    limites du possible dans le monde numérique.
                </p>
                <p class="text-slate-400 leading-relaxed">
                    Mon parcours m'a conduit à maîtriser l'ensemble de la chaîne de développement — de la conception
                    de bases de données robustes à la création d'interfaces utilisateurs mémorables. Je crois fermement
                    que le code de qualité et le beau design ne sont pas des compromis, mais des complémentaires.
                </p>
                <div class="flex gap-4 pt-2">
                    <a href="#contact" class="neon-btn text-sm">Travaillons ensemble</a>
                    <a href="https://github.com/Paul-Elibana" target="_blank" rel="noopener" class="ghost-btn text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.745.083-.729.083-.729 1.205.084 1.84 1.237 1.84 1.237 1.07 1.834 2.807 1.304 3.492.997.108-.775.418-1.305.762-1.604-2.665-.305-5.467-1.332-5.467-5.93 0-1.31.47-2.38 1.235-3.22-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.3 1.23A11.51 11.51 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.91 1.235 3.22 0 4.61-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222 0 1.606-.015 2.896-.015 3.286 0 .322.216.694.825.576C20.565 21.796 24 17.3 24 12c0-6.63-5.37-12-12-12z"/></svg>
                        Mon GitHub
                    </a>
                </div>
            </div>

            {{-- ░░ ZONE ASSET : illustration ░░ — Uploader un asset de type "Illustration" dans Assets du site --}}
            @if(isset($assets['illustration']) && $assets['illustration']->first())
                <div class="rounded-2xl overflow-hidden glass border border-white/10 mb-5 section-reveal">
                    <img src="{{ $assets['illustration']->first()->url }}"
                         alt="Illustration à propos"
                         class="w-full h-52 object-cover">
                </div>
            @endif

            {{-- Valeurs --}}
            <div class="grid grid-cols-1 gap-5">
                @foreach([
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>', 'title' => 'Performance d\'abord', 'desc' => 'Chaque ligne de code est pensée pour la rapidité et l\'efficacité. Un site lent est un site perdu.'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>', 'title' => 'Design avec intention', 'desc' => 'Chaque choix visuel a une raison d\'être. L\'esthétique et la fonctionnalité forment un tout indissociable.'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>', 'title' => 'Code maintenable', 'desc' => 'Un projet bien architecturé reste évolutif dans le temps. Je code pour aujourd\'hui et pour demain.'],
                ] as $i => $val)
                    <div class="section-reveal" data-delay="{{ $i * 120 }}">
                        <x-glass-card class="flex items-start gap-5">
                            <div class="w-12 h-12 rounded-xl bg-accent-primary/10 border border-accent-primary/20 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-accent-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $val['icon'] !!}</svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-100 mb-1">{{ $val['title'] }}</h3>
                                <p class="text-sm text-slate-400 leading-relaxed">{{ $val['desc'] }}</p>
                            </div>
                        </x-glass-card>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    {{-- ══════════════════════════ TIMELINE ══════════════════════════ --}}
    <section id="timeline" class="py-20 relative overflow-hidden">

        {{-- ░░ ZONE ASSET : background ░░ — Uploader un asset de type "Arrière-plan" dans Assets du site --}}
        @if(isset($assets['background']) && $assets['background']->first())
            <div class="absolute inset-0 pointer-events-none" style="z-index:0">
                <img src="{{ $assets['background']->first()->url }}" alt=""
                     class="w-full h-full object-cover opacity-[0.04]">
            </div>
        @endif
        <div class="text-center mb-16 section-reveal">
            <x-badge variant="primary" class="mb-4">PARCOURS</x-badge>
            <h2 class="text-4xl md:text-5xl font-bold">Formation & <span class="gradient-text">Expériences</span></h2>
            <p class="text-slate-400 mt-4 max-w-xl mx-auto">Mon chemin vers le développement web, étape par étape.</p>
        </div>

        <div class="timeline-container max-w-4xl mx-auto space-y-0 relative z-10">
            @forelse($timeline as $i => $item)
                @php $isLeft = $i % 2 === 0; @endphp
                <div class="relative grid md:grid-cols-2 gap-0 min-h-[140px] items-center
                    {{ $isLeft ? 'reveal-left' : 'reveal-right' }}" data-delay="{{ $i * 100 }}">

                    {{-- Left side --}}
                    <div class="{{ $isLeft ? 'md:pr-12 md:text-right' : 'md:col-start-2 md:pl-12' }}">
                        @if($isLeft)
                            <div class="glass-strong rounded-2xl p-6 mb-4 md:mb-8">
                                <div class="flex items-center md:justify-end gap-2 mb-2">
                                    <x-badge variant="{{ $item->type === 'exp' ? 'primary' : 'secondary' }}">
                                        {{ $item->type === 'exp' ? 'Expérience' : 'Formation' }}
                                    </x-badge>
                                    <span class="text-xs text-slate-500 font-mono">{{ $item->date_label }}</span>
                                </div>
                                <h3 class="font-bold text-slate-100 mb-1">{{ $item->title }}</h3>
                                <p class="text-sm text-accent-primary mb-2">{{ $item->organization }}</p>
                                @if($item->description)
                                    <p class="text-xs text-slate-400 leading-relaxed">{{ $item->description }}</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Center dot --}}
                    <div class="hidden md:block absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 z-10">
                        <div class="timeline-dot relative">
                            <span class="absolute inset-0 flex items-center justify-center text-xs">{{ $item->icon }}</span>
                        </div>
                    </div>

                    {{-- Right side --}}
                    @if(!$isLeft)
                        <div class="md:col-start-2 md:pl-12">
                            <div class="glass-strong rounded-2xl p-6 mb-4 md:mb-8">
                                <div class="flex items-center gap-2 mb-2">
                                    <x-badge variant="{{ $item->type === 'exp' ? 'primary' : 'secondary' }}">
                                        {{ $item->type === 'exp' ? 'Expérience' : 'Formation' }}
                                    </x-badge>
                                    <span class="text-xs text-slate-500 font-mono">{{ $item->date_label }}</span>
                                </div>
                                <h3 class="font-bold text-slate-100 mb-1">{{ $item->title }}</h3>
                                <p class="text-sm text-accent-secondary mb-2">{{ $item->organization }}</p>
                                @if($item->description)
                                    <p class="text-xs text-slate-400 leading-relaxed">{{ $item->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-16 text-slate-500 italic">
                    Aucune entrée de parcours pour l'instant.
                </div>
            @endforelse
        </div>
    </section>

    <div class="section-divider"></div>

    {{-- ══════════════════════════ SKILLS ══════════════════════════ --}}
    <section id="skills" class="py-20 relative overflow-hidden">

        {{-- ░░ ZONE ASSET : background (réutilisé) ░░ --}}
        @if(isset($assets['background']) && $assets['background']->first())
            <div class="absolute inset-0 pointer-events-none" style="z-index:0">
                <img src="{{ $assets['background']->first()->url }}" alt=""
                     class="w-full h-full object-cover opacity-[0.03] scale-x-[-1]">
            </div>
        @endif
        <div class="text-center mb-16 section-reveal relative z-10">
            <x-badge variant="secondary">COMPÉTENCES</x-badge>
            <h2 class="text-4xl md:text-5xl font-bold mt-4">Tech <span class="gradient-text">Stack</span></h2>
            <p class="text-slate-400 mt-4 max-w-xl mx-auto">Les outils que je maîtrise et avec lesquels je construis chaque jour.</p>
        </div>

        @if($skills->count())
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">
                @foreach($skills as $category => $items)
                    <div class="section-reveal" data-delay="{{ $loop->index * 80 }}">
                        <x-glass-card :hover="false">
                            <h3 class="text-sm font-bold text-accent-primary uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="w-5 h-0.5 bg-accent-primary rounded inline-block"></span>
                                {{ $category }}
                            </h3>
                            <div class="space-y-4">
                                @foreach($items as $skill)
                                    @php $level = $skill->level ?? 75; @endphp
                                    <div>
                                        <div class="flex justify-between mb-1.5">
                                            <span class="text-sm font-medium text-slate-200">{{ $skill->name }}</span>
                                            <span class="text-xs text-slate-500 font-mono">{{ $level }}%</span>
                                        </div>
                                        <div class="skill-bar-track">
                                            <div class="skill-bar-fill" data-level="{{ $level }}"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-glass-card>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 text-slate-500 italic">Configuration des compétences en cours...</div>
        @endif
    </section>

    <div class="section-divider"></div>

    {{-- ══════════════════════════ CERTIFICATIONS ══════════════════════════ --}}
    {{-- ░░ ZONE ASSET : certification ░░ — Uploader des assets de type "Certification / Diplôme" dans Assets du site --}}
    @if(isset($assets['certification']) && $assets['certification']->count())
    <section id="certifications" class="py-20">
        <div class="text-center mb-12 section-reveal">
            <x-badge variant="secondary">CERTIFICATIONS</x-badge>
            <h2 class="text-4xl md:text-5xl font-bold mt-4">Diplômes & <span class="gradient-text">Certifications</span></h2>
            <p class="text-slate-400 mt-4 max-w-xl mx-auto">Formations validées et certifications professionnelles obtenues.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($assets['certification'] as $i => $cert)
                <div class="section-reveal" data-delay="{{ $i * 80 }}">
                    <x-glass-card class="flex flex-col gap-4 p-0 overflow-hidden">
                        <div class="w-full overflow-hidden bg-slate-900">
                            <img src="{{ $cert->url }}"
                                 alt="{{ $cert->title ?? 'Certification' }}"
                                 class="w-full h-44 object-cover hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="px-5 pb-5 space-y-1">
                            <p class="text-sm font-semibold text-slate-200">{{ $cert->title ?? 'Certification' }}</p>
                            @if($cert->issuer)
                                <p class="text-xs text-accent-primary">{{ $cert->issuer }}</p>
                            @endif
                            @if($cert->issue_date)
                                <p class="text-xs text-slate-500 font-mono">{{ $cert->issue_date->format('M Y') }}</p>
                            @endif
                        </div>
                    </x-glass-card>
                </div>
            @endforeach
        </div>
    </section>
    <div class="section-divider"></div>
    @endif

    {{-- ══════════════════════════ PROJETS ══════════════════════════ --}}
    <section id="projects" class="py-20">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 section-reveal">
            <div>
                <x-badge variant="primary" class="mb-4">RÉALISATIONS</x-badge>
                <h2 class="text-4xl md:text-5xl font-bold">Mes <span class="gradient-text">Projets</span></h2>
                <p class="text-slate-400 mt-3">Une sélection de mes travaux les plus récents et significatifs.</p>
            </div>
            {{-- Filter buttons --}}
            <div class="flex flex-wrap gap-2" id="project-filters">
                <button data-filter="all" class="text-xs px-4 py-2 rounded-full border border-accent-primary text-accent-primary bg-accent-primary/10 font-medium transition-all">
                    Tous
                </button>
                @foreach($projects->pluck('technologies')->flatten()->unique()->take(5) as $tech)
                    <button data-filter="{{ $tech }}" class="text-xs px-4 py-2 rounded-full border border-white/10 text-slate-400 font-medium transition-all hover:border-accent-primary/50 hover:text-accent-primary">
                        {{ $tech }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="projects-grid">
            @forelse($projects as $project)
                @php $cat = $project->technologies[0] ?? 'Web'; @endphp
                <div class="project-card section-reveal" data-category="{{ $cat }}" data-delay="{{ $loop->index * 80 }}">

                    {{-- Image --}}
                    <div class="relative aspect-video overflow-hidden bg-slate-900">
                        @if($project->image_path)
                            <img src="{{ asset('storage/' . $project->image_path) }}"
                                 alt="{{ $project->title }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-950 to-black">
                                <div class="text-center space-y-2">
                                    <div class="text-4xl opacity-30">{{ $loop->index % 2 === 0 ? '🖥️' : '⚡' }}</div>
                                    <p class="text-xs text-slate-700 font-mono uppercase tracking-widest">{{ $project->title }}</p>
                                </div>
                            </div>
                        @endif
                        {{-- Overlay on hover --}}
                        <div class="project-overlay rounded-none">
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank" rel="noopener"
                                   class="w-10 h-10 rounded-full glass flex items-center justify-center text-accent-primary hover:bg-accent-primary/20 transition-all">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.745.083-.729.083-.729 1.205.084 1.84 1.237 1.84 1.237 1.07 1.834 2.807 1.304 3.492.997.108-.775.418-1.305.762-1.604-2.665-.305-5.467-1.332-5.467-5.93 0-1.31.47-2.38 1.235-3.22-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.3 1.23A11.51 11.51 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.91 1.235 3.22 0 4.61-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222 0 1.606-.015 2.896-.015 3.286 0 .322.216.694.825.576C20.565 21.796 24 17.3 24 12c0-6.63-5.37-12-12-12z"/></svg>
                                </a>
                            @endif
                            @if($project->live_url)
                                <a href="{{ $project->live_url }}" target="_blank" rel="noopener"
                                   class="w-10 h-10 rounded-full glass flex items-center justify-center text-accent-secondary hover:bg-accent-secondary/20 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6 space-y-3">
                        <h3 class="text-lg font-bold text-slate-100 hover:text-accent-primary transition-colors">
                            {{ $project->title }}
                        </h3>
                        <p class="text-sm text-slate-400 leading-relaxed line-clamp-2">
                            {{ $project->description }}
                        </p>
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            @foreach($project->technologies as $tech)
                                <x-badge variant="neutral">{{ $tech }}</x-badge>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <x-glass-card :hover="false" class="text-center py-20">
                        <div class="text-4xl mb-4">🚀</div>
                        <p class="text-slate-500 italic">Les projets arrivent bientôt...</p>
                        <p class="text-xs text-slate-600 mt-2">Ajoutez des projets depuis votre espace admin.</p>
                    </x-glass-card>
                </div>
            @endforelse
        </div>
    </section>

    <div class="section-divider"></div>

    {{-- ══════════════════════════ SERVICES ══════════════════════════ --}}
    <section id="services" class="py-20">
        <div class="text-center mb-16 section-reveal">
            <x-badge variant="secondary">SERVICES</x-badge>
            <h2 class="text-4xl md:text-5xl font-bold mt-4">Ce que je <span class="gradient-text">propose</span></h2>
            <p class="text-slate-400 mt-4 max-w-xl mx-auto">Des solutions adaptées à vos besoins, de la conception à la mise en ligne.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($services as $i => $service)
                <div class="service-card section-reveal" data-delay="{{ $i * 100 }}">
                    <div class="w-14 h-14 rounded-2xl bg-accent-{{ $service->color }}/10 border border-accent-{{ $service->color }}/20 flex items-center justify-center mb-6">
                        @if($service->icon_svg)
                            <svg class="w-7 h-7 text-accent-{{ $service->color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $service->icon_svg !!}</svg>
                        @else
                            <span class="text-2xl">🛠</span>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-slate-100">{{ $service->title }}</h3>
                    <p class="text-sm text-slate-400 leading-relaxed mb-5">{{ $service->description }}</p>
                    @if($service->tags)
                        <div class="flex flex-wrap gap-2">
                            @foreach($service->tags as $tag)
                                <x-badge variant="{{ $service->color }}">{{ $tag }}</x-badge>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <div class="section-divider"></div>

    {{-- ══════════════════════════ CONTACT ══════════════════════════ --}}
    <section id="contact" class="py-20">
        <div class="text-center mb-16 section-reveal">
            <x-badge variant="primary">CONTACT</x-badge>
            <h2 class="text-4xl md:text-5xl font-bold mt-4">Travaillons <span class="gradient-text">ensemble</span></h2>
            <p class="text-slate-400 mt-4 max-w-xl mx-auto">Un projet en tête ? Une question ? Je réponds généralement sous 24h.</p>
        </div>

        <div class="grid lg:grid-cols-5 gap-12 items-start">

            {{-- Infos --}}
            <div class="lg:col-span-2 space-y-6 section-reveal">
                <x-glass-card :hover="false">
                    <h3 class="font-bold text-slate-100 mb-6 text-lg">Me joindre directement</h3>
                    @php
                        $contactEmail = $adminUser?->public_email ?: $adminUser?->email ?: 'paoloedwen@gmail.com';
                        $contactLinks = [['href' => 'mailto:'.$contactEmail, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>', 'label' => 'Email', 'value' => $contactEmail]];
                        if ($adminUser?->phone) $contactLinks[] = ['href' => 'https://wa.me/'.preg_replace('/\D/','',$adminUser->phone), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>', 'label' => 'WhatsApp', 'value' => $adminUser->phone];
                        if ($adminUser?->github_url) $contactLinks[] = ['href' => $adminUser->github_url, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>', 'label' => 'GitHub', 'value' => ltrim(parse_url($adminUser->github_url, PHP_URL_PATH), '/')];
                        if ($adminUser?->linkedin_url) $contactLinks[] = ['href' => $adminUser->linkedin_url, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/>', 'label' => 'LinkedIn', 'value' => 'linkedin.com'];
                    @endphp
                    <div class="space-y-5">
                        @foreach($contactLinks as $contact)
                            <a href="{{ $contact['href'] }}" target="_blank" rel="noopener"
                               class="flex items-center gap-4 group hover:text-accent-primary transition-colors">
                                <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center group-hover:border-accent-primary/30 group-hover:bg-accent-primary/5 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $contact['icon'] !!}</svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 uppercase tracking-wide">{{ $contact['label'] }}</p>
                                    <p class="text-sm font-medium text-slate-300 group-hover:text-accent-primary transition-colors">{{ $contact['value'] }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </x-glass-card>

                <x-glass-card :hover="false">
                    <p class="text-xs text-slate-500 uppercase tracking-widest mb-3">Disponibilité</p>
                    <div class="flex items-center gap-2">
                        @if($adminUser?->is_available !== false)
                            <span class="w-2.5 h-2.5 rounded-full bg-green-400 animate-pulse"></span>
                            <span class="text-sm font-medium text-slate-300">{{ $adminUser?->availability_text ?: 'Disponible pour de nouveaux projets' }}</span>
                        @else
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-600"></span>
                            <span class="text-sm font-medium text-slate-500">{{ $adminUser?->availability_text ?: 'Actuellement indisponible' }}</span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Réponse sous 24h · {{ $adminUser?->location ?? 'Africa/Libreville' }}</p>
                </x-glass-card>
            </div>

            {{-- Formulaire --}}
            <div class="lg:col-span-3 section-reveal" data-delay="100">
                <x-glass-card :hover="false">
                    <h3 class="font-bold text-slate-100 mb-6 text-lg">Envoyer un message</h3>
                    <form id="contact-form" class="space-y-5" novalidate>
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Votre nom *</label>
                                <input type="text" name="name" placeholder="Paul Dupont" class="contact-input" required>
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Votre email *</label>
                                <input type="email" name="email" placeholder="paul@example.com" class="contact-input" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Sujet *</label>
                            <input type="text" name="subject" placeholder="Demande de devis / Collaboration / Question" class="contact-input" required>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Message *</label>
                            <textarea name="message" rows="5" placeholder="Décrivez votre projet ou votre question..." class="contact-input resize-none" required minlength="10"></textarea>
                        </div>
                        <button type="submit" class="neon-btn w-full justify-center text-sm py-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Envoyer le message
                        </button>
                        <p class="text-xs text-slate-600 text-center">Vos données ne sont jamais partagées avec des tiers.</p>
                    </form>
                </x-glass-card>
            </div>
        </div>
    </section>

</main>

{{-- ══════════════════════════ FOOTER ══════════════════════════ --}}
<footer class="mt-20 border-t border-white/5">
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid md:grid-cols-3 gap-12 mb-12">

            {{-- Brand --}}
            <div class="space-y-4">
                <div class="text-2xl font-bold gradient-text tracking-tighter">
                    &lt;PE /&gt;
                </div>
                <p class="text-sm text-slate-500 leading-relaxed max-w-xs">
                    Développeur Full-Stack passionné par la création d'expériences web haut de gamme.
                    Basé à Libreville, disponible partout.
                </p>
                <div class="flex gap-4 pt-2">
                    <a href="https://github.com/Paul-Elibana" target="_blank" rel="noopener" class="text-slate-600 hover:text-accent-primary transition-colors" aria-label="GitHub">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.745.083-.729.083-.729 1.205.084 1.84 1.237 1.84 1.237 1.07 1.834 2.807 1.304 3.492.997.108-.775.418-1.305.762-1.604-2.665-.305-5.467-1.332-5.467-5.93 0-1.31.47-2.38 1.235-3.22-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.3 1.23A11.51 11.51 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.91 1.235 3.22 0 4.61-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222 0 1.606-.015 2.896-.015 3.286 0 .322.216.694.825.576C20.565 21.796 24 17.3 24 12c0-6.63-5.37-12-12-12z"/></svg>
                    </a>
                    <a href="https://wa.me/24177519644" target="_blank" rel="noopener" class="text-slate-600 hover:text-green-400 transition-colors" aria-label="WhatsApp">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Navigation --}}
            <div>
                <p class="text-xs text-slate-500 uppercase tracking-widest mb-5">Navigation</p>
                <div class="grid grid-cols-2 gap-2">
                    @foreach(['#about' => 'À propos', '#timeline' => 'Parcours', '#skills' => 'Compétences', '#projects' => 'Projets', '#services' => 'Services', '#contact' => 'Contact'] as $href => $label)
                        <a href="{{ $href }}" class="text-sm text-slate-500 hover:text-accent-primary transition-colors py-1">{{ $label }}</a>
                    @endforeach
                </div>
            </div>

            {{-- Disponibilité --}}
            <div>
                <p class="text-xs text-slate-500 uppercase tracking-widest mb-5">Statut actuel</p>
                <div class="space-y-3">
                    <div class="flex items-center gap-2">
                        @if($adminUser?->is_available !== false)
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                            <span class="text-sm text-slate-400">{{ $adminUser?->availability_text ?: 'Disponible pour missions' }}</span>
                        @else
                            <span class="w-2 h-2 rounded-full bg-slate-600"></span>
                            <span class="text-sm text-slate-500">{{ $adminUser?->availability_text ?: 'Actuellement indisponible' }}</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-accent-primary"></span>
                        <span class="text-sm text-slate-400">{{ $adminUser?->location ?? 'Libreville, Gabon' }} 🌍</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-accent-secondary"></span>
                        <span class="text-sm text-slate-400">Remote · Freelance · CDI</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-600">
            <p>&copy; {{ date('Y') }} Paul Edwen Elibana Mbadinga — Tous droits réservés.</p>
            <div class="flex items-center gap-2 font-mono">
                <span>BUILT WITH</span>
                <span class="text-accent-primary">Laravel</span>
                <span>+</span>
                <span class="text-accent-secondary">Tailwind</span>
                <span>+</span>
                <span class="text-slate-400">♥</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('carte') }}" class="hover:text-accent-secondary transition-colors">Carte de visite ↗</a>
                <a href="#hero" class="flex items-center gap-1 hover:text-accent-primary transition-colors">
                    Retour en haut
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</footer>

{{-- Skill bars init via JS inline --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const bars = document.querySelectorAll('.skill-bar-fill');
    const obs = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.width = entry.target.dataset.level + '%';
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });
    bars.forEach(b => obs.observe(b));
});
</script>

</body>
</html>
