<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Traits\Upload;
use App\Models\Card;
use App\Models\UserRequest;
use App\Traits\CacheMethods;
use App\Interfaces\InterfaceCache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Storage;

class SeasonController extends Controller 
{
    use Upload, CacheMethods;

    public function create(Request $request) : RedirectResponse 
    {
        $card = new Card();
        $card->season = $request->input('season');
        $card->version = $request->input('version');

        $file = $request->file('file');
        $card->img = $this->storeFile($file); 
        $file = $request->file('pack');
        
        // beacuse announcements are without files
        if ($file){ 
            $pack = $this->storeFile($file);
            $card->pack = $pack;
        }else{
            $card->pack = "anons";
        }
        
        $card->description = mb_convert_encoding(trim($request->input('description')), 'UTF-8');
       
        $card->save();

        $this->cacheUpdate('seasons',Card::all());

        return back()->with('success');
    }

    public function delete(Request $request) : RedirectResponse
    {
        $cardID = $request->input("cardID");
        $card = Card::find($cardID);
        /*
            announcements are without pack file, but db record is 'anons'
        */
        if ($card->pack != "anons")
        {
            //delete files from disk
            $this->deleteFile($card->pack);
            $this->deleteFile($card->img);
            //delete files records
            File::query()->select('*')->where('pack',$card->pack)->delete();
        }

        $card->delete();

        //Cache update
        $this->cacheForgetKey('seasons');
        $this->cacheUpdate('seasons',Card::getAllCardsOrdered());

        return back()->with('success');
    }
    
    public function download(Request $request) 
    {
        $card = Card::find($request->id);
        $pack = $this->cacheRemember('pack:'.$request->id,$card->pack);

        return url('storage/'.$pack);
    }

    public function update(Request $request) : RedirectResponse 
    {
        $card = Card::find($request->input('cardID'));

        if($season = $request->input('newSeason'))
        $card->season = $season;
        
        if($version = $request->input('newVersion'))
        $card->version = $version;

        if($pack = $request->file('newPack'))
        $card->pack = $this->storeFile($pack);

        if($file = $request->file('newImg'))
        $card->img = $this->storeFile($file); 

        $description = mb_convert_encoding(trim($request->input('new_description')), 'UTF-8');
        if($description) $card->description = $description;

        $card->save();

        $this->cacheUpdate('seasons',Card::getAllCardsOrdered());

        return back()->with('success','Saved');
    }
    public function moveUp(Request $request) : RedirectResponse
    { 
        $card_this = Card::find($request->input("cardID"));
        $id_this = $card_this->id;
        $min_id = Card::query()->min('id');

        if($id_this != $min_id){

            $card_prev = Card::find($id_this - 1);
            $id_prev = $card_prev->id;
            $temp_id = 0;

            $card_prev->id = $temp_id;
            $card_prev->save();

            $card_this->id = $id_prev;
            $card_this->save();

            $card_prev->id = $id_this;
            $card_prev->save();
        }
        else return back()->with("status","Fail");

        $this->cacheUpdate('seasons',Card::getAllCardsOrdered());
       
        return back()->with("status","Saved");
    }
    public function moveDown(Request $request) : RedirectResponse
    { 
        $card_this = Card::find($request->input("cardID"));
        $id_this = $card_this->id;
        $max_id = Card::query()->max('id');
        
        if($id_this < $max_id){
            
            $card_next = Card::find($id_this+1);
            $id_next = $id_this + 1;
            $temp_id = 0;

            $card_next->id = $temp_id;
            $card_next->save();

            $card_this->id = $id_next;
            $card_this->save();

            $card_next->id = $id_this;
            $card_next->save();
        }
        else return back()->with("status","Fail");

        $this->cacheUpdate('seasons',Card::getAllCardsOrdered());

        return back()->with("status","Saved");
    }

    public function adminShow() : View
    {   
        $seasons = $this->cacheRemember('seasons');
        return view('profile.admin', ['seasons' => $seasons,]); 
    }

    public function homeShow(): View
    {
        $seasons = $this->cacheRemember('seasons');
        return view('main',['seasons' => $seasons]);
    }

    private function storeFile($file,$folder = null)
    {
        $path = $this->UploadFile($file, 'Albumes');
        File::create(['path' => $path]);

        return $path;
    }


    private function cacheRemember($key = 'seasons', $value = null, int $ttl = 3600): mixed
    { 
        $data = Cache::remember($key, Carbon::now()->addMinutes(5), function () use ($value) {
            if (isset($value)) return json_encode($value);
            else return Card::getAllCardsOrdered();
        });
        return json_decode($data);
    }
    
}

