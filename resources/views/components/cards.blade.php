
@isset($seasons)
    @foreach ($seasons as $card)

        <div class="mt-10">
            <div class="card-wrapper">
                <div class="card-description leading-relaxed text-zinc-700 dark:text-zinc-200">
                    {{$card->description}}
                </div> 

                @include('components.card');

                
                <div class="card-footer" hidden>
                    <div class="card-foo-block ">Info</div>
                    <div class="card-foo-block">Desc</div>
                    <div class="card-foo-block">Download</div>
                    
                </div>
            </div>
        </div>
    @endforeach
@endisset