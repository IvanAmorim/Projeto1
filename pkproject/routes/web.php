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

Route::get('Admin/categoria',[ServicosController::class,'categoria'])->name('Admin.categoria');
Route::post('/Admin/categoria',[ServicosController::class, 'categoryinsert']);

Route::get('Admin/servico',[ServicosController::class,'servicos'])->name('Admin.servico');
Route::post('Admin/servico',[ServicosController::class, 'servicoinsert']);
Route::get('Admin/perguntas',[ServicosController::class, 'perguntas'])->name('Admin.perguntas');
Route::post('Admin/perguntas',[ServicosController::class, 'perguntasInsert']);
Route::get('Admin/respostas',[ServicosController::class, 'respostas'])->name('Admin.respostas');
Route::post('Admin/respostas',[ServicosController::class, 'respostasInsert']);

Route::get('Pages/servico/{id}',[ServicosController::class, 'servico'])->name('Pages.servico');
Route::post('Pages/servico/{id}',[ServicosController::class, 'propostainsert'])->name('Inserirproposta');

Route::get('Pages/verpropostas/{id}',[ServicosController::class, 'verproposta'])->name('Pages.verpropostas');

Route::get('Pages/conversas/{id}',[ServicosController::class, 'conversas'])->name('Pages.conversas');
Route::post('Pages/conversas/{id}',[ServicosController::class, 'conversassubmit']);

Route::post('Pages/conversas/{id}/estado',[ServicosController::class, 'estado']);

Route::get('Pages/planos',[ServicosController::class, 'planos'])->name('Pages.planos');
Route::post('Pages/plano',[ServicosController::class, 'plano']);
