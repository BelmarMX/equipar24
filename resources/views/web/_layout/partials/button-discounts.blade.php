@empty( $promos )
    <a href="{{ route('promociones', $promos -> slug) }}" class="btn btn-promociones">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <i class="bi bi-tag-fill"></i> Promoción vigente
    </a>
@endif
