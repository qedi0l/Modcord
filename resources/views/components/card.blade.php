<div class="season-card">
    <div class="a-pos full-percent c-w rounded-xl-top z-3 flex card-headr">
        <div class="full-percent mg-left-30 flex align-items">
            {{$card->season}}
        </div>
    </div>

    <div class="z-2">
        <img src="{{url('storage/'.$card->img)}}" alt="{{$card->season}}" class="rounded-xl fit-cover max-height-40">
    </div>

    <div class="a-pos full-percent jc-sb c-w z-3 bt-0 card-foo flex">
        <div class="mg-left-30 flex align-items">
            Version {{$card->version}}
        </div>
        <div class="mg-right-30">
            @if ($card->pack == "anons")
                <x-primary-button>
                    <a href="{{route('announcements.index')}}">{{ __('announcement') }}</a>
                </x-primary-button>
            @else
                <x-primary-button>
                    <a href="{{url('storage/'.$card->pack)}}">{{ __('Download') }}</a>
                </x-primary-button> 
            @endif
        </div>
    </div>
</div>