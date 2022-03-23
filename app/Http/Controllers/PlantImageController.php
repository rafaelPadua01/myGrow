<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\PlantImage;
use App\Models\Plant;
use App\Http\Controllers\PlantController;


class PlantImageController extends Controller
{
    //construtor da classe
	public function __construct(PlantImage $plant_image){
		$this->plant_image = $plant_image;
	}
	//metodo index 
	/*
	public function index(){
		try{
			$image_profile = PlantImage::all();
			return Inertia::render('');
		}
		catch(Exception $e){
			$error = $e;
			\Response::json($error);
		}
	}
	*/
	public function create(Request $request, $id){
		$img = $request->file('files');
		$id_plant = Plant::findOrFail($id);
		$auth_user_id = \Auth::id();
		$select_rows = PlantImage::select('*')->where('id_plant', '=', $id);
		try{
				if($select_rows->first() ){
					$response = 'Esta planta ja possui uma imagem de perfil,
						 remova-a para qiue possa usar uma nova ';
					return \Response::json($response);
				}
			else{
					$insert_image = PlantImage::create([
					'name_image' => $request->file('files')->getClientOriginalName(), //nome da imagem
					'size' => $img->getSize(),    // tamanho da imagem	
					'type' => $img->extension(),   // tipo da imagem
					'id_user' => $auth_user_id, // id usuario logado que fez upload da imagem
					'id_plant' => $id_plant->id,  //id da planta que receberá a imagem
				]);
				
				if($insert_image){
				
						$path = Storage::putFileAs('public/profile_plant', $img, $img->getClientOriginalName());
						$img_name = $request->file('files')->getClientOriginalName();
						$response = $insert_image;
						return $response; 	
						//$upload_dir = $img->store($img_name);
						//return;
					}
				
				return $response; 
					
			}
							
					return \Response::json($response);
			}
		catch(Exception $e)
		{
			$error = $e;
			return \Response::json($response);
		}
	}
	public function remove($id){
		$image = PlantImage::findOrFail($id);
		$name_image = $image->name_image;
		
		try{
			
			//Remmove arquivo da tabela
			$delete = PlantImage::select('*')->where('id', '=', $id)->delete();
			
			 //Remove imagem do diretorio 
			$delete_to_dir = Storage::disk('public')->delete('/profile_plant/'.$name_image);
			if($delete_to_dir){
				$response = 'Imagem removida';
				return $response;	
			}
			else{
				$error = 'Nao foi possível remover imagem';
				return \Response::json($error);
			}
			return \Response::json($response);
		}
		catch(Exception $e){
			return \Response::json($e);
		}

	}
}
