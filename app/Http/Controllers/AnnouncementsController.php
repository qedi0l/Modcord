<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CacheMethods;
use App\Models\Card;
use App\Models\UserRequest;
use Carbon\Carbon;
use Illuminate\Cookie\CookieJar;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;

class announcementsController extends Controller
{
    use CacheMethods;
    public function index(Request $request): View
    {
        $announcements = $this->cacheRemember('announcements');

        $client_ip = $request->getClientIp();
        $cash_ip = $this->cacheGet('ip-'.$client_ip);
        $cookie_ip = $request->cookie('ip');

        if((!empty($cash_ip) or !empty($cookie_ip)) and ($cash_ip == $cookie_ip))
        {
            $requests = UserRequest::where('ip_address',$cookie_ip)->get();
            cookie();
        }
        else
        {
            $requests = UserRequest::where('ip_address',$client_ip)->get();
        }

        return view('announcements',['seasons' => $announcements, 'requests' => $requests]) -> with('success');
    }
   
    public function create()
    {
        
    }
    
    public function store()
    {
        //
    }
   
    public function show()
    {
        //
    }
    
    public function edit()
    {
        //
    }

    public function destroy()
    {
        //
    }

    private function cacheRemember(string $key, mixed $value = null, int $ttl = 3600): mixed 
    {
        $data = Cache::remember($key, Carbon::now()->addMinutes(5), function () use ($value) {
            if (isset($value)) return json_encode($value);
            else return Card::where('pack','anons')
                            ->orderBy('id','asc')
                            ->get();
        });
        return json_decode($data);
    }

   
}