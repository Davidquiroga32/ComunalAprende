<footer class="footer">
    <div class="footer-content">

        {{-- Columna 1: Descripción y redes --}}
        <div class="footer-section">
            <h4>Comunal Aprende</h4>
            <p>
                Fortaleciendo comunidades a través de la educación, la asesoría y el acompañamiento
                profesional para organizaciones sociales en Colombia.
            </p>
            <div class="social-links">
                <a href="#" class="social-link" aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-link" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-link" aria-label="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="#" class="social-link" aria-label="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>

        {{-- Columna 2: Enlaces rápidos --}}
        <div class="footer-section">
            <h4>Enlaces Rápidos</h4>
            <ul class="footer-links">
                <li><a href="{{ route('inicio') }}">Inicio</a></li>
                <li><a href="{{ route('cursos.index') }}">Cursos</a></li>
                <li><a href="{{ route('contacto') }}">Contáctanos</a></li>
                <li><a href="{{ route('normatividad') }}">Normatividad</a></li>
            </ul>
        </div>

        {{-- Columna 3: Recursos --}}
        <div class="footer-section">
            <h4>Recursos</h4>
            <ul class="footer-links">
                <li><a href="#">Preguntas Frecuentes</a></li>
                <li><a href="#">Términos y Condiciones</a></li>
                <li><a href="#">Política de Privacidad</a></li>
                <li><a href="#">Centro de Ayuda</a></li>
            </ul>
        </div>

        {{-- Columna 4: Contacto --}}
        <div class="footer-section">
            <h4>Contacto</h4>
            <p>
                <i class="fas fa-envelope"></i> info@comunalaprende.com<br>
                <i class="fas fa-phone"></i> +57 (1) 234 5678<br>
                <i class="fas fa-map-marker-alt"></i> Villavicencio, Meta
            </p>
        </div>

    </div>

    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Comunal Aprende. Todos los derechos reservados.</p>
    </div>
</footer>