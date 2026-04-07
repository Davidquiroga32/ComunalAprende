@extends('admin.layout')
@section('title','Nueva Lección')
@section('page-title','Nueva Lección — ' . $modulo->titulo)

@section('content')
<style>
    .adm-back { display: inline-flex; align-items: center; gap: .4rem; font-size: .84rem; color: #0f3460; font-weight: 600; text-decoration: none; margin-bottom: 1.1rem; }
    .adm-back:hover { text-decoration: underline; }
    .adm-form-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06); padding: 1.5rem; margin-bottom: 1.25rem; }
    .adm-form-section { font-family: 'Poppins',sans-serif; font-size: .82rem; font-weight: 700; color: #0f3460; text-transform: uppercase; letter-spacing: .07em; margin-bottom: 1rem; padding-bottom: .5rem; border-bottom: 2px solid #f0f4f8; display: flex; align-items: center; gap: .4rem; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.1rem; }
    .form-full { grid-column: 1/-1; }
    .fg { margin-bottom: .1rem; }
    .fg label { display: block; font-size: .83rem; font-weight: 600; color: #334155; margin-bottom: .35rem; }
    .fg label .req { color: #e94560; }
    .fi { width: 100%; padding: .65rem .9rem; border: 1.5px solid #d1d9e0; border-radius: 8px; font-size: .88rem; color: #334155; background: #fff; transition: border-color .16s, box-shadow .16s; outline: none; font-family: inherit; }
    .fi:focus { border-color: #0f3460; box-shadow: 0 0 0 3px rgba(15,52,96,.1); }
    textarea.fi { resize: vertical; min-height: 200px; }
    .fe { font-size: .78rem; color: #e94560; margin-top: .3rem; display: flex; align-items: center; gap: .3rem; }
    .toggle-row { display: flex; align-items: center; gap: .75rem; }
    .toggle-switch { position: relative; width: 44px; height: 24px; flex-shrink: 0; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider { position: absolute; inset: 0; background: #d1d9e0; border-radius: 999px; cursor: pointer; transition: background .2s; }
    .toggle-slider::before { content: ''; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: transform .2s; }
    .toggle-switch input:checked + .toggle-slider { background: #0f3460; }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(20px); }
    .btn-save { display: inline-flex; align-items: center; gap: .5rem; padding: .7rem 1.5rem; background: #0f3460; color: #fff; border: none; border-radius: 8px; font-size: .9rem; font-weight: 700; cursor: pointer; transition: background .16s; }
    .btn-save:hover { background: #1a1a2e; }
    .btn-cancel { display: inline-flex; align-items: center; gap: .5rem; padding: .7rem 1.25rem; background: #f0f4f8; color: #64748b; border-radius: 8px; font-size: .9rem; font-weight: 600; text-decoration: none; transition: background .16s; }
    .btn-cancel:hover { background: #e2e8f0; color: #334155; }
    .tipo-tabs { display: flex; flex-wrap: wrap; gap: .5rem; margin-top: .35rem; }
    .tipo-tab { flex: 1; min-width: 90px; display: flex; align-items: center; justify-content: center; gap: .4rem; padding: .6rem; border: 1.5px solid #d1d9e0; border-radius: 8px; cursor: pointer; font-size: .82rem; font-weight: 600; color: #64748b; transition: all .16s; user-select: none; }
    .tipo-tab input { display: none; }
    .tipo-tab:has(input:checked) { border-color: #0f3460; background: #f0f4f8; color: #0f3460; }
    @media (max-width: 700px) { .form-grid { grid-template-columns: 1fr; } }
</style>

<a href="{{ route('admin.cursos.show', $curso) }}" class="adm-back">
    <i class="fas fa-arrow-left"></i> Volver al curso
</a>

<form method="POST" action="{{ route('admin.lecciones.store', $modulo) }}" enctype="multipart/form-data">
    @csrf

    <div class="adm-form-card">
        <div class="adm-form-section"><i class="fas fa-info-circle"></i> Información de la Lección</div>
        <div class="form-grid">
            <div class="fg form-full">
                <label for="titulo">Título <span class="req">*</span></label>
                <input type="text" id="titulo" name="titulo" class="fi @error('titulo') error @enderror"
                    value="{{ old('titulo') }}" required>
                @error('titulo')<div class="fe"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            </div>

            <div class="fg form-full">
                <label>Tipo de contenido <span class="req">*</span></label>
                <div class="tipo-tabs">
                    @foreach(['texto'=>['fa-file-alt','Texto'],'video'=>['fa-play-circle','Video'],'pdf'=>['fa-file-pdf','PDF'],'quiz'=>['fa-question-circle','Quiz'],'tarea'=>['fa-tasks','Tarea']] as $val => [$ico, $lbl])
                        <label class="tipo-tab">
                            <input type="radio" name="tipo_contenido" value="{{ $val }}"
                                {{ old('tipo_contenido','texto') == $val ? 'checked' : '' }}
                                onchange="tipoChange('{{ $val }}')">
                            <i class="fas {{ $ico }}"></i> {{ $lbl }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="fg">
                <label for="duracion_minutos">Duración (minutos)</label>
                <input type="number" id="duracion_minutos" name="duracion_minutos" class="fi" min="0"
                    value="{{ old('duracion_minutos', 0) }}">
            </div>

            <div class="fg" style="display:flex;align-items:center;padding-top:1.5rem;">
                <div class="toggle-row">
                    <label class="toggle-switch">
                        <input type="checkbox" name="activo" value="1" checked>
                        <span class="toggle-slider"></span>
                    </label>
                    <div>
                        <div style="font-weight:600;font-size:.88rem;color:#334155;">Lección Activa</div>
                        <div style="font-size:.75rem;color:#94a3b8;">Visible para estudiantes</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="adm-form-card">
        <div class="adm-form-section"><i class="fas fa-align-left"></i> Contenido</div>

        {{-- Texto --}}
        <div id="campo-texto" class="fg">
            <label for="contenido">Contenido (texto / HTML)</label>
            <textarea id="contenido" name="contenido" class="fi" rows="10">{{ old('contenido') }}</textarea>
        </div>

        {{-- Video URL --}}
        {{-- Video: tabs URL / Subir --}}
        <div id="campo-video" style="display:none;">
            <div style="display:flex;gap:.5rem;margin-bottom:1rem;">
                <button type="button" id="tab-url" onclick="videoTab('url')"
                    style="flex:1;padding:.55rem;border-radius:8px;font-size:.83rem;font-weight:600;cursor:pointer;border:1.5px solid #0f3460;background:#0f3460;color:#fff;">
                    <i class="fas fa-link"></i> URL de YouTube / Vimeo
                </button>
                <button type="button" id="tab-upload" onclick="videoTab('upload')"
                    style="flex:1;padding:.55rem;border-radius:8px;font-size:.83rem;font-weight:600;cursor:pointer;border:1.5px solid #d1d9e0;background:#f8fafc;color:#64748b;">
                    <i class="fas fa-upload"></i> Subir video propio
                </button>
            </div>
            <div id="video-panel-url" class="fg">
                <label for="video_url">URL del video (YouTube, Vimeo&hellip;)</label>
                <input type="url" id="video_url" name="video_url" class="fi @error('video_url') error @enderror"
                    value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                @error('video_url')<div class="fe"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            </div>
            <div id="video-panel-upload" class="fg" style="display:none;">
                <label for="video_archivo">Archivo de video (MP4, MOV, WEBM &mdash; m&aacute;x. 500 MB)</label>
                <input type="file" id="video_archivo" name="video_archivo" class="fi"
                    accept="video/mp4,video/quicktime,video/avi,video/webm">
                <div style="font-size:.75rem;color:#94a3b8;margin-top:.35rem;">
                    <i class="fas fa-info-circle"></i> El video se guardar&aacute; en el servidor y podr&aacute; reproducirse directamente.
                </div>
                @error('video_archivo')<div class="fe"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Archivo --}}
        <div id="campo-archivo" class="fg" style="display:none;">
            <label for="archivo">Archivo (PDF, DOC, PPT — máx. 10MB)</label>
            <input type="file" id="archivo" name="archivo" class="fi"
                accept=".pdf,.doc,.docx,.ppt,.pptx">
            @error('archivo')<div class="fe"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        {{-- Quiz / Tarea --}}
        <div id="campo-quiz" style="display:none;">
            <div style="background:#f8fafc;border-radius:8px;padding:1rem;font-size:.86rem;color:#64748b;text-align:center;">
                <i class="fas fa-tools" style="font-size:1.5rem;display:block;margin-bottom:.5rem;color:#94a3b8;"></i>
                La funcionalidad de quiz y tareas se puede implementar en la siguiente fase.
                Por ahora puedes agregar las instrucciones en el campo de texto.
            </div>
        </div>
    </div>

    <div style="display:flex;align-items:center;gap:.75rem;">
        <button type="submit" class="btn-save"><i class="fas fa-save"></i> Crear Lección</button>
        <a href="{{ route('admin.cursos.show', $curso) }}" class="btn-cancel"><i class="fas fa-times"></i> Cancelar</a>
    </div>
</form>

<script src="https://cdn.tiny.cloud/1/p30aqfgpavkfbyxyl70u3q5ebnu6du23mu5o9byqtxbpy65q/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#contenido',
    language: 'es',
    language_url: 'https://cdn.jsdelivr.net/npm/tinymce-i18n@23.10.9/langs7/es.js',
    height: 450,
    menubar: false,
    branding: false,
    promotion: false,
    plugins: 'lists link image media table code wordcount',
    toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media | table | code',
    block_formats: 'Párrafo=p; Encabezado 2=h2; Encabezado 3=h3; Encabezado 4=h4',
    images_upload_url: '{{ route("admin.lecciones.upload-imagen") }}',
    images_upload_handler: function(blobInfo, progress) {
        return new Promise(function(resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{ route("admin.lecciones.upload-imagen") }}');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhr.upload.onprogress = function(e) { progress(e.loaded / e.total * 100); };
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var json = JSON.parse(xhr.responseText);
                    resolve(json.location);
                } else {
                    reject('Error al subir la imagen: ' + xhr.status);
                }
            };
            var formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        });
    },
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, Segoe UI, sans-serif; font-size: 15px; color: #334155; line-height: 1.7; max-width: 100%; } img { max-width: 100%; height: auto; border-radius: 6px; }',
    setup: function(editor) {
        editor.on('change', function() { editor.save(); });
    }
});
function videoTab(tab) {
    document.getElementById('video-panel-url').style.display    = tab === 'url'    ? 'block' : 'none';
    document.getElementById('video-panel-upload').style.display = tab === 'upload' ? 'block' : 'none';
    document.getElementById('tab-url').style.background    = tab === 'url'    ? '#0f3460' : '#f8fafc';
    document.getElementById('tab-url').style.color         = tab === 'url'    ? '#fff'    : '#64748b';
    document.getElementById('tab-url').style.borderColor   = tab === 'url'    ? '#0f3460' : '#d1d9e0';
    document.getElementById('tab-upload').style.background = tab === 'upload' ? '#0f3460' : '#f8fafc';
    document.getElementById('tab-upload').style.color      = tab === 'upload' ? '#fff'    : '#64748b';
    document.getElementById('tab-upload').style.borderColor= tab === 'upload' ? '#0f3460' : '#d1d9e0';
}
function videoTab(tab) {
    document.getElementById('video-panel-url').style.display    = tab === 'url'    ? 'block' : 'none';
    document.getElementById('video-panel-upload').style.display = tab === 'upload' ? 'block' : 'none';
    document.getElementById('tab-url').style.cssText    = tab==='url'    ? 'flex:1;padding:.55rem;border-radius:8px;font-size:.83rem;font-weight:600;cursor:pointer;border:1.5px solid #0f3460;background:#0f3460;color:#fff;' : 'flex:1;padding:.55rem;border-radius:8px;font-size:.83rem;font-weight:600;cursor:pointer;border:1.5px solid #d1d9e0;background:#f8fafc;color:#64748b;';
    document.getElementById('tab-upload').style.cssText = tab==='upload' ? 'flex:1;padding:.55rem;border-radius:8px;font-size:.83rem;font-weight:600;cursor:pointer;border:1.5px solid #0f3460;background:#0f3460;color:#fff;' : 'flex:1;padding:.55rem;border-radius:8px;font-size:.83rem;font-weight:600;cursor:pointer;border:1.5px solid #d1d9e0;background:#f8fafc;color:#64748b;';
}
function tipoChange(tipo) {
    document.getElementById('campo-texto').style.display   = tipo === 'texto' ? 'block' : 'none';
    document.getElementById('campo-video').style.display   = tipo === 'video' ? 'block' : 'none';
    document.getElementById('campo-archivo').style.display = tipo === 'pdf' ? 'block' : 'none';
    document.getElementById('campo-quiz').style.display    = 'none';
    if (tipo === 'texto') {
        tinymce.get('contenido') && tinymce.get('contenido').show();
    } else {
        tinymce.get('contenido') && tinymce.get('contenido').hide();
    }
}
document.addEventListener('DOMContentLoaded', () => tipoChange('{{ old("tipo_contenido","texto") }}'));
</script>
@endsection