<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    //
	private $user;
	
	public function __construct(User $user)
	{
		$this->user = $user;	
	}
	public function index()
	{
		$users  = User::all();
		return \Response::json($user); 
	}
	public function save(){} 	
	public function update(){}
	public function delete(){}
	public function upload_profile_photo(Request $request)
	{
		// Recebe o id do usuario logado 
		$auth_user  = \Auth::id();
		
		//Percorre o array e armazena seus valor em $image 
		foreach($request->file('files') as $image ){
			
			try{
				//Verifica se o valor passsado no array é um arquivo válido
				if($request->hasFile('files')){
					//Recebe o valor do array 
					$upload_file =$image;
					//Recebe o nome do arquivo
					$filename = $image->getClientOriginalName();
					//Cria o diretorio em Storage, upload do arquvo para o diretorio criado
					$path = Storage::putFileAs('/user/profile_photo', $image,  $filename);
					//Atualiza na base de dados para que a coluna recebe o novo valor
					$update = User::where('id','=', $auth_user)->update(['profile_photo_path' => $path]);
			}  
		 	$response = true;
			return \Response::json($response);
			
		}
		catch(Exception $e)
		{
			$error = $e;		
			return \Response::json($error);
		} 
		//	dd($filename);
		}
	//	dd($auth_user, $upload_file->getClientOriginalName());
		
		
		//dd($request);				
	} 
	public function delete_profile_photo(Request $request){
		$auth_user  = \Auth::id();
		$profile_image = $request;
		$filename = substr($profile_image->profile_photo_path, 19);
		$path =  public_path('user/profile_photo/'.$filename);
		
		try{
			
				$remove_img = Storage::disk('public')->delete('/user/profile_photo/'.$filename);
				if($remove_img){
					$update_table = User::where('id', '=', $auth_user)->update(['profile_photo_path' => ' ']);
						
				}
			$response = 'Atualizado ...';	
			return \Response($response);
			//dd($path);
		}
		catch(Exception $e){
			$response = $e;
			return \Response::json($response);	
		}
	}
	
	
}
