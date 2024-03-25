<div class="p-4 sm:p-8 mt-2r mb-10">
    <div class="r-pos">
        <div class="max-w-6xl">
            <div class="a-pos p-4 sm:p-8 bg-21 color-white width-100">
                <div class="">
                    <div class="mb-3">
                        <p class="font-big mb-10"> ONLY ONE REQUEST PER ANNOUNCEMENT</p>
    
                        <div class="mb-3">
                            <x-input-label :value="__('Game nickname')" />
                            <x-text-input disabled  type="text" placeholder="Aboba2010 " class="mt-1 block w-full"/>
                        </div>
                    </div>
    
                    
                    <div class="mb-3">
                        <x-input-label for="userRequest" :value="__('Tell us why we would choose you')" />
                        <textarea disabled placeholder="Все несерьезно написанные заявки будут отклонены" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm width-100 height-100"></textarea>
                    </div>
    
                
                    <div class="mb-3 w-30">
                        <x-input-label for="contact" :value="__('Contacts Discord / Telegram tag')" />
                        <x-text-input disabled type="text" placeholder="Aboba2010#2435 " class="mt-1 block w-full"/>
                    </div>
                    
    
                    <div class="mb-3 w-30">
                        <x-input-label for="contact" :value="__('Season')" />
                        @include('components.select', array($values = $seasons))
                    </div>
    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" >
                        <label disabled class="form-check-label" >Yes, Im read the <a style="color:#dc3545" class="td-underline"> RULES</a>.</label>
                    </div>
                    
                    <button type="button" class="btn btn-danger">Submit</button>
                </div>
            </div>
        </div>

        <div class="r-pos shadow-outline p-4 sm:p-8 mt-2r bg-transparent back-drop-blur-lg back-drop-blur bg-dark color-white sm:rounded-lg font-small">
            <form method="post" action="{{ route('requests.create') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <p class="font-big mb-10"> ONLY ONE REQUEST PER ANNOUNCEMENT</p>

                    <div class="mb-3">
                        <x-input-label for="nickname" :value="__('Game nickname')" />
                        <x-text-input required id="nickname" name="nickname" type="text" placeholder="Aboba2010 " class="mt-1 block w-full"/>
                    </div>
                </div>

                
                <div class="mb-3">
                    <x-input-label for="userRequest" :value="__('Tell us why we would choose you')" />
                    <textarea required placeholder="Все несерьезно написанные заявки будут отклонены" name="userRequest" id="userRequest" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm width-100 height-100"></textarea>
                </div>
            

            
                <div class="mb-3 w-30">
                    <x-input-label for="contact" :value="__('Contacts Discord / Telegram tag')" />
                    <x-text-input required id="contact" name="contact" type="text" placeholder="Aboba2010#2435 " class="mt-1 block w-full"/>
                </div>
                

                <div class="mb-3 w-30">
                    <x-input-label for="contact" :value="__('Season')" />
                    @include('components.select', array($values = $seasons))
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="checkbox">
                    <label required class="form-check-label" for="checkbox">Yes, Im read the <a href="#" style="color:#dc3545" class="td-underline"> RULES</a>.</label>
                </div>

                <button type="submit" class="btn btn-danger">Submit</button>
            
            </form>
        </div>
    </div>
</div>