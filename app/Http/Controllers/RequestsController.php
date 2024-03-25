<?php

namespace App\Http\Controllers;

use App\Models\UserRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RequestsController extends Controller
{
   
    public function index(Request $request): View
    {
        return view('requests', [
            'request' => $request->ip(),
        ]); 
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
}
