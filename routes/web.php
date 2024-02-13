<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/categoria/{categoria}', [CategoriaController::class, 'show']);
Route::get('/cadastroCategoria', [CategoriaController::class, 'create']);
Route::post('/cadastroCategoria', [CategoriaController::class, 'store'])->name('cadastroCategoria');

Route::get('/produto/{produto}', [ProdutoController::class, 'show']);
Route::get('/cadastroProduto', [ProdutoController::class, 'create']);
Route::post('/cadastroProduto', [ProdutoController::class, 'store'])->name('cadastroProduto');
