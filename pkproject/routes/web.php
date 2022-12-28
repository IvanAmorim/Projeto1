<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ServicosController;

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

//redirecionar para o index
Route::get('/',[PagesController::class,'index']);
Route::get('/index',[PagesController::class,'index'])->name('main');
Route::get('ServiceTemplate/{id}', [ServicosController::class, 'index'])->name('service');

Route::get('/dbconn', function(){
    return view('dbconn');
});

Route::get('/job/{id}',[PagesController::class,'job'])->name('job');

//Inserir dados dos pedidos 
Route::post('/job/{id}',[ServicosController::class, 'DataInsert']);