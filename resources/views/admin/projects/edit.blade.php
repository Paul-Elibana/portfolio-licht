@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.projects') }}" class="text-slate-500 hover:text-accent-primary transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold">Modifier le projet</h1>
            <p class="text-slate-400 text-sm mt-1">{{ $project->title }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-5 gap-6">

        {{-- Apercu image --}}
        <div class="lg:col-span-2">
            <x-glass-card :hover="false">
                <p class="text-xs text-slate-400 uppercase tracking-widest mb-4">Image actuelle</p>
                <div class="relative rounded-xl overflow-hidden aspect-video bg-slate-900 border border-white/5">
                    @if($project->image_path)
                        <img id="project-preview-img"
                             src="{{ asset('storage/' . $project->image_path) }}?v={{ $project->updated_at?->timestamp ?? time() }}"
                             alt="{{ $project->title }}"
                             class="w-full h-full object-cover">
                        <div class="absolute bottom-2 left-2">
                            <x-badge variant="neutral">Actuel</x-badge>
                        </div>
                    @else
                        <img id="project-preview-img" src="" alt="Apercu" class="hidden w-full h-full object-cover">
                        <div id="project-preview-placeholder" class="w-full h-full flex flex-col items-center justify-center gap-3 text-slate-700">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-xs text-slate-600">Aucune image</p>
                        </div>
                    @endif
                </div>
                <p class="text-[10px] text-slate-600 mt-3 leading-relaxed">Selectionner un nouveau fichier pour remplacer<br>JPG, PNG, WEBP — Max 5Mo</p>
            </x-glass-card>
        </div>

        {{-- Formulaire --}}
        <div class="lg:col-span-3">
            <x-glass-card :hover="false">
                <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf @method('PUT')

                    <div>
                        <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Titre du projet *</label>
                        <input type="text" name="title" value="{{ old('title', $project->title) }}" required class="contact-input">
                        @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Remplacer l'image (optionnel)</label>
                        <input type="file" name="image_path" id="project-image-input" accept="image/*" class="contact-input cursor-pointer">
                        @error('image_path') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Description *</label>
                        <textarea name="description" rows="4" required class="contact-input resize-none">{{ old('description', $project->description) }}</textarea>
                        @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Technologies *</label>
                        <input type="text" name="technologies" value="{{ old('technologies', implode(', ', $project->technologies ?? [])) }}" required class="contact-input">
                        <p class="text-[10px] text-slate-600 mt-1">Separees par des virgules</p>
                        @error('technologies') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Lien GitHub</label>
                            <input type="url" name="github_url" value="{{ old('github_url', $project->github_url) }}" placeholder="https://github.com/..." class="contact-input">
                            @error('github_url') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Lien Live / Demo</label>
                            <input type="url" name="live_url" value="{{ old('live_url', $project->live_url) }}" placeholder="https://..." class="contact-input">
                            @error('live_url') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-between pt-4 border-t border-white/5">
                        <a href="{{ route('admin.projects') }}" class="ghost-btn text-sm">Annuler</a>
                        <button type="submit" class="neon-btn text-sm">Enregistrer</button>
                    </div>
                </form>
            </x-glass-card>
        </div>
    </div>
</div>

<script>
document.getElementById('project-image-input')?.addEventListener('change', function() {
    const file = this.files[0];
    if (!file || !file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('project-preview-img');
        const placeholder = document.getElementById('project-preview-placeholder');
        img.src = e.target.result;
        img.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(file);
});
</script>
@endsection
