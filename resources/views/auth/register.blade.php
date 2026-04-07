    @extends('layouts.auth')

    @section('title', 'Registro - Comunal Aprende')

    @section('content')
    <div class="auth-container">
        <div class="auth-card" style="max-width: 640px;">

            <div class="auth-header">
                <a href="{{ route('inicio') }}" style="display:inline-block;margin-bottom:.25rem;">
                    <img src="{{ asset('images/logo.png') }}"
                        alt="Comunal Aprende"
                        style="height:120px;width:auto;object-fit:contain;"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="auth-logo" style="display:none;">CA</div>
                </a>
                <h1 class="auth-title">Crea tu cuenta</h1>
                <p class="auth-subtitle">Únete a nuestra comunidad de aprendizaje</p>
            </div>

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                {{-- ── SECCIÓN 1: Datos personales ── --}}
                <div class="register-section-title">
                    <i class="fas fa-user"></i> Datos Personales
                </div>

                {{-- Nombre completo --}}
                <div class="form-group">
                    <label class="form-label" for="name">
                        Nombre completo <span class="required">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text"
                            class="form-input @error('name') error @enderror"
                            id="name" name="name"
                            placeholder="Ej: Juan Carlos Pérez Rodríguez"
                            value="{{ old('name') }}"
                            required autofocus>
                    </div>
                    @error('name')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Documento de identidad --}}
                <div class="form-group">
                    <label class="form-label" for="documento">
                        Documento de identidad <span class="required">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-id-card input-icon"></i>
                        <input type="text"
                            class="form-input @error('documento') error @enderror"
                            id="documento" name="documento"
                            placeholder="Ej: 1234567890"
                            value="{{ old('documento') }}"
                            required>
                    </div>
                    @error('documento')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- ── SECCIÓN 2: Ubicación ── --}}
                <div class="register-section-title">
                    <i class="fas fa-map-marker-alt"></i> Ubicación
                </div>

                {{-- Departamento --}}
                <div class="form-group">
                    <label class="form-label" for="departamento">
                        Departamento <span class="required">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-map input-icon"></i>
                        <select class="form-input @error('departamento') error @enderror"
                                id="departamento" name="departamento"
                                onchange="filtrarMunicipios()" required>
                            <option value="">-- Selecciona un departamento --</option>
                            <option value="Amazonas"          {{ old('departamento') == 'Amazonas'          ? 'selected' : '' }}>Amazonas</option>
                            <option value="Antioquia"         {{ old('departamento') == 'Antioquia'         ? 'selected' : '' }}>Antioquia</option>
                            <option value="Arauca"            {{ old('departamento') == 'Arauca'            ? 'selected' : '' }}>Arauca</option>
                            <option value="Atlántico"         {{ old('departamento') == 'Atlántico'         ? 'selected' : '' }}>Atlántico</option>
                            <option value="Bolívar"           {{ old('departamento') == 'Bolívar'           ? 'selected' : '' }}>Bolívar</option>
                            <option value="Boyacá"            {{ old('departamento') == 'Boyacá'            ? 'selected' : '' }}>Boyacá</option>
                            <option value="Caldas"            {{ old('departamento') == 'Caldas'            ? 'selected' : '' }}>Caldas</option>
                            <option value="Caquetá"           {{ old('departamento') == 'Caquetá'           ? 'selected' : '' }}>Caquetá</option>
                            <option value="Casanare"          {{ old('departamento') == 'Casanare'          ? 'selected' : '' }}>Casanare</option>
                            <option value="Cauca"             {{ old('departamento') == 'Cauca'             ? 'selected' : '' }}>Cauca</option>
                            <option value="Cesar"             {{ old('departamento') == 'Cesar'             ? 'selected' : '' }}>Cesar</option>
                            <option value="Chocó"             {{ old('departamento') == 'Chocó'             ? 'selected' : '' }}>Chocó</option>
                            <option value="Córdoba"           {{ old('departamento') == 'Córdoba'           ? 'selected' : '' }}>Córdoba</option>
                            <option value="Cundinamarca"      {{ old('departamento') == 'Cundinamarca'      ? 'selected' : '' }}>Cundinamarca</option>
                            <option value="Guainía"           {{ old('departamento') == 'Guainía'           ? 'selected' : '' }}>Guainía</option>
                            <option value="Guaviare"          {{ old('departamento') == 'Guaviare'          ? 'selected' : '' }}>Guaviare</option>
                            <option value="Huila"             {{ old('departamento') == 'Huila'             ? 'selected' : '' }}>Huila</option>
                            <option value="La Guajira"        {{ old('departamento') == 'La Guajira'        ? 'selected' : '' }}>La Guajira</option>
                            <option value="Magdalena"         {{ old('departamento') == 'Magdalena'         ? 'selected' : '' }}>Magdalena</option>
                            <option value="Meta"              {{ old('departamento') == 'Meta'              ? 'selected' : '' }}>Meta</option>
                            <option value="Nariño"            {{ old('departamento') == 'Nariño'            ? 'selected' : '' }}>Nariño</option>
                            <option value="Norte de Santander"{{ old('departamento') == 'Norte de Santander'? 'selected' : '' }}>Norte de Santander</option>
                            <option value="Putumayo"          {{ old('departamento') == 'Putumayo'          ? 'selected' : '' }}>Putumayo</option>
                            <option value="Quindío"           {{ old('departamento') == 'Quindío'           ? 'selected' : '' }}>Quindío</option>
                            <option value="Risaralda"         {{ old('departamento') == 'Risaralda'         ? 'selected' : '' }}>Risaralda</option>
                            <option value="San Andrés"        {{ old('departamento') == 'San Andrés'        ? 'selected' : '' }}>San Andrés y Providencia</option>
                            <option value="Santander"         {{ old('departamento') == 'Santander'         ? 'selected' : '' }}>Santander</option>
                            <option value="Sucre"             {{ old('departamento') == 'Sucre'             ? 'selected' : '' }}>Sucre</option>
                            <option value="Tolima"            {{ old('departamento') == 'Tolima'            ? 'selected' : '' }}>Tolima</option>
                            <option value="Valle del Cauca"   {{ old('departamento') == 'Valle del Cauca'   ? 'selected' : '' }}>Valle del Cauca</option>
                            <option value="Vaupés"            {{ old('departamento') == 'Vaupés'            ? 'selected' : '' }}>Vaupés</option>
                            <option value="Vichada"           {{ old('departamento') == 'Vichada'           ? 'selected' : '' }}>Vichada</option>
                            <option value="Bogotá D.C."       {{ old('departamento') == 'Bogotá D.C.'       ? 'selected' : '' }}>Bogotá D.C.</option>
                        </select>
                    </div>
                    @error('departamento')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Municipio --}}
                <div class="form-group">
                    <label class="form-label" for="municipio">
                        Municipio <span class="required">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-city input-icon"></i>
                        <select class="form-input @error('municipio') error @enderror"
                                id="municipio" name="municipio" required
                                disabled>
                            <option value="">-- Primero selecciona un departamento --</option>
                        </select>
                    </div>
                    @error('municipio')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- ── SECCIÓN 3: Contacto ── --}}
                <div class="register-section-title">
                    <i class="fas fa-phone"></i> Contacto
                </div>

                {{-- Correo electrónico --}}
                <div class="form-group">
                    <label class="form-label" for="email">
                        Correo electrónico <span class="required">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email"
                            class="form-input @error('email') error @enderror"
                            id="email" name="email"
                            placeholder="tu@correo.com"
                            value="{{ old('email') }}"
                            required>
                    </div>
                    @error('email')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Celular --}}
                <div class="form-group">
                    <label class="form-label" for="celular">
                        Número de celular <span class="required">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-mobile-alt input-icon"></i>
                        <input type="tel"
                            class="form-input @error('celular') error @enderror"
                            id="celular" name="celular"
                            placeholder="Ej: 3001234567"
                            value="{{ old('celular') }}"
                            required>
                    </div>
                    @error('celular')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- ── SECCIÓN 4: Acción Comunal ── --}}
                <div class="register-section-title">
                    <i class="fas fa-users"></i> Acción Comunal
                </div>

                {{-- ¿Pertenece a OAC? --}}
                <div class="form-group">
                    <label class="form-label">
                        ¿Pertenece a un Organismo de Acción Comunal? <span class="required">*</span>
                    </label>
                    <div style="display: flex; gap: 1rem; margin-top: 0.5rem;">
                        <label class="oac-option" id="oac-si">
                            <input type="radio" name="pertenece_oac" value="1"
                                {{ old('pertenece_oac') == '1' ? 'checked' : '' }}
                                onchange="toggleOAC(true)">
                            <i class="fas fa-check-circle"></i> Sí
                        </label>
                        <label class="oac-option" id="oac-no">
                            <input type="radio" name="pertenece_oac" value="0"
                                {{ old('pertenece_oac', '0') == '0' ? 'checked' : '' }}
                                onchange="toggleOAC(false)">
                            <i class="fas fa-times-circle"></i> No
                        </label>
                    </div>
                </div>

                {{-- Nombre del organismo (condicional) --}}
                <div class="form-group" id="oacField"
                    style="display: {{ old('pertenece_oac') == '1' ? 'block' : 'none' }};">
                    <label class="form-label" for="organismo_accion_comunal">
                        Nombre del Organismo de Acción Comunal <span class="required">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-building input-icon"></i>
                        <input type="text"
                            class="form-input @error('organismo_accion_comunal') error @enderror"
                            id="organismo_accion_comunal"
                            name="organismo_accion_comunal"
                            placeholder="Ej: JAC Barrio El Prado"
                            value="{{ old('organismo_accion_comunal') }}">
                    </div>
                    @error('organismo_accion_comunal')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Condición --}}
                <div class="form-group">
                    <label class="form-label">
                        Condición <span class="required">*</span>
                    </label>
                    <div style="display: flex; gap: 1rem; margin-top: 0.5rem;">
                        <label class="oac-option">
                            <input type="radio" name="condicion" value="afiliado"
                                {{ old('condicion') == 'afiliado' ? 'checked' : '' }} required>
                            <i class="fas fa-id-badge"></i> Afiliado
                        </label>
                        <label class="oac-option">
                            <input type="radio" name="condicion" value="particular"
                                {{ old('condicion', 'particular') == 'particular' ? 'checked' : '' }}>
                            <i class="fas fa-user"></i> Persona Particular
                        </label>
                    </div>
                    @error('condicion')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- ── SECCIÓN 5: Contraseña ── --}}
                <div class="register-section-title">
                    <i class="fas fa-lock"></i> Contraseña
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">
                        Contraseña <span class="required">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password"
                            class="form-input @error('password') error @enderror"
                            id="password" name="password"
                            placeholder="Mínimo 8 caracteres"
                            required oninput="checkPasswordStrength()">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                    <div class="password-strength" id="passwordStrength">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <span class="strength-text" id="strengthText"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">
                        Confirmar contraseña <span class="required">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password"
                            class="form-input"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Repite tu contraseña"
                            required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                </div>

                {{-- Términos y condiciones   --}}
                <div class="form-group">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" id="terms" name="terms" class="form-checkbox">
                        <span>
                            <a href="#" class="form-link" target="_blank">
                                Acepto los términos, condiciones
                            </a>
                            <a href="#" class="form-link" target="_blank">
                                y la política de privacidad
                            </a>
                        </span>
                    </label>
            
                    @error('terms')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Newsletter --}}
                <div class="flex items-start gap-2">
                    <input
                        type="checkbox"
                        id="newsletter"
                        name="newsletter"
                        value="1"
                        class="form-checkbox mt-1"
                        {{ old('newsletter', true) ? 'checked' : '' }}
                    >

                    <label for="newsletter" class="text-sm text-gray-700 cursor-pointer">
                        Deseo recibir información sobre nuevos cursos y actualizaciones
                    </label>
                </div>

                <button type="submit" class="btn btn-primary form-submit">
                    <i class="fas fa-user-plus"></i> Crear Cuenta
                </button>
            </form>

            <div class="auth-footer">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="form-link">Inicia sesión aquí</a>
            </div>
        </div>
    </div>
    @endsection

    @section('extra-js')
    <style>
        .register-section-title {
            font-family: var(--font-display);
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--azul-principal);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin: 1.5rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--azul-suave);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .oac-option {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            border: 2px solid var(--gris-medio);
            border-radius: var(--radius-md);
            cursor: pointer;
            font-weight: 500;
            color: var(--gris-texto);
            transition: all 0.2s ease;
            user-select: none;
        }

        .oac-option input[type="radio"] {
            display: none;
        }

        .oac-option:has(input:checked) {
            border-color: var(--azul-principal);
            background: var(--azul-suave);
            color: var(--azul-principal);
        }

        .oac-option i { font-size: 1rem; }

        @media (max-width: 500px) {
            .auth-card { padding: var(--spacing-lg) var(--spacing-md) !important; }
        }
    </style>

    <script>
    // ── Municipios por departamento ──────────────────────────────────────────────
    const municipiosPorDepartamento = {
        "Amazonas": ["Leticia","El Encanto","La Chorrera","La Pedrera","La Victoria","Mirití-Paraná","Puerto Alegría","Puerto Arica","Puerto Nariño","Puerto Santander","Tarapacá"],
        "Antioquia": ["Medellín","Abejorral","Abriaquí","Alejandría","Amagá","Amalfi","Andes","Angelópolis","Angostura","Anorí","Anzá","Apartadó","Arboletes","Argelia","Armenia","Barbosa","Bello","Betania","Betulia","Briceño","Buriticá","Cáceres","Caicedo","Caldas","Campamento","Cañasgordas","Caracolí","Caramanta","Carepa","Carolina","Caucasia","Chigorodó","Cisneros","Ciudad Bolívar","Cocorná","Concepción","Concordia","Copacabana","Dabeiba","Don Matías","Ebéjico","El Bagre","El Carmen de Viboral","El Santuario","Entrerríos","Envigado","Fredonia","Frontino","Giraldo","Girardota","Gómez Plata","Granada","Guadalupe","Guarne","Guatapé","Heliconia","Hispania","Itagüí","Ituango","Jardín","Jericó","La Ceja","La Estrella","La Pintada","La Unión","Liborina","Maceo","Marinilla","Montebello","Murindó","Mutatá","Nariño","Nechí","Necoclí","Olaya","Peñol","Peque","Pueblorrico","Puerto Berrío","Puerto Nare","Puerto Triunfo","Remedios","Rionegro","Sabanalarga","Sabaneta","Salgar","San Andrés de Cuerquia","San Carlos","San Francisco","San Jerónimo","San José de la Montaña","San Juan de Urabá","San Luis","San Pedro de los Milagros","San Pedro de Urabá","San Rafael","San Roque","San Vicente","Santa Bárbara","Santa Rosa de Osos","Santo Domingo","Segovia","Sonsón","Sopetrán","Támesis","Tarazá","Tarso","Titiribí","Toledo","Turbo","Uramita","Urrao","Valdivia","Valparaíso","Vegachí","Venecia","Vigía del Fuerte","Yalí","Yarumal","Yolombó","Yondó","Zaragoza"],
        "Arauca": ["Arauca","Arauquita","Cravo Norte","Fortul","Puerto Rondón","Saravena","Tame"],
        "Atlántico": ["Barranquilla","Baranoa","Campo de la Cruz","Candelaria","Galapa","Juan de Acosta","Luruaco","Malambo","Manatí","Palmar de Varela","Piojó","Polonuevo","Ponedera","Puerto Colombia","Repelón","Sabanagrande","Sabanalarga","Santa Lucía","Santo Tomás","Soledad","Suan","Tubará","Usiacurí"],
        "Bolívar": ["Cartagena","Achí","Altos del Rosario","Arenal","Arjona","Arroyohondo","Barranco de Loba","Calamar","Cantagallo","Cicuco","Clemencia","Córdoba","El Carmen de Bolívar","El Guamo","El Peñón","Hatillo de Loba","Magangué","Mahates","Margarita","María la Baja","Montecristo","Mompós","Morales","Norosí","Pinillos","Regidor","Río Viejo","San Cristóbal","San Estanislao","San Fernando","San Jacinto","San Jacinto del Cauca","San Juan Nepomuceno","San Martín de Loba","San Pablo","Santa Catalina","Santa Rosa","Santa Rosa del Sur","Simití","Soplaviento","Talaigua Nuevo","Tiquisio","Turbaco","Turbana","Villanueva","Zambrano"],
        "Boyacá": ["Tunja","Almeida","Aquitania","Arcabuco","Belén","Berbeo","Betéitiva","Boavita","Boyacá","Briceño","Buenavista","Busbanzá","Caldas","Campohermoso","Cerinza","Chinavita","Chiquinquirá","Chíquiza","Chiscas","Chita","Chitaraque","Chivatá","Ciénega","Cómbita","Coper","Corrales","Covarachía","Cubará","Cucaita","Cuítiva","Duitama","El Cocuy","El Espino","Firavitoba","Floresta","Gachantivá","Gámeza","Garagoa","Guacamayas","Guateque","Guayatá","Güicán","Iza","Jenesano","Jericó","La Capilla","La Uvita","La Victoria","Labranzagrande","Macanal","Maripí","Miraflores","Mongua","Monguí","Moniquirá","Motavita","Muzo","Nobsa","Nuevo Colón","Oicatá","Otanche","Pachavita","Páez","Paipa","Pajarito","Panqueba","Pauna","Paya","Paz de Río","Pesca","Pisba","Puerto Boyacá","Quípama","Ramiriquí","Ráquira","Rondón","Saboyá","Sáchica","Samacá","San Eduardo","San José de Pare","San Luis de Gaceno","San Mateo","San Miguel de Sema","San Pablo de Borbur","Santa María","Santa Rosa de Viterbo","Santa Sofía","Santana","Sativanorte","Sativasur","Siachoque","Soatá","Socotá","Socha","Sogamoso","Somondoco","Sora","Soracá","Sotaquirá","Susacón","Sutamarchán","Sutatenza","Tasco","Tenza","Tibaná","Tibasosa","Tinjacá","Tipacoque","Toca","Togüí","Tópaga","Tota","Turmequé","Tuta","Tutazá","Úmbita","Ventaquemada","Villa de Leyva","Viracachá","Zetaquira"],
        "Caldas": ["Manizales","Aguadas","Anserma","Aranzazu","Belalcázar","Chinchiná","Filadelfia","La Dorada","La Merced","Manzanares","Marmato","Marquetalia","Marulanda","Neira","Norcasia","Pácora","Palestina","Pensilvania","Riosucio","Risaralda","Salamina","Samaná","San José","Supía","Victoria","Villamaría","Viterbo"],
        "Caquetá": ["Florencia","Albania","Belén de los Andaquíes","Cartagena del Chairá","Curillo","El Doncello","El Paujíl","La Montañita","Milán","Morelia","Puerto Rico","San José del Fragua","San Vicente del Caguán","Solano","Solita","Valparaíso"],
        "Casanare": ["Yopal","Aguazul","Chámeza","Hato Corozal","La Salina","Maní","Monterrey","Nunchía","Orocué","Paz de Ariporo","Pore","Recetor","Sabanalarga","Sácama","San Luis de Palenque","Támara","Tauramena","Trinidad","Villanueva"],
        "Cauca": ["Popayán","Almaguer","Argelia","Balboa","Bolívar","Buenos Aires","Cajibío","Caldono","Caloto","Coconuco","Corinto","El Tambo","Florencia","Guachené","Guapi","Inzá","Jambaló","La Sierra","La Vega","López de Micay","Mercaderes","Miranda","Morales","Padilla","Páez","Patía","Piamonte","Piendamó","Puerto Tejada","Puracé","Rosas","San Sebastián","Santander de Quilichao","Santa Rosa","Silvia","Sotara","Suárez","Sucre","Timbío","Timbiquí","Toribío","Totoró","Villa Rica"],
        "Cesar": ["Valledupar","Aguachica","Agustín Codazzi","Astrea","Becerril","Bosconia","Chimichagua","Chiriguaná","Curumaní","El Copey","El Paso","Gamarra","González","La Gloria","La Jagua de Ibirico","La Paz","Manaure","Pailitas","Pelaya","Pueblo Bello","Río de Oro","San Alberto","San Diego","San Martín","Tamalameque"],
        "Chocó": ["Quibdó","Acandí","Alto Baudó","Atrato","Bagadó","Bahía Solano","Bajo Baudó","Bojayá","Carmen del Darién","Cértegui","Condoto","El Cantón del San Pablo","El Carmen de Atrato","El Litoral del San Juan","Istmina","Juradó","Lloró","Medio Atrato","Medio Baudó","Medio San Juan","Nóvita","Nuquí","Río Iro","Río Quito","Riosucio","San José del Palmar","Sipí","Tadó","Unión Panamericana"],
        "Córdoba": ["Montería","Ayapel","Buenavista","Canalete","Cereté","Chimá","Chinú","Ciénaga de Oro","Cotorra","La Apartada","Lorica","Los Córdobas","Momil","Montelíbano","Moñitos","Planeta Rica","Pueblo Nuevo","Puerto Escondido","Puerto Libertador","Purísima","Sahagún","San Andrés de Sotavento","San Antero","San Bernardo del Viento","San Carlos","San José de Uré","San Pelayo","Tierralta","Tuchín","Valencia"],
        "Cundinamarca": ["Bogotá D.C.","Agua de Dios","Albán","Anapoima","Anolaima","Arbeláez","Beltrán","Bituima","Bojacá","Cabrera","Cachipay","Cajicá","Caparrapí","Cáqueza","Carmen de Carupa","Chaguaní","Chía","Chipaque","Choachí","Chocontá","Cogua","Cota","Cucunubá","El Colegio","El Peñón","El Rosal","Facatativá","Fómeque","Fosca","Funza","Fúquene","Fusagasugá","Gachalá","Gachancipá","Gachetá","Gama","Girardot","Granada","Guachetá","Guaduas","Guasca","Guataquí","Guatavita","Guayabal de Síquima","Guayabetal","Gutiérrez","Jerusalén","Junín","La Calera","La Mesa","La Palma","La Peña","La Vega","Lenguazaque","Machetá","Madrid","Manta","Medina","Mosquera","Nariño","Nemocón","Nilo","Nimaima","Nocaima","Ospina Pérez","Pacho","Paime","Pandi","Paratebueno","Pasca","Puerto Salgar","Pulí","Quebradanegra","Quetame","Quipile","Ricaurte","San Antonio del Tequendama","San Bernardo","San Cayetano","San Francisco","San Juan de Río Seco","Sasaima","Sesquilé","Sibaté","Silvania","Simijaca","Soacha","Sopó","Subachoque","Suesca","Supatá","Susa","Sutatausa","Tabio","Tausa","Tena","Tibacuy","Tibirita","Tocaima","Tocancipá","Topaipí","Ubalá","Ubaque","Ubaté","Une","Útica","Venecia","Vergara","Vianí","Villagómez","Villapinzón","Villeta","Viotá","Yacopí","Zipacón","Zipaquirá"],
        "Guainía": ["Inírida","Barranco Minas","Cacahual","La Guadalupe","Mapiripana","Morichal","Pana Pana","Puerto Colombia","San Felipe"],
        "Guaviare": ["San José del Guaviare","Calamar","El Retorno","Miraflores"],
        "Huila": ["Neiva","Acevedo","Agrado","Aipe","Algeciras","Altamira","Baraya","Campoalegre","Colombia","Elías","Garzón","Gigante","Guadalupe","Hobo","Iquira","Isnos","La Argentina","La Plata","Nátaga","Oporapa","Paicol","Palermo","Palestina","Pital","Pitalito","Rivera","Saladoblanco","San Agustín","Santa María","Suaza","Tarqui","Tesalia","Tello","Teruel","Timaná","Villavieja","Yaguará"],
        "La Guajira": ["Riohacha","Albania","Barrancas","Dibulla","Distracción","El Molino","Fonseca","Hatonuevo","La Jagua del Pilar","Maicao","Manaure","San Juan del Cesar","Uribia","Urumita","Villanueva"],
        "Magdalena": ["Santa Marta","Algarrobo","Aracataca","Ariguaní","Cerro de San Antonio","Chivolo","Ciénaga","Concordia","El Banco","El Piñón","El Retén","Fundación","Guamal","Nueva Granada","Pedraza","Pijiño del Carmen","Pivijay","Plato","Puebloviejo","Remolino","Sabanas de San Ángel","Salamina","San Sebastián de Buenavista","San Zenón","Santa Ana","Santa Bárbara de Pinto","Sitionuevo","Tenerife","Zapayán","Zona Bananera"],
        "Meta": ["Villavicencio","Acacías","Barranca de Upía","Cabuyaro","Castilla la Nueva","Cubarral","Cumaral","El Calvario","El Castillo","El Dorado","Fuente de Oro","Granada","Guamal","La Macarena","La Uribe","Lejanías","Mapiripán","Mesetas","Puerto Concordia","Puerto Gaitán","Puerto Lleras","Puerto López","Puerto Rico","Restrepo","San Carlos de Guaroa","San Juan de Arama","San Juanito","San Martín","Vistahermosa"],
        "Nariño": ["Pasto","Albán","Aldana","Ancuyá","Arboleda","Barbacoas","Belén","Buesaco","Chachagüí","Colón","Consacá","Contadero","Córdoba","Cuaspud","Cumbal","Cumbitara","El Charco","El Peñol","El Rosario","El Tablón de Gómez","El Tambo","Francisco Pizarro","Funes","Guachucal","Guaitarilla","Gualmatán","Iles","Imués","Ipiales","La Cruz","La Florida","La Llanada","La Tola","La Unión","Leiva","Linares","Los Andes","Magüí","Mallama","Mosquera","Nariño","Olaya Herrera","Ospina","Policarpa","Potosí","Providencia","Puerres","Pupiales","Ricaurte","Roberto Payán","Samaniego","San Bernardo","San Lorenzo","San Pablo","San Pedro de Cartago","Sandoná","Santa Bárbara","Santacruz","Sapuyes","Taminango","Tangua","Tumaco","Túquerres","Yacuanquer"],
        "Norte de Santander": ["Cúcuta","Ábrego","Arboledas","Bochalema","Bucarasica","Cácota","Cachirá","Chinácota","Chitagá","Convención","Cucutilla","Durania","El Carmen","El Tarra","El Zulia","Gramalote","Hacarí","Herrán","La Esperanza","La Playa","Labateca","Los Patios","Lourdes","Mutiscua","Ocaña","Pamplona","Pamplonita","Puerto Santander","Ragonvalia","Salazar","San Calixto","San Cayetano","Santiago","Sardinata","Silos","Teorama","Tibú","Toledo","Villa Caro","Villa del Rosario"],
        "Putumayo": ["Mocoa","Colón","Orito","Puerto Asís","Puerto Caicedo","Puerto Guzmán","Puerto Leguízamo","San Francisco","San Miguel","Santiago","Sibundoy","Valle del Guamuez","Villagarzón"],
        "Quindío": ["Armenia","Buenavista","Calarcá","Circasia","Córdoba","Filandia","Génova","La Tebaida","Montenegro","Pijao","Quimbaya","Salento"],
        "Risaralda": ["Pereira","Apía","Balboa","Belén de Umbría","Dosquebradas","Guática","La Celia","La Virginia","Marsella","Mistrató","Pueblo Rico","Quinchía","Santa Rosa de Cabal","Santuario"],
        "San Andrés": ["San Andrés","Providencia"],
        "Santander": ["Bucaramanga","Aguada","Albania","Aratoca","Barbosa","Barichara","Barrancabermeja","Betulia","Bolívar","Cabrera","California","Capitanejo","Carcasí","Cepitá","Cerrito","Charalá","Charta","Chima","Chipatá","Cimitarra","Concepción","Confines","Contratación","Coromoro","Curití","El Carmen de Chucurí","El Guacamayo","El Peñón","El Playón","Encino","Enciso","Florián","Floridablanca","Galán","Gámbita","Girón","Guaca","Guadalupe","Guapotá","Guavatá","Güepsa","Hato","Jesús María","Jordán","La Belleza","La Paz","Landázuri","Lebrija","Los Santos","Macaravita","Málaga","Matanza","Mogotes","Molagavita","Ocamonte","Oiba","Onzaga","Palmar","Palmas del Socorro","Páramo","Piedecuesta","Pinchote","Puente Nacional","Puerto Parra","Puerto Wilches","Rionegro","Sabana de Torres","San Andrés","San Benito","San Gil","San Joaquín","San José de Miranda","San Miguel","San Vicente de Chucurí","Santa Bárbara","Santa Helena del Opón","Simacota","Socorro","Suaita","Sucre","Suratá","Tona","Valle de San José","Vélez","Vetas","Villanueva","Zapatoca"],
        "Sucre": ["Sincelejo","Buenavista","Caimito","Chalán","Colosó","Corozal","Coveñas","El Roble","Galeras","Guaranda","La Unión","Los Palmitos","Majagual","Morroa","Ovejas","Palmito","Sampués","San Benito Abad","San Juan de Betulia","San Marcos","San Onofre","San Pedro","San Luis de Sincé","Santiago de Tolú","Sucre","Tolú Viejo"],
        "Tolima": ["Ibagué","Alpujarra","Alvarado","Ambalema","Anzoátegui","Armero","Ataco","Cajamarca","Carmen de Apicalá","Casabianca","Chaparral","Coello","Coyaima","Cunday","Dolores","Espinal","Falan","Flandes","Fresno","Guamo","Herveo","Honda","Icononzo","Lérida","Líbano","Mariquita","Melgar","Murillo","Natagaima","Ortega","Palocabildo","Piedras","Planadas","Prado","Purificación","Rioblanco","Roncesvalles","Rovira","Saldaña","San Antonio","San Luis","Santa Isabel","Suárez","Valle de San Juan","Venadillo","Villahermosa","Villarrica"],
        "Valle del Cauca": ["Cali","Alcalá","Andalucía","Ansermanuevo","Argelia","Bolívar","Buenaventura","Buga","Bugalagrande","Caicedonia","Calima","Candelaria","Cartago","Dagua","El Águila","El Cairo","El Cerrito","El Dovio","Florida","Ginebra","Guacarí","Jamundí","La Cumbre","La Unión","La Victoria","Obando","Palmira","Pradera","Restrepo","Riofrío","Roldanillo","San Pedro","Sevilla","Toro","Trujillo","Tuluá","Ulloa","Versalles","Vijes","Yotoco","Yumbo","Zarzal"],
        "Vaupés": ["Mitú","Carurú","Pacoa","Papunaua","Taraira","Yavaraté"],
        "Vichada": ["Puerto Carreño","Cumaribo","La Primavera","Santa Rosalía"],
        "Bogotá D.C.": ["Bogotá D.C."]
    };

    function filtrarMunicipios() {
        const depto    = document.getElementById('departamento').value;
        const munSelect = document.getElementById('municipio');
        const oldMun   = "{{ old('municipio') }}";

        munSelect.innerHTML = '<option value="">-- Selecciona un municipio --</option>';

        if (depto && municipiosPorDepartamento[depto]) {
            municipiosPorDepartamento[depto].forEach(function(mun) {
                const opt = document.createElement('option');
                opt.value = mun;
                opt.textContent = mun;
                if (mun === oldMun) opt.selected = true;
                munSelect.appendChild(opt);
            });
            munSelect.disabled = false;
        } else {
            munSelect.disabled = true;
        }
    }

    function toggleOAC(mostrar) {
        document.getElementById('oacField').style.display = mostrar ? 'block' : 'none';
        const input = document.getElementById('organismo_accion_comunal');
        input.required = mostrar;
        if (!mostrar) input.value = '';
    }

    // Restaurar municipio si hay old() value al volver del servidor
    document.addEventListener('DOMContentLoaded', function() {
        const depto = document.getElementById('departamento').value;
        if (depto) filtrarMunicipios();
    });
    </script>
    @endsection