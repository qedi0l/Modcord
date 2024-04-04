<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold  text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Requests') }}
        </h2>
    </x-slot>

    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-dark  sm:rounded-lg">
                <div class="max-w-xl">
                    
                </div>
            </div>

            

            <div class="p-4 sm:p-8 bg-dark  sm:rounded-lg">
                    @isset($user_requests)
                        @foreach ($user_requests as $request)
                        
                            @include('profile.partials.user-request-card')
                        @endforeach
                    @endisset
            </div>

        </div>
    </div>
</x-app-layout>
