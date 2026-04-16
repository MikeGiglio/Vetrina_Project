@extends('admin.layouts.admin')

@section('title', 'Galleria')
@section('page-title', 'Galleria Foto')

@section('content')

{{-- Upload area --}}
<div class="admin-card" style="margin-bottom:1.5rem;">
    <div class="section-title">Carica Nuove Foto</div>
    <form method="POST" action="{{ route('admin.photos.store') }}" enctype="multipart/form-data" id="upload-form">
        @csrf

        {{-- Drop zone --}}
        <div id="drop-zone"
             style="border:2px dashed rgba(22,163,74,0.3);border-radius:0.75rem;padding:2.5rem;text-align:center;cursor:pointer;transition:all 0.2s;background:rgba(22,163,74,0.03);"
             onclick="document.getElementById('photo-input').click()"
             ondragover="event.preventDefault();this.style.borderColor='rgba(22,163,74,0.7)';this.style.background='rgba(22,163,74,0.08)'"
             ondragleave="this.style.borderColor='rgba(22,163,74,0.3)';this.style.background='rgba(22,163,74,0.03)'"
             ondrop="handleDrop(event)">
            <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="1.4" style="margin:0 auto 0.85rem;display:block;opacity:0.7;">
                <polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/>
                <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
            </svg>
            <div style="font-family:'DM Sans',sans-serif;font-size:0.9rem;font-weight:500;color:#A8D4AB;margin-bottom:0.3rem;">
                Trascina qui le foto o clicca per selezionarle
            </div>
            <div style="font-family:'DM Sans',sans-serif;font-size:0.75rem;color:rgba(168,212,171,0.4);">
                JPG, PNG, AVIF, WebP — max 5 MB per file
            </div>
            <input type="file" id="photo-input" name="photos[]" multiple accept="image/*" style="display:none" onchange="previewFiles(this.files)">
        </div>

        {{-- Preview con titoli --}}
        <div id="preview-grid" style="display:none;margin-top:1.25rem;">
            <div style="font-family:'DM Sans',sans-serif;font-size:0.75rem;font-weight:600;letter-spacing:0.12em;text-transform:uppercase;color:rgba(168,212,171,0.45);margin-bottom:0.75rem;">
                Anteprima — aggiungi un titolo a ogni foto
            </div>
            <div id="preview-items" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));gap:1rem;"></div>
        </div>

        {{-- Azioni --}}
        <div style="margin-top:1.25rem;display:flex;gap:0.75rem;align-items:center;" id="upload-actions" style="display:none;">
            <button type="submit" class="btn-primary" id="upload-btn" style="display:none;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/>
                </svg>
                Carica foto
            </button>
            <button type="button" id="clear-btn" class="btn-secondary" style="display:none;"
                onclick="clearUpload()">Annulla</button>
        </div>
    </form>
</div>

{{-- Foto esistenti --}}
<div class="admin-card" style="padding:0;overflow:hidden;">
    <div style="padding:1.25rem 1.5rem;border-bottom:1px solid rgba(168,212,171,0.08);">
        <div class="section-title" style="margin:0;">Foto Esistenti ({{ $photos->count() }})</div>
    </div>

    @if($photos->isEmpty())
    <div style="padding:3rem;text-align:center;font-family:'DM Sans',sans-serif;font-size:0.88rem;color:rgba(168,212,171,0.35);">
        Nessuna foto ancora. Carica le prime immagini sopra.
    </div>
    @else
    <div style="padding:1.5rem;display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));gap:1rem;">
        @foreach($photos as $photo)
        <div style="border:1px solid rgba(168,212,171,{{ $photo->is_active ? '0.14' : '0.05' }});border-radius:0.75rem;overflow:hidden;background:rgba(255,255,255,0.02);">

            {{-- Immagine --}}
            <div style="position:relative;aspect-ratio:4/3;overflow:hidden;background:#0D1F0B;">
                <img src="/images/house/{{ $photo->filename }}" alt="{{ $photo->alt }}"
                     style="width:100%;height:100%;object-fit:cover;{{ $photo->is_active ? '' : 'opacity:0.3;filter:grayscale(1);' }}">
                @if(!$photo->is_active)
                <div style="position:absolute;top:0.4rem;right:0.4rem;">
                    <span class="badge" style="background:rgba(0,0,0,0.65);color:rgba(168,212,171,0.5);font-size:0.6rem;">nascosta</span>
                </div>
                @endif
            </div>

            {{-- Titolo editabile inline --}}
            <div style="padding:0.6rem 0.7rem 0.5rem;">
                <div id="title-view-{{ $photo->id }}" style="display:flex;align-items:center;justify-content:space-between;gap:0.4rem;margin-bottom:0.5rem;">
                    <span style="font-family:'DM Sans',sans-serif;font-size:0.8rem;font-weight:600;color:#A8D4AB;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;flex:1;"
                          title="{{ $photo->alt }}">{{ $photo->alt ?: '—' }}</span>
                    <button type="button" onclick="editTitle({{ $photo->id }})"
                        style="flex-shrink:0;background:none;border:none;cursor:pointer;color:rgba(168,212,171,0.4);padding:0.15rem;"
                        title="Modifica titolo">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                </div>
                <form id="title-form-{{ $photo->id }}" method="POST"
                      action="{{ route('admin.photos.alt', $photo) }}"
                      style="display:none;margin-bottom:0.5rem;">
                    @csrf @method('PATCH')
                    <div style="display:flex;gap:0.35rem;">
                        <input type="text" name="alt" value="{{ $photo->alt }}"
                               placeholder="es. Bagno"
                               style="flex:1;background:rgba(255,255,255,0.06);border:1px solid rgba(22,163,74,0.35);border-radius:0.4rem;padding:0.35rem 0.5rem;font-family:'DM Sans',sans-serif;font-size:0.78rem;color:#F0F5F1;outline:none;min-width:0;">
                        <button type="submit"
                            style="flex-shrink:0;background:#16A34A;border:none;border-radius:0.4rem;padding:0.35rem 0.55rem;cursor:pointer;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        </button>
                        <button type="button" onclick="cancelTitle({{ $photo->id }})"
                            style="flex-shrink:0;background:rgba(168,212,171,0.07);border:1px solid rgba(168,212,171,0.15);border-radius:0.4rem;padding:0.35rem 0.5rem;cursor:pointer;color:rgba(168,212,171,0.6);font-size:0.72rem;">✕</button>
                    </div>
                </form>

                {{-- Azioni --}}
                <div style="display:flex;gap:0.4rem;">
                    <form method="POST" action="{{ route('admin.photos.toggle', $photo) }}" style="flex:1;">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-secondary"
                                style="width:100%;padding:0.28rem 0.4rem;font-size:0.68rem;justify-content:center;">
                            @if($photo->is_active)
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            Nascondi
                            @else
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            Mostra
                            @endif
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.photos.destroy', $photo) }}"
                          onsubmit="return confirm('Eliminare questa foto definitivamente?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger" style="padding:0.28rem 0.45rem;" title="Elimina">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                <path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
