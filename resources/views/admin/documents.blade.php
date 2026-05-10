@extends('layouts.admin')

@section('content')
<div class="space-y-10">

    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-bold tracking-tight">Assets du site</h1>
            <p class="text-slate-400 mt-2 text-sm uppercase tracking-widest">Images et fichiers utilisés sur votre portfolio</p>
        </div>
        <span class="text-xs font-mono text-slate-500">{{ $assets->count() }} asset(s)</span>
    </div>

    @if(session('success'))
        <div class="p-4 bg-accent-primary/20 border border-accent-primary/30 text-accent-primary rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8">

        {{-- Formulaire upload --}}
        <div class="lg:col-span-1">
            <x-glass-card :hover="false">
                <h3 class="text-lg font-bold mb-6">Ajouter un asset</h3>
                <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div class="border-2 border-dashed border-white/10 rounded-xl p-6 text-center hover:border-accent-primary/50 transition-colors cursor-pointer relative">
                        <input type="file" name="document_path" id="asset-file-input" required accept="image/*,.pdf,.svg"
                               class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                        <div id="drop-preview" class="hidden mb-3">
                            <img id="preview-img" src="" alt="Apercu" class="w-full h-32 object-cover rounded-lg mx-auto">
                        </div>
                        <div id="drop-placeholder">
                            <svg class="w-10 h-10 text-slate-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-xs text-slate-500">Glisser-deposer ou cliquer</p>
                            <p class="text-[10px] text-slate-600 mt-1">JPG, PNG, WEBP, SVG, PDF - Max 5Mo</p>
                        </div>
                        <p id="file-name" class="text-xs text-accent-primary mt-2 hidden"></p>
                    </div>

                    <div>
                        <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Titre *</label>
                        <input type="text" name="title" required placeholder="Photo hero, Logo..." class="contact-input">
                    </div>

                    <div>
                        <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Type *</label>
                        <select name="type" required class="contact-input">
                            @foreach(\App\Models\PublicDocument::TYPES as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Tag (optionnel)</label>
                        <input type="text" name="tag" placeholder="hero-principal, cv..." class="contact-input">
                    </div>

                    <div>
                        <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Description (optionnel)</label>
                        <textarea name="description" rows="2" placeholder="Contexte d'usage..." class="contact-input resize-none"></textarea>
                    </div>

                    <button type="submit" class="neon-btn w-full justify-center text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Televerser
                    </button>
                </form>
            </x-glass-card>
        </div>

        {{-- Galerie --}}
        <div class="lg:col-span-2">
            @if($assets->count())
                <div class="flex flex-wrap gap-2 mb-6">
                    <button data-asset-filter="all"
                            class="asset-filter-btn text-xs px-3 py-1.5 rounded-full border border-accent-primary text-accent-primary bg-accent-primary/10 font-medium transition-all">
                        Tous ({{ $assets->count() }})
                    </button>
                    @foreach($assets->groupBy('type') as $type => $group)
                        <button data-asset-filter="{{ $type }}"
                                class="asset-filter-btn text-xs px-3 py-1.5 rounded-full border border-white/10 text-slate-400 font-medium transition-all hover:border-accent-primary/50">
                            {{ \App\Models\PublicDocument::TYPES[$type] ?? $type }} ({{ $group->count() }})
                        </button>
                    @endforeach
                </div>

                <div class="grid sm:grid-cols-2 gap-4" id="assets-grid">
                    @foreach($assets as $asset)
                        @php
                            $ext     = strtolower(pathinfo($asset->document_path, PATHINFO_EXTENSION));
                            $isImage = in_array($ext, ['jpg','jpeg','png','webp','gif','svg']);
                            $isPdf   = $ext === 'pdf';
                        @endphp
                        <div class="asset-item glass rounded-2xl overflow-hidden group transition-all duration-300 hover:border-white/20"
                             data-type="{{ $asset->type }}">

                            <div class="relative bg-slate-900" style="height:150px;">
                                @if($isImage)
                                    <img src="{{ $asset->url }}" alt="{{ $asset->title }}" class="w-full h-full object-cover">
                                @elseif($isPdf)
                                    <iframe src="{{ asset('storage/' . $asset->document_path) }}#toolbar=0&navpanes=0&scrollbar=0&view=FitH"
                                            class="w-full h-full border-0 pointer-events-none"
                                            loading="lazy"
                                            title="{{ $asset->title }}"></iframe>
                                    <div class="absolute bottom-1 right-1 bg-red-500/20 border border-red-400/30 rounded px-1.5 py-0.5 text-[9px] text-red-400 font-mono">PDF</div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                @endif

                                <div class="absolute inset-0 bg-slate-950/80 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                                    <a href="{{ asset('storage/' . $asset->document_path) }}" target="_blank"
                                       class="w-9 h-9 rounded-xl glass flex items-center justify-center text-accent-primary hover:bg-accent-primary/20 transition-all" title="Voir">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <button onclick="copyAssetUrl('{{ asset('storage/' . $asset->document_path) }}')"
                                            class="w-9 h-9 rounded-xl glass flex items-center justify-center text-slate-300 hover:bg-white/10 transition-all" title="Copier URL">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                    <a href="{{ route('admin.documents.edit', $asset) }}"
                                       class="w-9 h-9 rounded-xl glass flex items-center justify-center text-accent-secondary hover:bg-accent-secondary/20 transition-all" title="Modifier">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.documents.delete', $asset) }}" method="POST"
                                          onsubmit="return confirm('Supprimer definitivement cet asset ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-9 h-9 rounded-xl glass flex items-center justify-center text-red-400 hover:bg-red-400/20 transition-all" title="Supprimer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="p-4 space-y-1.5">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-sm font-medium text-slate-200 truncate">{{ $asset->title }}</p>
                                    <x-badge variant="{{ $asset->type === 'hero' ? 'primary' : 'neutral' }}">
                                        {{ $asset->type }}
                                    </x-badge>
                                </div>
                                @if($asset->tag)
                                    <p class="text-xs text-slate-500">#{{ $asset->tag }}</p>
                                @endif
                                @if($asset->description)
                                    <p class="text-xs text-slate-500 line-clamp-1">{{ $asset->description }}</p>
                                @endif
                                <p class="text-[10px] text-slate-600 font-mono">{{ $asset->updated_at?->format('d/m/Y') ?? '—' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <x-glass-card :hover="false" class="text-center py-20">
                    <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-slate-500 italic">Aucun asset pour le moment.</p>
                </x-glass-card>
            @endif
        </div>
    </div>
</div>

<script>
function copyAssetUrl(url) {
    navigator.clipboard.writeText(url).then(() => {
        const t = document.createElement('div');
        t.className = 'toast toast-success';
        t.innerHTML = '<div class="flex items-center gap-2"><span>✓</span><span>URL copiee !</span></div>';
        document.body.appendChild(t);
        setTimeout(() => t.remove(), 3000);
    });
}
document.querySelectorAll('.asset-filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.asset-filter-btn').forEach(b => {
            b.classList.remove('border-accent-primary','text-accent-primary','bg-accent-primary/10');
            b.classList.add('border-white/10','text-slate-400');
        });
        btn.classList.add('border-accent-primary','text-accent-primary','bg-accent-primary/10');
        btn.classList.remove('border-white/10','text-slate-400');
        const f = btn.dataset.assetFilter;
        document.querySelectorAll('.asset-item').forEach(item => {
            item.style.display = (f === 'all' || item.dataset.type === f) ? '' : 'none';
        });
    });
});
document.getElementById('asset-file-input')?.addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-name').classList.remove('hidden');
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('drop-preview').classList.remove('hidden');
            document.getElementById('drop-placeholder').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
