<section>
    <div class="card-wrapper">
        <div class="w-30 card-description leading-relaxed text-zinc-700 dark:text-zinc-200">
            About season 
            <textarea name="new_description" id="new_description" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm width-100 height-100">
                {{$card->description}}
            </textarea>

        </div> 
        <div class="season-card top-40">
            <div class="a-pos full-percent c-w rounded-xl-top z-3 flex card-headr">
                <div class="full-percent mg-left-30 flex align-items">
                    {{$card->season}}
                </div>
            </div>
    
            <div class="z-2 ">
                <img src="{{url('storage/'.$card->img)}}" class="rounded-xl fit-cover max-height-30">
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
    </div>
</section>