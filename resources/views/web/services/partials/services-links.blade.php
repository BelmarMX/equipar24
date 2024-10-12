<div id="services__link_container" class="container-fluid mb-5 p-0">
    <a href="{{ route('proyectos') }}" @if($nth_active == 1) class="active" @endif>
        <i class="bi bi-bookmark-heart-fill"></i> Ponemos en marcha tu proyecto
    </a>
    <a href="{{ route('servicios') }}" @if($nth_active == 2) class="active" @endif>
        <i class="bi bi-bookmark-heart-fill"></i> Servicios especializados
    </a>
</div>