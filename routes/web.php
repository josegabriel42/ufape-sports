<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Http\Request;
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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/categoria/{categoria}', [CategoriaController::class, 'show']);
Route::get('/cadastroCategoria', [CategoriaController::class, 'create'])->name('telaCadastroCategoria');
Route::post('/cadastroCategoria', [CategoriaController::class, 'store'])->name('cadastroCategoria');

Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos');
Route::get('/consultaProdutos/{nome?}/{categoria?}/{marca?}/{cor?}/{preco_minimo?}/{preco_maximo?}/{peso_minimo?}/{peso_maximo?}', [ProdutoController::class, 'consulta'])->name('consultaProdutos');
Route::get('/produto/{produto}', [ProdutoController::class, 'show'])->name('visualizarProduto');
Route::get('/cadastroProduto', [ProdutoController::class, 'create'])->name('telaCadastroProduto');
Route::post('/cadastroProduto', [ProdutoController::class, 'store'])->name('cadastroProduto');

Route::get('/cadastroPromocao', [CategoriaController::class, 'create'])->name('telaCadastroPromocao');;

Route::put('/adicionarAoCarrinho', function(Request $request) {
    return redirect()->back()->with('adicionado', true);
})->name('adicionarAoCarrinho');
