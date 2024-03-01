<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('New season') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure check overall before publish') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.admin.new') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="season" :value="__('Season Number')" />
            <x-text-input id="season" name="season" type="text" class="mt-1 block w-full"/>
            
        </div>

        <div>
            <x-input-label for="version" :value="__('Game version')" />
            <x-text-input id="version" name="version" type="text" class="mt-1 block w-full" />
        </div>
        <div>
            <x-input-label for="description" :value="__('Season description')" />
            <textarea name="description" id="description" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm width-100 height-100"></textarea>
        </div>

        <div>
            <x-input-label for="img" :value="__('Season Cover')" />
            <input class="color-light" required type='file' name='file' accept='image/jpeg,image/png'>
        </div>

        <div>
            <x-input-label for="pack" :value="__('Season Pack')" />
            <input class="color-light" type='file' name='pack'>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
