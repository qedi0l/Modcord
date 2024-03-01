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

                            <form method="post" action="{{ route('profile.admin.update',['id' => $card->id]) }}" enctype="multipart/form-data">
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
                        @endforeach
                    @endisset
                
            </div>


        </div>
    </div>
</x-app-layout>
