@props(['id', 'error'])
<span id="{{$id }}_error" class="text-red-500 text-sm p-px is-invalid">
    <i class="fa-solid fa-triangle-exclamation me-1 text-amber-500"></i> {{ $error }}
</span>
