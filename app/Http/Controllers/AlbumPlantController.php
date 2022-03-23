<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\AlbumPlant;
use App\Models\AlbumImage;
use App\Models\Plant;
use Inertia\Inertia;

class AlbumPlantController extends Controller
{
    //
    public function __construct(AlbumPlant $album_plant){
        $this->album_plant = $album_plant;
    }
    public function index(){
        $albuns = AlbumPlant::all();
	$album_images = AlbumImage::orderBy('id')->limit(4)->get();
      	  return Inertia::render('Albuns/albuns',[
            'albuns' => $albuns,
		'images' => $album_images,
        ]);
    }

    public function create(Request $request, $id){
        $data = $request->all();
        $user_id = \Auth::id();
        try{
            $create_album = AlbumPlant::create([
                'name_album' => $request->album_name,
                'id_plant' => $id,
                'id_user' => $user_id,

            ]);
            Storage::makeDirectory($request->album_name);
            $response = true;
            return \Response::json($response);
        }catch(Exception $e){
            $error = $e;
            \Response::json($error);
        }
    }

	public function delete($id){
		try{
            $album_delete = AlbumPlant::findOrFail($id)->where('id', '=', $id)->delete();
            $response = true;
            return \Response::json($response);
        }
        catch(Exception $e){
            $error = $e;
            return \Response::json($error);
        }
       
	}

    
}
