@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(session('mensagem_status_aviso'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>{{ session('mensagem_status_aviso') }}</strong> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('mensagem_status'))
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>{{ session('mensagem_status') }}</strong> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('mensagem_status_erro'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('mensagem_status_erro') }}</strong> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <label for="nome">Nome:</label>
                                <input type="text" id="nome" name="nome" class="form-control mb-2" value="{{ $produto_atual->nome }}" disabled>
                            </div>
    
                            <div class="col-md-5">
                                <label for="marca">Marca:</label>
                                <input type="text" id="marca" name="marca" class="form-control mb-2" value="{{ $produto_atual->marca }}" disabled>
                            </div>
    
                            <div class="col-md-2">
                                <label for="color">Cor:</label>
                                <input type="color" id="cor" name="cor" class="w-100 form-control form-control-color mb-2" value="{{ $produto_atual->cor }}" disabled>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-12">
                                <label for="descricao">Descrição:</label>
                                <input type="text-area" id="descricao" name="descricao" class="form-control mb-2" value="{{ $produto_atual->descricao }}" disabled>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <label for="preco">Preço:</label>
                                <input type="text" id="preco" name="preco" class="form-control mb-2" value="R${{ $produto_atual->preco }}" disabled>
                            </div>
    
                            <div class="col-md-6">
                                <label for="peso">Peso:</label>
                                <input type="text" id="peso" name="peso" class="form-control mb-2" value="{{ $produto_atual->peso }}kg" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="preco">Preço com desconto:</label>
                                <input type="text" id="preco_com_desconto" name="preco_com_desconto" class="form-control mb-2" value="R${{ $produto_atual->preco_com_desconto }}" disabled>
                            </div>

                            <div class="col-md-6">
                                <label for="nome_categoria">Categoria</label>
                                <input type="text" id="nome_categoria" name="nome_categoria" class="form-control mb-2" value="{{ $nome_categoria }}" disabled>
                            </div>
                        </div>
    
                        @if(Auth::user()->email != 'adm@adm')
                            @if($produto_atual->estoque > 0)
                                <form method="POST" action="{{ route('adicionarAoCarrinho') }}">
                                    @method('PUT')
                                    @csrf
                                    <input type="text" id="produto_id" name="produto_id" value="{{ $produto_atual->id }}" hidden>
                                    
                                    <label for="quantidade">Quantidade:</label>
                                    <input type="number" class="form-control mb-2" min="1" step="1" id="quantidade" name="quantidade" value=1>
                                    <button type="submit" class="btn btn-secondary col-12">
                                        {{ __('Adicionar ao carrinho') }}
                                    </button>
                                </form>
                            @else
                                <div class="p-3 mb-2 rounded bg-danger text-center text-white">ESGOTADO!</div>
                            @endif
                        @else
                            <div class="col-md-6">
                                <label for="estoque">Estoque:</label>
                                <input type="number" id="estoque" name="estoque" class="form-control mb-2" value="{{ $produto_atual->estoque }}" disabled>
                            </div>
                            <a class="btn btn-warning col-12" href="{{ route('telaAtualizaProduto', ['produto' => $produto_atual->id]) }}" role="button">{{ __('Editar') }}</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Promoções aplicadas</h5>
                    </div>

                    <div class="body">
                        <div class="row justify-content-center">
                            @forelse($promocoes_valendo as $promocao)
                                <div class="col-md-6 m-1">
                                    <div class="p-2 mb-1 rounded bg-danger text-center text-white">
                                        <h5>{{ $promocao->nome}}</h5>
                                        <h5>{{ $promocao->percentagem}}%</h5>
                                    </div>
                                </div>
                            @empty
                                <h4 class="m-3" style="text-align: center; color:gray">Nenhuma promoção registrada para hoje</h4>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <hr>
            <h2>Na mesma categoria ({{ $nome_categoria }})</h2>

            <div class="row">
                @forelse($produtos_mesma_categoria as $produto)
                    <div class="col-md-3 mb-3">
                        <div class="card" style="@if($produto['promocao_ativa']) background-color:yellow; @endif">
                            <div class="card-body">
                                <input type="text" class="form-control mb-2" value="Nome: {{ $produto->nome }}" disabled>
                                <input type="text" class="form-control mb-2" value="Marca: {{ $produto->marca }}" disabled>
                                <input type="text" class="form-control mb-2" value="Preco: R${{ $produto->preco }}" disabled>
                                <input type="text" class="form-control mb-2" value="Promoção: R${{ $produto->preco_com_desconto }}" disabled>
                                <input type="text" class="form-control mb-2" value="Peso: {{ $produto->peso }}kg" disabled>
                                <input type="color" class="form-control form-control-color mb-2" value="{{ $produto->cor }}" disabled>

                                @if(Auth::user()->email != 'adm@adm')
                                    <form method="POST" action="{{ route('adicionarAoCarrinho') }}">
                                        @method('PUT')
                                        @csrf
                                        <input type="text" id="produto_id" name="produto_id" value="{{ $produto->id }}" hidden>
                                        
                                        @if($produto->estoque > 0)
                                            <input type="number" class="form-control mb-2" min="1" step="1" id="quantidade" name="quantidade" value=1>
                                            <button type="submit" class="btn btn-secondary col-12">
                                                {{ __('Adicionar ao carrinho') }}
                                            </button>
                                        @else
                                            <div class="p-3 mb-2 rounded bg-danger text-center text-white">ESGOTADO!</div>
                                        @endif
                                    </form>
                                @else
                                    <a class="btn btn-warning col-12" href="{{ route('telaAtualizaProduto', ['produto' => $produto->id]) }}" role="button">{{ __('Editar') }}</a>
                                @endif
                                <a class="btn btn-info col-12 my-2" href="{{ route('visualizarProduto', ['produto' => $produto->id]) }}" role="button">{{ __('Visualizar') }}</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <h3>Nenhum produto encontrado</h3>
                @endforelse
            </div>

    </div>
</div>
@endsection
