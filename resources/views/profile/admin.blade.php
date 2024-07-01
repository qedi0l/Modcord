<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold  text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-dark  sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.new-season-card')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-dark  sm:rounded-lg">
                
                    @isset($seasons)
                        @foreach ($seasons as $card)

                            <form id="CardForm-{{$card->id}}">
                                @csrf
                                <div class="flex b-t jc-sb sm:rounded-lg nowrap">
                                    <div class=" justify-content flex  margin-t-10-b-10">
                                        @include('profile.partials.seasons-index')
                                    </div>
                                    <div class="flex margin-t-10-b-10">
                                        @include('profile.partials.updete-season-information')
                                    </div>
                                </div>
                            </form>
                            <script>

                                // update card
                                $(document).ready(function() {
                                    $('#CardForm-{{$card->id}}').on('submit', function(e) {
                                        e.preventDefault(); 
    
                                        let newSeason = $('#new_season-{{$card->id}}').val();
                                        let newVersion = $('#new_version-{{$card->id}}').val();
                                        let newDescription = $('#new_description-{{$card->id}}').val();
                                        let newImg = $('#new_img-{{$card->id}}')[0].files[0];
                                        let newPack = $('#new_pack-{{$card->id}}')[0].files[0];
    
                                        formData = new FormData();
                                        formData.append('_token','{{ csrf_token()}}');
                                        formData.append('newSeason',newSeason);
                                        formData.append('newVersion',newVersion);
                                        formData.append('newDescription',newDescription);
                                        formData.append('newImg',newImg);
                                        formData.append('newPack',newPack);
                                        formData.append('cardID',"{{$card->id}}");
    
                                        $.ajax({
                                            url: "{{route('profile.admin.update')}}", 
                                            type: 'POST',
                                            data: formData,
                                            enctype: "multipart/form-data",
                                            contentType: false,
                                            processData: false,
                                            dataType:"html",
                                            success: function (response) {
                                                $('body').html(response);
                                            },
                                        });
                                    });
                                });
                            </script>
                        @endforeach

                        <script>
                            function moveSeasonUp(cardID,token){
                                $.ajax({
                                    url: "{{route('profile.admin.up')}}", 
                                    type: 'POST',
                                    data: {
                                        "_token": token,
                                        cardID:cardID,
                                    },
                                    success: function (response) {
                                        $('body').html(response);
                                    }
                                });
                            };

                            function moveSeasonDown(cardID,token){
                                $.ajax({
                                    url: "{{route('profile.admin.down')}}", 
                                    type: 'POST',
                                    data: {
                                        "_token": token,
                                        cardID:cardID,
                                    },
                                    success: function (response) {
                                        $('body').html(response);
                                    }
                                });
                            };

                            function deleteCard(cardID,token){
                                $.ajax({
                                    url: "{{route('profile.admin.delete')}}", 
                                    type: 'POST',
                                    data: {
                                        "_token": token,
                                        cardID:cardID,
                                    },
                                    success: function (response) {
                                        $('body').html(response);
                                    }
                                });
                            };
                        </script>
                    @endisset
                
            </div>


        </div>
    </div>
</x-app-layout>
