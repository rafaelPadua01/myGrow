<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\PlantImage;
use App\Models\AlbumPlant;
use App\Models\AlbumImage;
//use App\Http\Controllers\PlantImageController;
use Inertia\Inertia;

class PlantController extends Controller
{
    //
    private $plant;

    public function __construct(Plant $plant){
        $this->plant = $plant;
    }

    public function index(){
		$items = Plant::all(); //recebe todas as plantas do banco
		$image_profile = PlantImage::all(); // recebe todas as imagens de perfil
		
        return Inertia::render('Plants/plants', [
			'items' => $items,
			'image_profile' => $image_profile 
		]);

    }

    public function save(Request $request){
        $data = $request->all(); // recebe os dados enviados da requisição
        $user_id = \Auth::id(); // recebe os dados do usuario logado que fez a requisição
		//dd($request->name);
	try{
		//insere os dados na tabela de plantas
		$insert_data = Plant::create([
			'name' => $request->name,
			'especie' => $request->especie,
			'germinacao' => $request->germinacao,
			'floracao'=> $request->floracao,
			'id_user' => $user_id,
		]);
		
		//Se os dados forem inseridos
		if($insert_data){
				
			$response = $data;
			return $response;
		}
			
			return \Response::json($response);
	}
	catch(Exception $e){
		$error = $e;
		return \Response::json($error);
	}

        //dd($data, $user);

        return \Response::json($response);
    }

    public function edit(Request $request, $id){
		
		$edit_data = $request->all();
		try{
			$update_data = Plant::findOrFail($id)->where('id', '=', $id)->update($edit_data);
			return $response = $edit_data;
		//	return \Response::json($response);
		}
		catch(Exception $e){
			$error = $e;
			return \Response::json($error);
		}
		return \Response::json($response);
		
    }

    public function remove($id){
		try{
			
			$delete = Plant::findOrFail($id)->delete();		
			$remove_img_profile = PlantImage::where('id_plant', '=', $id)->delete();	
			$response = $delete;
			return \Response::json($response);
		}catch(Exception $e){
			$error = $e;
			return \Response::json($error);
		}
    }
}
