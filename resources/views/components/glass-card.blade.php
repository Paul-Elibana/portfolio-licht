@props(['hover' => true])

<div {{ $attributes->merge(['class' => 'glass rounded-2xl p-6 ' . ($hover ? 'glass-hover' : '')]) }}>
    {{ $slot }}
</div>

<!-- 
    Documentation :
    Ce composant crée un conteneur avec un effet de verre dépoli (glassmorphism).
    Paramètres :
    - hover (boolean) : Active ou non les effets au survol (par défaut : true).
-->
