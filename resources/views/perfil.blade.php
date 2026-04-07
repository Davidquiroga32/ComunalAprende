@extends('layouts.dashboard')

@section('title', 'Mi Perfil')
@section('page-title', 'Mi Perfil')

@section('content')
<style>
    .perf-grid { display: grid; grid-template-columns: 280px 1fr; gap: 1.25rem; align-items: start; }
    .perf-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(10,77,140,.07); overflow: hidden; }

    /* Avatar card */
    .avatar-section { padding: 2rem 1.5rem; text-align: center; border-bottom: 1px solid #e8eef5; }
    .avatar-wrap { position: relative; width: 96px; height: 96px; margin: 0 auto 1rem; }
    .avatar-img { width: 96px; height: 96px; border-radius: 50%; object-fit: cover; border: 3px solid #EBF3FF; }
    .avatar-init {
        width: 96px; height: 96px; border-radius: 50%;
        background: linear-gradient(135deg, #0A4D8C, #3B88D4);
        color: #fff; font-size: 2.4rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        border: 3px solid #EBF3FF;
    }
    .avatar-cam {
        position: absolute; bottom: 0; right: 0;
        width: 28px; height: 28px; background: #0A4D8C; color: #fff;
        border-radius: 50%; border: 2px solid #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: .72rem; cursor: pointer; transition: background .16s;
    }
    .avatar-cam:hover { background: #073A6B; }

    .perf-name   { font-family: 'Poppins',sans-serif; font-weight: 700; font-size: 1rem; color: #073A6B; margin-bottom: .2rem; }
    .perf-email  { font-size: .82rem; color: #64748b; }
    .perf-cond   {
        display: inline-block; margin-top: .5rem;
        background: #EBF3FF; color: #0A4D8C;
        font-size: .75rem; font-weight: 600;
        padding: .2rem .7rem; border-radius: 999px;
    }

    .perf-meta { padding: 1rem 1.25rem; }
    .perf-meta-row { display: flex; align-items: center; gap: .6rem; padding: .5rem 0; border-bottom: 1px solid #f1f5f9; font-size: .83rem; color: #475569; }
    .perf-meta-row:last-child { border-bottom: none; }
    .perf-meta-row i { color: #0A4D8C; width: 15px; text-align: center; }

    /* Form */
    .perf-section-title {
        font-family: 'Poppins',sans-serif; font-size: .82rem; font-weight: 700;
        color: #0A4D8C; text-transform: uppercase; letter-spacing: .07em;
        margin-bottom: 1rem; padding-bottom: .5rem;
        border-bottom: 2px solid #EBF3FF;
        display: flex; align-items: center; gap: .4rem;
    }
    .perf-form-pad { padding: 1.5rem; }
    .fg { margin-bottom: 1rem; }
    .fg label { display: block; font-size: .83rem; font-weight: 600; color: #334155; margin-bottom: .35rem; }
    .fg label .req { color: #dc3545; }
    .fi-wrap { position: relative; }
    .fi-wrap i.ico { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: .9rem; pointer-events: none; }
    .fi {
        width: 100%; padding: .65rem .9rem .65rem 2.4rem;
        border: 1.5px solid #d1d9e0; border-radius: 8px;
        font-size: .88rem; color: #334155;
        background: #fff; transition: border-color .16s, box-shadow .16s;
        outline: none; font-family: inherit;
    }
    .fi:focus { border-color: #0A4D8C; box-shadow: 0 0 0 3px rgba(10,77,140,.12); }
    .fi.error { border-color: #dc3545; }
    .fi-disabled { background: #f8fafc; cursor: not-allowed; color: #94a3b8; }
    select.fi { padding-left: 2.4rem; }
    .fe { font-size: .78rem; color: #dc3545; margin-top: .3rem; display: flex; align-items: center; gap: .3rem; }
    .fg-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .fg-full { grid-column: 1 / -1; }
    .form-save-row { display: flex; justify-content: flex-end; margin-top: .5rem; }

    .oac-radios { display: flex; gap: .75rem; margin-top: .4rem; }
    .oac-opt {
        flex: 1; display: flex; align-items: center; gap: .5rem;
        padding: .65rem 1rem; border: 1.5px solid #d1d9e0; border-radius: 8px;
        cursor: pointer; font-size: .86rem; font-weight: 500; color: #64748b;
        transition: all .16s; user-select: none;
    }
    .oac-opt input { display: none; }
    .oac-opt:has(input:checked) { border-color: #0A4D8C; background: #EBF3FF; color: #0A4D8C; }

    @media (max-width: 900px) { .perf-grid { grid-template-columns: 1fr; } }
    @media (max-width: 600px) { .fg-2col { grid-template-columns: 1fr; } }
</style>

<div class="perf-grid">

    {{-- Col izquierda: avatar + datos resumidos + cambiar contraseña --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- Avatar --}}
        <div class="perf-card">
            <div class="avatar-section">
                <form method="POST" action="{{ route('dashboard.perfil.update') }}"
                    enctype="multipart/form-data" id="avatarForm">
                    @csrf @method('PUT')
                    {{-- Campos requeridos por la validación --}}
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="condicion" value="{{ $user->condicion }}">
                    <input type="hidden" name="pertenece_oac" value="{{ $user->pertenece_oac ? '1' : '0' }}">
                    @if($user->organismo_accion_comunal)
                        <input type="hidden" name="organismo_accion_comunal" value="{{ $user->organismo_accion_comunal }}">
                    @endif
                    @if($user->celular)
                        <input type="hidden" name="celular" value="{{ $user->celular }}">
                    @endif
                    @if($user->departamento)
                        <input type="hidden" name="departamento" value="{{ $user->departamento }}">
                    @endif
                    @if($user->municipio)
                        <input type="hidden" name="municipio" value="{{ $user->municipio }}">
                    @endif
                    <div class="avatar-wrap">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="avatar"
                                class="avatar-img" id="avatarImg">
                        @else
                            <div class="avatar-init" id="avatarInit">{{ strtoupper(substr($user->name,0,1)) }}</div>
                            <img src="" alt="avatar" class="avatar-img" id="avatarImg" style="display:none;">
                        @endif
                        <label class="avatar-cam" for="avatarFile" title="Cambiar foto">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" id="avatarFile" name="avatar"
                            accept="image/*" style="display:none;" onchange="previewAvatar(this)">
                    </div>
                </form>
                <div class="perf-name">{{ $user->name }}</div>
                <div class="perf-email">{{ $user->email }}</div>
                <span class="perf-cond">{{ $user->condicion === 'afiliado' ? 'Afiliado' : 'Particular' }}</span>
            </div>
            <div class="perf-meta">
                @if($user->celular)
                    <div class="perf-meta-row"><i class="fas fa-mobile-alt"></i> {{ $user->celular }}</div>
                @endif
                @if($user->municipio)
                    <div class="perf-meta-row"><i class="fas fa-map-marker-alt"></i> {{ $user->municipio }}, {{ $user->departamento }}</div>
                @endif
                @if($user->documento)
                    <div class="perf-meta-row"><i class="fas fa-id-card"></i> {{ $user->documento }}</div>
                @endif
                @if($user->pertenece_oac && $user->organismo_accion_comunal)
                    <div class="perf-meta-row"><i class="fas fa-users"></i> {{ $user->organismo_accion_comunal }}</div>
                @endif
                <div class="perf-meta-row">
                    <i class="fas fa-calendar"></i> Miembro desde {{ $user->created_at->format('d/m/Y') }}
                </div>
            </div>
        </div>

        {{-- Cambiar contraseña --}}
        <div class="perf-card">
            <div class="perf-form-pad">
                <div class="perf-section-title"><i class="fas fa-lock"></i> Cambiar Contraseña</div>
                <form method="POST" action="{{ route('dashboard.password.update') }}">
                    @csrf @method('PUT')
                    <div class="fg">
                        <label for="current_password">Contraseña actual <span class="req">*</span></label>
                        <div class="fi-wrap">
                            <i class="fas fa-lock ico"></i>
                            <input type="password" id="current_password" name="current_password"
                                   class="fi @error('current_password') error @enderror"
                                   placeholder="Tu contraseña actual">
                        </div>
                        @error('current_password')<div class="fe"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="fg">
                        <label for="password">Nueva contraseña <span class="req">*</span></label>
                        <div class="fi-wrap">
                            <i class="fas fa-key ico"></i>
                            <input type="password" id="password" name="password"
                                   class="fi @error('password') error @enderror"
                                   placeholder="Mínimo 8 caracteres">
                        </div>
                        @error('password')<div class="fe"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="fg">
                        <label for="password_confirmation">Confirmar nueva contraseña</label>
                        <div class="fi-wrap">
                            <i class="fas fa-key ico"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="fi" placeholder="Repite la contraseña">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                        <i class="fas fa-save"></i> Actualizar Contraseña
                    </button>
                </form>
            </div>
        </div>

    </div>

    {{-- Col derecha: formulario datos personales --}}
    <div class="perf-card">
        <div class="perf-form-pad">
            <div class="perf-section-title"><i class="fas fa-user-edit"></i> Datos Personales</div>

            <form method="POST" action="{{ route('dashboard.perfil.update') }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="fg-2col">
                    {{-- Nombre --}}
                    <div class="fg fg-full">
                        <label for="name">Nombre completo <span class="req">*</span></label>
                        <div class="fi-wrap">
                            <i class="fas fa-user ico"></i>
                            <input type="text" id="name" name="name"
                                   class="fi @error('name') error @enderror"
                                   value="{{ old('name', $user->name) }}" required>
                        </div>
                        @error('name')<div class="fe"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>

                    {{-- Documento --}}
                    <div class="fg">
                        <label for="documento">Documento de identidad</label>
                        <div class="fi-wrap">
                            <i class="fas fa-id-card ico"></i>
                            <input type="text" class="fi fi-disabled" value="{{ $user->documento }}" disabled>
                        </div>
                        <small style="font-size:.75rem;color:#94a3b8;">No puede modificarse.</small>
                    </div>

                    {{-- Correo --}}
                    <div class="fg">
                        <label>Correo electrónico</label>
                        <div class="fi-wrap">
                            <i class="fas fa-envelope ico"></i>
                            <input type="email" class="fi fi-disabled" value="{{ $user->email }}" disabled>
                        </div>
                        <small style="font-size:.75rem;color:#94a3b8;">No puede modificarse.</small>
                    </div>

                    {{-- Celular --}}
                    <div class="fg">
                        <label for="celular">Número de celular</label>
                        <div class="fi-wrap">
                            <i class="fas fa-mobile-alt ico"></i>
                            <input type="tel" id="celular" name="celular"
                                   class="fi @error('celular') error @enderror"
                                   value="{{ old('celular', $user->celular) }}"
                                   placeholder="Ej: 3001234567">
                        </div>
                        @error('celular')<div class="fe"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>

                    {{-- Departamento --}}
                    <div class="fg">
                        <label for="departamento">Departamento</label>
                        <div class="fi-wrap">
                            <i class="fas fa-map ico"></i>
                            <select id="departamento" name="departamento" class="fi" onchange="filtrarMunicipiosPerf()">
                                <option value="">-- Selecciona --</option>
                                @foreach(['Amazonas','Antioquia','Arauca','Atlántico','Bolívar','Boyacá','Caldas','Caquetá','Casanare','Cauca','Cesar','Chocó','Córdoba','Cundinamarca','Guainía','Guaviare','Huila','La Guajira','Magdalena','Meta','Nariño','Norte de Santander','Putumayo','Quindío','Risaralda','San Andrés','Santander','Sucre','Tolima','Valle del Cauca','Vaupés','Vichada','Bogotá D.C.'] as $dep)
                                    <option value="{{ $dep }}" {{ old('departamento', $user->departamento) == $dep ? 'selected' : '' }}>{{ $dep }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Municipio --}}
                    <div class="fg">
                        <label for="municipio">Municipio</label>
                        <div class="fi-wrap">
                            <i class="fas fa-city ico"></i>
                            <select id="municipio" name="municipio" class="fi">
                                <option value="{{ $user->municipio }}" selected>{{ $user->municipio ?? '-- Selecciona departamento primero --' }}</option>
                            </select>
                        </div>
                    </div>

                    {{-- OAC --}}
                    <div class="fg fg-full">
                        <label>¿Pertenece a un Organismo de Acción Comunal?</label>
                        <div class="oac-radios">
                            <label class="oac-opt">
                                <input type="radio" name="pertenece_oac" value="1"
                                       {{ old('pertenece_oac', $user->pertenece_oac ? '1' : '0') == '1' ? 'checked' : '' }}
                                       onchange="toggleOACPerf(true)">
                                <i class="fas fa-check-circle"></i> Sí
                            </label>
                            <label class="oac-opt">
                                <input type="radio" name="pertenece_oac" value="0"
                                       {{ old('pertenece_oac', $user->pertenece_oac ? '1' : '0') == '0' ? 'checked' : '' }}
                                       onchange="toggleOACPerf(false)">
                                <i class="fas fa-times-circle"></i> No
                            </label>
                        </div>
                    </div>

                    <div class="fg fg-full" id="oacFieldPerf"
                         style="display:{{ old('pertenece_oac', $user->pertenece_oac ? '1' : '0') == '1' ? 'block' : 'none' }};">
                        <label for="organismo_accion_comunal">Nombre del Organismo</label>
                        <div class="fi-wrap">
                            <i class="fas fa-building ico"></i>
                            <input type="text" id="organismo_accion_comunal" name="organismo_accion_comunal"
                                   class="fi @error('organismo_accion_comunal') error @enderror"
                                   value="{{ old('organismo_accion_comunal', $user->organismo_accion_comunal) }}"
                                   placeholder="Ej: JAC Barrio El Prado">
                        </div>
                        @error('organismo_accion_comunal')<div class="fe"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>

                    {{-- Condición --}}
                    <div class="fg fg-full">
                        <label>Condición</label>
                        <div class="oac-radios">
                            <label class="oac-opt">
                                <input type="radio" name="condicion" value="afiliado"
                                       {{ old('condicion', $user->condicion) == 'afiliado' ? 'checked' : '' }}>
                                <i class="fas fa-id-badge"></i> Afiliado
                            </label>
                            <label class="oac-opt">
                                <input type="radio" name="condicion" value="particular"
                                       {{ old('condicion', $user->condicion) == 'particular' ? 'checked' : '' }}>
                                <i class="fas fa-user"></i> Persona Particular
                            </label>
                        </div>
                        @error('condicion')<div class="fe"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-save-row">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('extra-js')
<script>
const muniData = {"Amazonas":["Leticia","El Encanto","La Chorrera","La Pedrera","La Victoria","Mirití-Paraná","Puerto Alegría","Puerto Arica","Puerto Nariño","Puerto Santander","Tarapacá"],"Antioquia":["Medellín","Abejorral","Abriaquí","Alejandría","Amagá","Amalfi","Andes","Angelópolis","Angostura","Anorí","Anzá","Apartadó","Arboletes","Argelia","Armenia","Barbosa","Bello","Betania","Betulia","Briceño","Buriticá","Cáceres","Caicedo","Caldas","Campamento","Cañasgordas","Caracolí","Caramanta","Carepa","Carolina","Caucasia","Chigorodó","Cisneros","Ciudad Bolívar","Cocorná","Concepción","Concordia","Copacabana","Dabeiba","Don Matías","Ebéjico","El Bagre","El Carmen de Viboral","El Santuario","Entrerríos","Envigado","Fredonia","Frontino","Giraldo","Girardota","Gómez Plata","Granada","Guadalupe","Guarne","Guatapé","Heliconia","Hispania","Itagüí","Ituango","Jardín","Jericó","La Ceja","La Estrella","La Pintada","La Unión","Liborina","Maceo","Marinilla","Montebello","Murindó","Mutatá","Nariño","Nechí","Necoclí","Olaya","Peñol","Peque","Pueblorrico","Puerto Berrío","Puerto Nare","Puerto Triunfo","Remedios","Rionegro","Sabanalarga","Sabaneta","Salgar","San Andrés de Cuerquia","San Carlos","San Francisco","San Jerónimo","San José de la Montaña","San Juan de Urabá","San Luis","San Pedro de los Milagros","San Pedro de Urabá","San Rafael","San Roque","San Vicente","Santa Bárbara","Santa Rosa de Osos","Santo Domingo","Segovia","Sonsón","Sopetrán","Támesis","Tarazá","Tarso","Titiribí","Toledo","Turbo","Uramita","Urrao","Valdivia","Valparaíso","Vegachí","Venecia","Vigía del Fuerte","Yalí","Yarumal","Yolombó","Yondó","Zaragoza"],"Arauca":["Arauca","Arauquita","Cravo Norte","Fortul","Puerto Rondón","Saravena","Tame"],"Atlántico":["Barranquilla","Baranoa","Campo de la Cruz","Candelaria","Galapa","Juan de Acosta","Luruaco","Malambo","Manatí","Palmar de Varela","Piojó","Polonuevo","Ponedera","Puerto Colombia","Repelón","Sabanagrande","Sabanalarga","Santa Lucía","Santo Tomás","Soledad","Suan","Tubará","Usiacurí"],"Bolívar":["Cartagena","Achí","Altos del Rosario","Arenal","Arjona","Arroyohondo","Barranco de Loba","Calamar","Cantagallo","Cicuco","Clemencia","Córdoba","El Carmen de Bolívar","El Guamo","El Peñón","Hatillo de Loba","Magangué","Mahates","Margarita","María la Baja","Montecristo","Mompós","Morales","Norosí","Pinillos","Regidor","Río Viejo","San Cristóbal","San Estanislao","San Fernando","San Jacinto","San Jacinto del Cauca","San Juan Nepomuceno","San Martín de Loba","San Pablo","Santa Catalina","Santa Rosa","Santa Rosa del Sur","Simití","Soplaviento","Talaigua Nuevo","Tiquisio","Turbaco","Turbana","Villanueva","Zambrano"],"Boyacá":["Tunja","Almeida","Aquitania","Arcabuco","Belén","Berbeo","Betéitiva","Boavita","Boyacá","Briceño","Buenavista","Busbanzá","Caldas","Campohermoso","Cerinza","Chinavita","Chiquinquirá","Chíquiza","Chiscas","Chita","Chitaraque","Chivatá","Ciénega","Cómbita","Coper","Corrales","Covarachía","Cubará","Cucaita","Cuítiva","Duitama","El Cocuy","El Espino","Firavitoba","Floresta","Gachantivá","Gámeza","Garagoa","Guacamayas","Guateque","Guayatá","Güicán","Iza","Jenesano","Jericó","La Capilla","La Uvita","La Victoria","Labranzagrande","Macanal","Maripí","Miraflores","Mongua","Monguí","Moniquirá","Motavita","Muzo","Nobsa","Nuevo Colón","Oicatá","Otanche","Pachavita","Páez","Paipa","Pajarito","Panqueba","Pauna","Paya","Paz de Río","Pesca","Pisba","Puerto Boyacá","Quípama","Ramiriquí","Ráquira","Rondón","Saboyá","Sáchica","Samacá","San Eduardo","San José de Pare","San Luis de Gaceno","San Mateo","San Miguel de Sema","San Pablo de Borbur","Santa María","Santa Rosa de Viterbo","Santa Sofía","Santana","Sativanorte","Sativasur","Siachoque","Soatá","Socotá","Socha","Sogamoso","Somondoco","Sora","Soracá","Sotaquirá","Susacón","Sutamarchán","Sutatenza","Tasco","Tenza","Tibaná","Tibasosa","Tinjacá","Tipacoque","Toca","Togüí","Tópaga","Tota","Turmequé","Tuta","Tutazá","Úmbita","Ventaquemada","Villa de Leyva","Viracachá","Zetaquira"],"Caldas":["Manizales","Aguadas","Anserma","Aranzazu","Belalcázar","Chinchiná","Filadelfia","La Dorada","La Merced","Manzanares","Marmato","Marquetalia","Marulanda","Neira","Norcasia","Pácora","Palestina","Pensilvania","Riosucio","Risaralda","Salamina","Samaná","San José","Supía","Victoria","Villamaría","Viterbo"],"Caquetá":["Florencia","Albania","Belén de los Andaquíes","Cartagena del Chairá","Curillo","El Doncello","El Paujíl","La Montañita","Milán","Morelia","Puerto Rico","San José del Fragua","San Vicente del Caguán","Solano","Solita","Valparaíso"],"Casanare":["Yopal","Aguazul","Chámeza","Hato Corozal","La Salina","Maní","Monterrey","Nunchía","Orocué","Paz de Ariporo","Pore","Recetor","Sabanalarga","Sácama","San Luis de Palenque","Támara","Tauramena","Trinidad","Villanueva"],"Cauca":["Popayán","Almaguer","Argelia","Balboa","Bolívar","Buenos Aires","Cajibío","Caldono","Caloto","Coconuco","Corinto","El Tambo","Florencia","Guachené","Guapi","Inzá","Jambaló","La Sierra","La Vega","López de Micay","Mercaderes","Miranda","Morales","Padilla","Páez","Patía","Piamonte","Piendamó","Puerto Tejada","Puracé","Rosas","San Sebastián","Santander de Quilichao","Santa Rosa","Silvia","Sotara","Suárez","Sucre","Timbío","Timbiquí","Toribío","Totoró","Villa Rica"],"Cesar":["Valledupar","Aguachica","Agustín Codazzi","Astrea","Becerril","Bosconia","Chimichagua","Chiriguaná","Curumaní","El Copey","El Paso","Gamarra","González","La Gloria","La Jagua de Ibirico","La Paz","Manaure","Pailitas","Pelaya","Pueblo Bello","Río de Oro","San Alberto","San Diego","San Martín","Tamalameque"],"Chocó":["Quibdó","Acandí","Alto Baudó","Atrato","Bagadó","Bahía Solano","Bajo Baudó","Bojayá","Carmen del Darién","Cértegui","Condoto","El Cantón del San Pablo","El Carmen de Atrato","El Litoral del San Juan","Istmina","Juradó","Lloró","Medio Atrato","Medio Baudó","Medio San Juan","Nóvita","Nuquí","Río Iro","Río Quito","Riosucio","San José del Palmar","Sipí","Tadó","Unión Panamericana"],"Córdoba":["Montería","Ayapel","Buenavista","Canalete","Cereté","Chimá","Chinú","Ciénaga de Oro","Cotorra","La Apartada","Lorica","Los Córdobas","Momil","Montelíbano","Moñitos","Planeta Rica","Pueblo Nuevo","Puerto Escondido","Puerto Libertador","Purísima","Sahagún","San Andrés de Sotavento","San Antero","San Bernardo del Viento","San Carlos","San José de Uré","San Pelayo","Tierralta","Tuchín","Valencia"],"Cundinamarca":["Agua de Dios","Albán","Anapoima","Anolaima","Arbeláez","Beltrán","Bituima","Bojacá","Cabrera","Cachipay","Cajicá","Caparrapí","Cáqueza","Carmen de Carupa","Chaguaní","Chía","Chipaque","Choachí","Chocontá","Cogua","Cota","Cucunubá","El Colegio","El Peñón","El Rosal","Facatativá","Fómeque","Fosca","Funza","Fúquene","Fusagasugá","Gachalá","Gachancipá","Gachetá","Gama","Girardot","Granada","Guachetá","Guaduas","Guasca","Guataquí","Guatavita","Guayabal de Síquima","Guayabetal","Gutiérrez","Jerusalén","Junín","La Calera","La Mesa","La Palma","La Peña","La Vega","Lenguazaque","Machetá","Madrid","Manta","Medina","Mosquera","Nariño","Nemocón","Nilo","Nimaima","Nocaima","Pacho","Paime","Pandi","Paratebueno","Pasca","Puerto Salgar","Pulí","Quebradanegra","Quetame","Quipile","Ricaurte","San Antonio del Tequendama","San Bernardo","San Cayetano","San Francisco","San Juan de Río Seco","Sasaima","Sesquilé","Sibaté","Silvania","Simijaca","Soacha","Sopó","Subachoque","Suesca","Supatá","Susa","Sutatausa","Tabio","Tausa","Tena","Tibacuy","Tibirita","Tocaima","Tocancipá","Topaipí","Ubalá","Ubaque","Ubaté","Une","Útica","Venecia","Vergara","Vianí","Villagómez","Villapinzón","Villeta","Viotá","Yacopí","Zipacón","Zipaquirá"],"Guainía":["Inírida","Barranco Minas","Cacahual","La Guadalupe","Mapiripana","Morichal","Pana Pana","Puerto Colombia","San Felipe"],"Guaviare":["San José del Guaviare","Calamar","El Retorno","Miraflores"],"Huila":["Neiva","Acevedo","Agrado","Aipe","Algeciras","Altamira","Baraya","Campoalegre","Colombia","Elías","Garzón","Gigante","Guadalupe","Hobo","Iquira","Isnos","La Argentina","La Plata","Nátaga","Oporapa","Paicol","Palermo","Palestina","Pital","Pitalito","Rivera","Saladoblanco","San Agustín","Santa María","Suaza","Tarqui","Tesalia","Tello","Teruel","Timaná","Villavieja","Yaguará"],"La Guajira":["Riohacha","Albania","Barrancas","Dibulla","Distracción","El Molino","Fonseca","Hatonuevo","La Jagua del Pilar","Maicao","Manaure","San Juan del Cesar","Uribia","Urumita","Villanueva"],"Magdalena":["Santa Marta","Algarrobo","Aracataca","Ariguaní","Cerro de San Antonio","Chivolo","Ciénaga","Concordia","El Banco","El Piñón","El Retén","Fundación","Guamal","Nueva Granada","Pedraza","Pijiño del Carmen","Pivijay","Plato","Puebloviejo","Remolino","Sabanas de San Ángel","Salamina","San Sebastián de Buenavista","San Zenón","Santa Ana","Santa Bárbara de Pinto","Sitionuevo","Tenerife","Zapayán","Zona Bananera"],"Meta":["Villavicencio","Acacías","Barranca de Upía","Cabuyaro","Castilla la Nueva","Cubarral","Cumaral","El Calvario","El Castillo","El Dorado","Fuente de Oro","Granada","Guamal","La Macarena","La Uribe","Lejanías","Mapiripán","Mesetas","Puerto Concordia","Puerto Gaitán","Puerto Lleras","Puerto López","Puerto Rico","Restrepo","San Carlos de Guaroa","San Juan de Arama","San Juanito","San Martín","Vistahermosa"],"Nariño":["Pasto","Albán","Aldana","Ancuyá","Arboleda","Barbacoas","Belén","Buesaco","Chachagüí","Colón","Consacá","Contadero","Córdoba","Cuaspud","Cumbal","Cumbitara","El Charco","El Peñol","El Rosario","El Tablón de Gómez","El Tambo","Francisco Pizarro","Funes","Guachucal","Guaitarilla","Gualmatán","Iles","Imués","Ipiales","La Cruz","La Florida","La Llanada","La Tola","La Unión","Leiva","Linares","Los Andes","Magüí","Mallama","Mosquera","Nariño","Olaya Herrera","Ospina","Policarpa","Potosí","Providencia","Puerres","Pupiales","Ricaurte","Roberto Payán","Samaniego","San Bernardo","San Lorenzo","San Pablo","San Pedro de Cartago","Sandoná","Santa Bárbara","Santacruz","Sapuyes","Taminango","Tangua","Tumaco","Túquerres","Yacuanquer"],"Norte de Santander":["Cúcuta","Ábrego","Arboledas","Bochalema","Bucarasica","Cácota","Cachirá","Chinácota","Chitagá","Convención","Cucutilla","Durania","El Carmen","El Tarra","El Zulia","Gramalote","Hacarí","Herrán","La Esperanza","La Playa","Labateca","Los Patios","Lourdes","Mutiscua","Ocaña","Pamplona","Pamplonita","Puerto Santander","Ragonvalia","Salazar","San Calixto","San Cayetano","Santiago","Sardinata","Silos","Teorama","Tibú","Toledo","Villa Caro","Villa del Rosario"],"Putumayo":["Mocoa","Colón","Orito","Puerto Asís","Puerto Caicedo","Puerto Guzmán","Puerto Leguízamo","San Francisco","San Miguel","Santiago","Sibundoy","Valle del Guamuez","Villagarzón"],"Quindío":["Armenia","Buenavista","Calarcá","Circasia","Córdoba","Filandia","Génova","La Tebaida","Montenegro","Pijao","Quimbaya","Salento"],"Risaralda":["Pereira","Apía","Balboa","Belén de Umbría","Dosquebradas","Guática","La Celia","La Virginia","Marsella","Mistrató","Pueblo Rico","Quinchía","Santa Rosa de Cabal","Santuario"],"San Andrés":["San Andrés","Providencia"],"Santander":["Bucaramanga","Aguada","Albania","Aratoca","Barbosa","Barichara","Barrancabermeja","Betulia","Bolívar","Cabrera","California","Capitanejo","Carcasí","Cepitá","Cerrito","Charalá","Charta","Chima","Chipatá","Cimitarra","Concepción","Confines","Contratación","Coromoro","Curití","El Carmen de Chucurí","El Guacamayo","El Peñón","El Playón","Encino","Enciso","Florián","Floridablanca","Galán","Gámbita","Girón","Guaca","Guadalupe","Guapotá","Guavatá","Güepsa","Hato","Jesús María","Jordán","La Belleza","La Paz","Landázuri","Lebrija","Los Santos","Macaravita","Málaga","Matanza","Mogotes","Molagavita","Ocamonte","Oiba","Onzaga","Palmar","Palmas del Socorro","Páramo","Piedecuesta","Pinchote","Puente Nacional","Puerto Parra","Puerto Wilches","Rionegro","Sabana de Torres","San Andrés","San Benito","San Gil","San Joaquín","San José de Miranda","San Miguel","San Vicente de Chucurí","Santa Bárbara","Santa Helena del Opón","Simacota","Socorro","Suaita","Sucre","Suratá","Tona","Valle de San José","Vélez","Vetas","Villanueva","Zapatoca"],"Sucre":["Sincelejo","Buenavista","Caimito","Chalán","Colosó","Corozal","Coveñas","El Roble","Galeras","Guaranda","La Unión","Los Palmitos","Majagual","Morroa","Ovejas","Palmito","Sampués","San Benito Abad","San Juan de Betulia","San Marcos","San Onofre","San Pedro","San Luis de Sincé","Santiago de Tolú","Sucre","Tolú Viejo"],"Tolima":["Ibagué","Alpujarra","Alvarado","Ambalema","Anzoátegui","Armero","Ataco","Cajamarca","Carmen de Apicalá","Casabianca","Chaparral","Coello","Coyaima","Cunday","Dolores","Espinal","Falan","Flandes","Fresno","Guamo","Herveo","Honda","Icononzo","Lérida","Líbano","Mariquita","Melgar","Murillo","Natagaima","Ortega","Palocabildo","Piedras","Planadas","Prado","Purificación","Rioblanco","Roncesvalles","Rovira","Saldaña","San Antonio","San Luis","Santa Isabel","Suárez","Valle de San Juan","Venadillo","Villahermosa","Villarrica"],"Valle del Cauca":["Cali","Alcalá","Andalucía","Ansermanuevo","Argelia","Bolívar","Buenaventura","Buga","Bugalagrande","Caicedonia","Calima","Candelaria","Cartago","Dagua","El Águila","El Cairo","El Cerrito","El Dovio","Florida","Ginebra","Guacarí","Jamundí","La Cumbre","La Unión","La Victoria","Obando","Palmira","Pradera","Restrepo","Riofrío","Roldanillo","San Pedro","Sevilla","Toro","Trujillo","Tuluá","Ulloa","Versalles","Vijes","Yotoco","Yumbo","Zarzal"],"Vaupés":["Mitú","Carurú","Pacoa","Papunaua","Taraira","Yavaraté"],"Vichada":["Puerto Carreño","Cumaribo","La Primavera","Santa Rosalía"],"Bogotá D.C.":["Bogotá D.C."]};

const currentMun = "{{ $user->municipio }}";

function filtrarMunicipiosPerf() {
    const dep = document.getElementById('departamento').value;
    const sel = document.getElementById('municipio');
    sel.innerHTML = '<option value="">-- Selecciona municipio --</option>';
    if (dep && muniData[dep]) {
        muniData[dep].forEach(m => {
            const o = document.createElement('option');
            o.value = m; o.textContent = m;
            if (m === currentMun) o.selected = true;
            sel.appendChild(o);
        });
        sel.disabled = false;
    } else { sel.disabled = true; }
}

function toggleOACPerf(show) {
    document.getElementById('oacFieldPerf').style.display = show ? 'block' : 'none';
    document.getElementById('organismo_accion_comunal').required = show;
}

function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('avatarImg');
            const init = document.getElementById('avatarInit');
            if (init) init.style.display = 'none';
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
        document.getElementById('avatarForm').submit();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const dep = document.getElementById('departamento').value;
    if (dep) filtrarMunicipiosPerf();
});
</script>
@endsection