@if( $errors -> any() )
    <div class="mb-4">
        @foreach( $errors -> all() AS $error )
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    </div>
@endif

@if( session('alert') )
    @include('web._layout.alerts.'.session('alert')['type'])
@endif
