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
            return back() -> with('status','More requests than allowed');
        }

        $req = new UserRequest();
        $req->contacts = $request->input('nickname')."/".$request->input('contact');
        $req->ip_address = $request->getClientIp();
        $req->season = Card::find($request->input('season-sel'))->season;
        $req->text = mb_convert_encoding(trim($request->input('textRequest')), 'UTF-8');
        $req->save();

        
        $cookie = cookie('ip', $client_ip, 60*60);
        
        //$this->updateCache('UserRequest/'.$client_ip,UserRequest::find($client_ip));

        return back() -> cookie($cookie) -> with('success');
    }
    
    public function update(Request $request) : RedirectResponse
    {
        $req = UserRequest::find($request->id);

        $radio = $request->input('btnradio');
        if($radio == "disaproved") $req->state = "disaproved";
        elseif($radio == "pending") $req->state = "pending";
        elseif($radio == "aproved") $req->state = "aproved";

        $req->response = $request->response;
        $req->save();

        $user_requests = UserRequest::query()->select('*')->orderBy('state')->get();
        $this->cacheUpdate("user_requests",$user_requests);

        return redirect() -> route('profile.requests') -> with('success');
    }
   
    public function show() : View
    {   
        $requests = UserRequest::getAllRequests();
        return view('profile.requests', [
            'user_requests' => $requests,
        ]);
    }
    
    public function delete(Request $request) : RedirectResponse
    {
        $client_ip = $request->getClientIp();
        if ($client_ip == UserRequest::find($request->UUID)->ip_address){
            UserRequest::find($request->UUID)->delete();
        }
        else return back() -> route('announcements.index') -> with('status','Unpriveleged acess');
        
        return back() -> with('success');
    }

    private function cacheRemember(string $key = 'requests', mixed $value = null, int $ttl = 3600): mixed 
    {
        $data = Cache::remember($key, Carbon::now()->addMinutes(5), function () use ($value) {
            if (isset($value)) return json_encode($value);
            else return UserRequest::getAllRequests();
        });
        return json_decode($data);
    }
}
