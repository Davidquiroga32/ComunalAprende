{{--
    Partial reutilizable: Banner de cabecera de página
    Uso: @include('partials.page-banner', ['titulo' => '...', 'descripcion' => '...'])
--}}
<section class="section" style="background: linear-gradient(135deg, var(--azul-oscuro), var(--azul-principal)); padding: 3rem 1.5rem;">
    <div class="container text-center">
        <h1 style="color: white; font-size: 2.5rem; margin-bottom: 1rem;">{{ $titulo }}</h1>
        @isset($descripcion)
            <p style="color: rgba(255,255,255,0.9); font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
                {{ $descripcion }}
            </p>
        @endisset
    </div>
</section>