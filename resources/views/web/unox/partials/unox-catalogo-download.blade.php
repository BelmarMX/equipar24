<div class="row">
    <div class="col-md-6 text-start">
        @if($doc)
        <a class="btn btn-secondary" href="{{ url('storage/catalogos/unox/'.$doc.'.pdf') }}" target="_blank">
            <i class="bi bi-file-earmark-pdf"></i> Ver todas las características.
        </a>
        @endif
    </div>
    <div class="col-md-6 text-center">
        <a href="https://api.whatsapp.com/send?phone=523322876603&amp;text=%C2%A1Hola%21%20Estoy%20interesado%20en%20productos%20UNOX%2C%20quisiera%20saber%20m%C3%A1s%20acerca%20de%20ellos" class="btn btn-success" data-bs-toggle="tooltip" title="" target="_blank" data-bs-original-title="Un experto te dará mas detalles">
            <i class="bi bi-whatsapp"></i> ¡Descubre más beneficios!
        </a>
    </div>
</div>