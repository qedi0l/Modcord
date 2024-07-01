<section class="mt-3">
    <form method="post" action="{{ route('profile.requests.update', ['id' => $request->id])}}" enctype="multipart/form-data">
        @csrf
        <div class="flex column status-idle">
            <div class="title">
                <div class="r-pos">
                    <div class="max-w-6xl">
                        <h1 class="{{'request-'.$request->state}} a-pos p-4 sm:p-8 bg-21 color-white width-100 sm:rounded-lg font-big">{{$request->season}}</h1>
                    </div>
                    <h1 class="r-pos shadow-outline flex jc-sb p-4 sm:p-8 bg-transparent back-drop-blur-lg back-drop-blur bg-dark color-white sm:rounded-lg font-big">
                        {{$request->contacts}}
                        <p>{{$request->season}}</p>
                        <div>
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="disaproved-{{$request->id}}" value="disaproved" autocomplete="off" @if ($request->state =='disaproved') checked @endif>
                                <label class="btn btn-outline-danger" for="disaproved-{{$request->id}}">Disaprove</label>
                                <input type="radio" class="btn-check" name="btnradio" id="pending-{{$request->id}}" value="pending" autocomplete="off" @if ($request->state =='pending') checked @endif>
                                <label class="btn btn-outline-warning" for="pending-{{$request->id}}">Pending</label>
                                <input type="radio" class="btn-check" name="btnradio" id="aproved-{{$request->id}}" value="aproved" autocomplete="off" @if ($request->state =='aproved') checked @endif>
                                <label class="btn btn-outline-success" for="aproved-{{$request->id}}">Aproved</label>
                            </div>
                            <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                    </h1>
                </div>
            </div>
            <div class="accordion sm:rounded-lg " id="accordionExample">
                <div class="accordion-item b-t bg-dark sm:rounded-lg color-white">
                    <h2 class="accordion-header sm:rounded-lg bg-dark">
                        <button class="accordion-button collapsed bg-dark color-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{$request->id}}" aria-expanded="false" aria-controls="collapseOne-{{$request->id}}">
                            Request text
                        </button>
                    </h2>
                    <div id="collapseOne-{{$request->id}}" class="accordion-collapse sm:rounded-lg  collapse bg-dark" data-bs-parent="#accordionExample">
                        <div class="accordion-body sm:rounded-lg  bg-dark">
                            <p>{{$request->text}}</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item b-t bg-dark sm:rounded-lg color-white">
                    <h2 class="accordion-header sm:rounded-lg bg-dark">
                        <button class="accordion-button collapsed bg-dark color-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo-{{$request->id}}" aria-expanded="false" aria-controls="collapseTwo-{{$request->id}}">
                            Request response
                        </button>
                    </h2>
                    <div id="collapseTwo-{{$request->id}}" class="accordion-collapse sm:rounded-lg  collapse bg-dark" data-bs-parent="#accordionExample">
                        <div class="accordion-body sm:rounded-lg  bg-dark">
                            <textarea placeholder="" name="response" id="response" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm width-100 height-100">{{$request->response}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
    
</section>