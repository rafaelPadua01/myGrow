<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Plant;
use App\Models\AlbumPlant;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\AlbumPlantController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Rotas das plantas para a dashboard/a
Route::get('/plants', function(){
	$plants = Plant::all();
	//dd($plants);
	return \Response::json($plants);
});

//Rotas  api albuns
Route::get('/albuns', function(){
	$albuns = AlbumPlant::all();
	return \Response::json($albuns);
});
