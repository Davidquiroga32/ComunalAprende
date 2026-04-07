{{-- resources/views/admin/cursos/form.blade.php --}}
{{-- Partial compartido por create y edit --}}

<style>
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.1rem; }
    .form-full  { grid-column: 1 / -1; }
    .adm-form-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06); padding: 1.5rem; margin-bottom: 1.25rem; }
    .adm-form-section { font-family: 'Poppins',sans-serif; font-size: .82rem; font-weight: 700; color: #0f3460; text-transform: uppercase; letter-spacing: .07em; margin-bottom: 1rem; padding-bottom: .5rem; border-bottom: 2px solid #f0f4f8; display: flex; align-items: center; gap: .4rem; }

    .fg { margin-bottom: .1rem; }
    .fg label { display: block; font-size: .83rem; font-weight: 600; color: #334155; margin-bottom: .35rem; }
    .fg label .req { color: #e94560; }
    .fi {
        width: 100%; padding: .65rem .9rem;
        border: 1.5px solid #d1d9e0; border-radius: 8px;
        font-size: .88rem; color: #334155; background: #fff;
        transition: border-color .16s, box-shadow .16s; outline: none; font-family: inherit;
    }
    .fi:focus { border-color: #0f3460; box-shadow: 0 0 0 3px rgba(15,52,96,.1); }
    .fi.error { border-color: #e94560; }
    textarea.fi { resize: vertical; min-height: 90px; }
    .fe { font-size: .78rem; color: #e94560; margin-top: .3rem; display: flex; align-items: center; gap: .3rem; }

    .toggle-row { display: flex; align-items: center; gap: .75rem; }
    .toggle-switch { position: relative; width: 44px; height: 24px; flex-shrink: 0; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; inset: 0; background: #d1d9e0; border-radius: 999px; cursor: pointer; transition: background .2s;
    }
    .toggle-slider::before { content: ''; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: transform .2s; }
    .toggle-switch input:checked + .toggle-slider { background: #0f3460; }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(20px); }

    .icon-preview { display: flex; align-items: center; gap: .75rem; margin-top: .5rem; }
    .icon-preview-box { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: #fff; background: linear-gradient(135deg,#0A4D8C,#3B88D4); }

    .btn-save {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .7rem 1.5rem; background: #0f3460; color: #fff;
        border: none; border-radius: 8px; font-size: .9rem; font-weight: 700;
        cursor: pointer; transition: background .16s;
    }
    .btn-save:hover { background: #1a1a2e; }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .7rem 1.25rem; background: #f0f4f8; color: #64748b;
        border-radius: 8px; font-size: .9rem; font-weight: 600;
        text-decoration: none; transition: background .16s;
    }
    .btn-cancel:hover { background: #e2e8f0; color: #334155; }

    @media (max-width: 700px) { .form-grid { grid-template-columns: 1fr; } }
</style>

<div class="adm-form-card">
    <div class="adm-form-section"><i class="fas fa-info-circle"></i> Información Básica</div>
    <div class="form-grid">
        <div class="fg form-full">
            <label for="titulo">Título del curso <span class="req">*</span></label>
            <input type="text" id="titulo" name="titulo" class="fi @error('titulo') error @enderror"
                value="{{ old('titulo', $curso->titulo ?? '') }}" required>
            @error('titulo')<div class="fe"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        <div class="fg form-full">
            <label for="descripcion_corta">Descripción corta (máx. 500 caracteres)</label>
            <input type="text" id="descripcion_corta" name="descripcion_corta" class="fi @error('descripcion_corta') error @enderror"
                value="{{ old('descripcion_corta', $curso->descripcion_corta ?? '') }}"
                placeholder="Breve resumen que se muestra en las tarjetas del catálogo">
            @error('descripcion_corta')<div class="fe"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        <div class="fg form-full">
            <label for="descripcion">Descripción completa</label>
            <textarea id="descripcion" name="descripcion" class="fi @error('descripcion') error @enderror"
                    rows="4">{{ old('descripcion', $curso->descripcion ?? '') }}</textarea>
            @error('descripcion')<div class="fe"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        <div class="fg">
            <label for="categoria">Categoría <span class="req">*</span></label>
            <select id="categoria" name="categoria" class="fi" required>
                @foreach(['gestion'=>'Gestión Comunal','normatividad'=>'Normatividad','liderazgo'=>'Liderazgo','proyectos'=>'Formulación de Proyectos','participacion'=>'Participación Ciudadana','contabilidad'=>'Contabilidad','otro'=>'Otro'] as $val => $label)
                    <option value="{{ $val }}" {{ old('categoria', $curso->categoria ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="fg">
            <label for="duracion_horas">Duración (horas)</label>
            <input type="number" id="duracion_horas" name="duracion_horas" class="fi" min="0"
                value="{{ old('duracion_horas', $curso->duracion_horas ?? 0) }}">
        </div>
    </div>
</div>

<div class="adm-form-card">
    <div class="adm-form-section"><i class="fas fa-dollar-sign"></i> Precio y Tipo</div>
    <div class="form-grid">
        <div class="fg">
            <label>Tipo de curso <span class="req">*</span></label>
            <div style="display:flex;gap:.75rem;margin-top:.35rem;">
                <label style="flex:1;display:flex;align-items:center;gap:.5rem;padding:.65rem 1rem;border:1.5px solid #d1d9e0;border-radius:8px;cursor:pointer;" id="tipo-free-label">
                    <input type="radio" name="tipo" value="free" id="tipo-free"
                        {{ old('tipo', $curso->tipo ?? 'free') == 'free' ? 'checked' : '' }}
                        onchange="togglePrecio(false)" style="display:none;">
                    <i class="fas fa-gift" style="color:#16a34a;"></i>
                    <span style="font-weight:600;font-size:.88rem;">Gratuito</span>
                </label>
                <label style="flex:1;display:flex;align-items:center;gap:.5rem;padding:.65rem 1rem;border:1.5px solid #d1d9e0;border-radius:8px;cursor:pointer;" id="tipo-paid-label">
                    <input type="radio" name="tipo" value="paid" id="tipo-paid"
                        {{ old('tipo', $curso->tipo ?? '') == 'paid' ? 'checked' : '' }}
                        onchange="togglePrecio(true)" style="display:none;">
                    <i class="fas fa-tag" style="color:#d97706;"></i>
                    <span style="font-weight:600;font-size:.88rem;">De Pago</span>
                </label>
            </div>
        </div>

        <div class="fg" id="precio-field" style="display:{{ old('tipo', $curso->tipo ?? 'free') == 'paid' ? 'block' : 'none' }};">
            <label for="precio">Precio (COP)</label>
            <input type="number" id="precio" name="precio" class="fi" min="0" step="1000"
                value="{{ old('precio', $curso->precio ?? 0) }}"
                placeholder="Ej: 120000">
        </div>
    </div>
</div>

<div class="adm-form-card">
    <div class="adm-form-section"><i class="fas fa-palette"></i> Apariencia</div>
    <div class="form-grid">
        <div class="fg">
            <label for="icono_fa">Ícono Font Awesome</label>
            <input type="text" id="icono_fa" name="icono_fa" class="fi"
                value="{{ old('icono_fa', $curso->icono_fa ?? 'fa-graduation-cap') }}"
                placeholder="fa-graduation-cap" oninput="updateIconPreview()">
            <div class="icon-preview">
                <div class="icon-preview-box" id="iconPreviewBox">
                    <i class="fas {{ old('icono_fa', $curso->icono_fa ?? 'fa-graduation-cap') }}" id="iconPreviewIcon"></i>
                </div>
                <small style="color:#94a3b8;font-size:.78rem;">Busca íconos en <a href="https://fontawesome.com/icons" target="_blank" style="color:#0f3460;">fontawesome.com/icons</a></small>
            </div>
        </div>

        <div class="fg">
            <label for="color_gradiente">Colores del gradiente</label>
            <input type="text" id="color_gradiente" name="color_gradiente" class="fi"
                value="{{ old('color_gradiente', $curso->color_gradiente ?? '#0A4D8C,#3B88D4') }}"
                placeholder="#0A4D8C,#3B88D4">
            <small style="color:#94a3b8;font-size:.78rem;">Dos colores hex separados por coma</small>
        </div>

        <div class="fg">
            <label>Imagen de portada</label>
            @if(isset($curso) && $curso->imagen)
                <div style="margin-bottom:.5rem;">
                    <img src="{{ $curso->imagen }}" alt="portada"
                        style="height:80px;border-radius:8px;object-fit:cover;">
                </div>
            @endif
            <input type="file" id="imagen" name="imagen" class="fi" accept="image/*">
        </div>
    </div>
</div>

<div class="adm-form-card">
    <div class="adm-form-section"><i class="fas fa-cog"></i> Configuración</div>
    <div style="display:flex;flex-wrap:wrap;gap:1.5rem;">
        <div class="toggle-row">
            <label class="toggle-switch">
                <input type="checkbox" name="activo" value="1"
                    {{ old('activo', $curso->activo ?? true) ? 'checked' : '' }}>
                <span class="toggle-slider"></span>
            </label>
            <div>
                <div style="font-weight:600;font-size:.88rem;color:#334155;">Curso Activo</div>
                <div style="font-size:.75rem;color:#94a3b8;">Visible para los estudiantes</div>
            </div>
        </div>
        <div class="toggle-row">
            <label class="toggle-switch">
                <input type="checkbox" name="destacado" value="1"
                    {{ old('destacado', $curso->destacado ?? false) ? 'checked' : '' }}>
                <span class="toggle-slider"></span>
            </label>
            <div>
                <div style="font-weight:600;font-size:.88rem;color:#334155;">Destacado</div>
                <div style="font-size:.75rem;color:#94a3b8;">Se muestra primero en el catálogo</div>
            </div>
        </div>
    </div>
</div>

<div style="display:flex;align-items:center;gap:.75rem;">
    <button type="submit" class="btn-save">
        <i class="fas fa-save"></i> {{ isset($curso) && $curso->exists ? 'Guardar Cambios' : 'Crear Curso' }}
    </button>
    <a href="{{ route('admin.cursos.index') }}" class="btn-cancel">
        <i class="fas fa-times"></i> Cancelar
    </a>
</div>

<script>
function togglePrecio(show) {
    document.getElementById('precio-field').style.display = show ? 'block' : 'none';
    const freeLabel = document.getElementById('tipo-free-label');
    const paidLabel = document.getElementById('tipo-paid-label');
    freeLabel.style.borderColor = show ? '#d1d9e0' : '#0f3460';
    freeLabel.style.background  = show ? '#fff' : '#f0f4f8';
    paidLabel.style.borderColor = show ? '#0f3460' : '#d1d9e0';
    paidLabel.style.background  = show ? '#f0f4f8' : '#fff';
}

function updateIconPreview() {
    const val = document.getElementById('icono_fa').value.trim();
    const icon = document.getElementById('iconPreviewIcon');
    icon.className = 'fas ' + (val || 'fa-graduation-cap');
}

document.addEventListener('DOMContentLoaded', () => {
    const isPaid = document.getElementById('tipo-paid')?.checked;
    togglePrecio(isPaid);
});
</script>