let selectedFiles = [];

function previewFiles(files) {
    const grid     = document.getElementById('preview-grid');
    const items    = document.getElementById('preview-items');
    const uploadBtn = document.getElementById('upload-btn');
    const clearBtn  = document.getElementById('clear-btn');

    items.innerHTML = '';
    selectedFiles   = Array.from(files);

    if (selectedFiles.length === 0) {
        grid.style.display = 'none';
        uploadBtn.style.display = 'none';
        clearBtn.style.display  = 'none';
        return;
    }

    selectedFiles.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const card = document.createElement('div');
            card.style.cssText = 'border:1px solid rgba(22,163,74,0.2);border-radius:0.65rem;overflow:hidden;background:rgba(255,255,255,0.02);';

            const imgWrap = document.createElement('div');
            imgWrap.style.cssText = 'aspect-ratio:4/3;overflow:hidden;background:#0D1F0B;';
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:100%;height:100%;object-fit:cover;';
            imgWrap.appendChild(img);

            const inputWrap = document.createElement('div');
            inputWrap.style.cssText = 'padding:0.6rem 0.65rem;';
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'titles[]';
            input.placeholder = 'es. Bagno';
            input.style.cssText = 'width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(22,163,74,0.3);border-radius:0.4rem;padding:0.4rem 0.55rem;font-family:\'DM Sans\',sans-serif;font-size:0.8rem;color:#F0F5F1;outline:none;box-sizing:border-box;';
            input.addEventListener('focus', () => input.style.borderColor = 'rgba(22,163,74,0.6)');
            input.addEventListener('blur',  () => input.style.borderColor = 'rgba(22,163,74,0.3)');
            inputWrap.appendChild(input);

            card.appendChild(imgWrap);
            card.appendChild(inputWrap);
            items.appendChild(card);

            // Focus first input
            if (i === 0) setTimeout(() => input.focus(), 50);
        };
        reader.readAsDataURL(file);
    });

    grid.style.display      = 'block';
    uploadBtn.style.display = 'inline-flex';
    clearBtn.style.display  = 'inline-flex';
}

function clearUpload() {
    document.getElementById('preview-items').innerHTML = '';
    document.getElementById('preview-grid').style.display = 'none';
    document.getElementById('photo-input').value = '';
    document.getElementById('upload-btn').style.display = 'none';
    document.getElementById('clear-btn').style.display  = 'none';
    selectedFiles = [];
}

function handleDrop(event) {
    event.preventDefault();
    const dz = document.getElementById('drop-zone');
    dz.style.borderColor = 'rgba(22,163,74,0.3)';
    dz.style.background  = 'rgba(22,163,74,0.03)';
    const dt = new DataTransfer();
    Array.from(event.dataTransfer.files).forEach(f => dt.items.add(f));
    document.getElementById('photo-input').files = dt.files;
    previewFiles(dt.files);
}

function editTitle(id) {
    document.getElementById('title-view-' + id).style.display = 'none';
    document.getElementById('title-form-' + id).style.display = 'block';
    document.querySelector('#title-form-' + id + ' input').focus();
}

function cancelTitle(id) {
    document.getElementById('title-form-' + id).style.display = 'none';
    document.getElementById('title-view-' + id).style.display = 'flex';
}
</script>
@endpush
