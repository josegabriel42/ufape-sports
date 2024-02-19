<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PromocaoController;
use App\Http\Controllers\UserController;
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

Route::get('/editar', [UserController::class, 'edit'])->name('edit');
Route::put('/atualizar', [UserController::class, 'update'])->name('update');

Route::get('/', [ProdutoController::class, 'index'])->name('home');

Route::get('/categoria/{categoria}', [CategoriaController::class, 'show']);
Route::get('/cadastroCategoria', [CategoriaController::class, 'create'])->name('telaCadastroCategoria');
Route::post('/cadastroCategoria', [CategoriaController::class, 'store'])->name('cadastroCategoria');

Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos');
Route::get('/consultaProdutos/{nome?}/{categoria?}/{marca?}/{cor?}/{preco_minimo?}/{preco_maximo?}/{peso_minimo?}/{peso_maximo?}/{promocao_id?}', [ProdutoController::class, 'consulta'])->name('consultaProdutos');
Route::get('/produto/{produto}', [ProdutoController::class, 'show'])->name('visualizarProduto');
Route::get('/cadastroProduto', [ProdutoController::class, 'create'])->name('telaCadastroProduto');
Route::post('/cadastroProduto', [ProdutoController::class, 'store'])->name('cadastroProduto');
Route::get('/atualizaProduto/{produto}', [ProdutoController::class, 'edit'])->name('telaAtualizaProduto');
Route::put('/atualizaProduto', [ProdutoController::class, 'update'])->name('atualizaProduto');

Route::get('/promocao/{promocao}', [PromocaoController::class, 'show'])->name('visualizarPromocao');
Route::get('/cadastroPromocao', [PromocaoController::class, 'create'])->name('telaCadastroPromocao');;
Route::post('/cadastroPromocao', [PromocaoController::class, 'store'])->name('cadastroPromocao');
Route::put('/aplicarOuRemoverPromocao', [PromocaoController::class, 'aplicarOuRemoverPromocao'])->name('aplicarOuRemoverPromocao');

Route::put('/adicionarAoCarrinho', [CompraController::class, 'adicionarAoCarrinho'])->name('adicionarAoCarrinho');
Route::get('/carrinho', [CompraController::class, 'irParaCarrinho'])->name('irParaCarrinho');
Route::get('/finalizarCompra', [PagamentoController::class, 'create'])->name('finalizarCompra');
Route::post('/finalizarPagamento', [PagamentoController::class, 'store'])->name('finalizarPagamento');
