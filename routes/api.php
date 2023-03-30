<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IdiomaController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TestamentoController;
use App\Http\Controllers\VersaoController;
use App\Http\Controllers\VersiculoController;
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

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::apiResources([
        'testamento' => TestamentoController::class,
        'livro' => LivroController::class,
        'versiculo' => VersiculoController::class,
        'idioma' => IdiomaController::class,
        'versao' => VersaoController::class,
    ]);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Site Publico
Route::get('/site', [SiteController::class, 'index']);
Route::get('/site/{versao}/{livro?}/{capitulo?}/{versiculo?}', [SiteController::class, 'lerBiblia']);
