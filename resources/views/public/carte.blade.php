<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carte de visite — {{ $adminUser->name ?? 'Portfolio' }}</title>
    <meta name="description" content="Carte de visite virtuelle de {{ $adminUser->name ?? 'Paul Edwen Elibana Mbadinga' }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            @page { margin: 8mm; size: A4 portrait; }

            body {
                background: #020617 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                min-height: 100vh !important;
            }

            .no-print { display: none !important; }

            .card-print {
                background: rgba(255,255,255,0.05) !important;
                border: 1px solid rgba(255,255,255,0.1) !important;
                box-shadow: 0 8px 32px rgba(0,0,0,0.37) !important;
                break-inside: avoid !important;
            }

            /* Forcer les backgrounds gradients */
            [style*="background"] { background: attr(style) !important; }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    {{-- Toolbar --}}
    <div class="no-print fixed top-4 right-4 flex items-center gap-2 z-50">
        <a href="{{ route('home') }}"
           class="glass px-4 py-2 rounded-xl text-sm text-slate-400 hover:text-slate-200 transition-colors border border-white/10">
            ← Portfolio
        </a>
        <button onclick="window.print()"
                class="neon-btn text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Imprimer / PDF
        </button>
    </div>

    {{-- Card --}}
    <div class="card-print glass border border-white/10 rounded-3xl overflow-hidden max-w-xl w-full shadow-2xl">

        {{-- Header --}}
        <div class="relative px-8 pt-10 pb-6 text-center"
             style="background: linear-gradient(135deg, rgba(6,182,212,0.12) 0%, rgba(139,92,246,0.12) 100%)">

            {{-- Decorative blobs --}}
            <div class="absolute top-0 left-0 w-32 h-32 bg-accent-primary/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-32 h-32 bg-accent-secondary/10 rounded-full blur-2xl pointer-events-none"></div>

            {{-- Photo --}}
            <div class="relative inline-block mb-4">
                <div class="w-28 h-28 rounded-full overflow-hidden glass border-2 border-white/20 mx-auto">
                    @if($adminUser && $adminUser->profile_photo)
                        <img src="{{ asset('storage/' . $adminUser->profile_photo) }}?v={{ $adminUser->updated_at?->timestamp ?? time() }}"
                             alt="{{ $adminUser->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <img src="{{ asset('images/default-avatar.svg') }}" alt="Avatar" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-green-400 border-2 border-slate-950"></div>
            </div>

            {{-- Name & title --}}
            <h1 class="text-2xl font-bold gradient-text">{{ $adminUser->name ?? 'Paul Edwen Elibana Mbadinga' }}</h1>
            <p class="text-accent-primary text-sm font-medium mt-1">Développeur Full-Stack</p>
            <p class="text-slate-500 text-xs mt-0.5">Libreville, Gabon 🌍</p>
        </div>

        {{-- Body --}}
        <div class="px-8 py-6 space-y-5">

            {{-- Contact info --}}
            <div class="space-y-3">
                @if($adminUser && $adminUser->email)
                <a href="mailto:{{ $adminUser->email }}"
                   class="flex items-center gap-3 text-sm text-slate-300 hover:text-accent-primary transition-colors group">
                    <div class="w-9 h-9 rounded-xl glass border border-white/10 flex items-center justify-center shrink-0 group-hover:border-accent-primary/30 transition-colors">
                        <svg class="w-4 h-4 text-accent-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="font-mono text-xs">{{ $adminUser->email }}</span>
                </a>
                @endif

                <a href="https://wa.me/24177519644" target="_blank" rel="noopener"
                   class="flex items-center gap-3 text-sm text-slate-300 hover:text-green-400 transition-colors group">
                    <div class="w-9 h-9 rounded-xl glass border border-white/10 flex items-center justify-center shrink-0 group-hover:border-green-400/30 transition-colors">
                        <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </div>
                    <span class="font-mono text-xs">+241 77 51 96 44</span>
                </a>

                <a href="https://github.com/Paul-Elibana" target="_blank" rel="noopener"
                   class="flex items-center gap-3 text-sm text-slate-300 hover:text-accent-primary transition-colors group">
                    <div class="w-9 h-9 rounded-xl glass border border-white/10 flex items-center justify-center shrink-0 group-hover:border-accent-primary/30 transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.745.083-.729.083-.729 1.205.084 1.84 1.237 1.84 1.237 1.07 1.834 2.807 1.304 3.492.997.108-.775.418-1.305.762-1.604-2.665-.305-5.467-1.332-5.467-5.93 0-1.31.47-2.38 1.235-3.22-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.3 1.23A11.51 11.51 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.91 1.235 3.22 0 4.61-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222 0 1.606-.015 2.896-.015 3.286 0 .322.216.694.825.576C20.565 21.796 24 17.3 24 12c0-6.63-5.37-12-12-12z"/>
                        </svg>
                    </div>
                    <span class="font-mono text-xs">github.com/Paul-Elibana</span>
                </a>
            </div>

            {{-- Skills tags --}}
            <div class="border-t border-white/5 pt-4">
                <p class="text-xs text-slate-500 uppercase tracking-widest mb-3">Stack principal</p>
                <div class="flex flex-wrap gap-2">
                    @foreach(['Laravel', 'PHP', 'Vue.js', 'Tailwind CSS', 'MySQL', 'Git'] as $tech)
                        <span class="px-2.5 py-1 text-xs rounded-full glass border border-white/10 text-slate-400">{{ $tech }}</span>
                    @endforeach
                </div>
            </div>

            {{-- QR Code --}}
            <div class="border-t border-white/5 pt-4 flex items-center gap-5">
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-widest mb-1">Scanner pour visiter</p>
                    <p class="text-[10px] text-slate-600">Portfolio en ligne</p>
                </div>
                <div id="qr-container" class="ml-auto w-20 h-20 bg-white rounded-xl p-1 shrink-0"></div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-8 py-4 border-t border-white/5 flex items-center justify-between text-[10px] text-slate-600 font-mono">
            <span>&lt;PE/&gt;</span>
            <span>Disponible — Remote & Libreville</span>
        </div>
    </div>

    {{-- QR code CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const url = '{{ url('/') }}';
        new QRCode(document.getElementById('qr-container'), {
            text: url,
            width: 72,
            height: 72,
            colorDark: '#0f172a',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M,
        });
    });
    </script>
</body>
</html>
