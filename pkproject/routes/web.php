<?php

use Illuminate\Support\Facades\Auth;
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
Route::get('/MainPage',[PagesController::class, 'main'])->name('main');

Route::get('ServiceTemplate/{id}', [ServicosController::class, 'index'])->name('service');



Route::get('/job/{id}',[PagesController::class,'job'])->name('job');

//Inserir dados dos pedidos 
Route::post('/job/{id}',[ServicosController::class, 'DataInsert']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('Pages/prestadores',[ServicosController::class, 'prestadores'])->name('Pages.prestadores');

Route::get('Pages/userpedidos',[ServicosController::class,'user'])->name('Pages.userpedidos');