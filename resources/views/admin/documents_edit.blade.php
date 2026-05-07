@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.documents') }}" class="text-slate-500 hover:text-accent-primary transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold">Modifier l'asset</h1>
            <p class="text-slate-400 text-sm mt-1">{{ $document->title }}</p>
        </div>
    </div>

    <x-glass-card :hover="false">
        <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')

            {{-- Apercu actuel --}}
            @php $isImage = in_array(strtolower(pathinfo($document->document_path, PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp','gif','svg']); @endphp
            @if($isImage)
                <div class="relative rounded-xl overflow-hidden aspect-video bg-slate-900">
                    <img src="{{ $document->url }}" alt="{{ $document->title }}" class="w-full h-full object-cover" id="edit-preview-img">
                    <div class="absolute bottom-2 left-2">
                        <x-badge variant="neutral">Actuel</x-badge>
                    </div>
                </div>
            @endif

            <div>
                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Remplacer le fichier (optionnel)</label>
                <input type="file" name="document_path" id="edit-file-input" accept="image/*,.pdf,.svg"
                       class="contact-input cursor-pointer">
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Titre *</label>
                    <input type="text" name="title" value="{{ old('title', $document->title) }}" required class="contact-input">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Type *</label>
                    <select name="type" required class="contact-input">
                        @foreach(\App\Models\PublicDocument::TYPES as $key => $label)
                            <option value="{{ $key }}" {{ old('type', $document->type) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Tag</label>
                <input type="text" name="tag" value="{{ old('tag', $document->tag) }}" class="contact-input">
            </div>

            <div>
                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Description</label>
                <textarea name="description" rows="3" class="contact-input resize-none">{{ old('description', $document->description) }}</textarea>
            </div>

            <div class="flex justify-between pt-4 border-t border-white/5">
                <a href="{{ route('admin.documents') }}" class="ghost-btn text-sm">Annuler</a>
                <button type="submit" class="neon-btn text-sm">Enregistrer</button>
            </div>
        </form>
    </x-glass-card>
</div>

<script>
document.getElementById('edit-file-input')?.addEventListener('change', function() {
    const file = this.files[0];
    if (!file || !file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('edit-preview-img');
        if (img) img.src = e.target.result;
    };
    reader.readAsDataURL(file);
});
</script>
@endsection
