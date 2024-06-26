<section>
    <div class="season-card height-auto color-light mg-left-30 ">
        <div class="r-pos z-2 ">
            <div class="">
                <div class="mb-10">
                    <x-input-label for="new_season" :value="__('Season')" />
                    <x-text-input id="new_season-{{$card->id}}" name="new_season" type="text" :value="__($card->season)" class="mt-1 block w-full" />
                </div>
                <div class="mb-10">
                    <x-input-label for="new_version" :value="__('Game version')" />
                    <x-text-input id="new_version-{{$card->id}}" name="new_version" type="text" :value="__($card->version)" class="mt-1 block w-full" />
                </div>
            </div>
        </div>

        <div class="r-pos z-2 bt-0 c">
            <div class="">
                <div class="mb-10">
                    <x-input-label for="new_img" :value="__('Season Cover')" />
                    <input type='file' id="new_img-{{$card->id}}" name='new_img' accept='image/jpeg,image/png'>
                </div>
                <div class="mb-10">
                    <x-input-label for="new_pack" :value="__('Season Pack')" />
                    <input type='file' id="new_pack-{{$card->id}}" name='new_pack' accept='image/jpeg,image/png'>
                </div>
                <div class="mg-right-30 mb-10 flex gap-10">
                    <x-primary-button type="submit"> {{ __('Save') }}</x-primary-button>
                    <x-primary-button type="button" onclick="deleteCard({{$card->id}},'{{ csrf_token()}}')">{{ __('Delete card') }}</x-primary-button> 
                </div>
            </div>
        </div>
    </div>
    
    <div class="move-card">
        <div class="text-end items-center gap-4">
            <button type="button" onclick="moveSeasonUp({{$card->id}},'{{ csrf_token()}}')" class="btn btn-primary">Up</button>
        </div>
        <div class="text-end items-center gap-4">
            <button type="button" onclick="moveSeasonDown({{$card->id}},'{{ csrf_token()}}')" class="btn btn-primary">Down</button>
        </div>
    </div>
</section>