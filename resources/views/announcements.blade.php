<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('layouts.head')

    <body class="antialiased">

        @include('layouts.navbar')

        <div class="relative flex items-top justify-center min-h-screen background-color-12 dark:bg-gray-900 sm:items-center py-4 sm:pt-0 ">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 top-20">
                
                
                @include('components.page-label', array($lable = "Announcements"))
                

                @include('components.cards');

                
                @include('components.page-label', array($lable = "Requests"))

                <div class="mt-3">
                    @foreach ($requests as $request)
                        <section class=" mt-3">
                            <div class="flex column status-idle">
                                <div class="title">
                                    <div class="r-pos">
                                        <div class="max-w-6xl">
                                            <h1 class="{{'request-'.$request->state}} a-pos p-4 sm:p-8 bg-21 color-white width-100 sm:rounded-lg font-big">{{$request->season}}</h1>
                                            

                                        </div>
                                        <h1 class="r-pos shadow-outline flex jc-sb p-4 sm:p-8 bg-transparent back-drop-blur-lg back-drop-blur bg-dark color-white sm:rounded-lg font-big">
                                            {{$request->season}}
                                            <div class="">
                                                {{$request->state}}
                                                @if ($request->state == "idle")
                                                    <button type="button" class="btn btn-danger">
                                                        <a href="{{route('requests.delete',$request->id)}}"> Delete</a>
                                                    </button> 
                                                @endif
                                            </div>
                                        </h1>
                                    </div>
                                </div>
                                <div class="text">

                                </div>
                            </div>
                        </section>
                        @if ($request->state != "idle")
                            <div class="accordion sm:rounded-lg " id="accordionExample">
                                <div class="accordion-item b-t bg-transparent bg-dark sm:rounded-lg color-white">
                                    <h2 class="accordion-header sm:rounded-lg bg-transparent bg-dark">
                                        <button class="accordion-button collapsed bg-transparent bg-dark color-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo-{{$request->id}}" aria-expanded="false" aria-controls="collapseTwo-{{$request->id}}">
                                            Request response
                                        </button>
                                    </h2>
                                    <div id="collapseTwo-{{$request->id}}" class="accordion-collapse bg-transparent sm:rounded-lg  collapse bg-dark" data-bs-parent="#accordionExample">
                                        <div class="accordion-body sm:rounded-lg bg-transparent bg-dark">
                                            {{$request->response}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        @endif
                    @endforeach
                </div>

                @if (session('status'))
                    <h1 class="alert alert-danger font-big mt-3">
                        {{ session('status') }}
                    </h1>
                @endif
                
                
                @include('components.request-form')

                <div class="flex z-2 align-items-baseline justify-center mt-4 sm:items-center sm:justify-between">
                    <div class="text-center z-2 text-sm text-gray-500 sm:text-left">
                        <div class="flex z-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mt-px w-5 h-5 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>

                            <a href="#" class="ml-1 underline">
                                Shop
                            </a>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-4 -mt-px w-5 h-5 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>

                            <a href="#" class="ml-1 underline">
                                Sponsor
                            </a>
                        </div>
                    </div>

                    <div class="ml-4 z-2 text-center text-sm text-gray-500 sm:text-right sm:ml-0 mt-10">
                        <div class="flex items-center  justify-center pt-8 margin-t-10-b-10 sm:justify-start sm:pt-0">
                            <p class="margin-right-10">Powered by </p>
                            <img width="225px" src="{{url('storage/cooltext322172763568995.png')}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </body>
</html>
