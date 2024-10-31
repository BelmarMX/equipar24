@if($reels)
<div class="container-fluid mb-5">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-2">Nuevos Reels</div>
            <ul class="reels flex-wrap">
                @foreach($reels AS $reel)
                    <li class="reels__item position-relative mb-2" data-bs-toggle="tooltip" title="{{$reel->title}}">
                        <video class="reels__item--video" src="{{$reel->asset_url.$reel->video}}" muted></video>
                        @if($reel->link)
                            <a class="position-absolute" href="{{$reel->link}}" data-bs-toggle="tooltip" title="{{$reel->link_summary}}">{{$reel->link_title ?? $reel->title}}</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif
