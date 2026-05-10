@extends('layouts.admin')

@section('content')
<div class="max-w-2xl space-y-8">

    <div>
        <a href="{{ route('admin.services') }}" class="text-xs text-slate-500 hover:text-slate-300 transition-colors flex items-center gap-1 mb-4">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour aux services
        </a>
        <h1 class="text-3xl font-bold gradient-text">Modifier le service</h1>
    </div>

    <form action="{{ route('admin.services.update', $service) }}" method="POST" class="glass rounded-2xl p-8 space-y-6">
        @csrf @method('PUT')

        <div class="grid sm:grid-cols-2 gap-5">
            <div class="sm:col-span-2">
                <label class="block text-xs text-slate-400 mb-1.5">Titre <span class="text-red-400">*</span></label>
                <input type="text" name="title" value="{{ old('title', $service->title) }}" required
                       class="contact-input">
                @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs text-slate-400 mb-1.5">Description <span class="text-red-400">*</span></label>
                <textarea name="description" rows="3" required
                          class="contact-input resize-none">{{ old('description', $service->description) }}</textarea>
                @error('description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs text-slate-400 mb-1.5">Couleur</label>
                <select name="color" class="contact-input">
                    <option value="primary" {{ old('color', $service->color) === 'primary' ? 'selected' : '' }}>Cyan (primaire)</option>
                    <option value="secondary" {{ old('color', $service->color) === 'secondary' ? 'selected' : '' }}>Violet (secondaire)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs text-slate-400 mb-1.5">Ordre d'affichage</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" min="0"
                       class="contact-input">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs text-slate-400 mb-1.5">Tags <span class="text-slate-600">(séparés par des virgules)</span></label>
                <input type="text" name="tags"
                       value="{{ old('tags', $service->tags ? implode(', ', $service->tags) : '') }}"
                       class="contact-input">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs text-slate-400 mb-1.5">Icône SVG <span class="text-slate-600">(contenu de &lt;path&gt;)</span></label>
                <textarea name="icon_svg" rows="3"
                          class="contact-input font-mono text-xs resize-none">{{ old('icon_svg', $service->icon_svg) }}</textarea>
                <p class="text-xs text-slate-600 mt-1">Copiez le contenu SVG depuis heroicons.com (viewBox 24×24)</p>
            </div>

            <div class="sm:col-span-2 flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       class="w-4 h-4 accent-cyan-400"
                       {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm text-slate-300">Afficher ce service sur le portfolio</label>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="neon-btn text-sm py-2 px-6">Enregistrer</button>
            <a href="{{ route('admin.services') }}" class="ghost-btn text-sm py-2 px-6">Annuler</a>
        </div>
    </form>

</div>
@endsection
