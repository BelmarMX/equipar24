@if($reels)
<div class="container-fluid mb-5">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-2">Nuevos Reels</div>
            <ul class="reels">
                @foreach($reels AS $reel)
                    <li class="reels__item" data-bs-toggle="tooltip" title="{{$reel->title}}">
                        <video class="reels__item--video" src="{{$reel->asset_url.$reel->video}}" muted></video>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<script>

</script>
