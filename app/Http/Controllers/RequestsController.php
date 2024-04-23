<?php

namespace App\Http\Controllers;

use App\Models\UserRequest;
use App\Models\Card;
use App\Traits\CacheMethods;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class RequestsController extends Controller
{
    use CacheMethods;
    public function index(Request $request): View
    {
        return view('requests', [
            'request' => $request,
        ]); 
    }
   
    public function create(Request $request): RedirectResponse
    {
        $client_ip = $request->getClientIp();

        $req_max_count = Card::query()->where('pack','anons')->count();

        if (UserRequest::query()->where('ip_address',$client_ip)->count('ip_address') >= $req_max_count){
            return redirect() -> route('announcements.index') -> with('status','More requests than allowed');
        }

        $req = new UserRequest();
        /*
            It is no need to separate nickname from contacts because of hand work
        */
        $req->contacts = $request->input('nickname')."/".$request->input('contact');

        $req->ip_address = $request->getClientIp();
        
        $req->season = Card::find($request->input('season-sel'))->season;
        $req->text = mb_convert_encoding(trim($request->input('textRequest')), 'UTF-8');
        
        $req->save();

        
        $cookie = cookie('ip', $client_ip, 60*60);
        
        //$this->updateCache('UserRequest/'.$client_ip,UserRequest::find($client_ip));

        return redirect() -> route('announcements.index') -> cookie($cookie) -> with('success');
    }
    
    public function update(Request $request) : RedirectResponse
    {
        $req = UserRequest::find($request->id);

        $radio = $request->input('btnradio');
        if($radio == "disaproved") $req->state = "disaproved";
        elseif($radio == "pending") $req->state = "pending";
        elseif($radio == "aproved") $req->state = "aproved";

        $req->response = $request->response;
        //dd($request);
        $req->save();

        return redirect() -> route('profile.requests') -> with('success');
    }
   
    public function show() : View
    {
        return view('profile.requests', [
            'user_requests' => UserRequest::query()->select('*')->orderBy('state')->get(),
        ]);
    }
    
    public function edit()
    {
        //
    }

    public function delete(Request $request) : RedirectResponse
    {
        $client_ip = $request->getClientIp();
        if ($client_ip == UserRequest::find($request->UUID)->ip_address){
            UserRequest::find($request->UUID)->delete();
        }
        else return redirect() -> route('announcements.index') -> with('status','Unpriveleged acess');
        
        return redirect() -> route('announcements.index') -> with('success');
    }

    public function cacheRemember(string $key = 'requests', mixed $value = null, int $ttl = 3600): mixed 
    {
        $data = Cache::remember($key, Carbon::now()->addMinutes(5), function () use ($value) {
            if (isset($value)) return json_encode($value);
            else return UserRequest::query()
                            ->select('*')
                            ->orderBy('id','asc')
                            ->get();
        });
        return json_decode($data);
    }
}
