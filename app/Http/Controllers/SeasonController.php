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


class SeasonController extends Controller 
{
    use Upload, CacheMethods;

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

        /*
            TODO make formatting saving
            TODO implement side text editor
        */
        $card->description = mb_convert_encoding(trim($request->input('description')), 'UTF-8');
        
        $card->save();

        $this->cacheUpdate('seasons',Card::all());

        return redirect('profile/admin');
    }
    
    
    public function index() : View
    {   
        
        $seasons = $this->cacheRemember();
        
        return view('profile.admin', [
            'seasons' => $seasons,
        ]); 
    }


    public function delete(Request $request) : View
    {

        $card = Card::find($request->id);
        /*
            announcements are without pack file, but db record is 'anons'
        */
        if (!empty($card->pack))
        {
            $this->deleteFile($card->pack);
            $this->deleteFile($card->img);
        }
       
 
        Card::find($request->id)->delete();
        if (!empty($card->pack))
        File::query()->select('*')->where('pack',$card->pack)->delete();
        
        $this->cacheForgetKey('seasons');
        $this->cacheUpdate('seasons',Card::all());

        return view('profile.admin');
    }
    
    public function download(Request $request) 
    {
        $card = Card::find($request->id);

        $pack = $this->cacheRemember('pack:'.$request->id,$card->pack);

        return url('storage/'.$pack);
    }

    public function update(Request $request) : RedirectResponse 
    {
        $card = Card::find($request->id);

        $season = $request->input('new_season');
        if($season) $card->season = $season;
        
        $version = $request->input('new_version');
        if($version) $card->version = $version;

        $pack = $request->file('new_pack');
        if($pack) $card->pack = $this->storeFile($pack);

        $file = $request->file('new_file');
        if($file) $card->img = $this->storeFile($file); 

        /*
            TODO make formatting saving
            TODO implement side text editor
        */
        $description = mb_convert_encoding(trim($request->input('new_description')), 'UTF-8');
        if($description) $card->description = $description;

        $card->save();

        $this->cacheUpdate('seasons',Card::all());

        return redirect()->route('profile.admin')->with('success','Saved');
    }
    public function moveUp(Request $request) : RedirectResponse
    { 

        /* 
            This moves season cards, moving their ids

            TODO: Code smells

        */

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

        $seasons = Card::query()
                        ->select('*')
                        ->orderBy('id','asc')
                        ->get();

        $this->cacheUpdate('seasons',$seasons);
       
        return redirect()->route('profile.admin')->with('success','Saved');
    }
    public function moveDown(Request $request) : RedirectResponse
    { 

        /* 
            This moves season cards, moving their ids

            TODO: Code smells

        */

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

        $seasons = Card::query()
                        ->select('*')
                        ->orderBy('id','asc')
                        ->get();

        $this->cacheUpdate('seasons', $seasons);

        return redirect()->route('profile.admin')->with('success','Saved');
    }

    public function homeIndex(): View
    {
        $seasons = $this->cacheRemember();
        
        return view('main',['seasons' => $seasons]) -> with('success');
    }

    public function cacheRemember($key = 'seasons', $value = null, int $ttl = 3600): mixed
    { 
        $data = Cache::remember($key, Carbon::now()->addMinutes(5), function () use ($value) {
            if (isset($value)) return json_encode($value);
            else return Card::query()
                            ->select('*')
                            ->orderBy('id','asc')
                            ->get();
        });
        return json_decode($data);
    }
    
}

