<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Traits\Upload;
use App\Models\Card;
use App\Interfaces\InterfaceCache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class SeasonController extends Controller implements InterfaceCache
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

        $this->updateCache();

        return redirect('profile/admin');
    }
    
    
    public function index() : View
    {   
        
        $seasons = $this->rememberCache();
        
        return view('profile.admin', [
            'seasons' => $seasons,
        ]); 
    }


    public function delete(Request $request) : View
    {

        $card = Card::find($request->id)[0];
        
        $this->deleteFile($card->pack);
        $this->deleteFile($card->img);
 
        Card::find($request->id)->delete();
        
        $this->updateCache();

        return view('profile.admin');
    }
    
    public function download(Request $request) 
    {
        $card = Card::find($request->id);

        $pack = $this->getCache('pack:'.$request->id);
        if (isset($pack)) $pack = $this->setCache('pack:'.$request->id,$pack);

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

        $this->updateCache();

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

        $this->updateCache('seasons',$seasons);
       
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

        $this->updateCache('seasons', $seasons);

        return redirect()->route('profile.admin')->with('success','Saved');
    }

    public function homeIndex(): View
    {
        $seasons = $this->rememberCache();
        
        return view('main',['seasons' => $seasons]) -> with('success');
    }

    public function announcements(): View
    {
        $announcements = Card::query()
                            ->select('*')
                            ->where('pack','anons')
                            ->orderBy('id','asc')
                            ->get();
                            
        $this->setCache('announcements',$announcements);
        
        return view('announcements',['seasons' => $announcements]) -> with('success');

    }

    public function getCache($key)
    {
        $data = Cache::get($key);
        
        return json_decode($data);
    }

    public function updateCache($key = 'seasons', $value = null)
    {
        if (!isset($value)){
            $value = Card::query()
                        ->select('*')
                        ->orderBy('id','asc')
                        ->get();
        }

        $this->forgetCacheKey($key);

        Cache::put($key, json_encode($value), now()->addMinutes(5));

    }

    public function setForeverCache($key, $value){}

    public function rememberCache($key = 'seasons', $value = null)
    {
        $seasons = Cache::remember($key, Carbon::now()->addMinutes(5), function () {
            return Card::query()
            ->select('*')
            ->orderBy('id','asc')
            ->get();
        });
        return json_decode($seasons);
    }

    public function setCache($key, $value)
    {

        if(Cache::has($key)) return $this->getCache($key);
        else Cache::set($key, $value, 3600);

    }

    public function forgetCacheKey($key)
    {
        Cache::forget($key);
    }
    
}

