<?php

use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\UsuarioController;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/ping', function () {
    return ['pong' => true];
});

Route::get('/401', [LoginController::class, 'unauthorized'])->name('autorization');

Route::post('/auth/login', [LoginController::class, 'login'])->name('login');
Route::post('/auth/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/auth/refresh', [LoginController::class, 'refresh'])->name('refresh');

Route::post('/user', [UsuarioController::class, 'store'])->name('create_user');
//Route::put('/user', [UsuarioController::class, 'update'])->name('update_user');

Route::get('/unidades/{servico}', [UnidadeController::class, 'index'])->name('list_unidades');

Route::get('/servicos/unidade/{idunidade}/{servico}/list', [ServicoController::class, 'index'])->name('list_servicos');
Route::get('/agendar/{servico}/{id_servico}/unidade/{id_unidade}', [ServicoController::class, 'create'])->name('form_agendamento');

Route::get('/agendamentos/{id_agendamento}', [AgendamentoController::class, 'show'])->name('detail_agendamentos');
Route::get('/{situacao}/list', [AgendamentoController::class, 'index'])->name('list_agendamentos');
Route::post('/servicos/agendar', [AgendamentoController::class, 'store'])->name('create_agendamento');
Route::delete('/agendamentos/{id_servico}/cancelar', [AgendamentoController::class, 'destroy'])->name('cancel_agendamento');

Route::post('/gethorarios', [AgendamentoController::class, 'getHorarios'])->name('getHorarios');
