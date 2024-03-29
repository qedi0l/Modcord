<?php

namespace App\Http\Controllers;

use App\Models\UserRequest;
use App\models\Card;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RequestsController extends Controller
{
   
    public function index(Request $request): View
    {
        return view('requests', [
            'request' => $request,
        ]); 
    }
   
    public function create(Request $request): RedirectResponse
    {
        $req = new UserRequest();
        /*
            It is no need to separate nickname from contacts 
        */
        $req->contacts = $request->input('nickname')."/".$request->input('contact');

        $req->ip_address = $request->getClientIp();
        
        $req->season = Card::find($request->input('season-sel'))->season;
        $req->text = mb_convert_encoding(trim($request->input('textRequest')), 'UTF-8');
        
        $req->save();

        //$this->updateCache();

        return redirect() -> route('announcements.index') -> with('success');
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

    public function delete(Request $request) : RedirectResponse
    {
        UserRequest::find($request->UUID)->delete();

        return redirect() -> route('announcements.index') -> with('success');
    }
}
