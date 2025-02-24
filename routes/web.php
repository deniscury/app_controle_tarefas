<?php

use Illuminate\Support\Facades\Route;
use App\Mail\MensagemTesteMail;
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

Route::get('/', function () {
    return view('bem-vindo');
});

Auth::routes(['verify' => true]);

/*
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('verified');
*/

Route::get('tarefa/exportar/{ext}', 'App\Http\Controllers\TarefaController@exportar')
    ->name('tarefa.exportar')
    ->middleware('verified');

Route::resource('tarefa', 'App\Http\Controllers\TarefaController')
    ->middleware('verified');

Route::get('/mensagem-teste', function(){
    Mail::to('deniscur@hotmail.com')->send(new MensagemTesteMail());
    return 'Enviado com sucesso';
});