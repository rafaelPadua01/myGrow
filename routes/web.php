<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Plant;
use App\Models\AlbumPlant;
use App\Models\PlantImage;
use App\Models\AlbumImage;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PlantImageController;
use App\Http\Controllers\AlbumPlantController;
use App\Http\Controllers\AlbumImageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

*/
//rota para a dash
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    	$users = \Auth::user();
	return Inertia::render('Dashboard', [
		'users' => $users,
	]);
})->name('dashboard');

// Rota para upload de foto de perfl
Route::post('/upload_profile_photo', [UserController::class, 'upload_profile_photo'])->name('upload_profile_photo')->middleware('auth');
Route::post('/delete_profile_image', [UserController::class, 'delete_profile_photo'])->name('delete_profile_photo')->middleware('auth');

/*
Route::post('/upload_profile_photo', function(){
		$response = "Upload function not complete....";
		return \Response::json($response);
})->middleware('auth');
*/


//Rota Form de cadastro de plantas 
Route::get('/plant', [PlantController::class, 'index'])->name('index')->middleware('auth');
Route::get('/formPlant', function(){
    return Inertia::render('Forms/FormPlant');
})->middleware('auth');
	
//Rotas de usuario autenticado
Route::get('/users', function(){
	$users = \Auth::user();
	return \Response::json($users);	
});


//Rotas das plantas
Route::post('/formPlant/save', [PlantController::class, 'save'])->name('save')->middleware('auth');
Route::post('/plant/edit/{id}', [PlantController::class, 'edit'])->name('edit')->middleware('auth');
Route::post('/plant/remove/{id}', [PlantController::class, 'remove'])->name('remove')->middleware('auth');

//Rotas do upload de image para profile
Route::post('/img_profile/{id}', [PlantImageController::class, 'create'])->name('create')->middleware('auth');
Route::delete('/img_profile/remove/{id}', [PlantImageController::class, 'remove'])->name('remove')->middleware('auth');

//Rotas dos albuns
Route::get('/album', [AlbumPlantController::class,'index'])->name('index')->middleware('auth');
Route::post('album/create/{id}', [AlbumPlantController::class, 'create'])->name('create')->middleware('auth');
Route::post('/album/remove/{id}', [AlbumPlantController::class, 'delete'])->name('delete')->middleware('auth');

//Album Image 
Route::post('/albumImage/upload/{id}', [AlbumImageController::class, 'upload'])->name('upload')->middleware('auth');
Route::post('/albumImage/remove/{id}', [AlbumImageController::class, 'delete'])->name('delete')->middleware('auth');
Route::get('/albumImage/show/{id}', [AlbumImageController::class, 'show'])->name('show')->middleware('auth');
