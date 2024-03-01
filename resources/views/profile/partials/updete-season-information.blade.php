<section>
    <div class="season-card height-auto color-light mg-left-30 ">
        <div class="r-pos z-2 ">
            <div class="">
                <div class="mb-10">
                    <x-input-label for="new_season" :value="__('Season')" />
                    <x-text-input id="new_season" name="new_season" type="text" :value="__($card->season)" class="mt-1 block w-full" />
                </div>
                <div class="mb-10">
                    <x-input-label for="new_version" :value="__('Game version')" />
                    <x-text-input id="new_version" name="new_version" type="text" :value="__($card->version)" class="mt-1 block w-full" />
                </div>
            </div>
        </div>

        <div class="r-pos z-2 bt-0 c">
            <div class="">
                <div class="mb-10">
                    <x-input-label for="new_img" :value="__('Season Cover')" />
                    <input type='file' name='new_file' accept='image/jpeg,image/png'>
                </div>
                <div class="mb-10">
                    <x-input-label for="new_pack" :value="__('Season Pack')" />
                    <input type='file' name='new_pack' accept='image/jpeg,image/png'>
                </div>
                <div class="mg-right-30 mb-10 flex gap-10">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                    <x-primary-button>
                        <a href="{{route('season.delete', ['id' => $card->id])}}">{{ __('Delete card') }}</a>
                    </x-primary-button> 

                    @if (session('status') === 'season-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="move-card">
        <div class="text-end items-center gap-4">
            <a type="button" href="{{ route('profile.admin.up', ['id' => $card->id]) }}"><button type="button" class="btn btn-primary">Up</button></a>
        </div>
        <div class="text-end items-center gap-4">
            <a type="button" href="{{ route('profile.admin.down', ['id' => $card->id]) }}"><button type="button" class="btn btn-primary">Down</button></a>
        </div>
    </div>
</section>