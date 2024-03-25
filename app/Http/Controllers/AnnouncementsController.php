<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Traits\Upload;
use App\Models\Card;
use App\Models\UserRequest;
use App\Interfaces\InterfaceCache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class announcementsController extends Controller implements InterfaceCache
{
    public function index(Request $request): View
    {
        $announcements = Card::query()
        ->select('*')
        ->where('pack','anons')
        ->orderBy('id','asc')
        ->get();
        //$requests = UserRequest::find($request->id);
        /*$requests = UserRequest::query()
                        ->select('*')
                        ->where('ip_address',$request->getClientIp())
                        ->get();
        //$client_ip = $request->getClientIp();
        //$requests = $this->rememberCache('ip:'.$client_ip, $client_ip);
        //var_dump($requests);*/
                
        $this->rememberCache('announcements',$announcements);
        //$requests = [];

        return view('announcements',['seasons' => $announcements]) -> with('success');
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

    public function getCache($key)
    {
        $data = Cache::get($key);
        
        return json_decode($data);
    }

    public function updateCache($key = 'announcements', $value = null)
    {

        $this->forgetCacheKey($key);

        if (isset($value)) $this->rememberCache($key,$value);

    }

    public function rememberCache($key = 'announcements', $value = null)
    {
        $data = Cache::remember($key, Carbon::now()->addMinutes(5), function () use ($value) {
            if (isset($value)) return json_encode($value);
            else return Card::query()
                            ->select('*')
                            ->where('pack','anons')
                            ->orderBy('id','asc')
                            ->get();
        });
        return json_decode($data);
    }

    public function setCache($key, $value){}
    public function setForeverCache($key, $value){}

    public function forgetCacheKey($key)
    {
        Cache::forget($key);
    }
}
