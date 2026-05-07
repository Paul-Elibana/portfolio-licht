@props(['variant' => 'primary'])

@php
    $colors = [
        'primary' => 'bg-accent-primary/20 text-accent-primary border-accent-primary/30',
        'secondary' => 'bg-accent-secondary/20 text-accent-secondary border-accent-secondary/30',
        'neutral' => 'bg-white/10 text-slate-300 border-white/20',
    ];
    $activeColor = $colors[$variant] ?? $colors['primary'];
@endphp

<span {{ $attributes->merge(['class' => "px-2.5 py-0.5 rounded-full text-xs font-medium border {$activeColor}"]) }}>
    {{ $slot }}
</span>

<!-- 
    Documentation :
    Ce composant affiche un badge coloré avec une transparence légère (glassmorphism).
    Paramètres :
    - variant (string) : 'primary', 'secondary', 'neutral'.
-->
