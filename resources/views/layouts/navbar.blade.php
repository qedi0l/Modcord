<nav class="nav-tfu navbar back-drop-blur fixed-top navbar-dark bg-dark " style="background-color: #00000036 !important;">
    <div class="container-fluid">
        <div class="r-pos">
            <div class="logo-animate">
                <h1 class="a-pos z-1 color-green filter-blur-ulg sm:px-6 lg:px-8 text-center text-sm pd-10 sm:text-left font-big"> Modcord </h1>
            </div>
                <h1 class="r-pos z-2 sm:px-6 lg:px-8 text-center text-sm pd-10 sm:text-left font-big color-white"><a href="{{route('/')}}"> Modcord </a></h1>
        </div>
        
        
        <div class="sub-panel">
        @if (Route::has('login'))
            <div class="hidden navbar-brand right-0 sm:block">
                @auth
                    <a href="{{ route('profile.admin') }}" class="text-sm text-gray-700 dark:text-gray-500 td-none">AdminPanel</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 td-none">Log in</a>

                    @if (Route::has('register'))
                        <a href="login" class="ml-4 text-sm text-gray-700 dark:text-gray-500 td-none">Register</a>
                    @endif
                @endauth
            </div>
        @endif
        </div>
    </div>
</nav>