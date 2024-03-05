<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Traits\Upload;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class SeasonController extends Controller
{
    use Upload;

    private function storeFile($file,$folder = null)
    {

        $path = $this->UploadFile($file, 'Albumes');
        
        File::create([
            'path' => $path
        ]);
        
        return $path;
    }

    public function create(Request $request) : RedirectResponse 
    {
        $card = new Card();
        $card->season = $request->input('season');
        $card->version = $request->input('version');

        $file = $request->file('pack');

        // beacuse announcements are without files
        if (isset($file)){ 
            $pack = $this->storeFile($file);
            $card->pack = $pack;
        }else{
            $card->pack = "anons";
        }

        $file = $request->file('file');
        $card->img = $this->storeFile($file); 

        //TODO make formatting saving
        $card->description = mb_convert_encoding(trim($request->input('description')), 'UTF-8');
        
        $card->save();

        return redirect('profile/admin');
    }
    
    
    public function index() : View
    {   
        
        $seasons = Cache::remember('seasons', now()->addMinutes(5), function () {
            return json_encode(Card::all());
        });
        
        return view('profile.admin', [
            'seasons' => json_decode($seasons),
        ]); 
    }


    public function delete(Request $request)
    {

        $card = Card::find($request->id)[0];
        
        $this->deleteFile($card->pack);
        $this->deleteFile($card->img);
 
        Card::find($request->id)->delete();
        
        Cache::remember('seasons', now()->addMinutes(5), function () {
            $seasons = Card::all();
            return json_encode($seasons);
        });

        return $this->index();
    }
    
    public function download(Request $request) 
    {
        
        $pack = Cache::remember('pack:'.$request->id, now()->addMinutes(5), function ($request) {
            $card = Card::find($request->id);
            return $card->pack;
        });

        return url('storage/'.$pack);
    }

    public function update(Request $request) : RedirectResponse 
    {
        $card = Card::find($request->id);
        $card->season = $request->input('new_season');;
        $card->version = $request->input('new_version');

        //TODO make formatting saving
        $card->description = mb_convert_encoding(trim($request->input('new_description')), 'UTF-8');

        $file = $request->file('new_pack');
        if(isset($file)) $card->pack = $this->storeFile($file);

        $file = $request->file('new_file');
        if(isset($file)) $card->img = $this->storeFile($file); 

        $card->save();

        Cache::forget('seasons');

        Cache::remember('seasons', now()->addMinutes(5), function () {
            $seasons = Card::all();
            return json_encode($seasons);
        });

        return redirect('profile/admin');
    }
    public function moveUp(Request $request) : RedirectResponse
    { 

        /* 
            This moves season cards, moving their ids

            TODO: Code smells

        */

        Cache::forget('seasons');

        $card_this = Card::find($request->id);
        $id_this = $card_this->id;
        $min_id = Card::query()->min('id');

        if($id_this!=$min_id){
            
            $card_prev = Card::find($request->id - 1);
            $id_prev = Card::find($id_this - 1)->id;
            $temp_id = 0;

            $card_prev->id = $temp_id;
            $card_prev->save();

            $card_this->id = $id_prev;
            $card_this->save();

            $card_prev->id = $id_this;
            $card_prev->save();
        }

        Cache::remember('seasons', now()->addMinutes(5), function () {
            $seasons = Card::query()->select('*')->orderBy('id','asc')->get();
            return json_encode($seasons);
        });
       
        return redirect()->route('profile.admin')->with('success','Saved');
    }
    public function moveDown(Request $request) : RedirectResponse
    { 

        /* 
            This moves season cards, moving their ids

            TODO: Code smells

        */


        Cache::forget('seasons');

        $card_this = Card::find($request->id);
        $id_this = $card_this->id;
        $max_id = Card::query()->max('id');
        
        if($id_this<$max_id){
            $card_next = Card::find($request->id+1);
            $id_next = Card::find($id_this + 1)->id;
            $temp_id = 0;

            $card_next->id = $temp_id;
            $card_next->save();

            $card_this->id = $id_next;
            $card_this->save();

            $card_next->id = $id_this;
            $card_next->save();
        }
        Cache::remember('seasons', now()->addMinutes(5), function () {
            $seasons = Card::query()->select('*')->orderBy('id','asc')->get();
            return json_encode($seasons);
        });


        return redirect()->route('profile.admin')->with('success','Saved');
    }

    public function homeIndex()
    {
        $seasons = Cache::remember('seasons', now()->addMinutes(5), function () {
            return json_encode(Card::all());
        });
        
        return view('main',['seasons' => json_decode($seasons)]) -> with('success');
    }
    
}

