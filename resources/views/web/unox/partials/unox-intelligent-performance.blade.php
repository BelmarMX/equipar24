<div class="row justify-content-around mb-3">
    <div class="col-12">
        <strong class="big">Maximiza tu trabajo, mejora tu rendimiento, alcanza tus metas.</strong>
    </div>
    <div class="col-2 text-center">
        <img class="img-fluid" style="max-width: 75px" src="{{ asset('v2/images/unox/ico-adaptative-cooking.webp') }}" alt="ADAPTIVE.Cooking&trade;"><br>
        <strong>ADAPTIVE.Cooking&trade;</strong>
        <p>Resultados perfectos.<br>Siempre.</p>
    </div>
    <div class="col-2 text-center">
        <img class="img-fluid" style="max-width: 75px" src="{{ asset('v2/images/unox/ico-climalux.webp') }}" alt="CLIMALUX&trade;"><br>
        <strong>CLIMALUX&trade;</strong>
        <p>Control total de la humedad.</p>
    </div>
    <div class="col-2 text-center">
        <img class="img-fluid" style="max-width: 75px" src="{{ asset('v2/images/unox/ico-smart-preheating.webp') }}" alt="SMART.Preheating"><br>
        <strong>SMART.Preheating</strong>
        <p>Precalentamiento inteligente.</p>
    </div>
    <div class="col-2 text-center">
        <img class="img-fluid" style="max-width: 75px" src="{{ asset('v2/images/unox/ico-auto-soft.webp') }}" alt="AUTO.Soft"><br>
        <strong>AUTO.Soft</strong>
        <p>Función de cocción suave.</p>
    </div>
    @isset($automatic)
        <div class="col-2 text-center">
            <img class="img-fluid" style="max-width: 75px" src="{{ asset('v2/images/unox/ico-auto-matic.webp') }}" alt="AUTO.Matic"><br>
            <strong>AUTO.Matic</strong>
            <p>Apertura automática de la puerta.</p>
        </div>
    @else
        <div class="col-2 text-center">
            <img class="img-fluid" style="max-width: 75px" src="{{ asset('v2/images/unox/ico-sense-klean.webp') }}" alt="SENSE.Klean"><br>
            <strong>SENSE.Klean</strong>
            <p>Limpieza inteligente.</p>
        </div>
    @endisset
</div>