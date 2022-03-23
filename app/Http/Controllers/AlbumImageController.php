<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Http\Controllers\AlbumImageController;
use App\Http\Controllers\AlbumPlantController;
use App\Models\AlbumImage;
use App\Models\AlbumPlant;
use Inertia\Inertia;

class AlbumImageController extends Controller
{
    //
	private $albuns;
	
	public function __construct(AlbumImage $albuns){
		$this->albuns = $albuns;
	}
	public function show($id){
		$album = AlbumPlant::findOrFail($id);
		$imgs =  AlbumImage::all()->where('id_album', '=', $id);
		return Inertia::render('Albuns/show', [
					'images' => $imgs,
					'album' => $album	
		]);	
	}
    public function upload(Request $request, $id){
        $files = $request->file('files');
	
	$user_id = \Auth::id();
        $album = AlbumPlant::findOrFail($id);	
	try{
		foreach($files as $file){
			$album_upload = AlbumImage::create([
					'image_name' => $file->getClientOriginalName(),
					'image_size' => $file->getSize(),
					'image_extension' => $file->extension(),
					'id_user' => $user_id,
					'id_album' => $id, 
			]);
			if($album_upload){
					$path = Storage::putFileAs('public/album/' . $album->name_album,  $file,  $file->getClientOriginalName());
					
			}
				
		}
			$response = 'Upload realizado com sucesso...';
					
		return \Response::json($response);	
	}
	catch(Exception $e){
		$error = $e;
		return \Response::json($error);	
	}
	
    
   }

public function delete($id){
	$image = AlbumImage::findOrFail($id);
	$album = AlbumPlant::select('name_album')->where('id', '=', $image->id_album)->get();
	//dd($album);
	try{
		$delete_img = AlbumImage::findOrFail($id)->where('id', '=', $id)->delete();
		if($delete_img){
			$delete_to_dir = Storage::disk('public')->delete('/album/'.$album.'/'.$image->name_image);
			$response = $delete_to_dir;
			return $response;
		}
		
		return \Response::json($response);
	}
	catch(Exception $e){
		$erro = $e;
		retutn \Response::json($reponse);
	}
}
}
