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

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Buscar Produtos') }}</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('consultaProdutos') }}">
                        @csrf

                        @isset($promocao)
                            <input type="text" id="promocao_id" name="promocao_id" value="{{ $promocao->id }}" hidden>
                        @endisset

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="nome" class="col-md-4 col-form-label">{{ __('Nome') }}</label>
        
                                    <div class="col-md-8">
                                        <input id="nome" type="text" class="form-control " name="nome" value="{{ old('nome') }}" autocomplete="nome">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <label for="categoria" class="col-md-4 col-form-label">{{ __('Categoria') }}</label>

                                    <div class="col-md-8">
                                        <select id="categoria" class="form-select" aria-label="Default select example" name="categoria">
                                            @foreach($categorias as $categoria)
                                                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="marca" class="col-md-2 col-form-label">{{ __('Marca') }}</label>

                            <div class="col-md-10">
                                <input id="marca" type="text" class="form-control" name="marca" value="{{ old('marca') }}" autocomplete="marca">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="preco_minimo" class="col-md-4 form-label">{{ __('Preço mínimo') }}</label>
                                    <div class="col-md-8">
                                        <input id="preco_minimo" type="number" step="0.01" class="form-control" name="preco_minimo" value="{{ old('preco_minimo') }}" autocomplete="preco_minimo">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <label for="preco_maximo" class="col-md-4 form-label">{{ __('Preço máximo') }}</label>
                                    <div class="col-md-8">
                                        <input id="preco_maximo" type="number" step="0.01" class="form-control" name="preco_maximo" value="{{ old('preco_maximo') }}" autocomplete="preco_maximo">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="peso_minimo" class="col-md-4 form-label">{{ __('Peso mínimo') }}</label>
                                    <div class="col-md-8">
                                        <input id="peso_minimo" type="number" step="0.01" class="form-control" name="peso_minimo" value="{{ old('peso_minimo') }}" autocomplete="peso_minimo">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <label for="peso_maximo" class="col-md-4 form-label">{{ __('Peso máximo') }}</label>
                                    <div class="col-md-8">
                                        <input id="peso_maximo" type="number" step="0.01" class="form-control " name="peso_maximo" value="{{ old('peso_maximo') }}" autocomplete="peso_maximo">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Buscar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- LISTAGEM DE PRODUTOS COM PROMOÇÃO -->
        @isset($promocao)
            <div class="col-md-12 mt-3">
                <hr>
                <h2>Na Promoção</h2>

                <div class="row">
                    @forelse($produtos_promocao as $produto_promocao)
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <input type="text" class="form-control mb-2" value="Nome: {{ $produto_promocao->nome }}" disabled>
                                    <input type="text" class="form-control mb-2" value="Marca: {{ $produto_promocao->marca }}" disabled>
                                    <input type="text" class="form-control mb-2" value="Preco: R${{ $produto_promocao->preco }}" disabled>
                                    <input type="text" class="form-control mb-2" value="Peso: {{ $produto_promocao->peso }}kg" disabled>
                                    <input type="color" class="form-control form-control-color mb-2" value="{{ $produto_promocao->cor }}" disabled>
                                    
                                    <form method="POST" action="{{ route('aplicarOuRemoverPromocao') }}">
                                        @method('PUT')
                                        @csrf
                                        <input type="text" id="promocao_id" name="promocao_id" value="{{ $promocao->id }}" hidden>
                                        <input type="text" id="produto_id" name="produto_id" value="{{ $produto_promocao->id }}" hidden>

                                        <button type="submit" class="btn btn-danger col-12">
                                            {{ __('Remover promoção') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h3>Nenhum produto encontrado</h3>
                    @endforelse
                </div>
            </div>
        @endempty

        <!-- LISTAGEM DE PRODUTOS SEM PROMOÇÃO -->
        <div class="col-md-12 mt-3">
            <hr>
            <h2>Produtos</h2>

            <div class="row">
                @forelse($produtos as $produto)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <input type="text" class="form-control mb-2" value="Nome: {{ $produto->nome }}" disabled>
                                <input type="text" class="form-control mb-2" value="Marca: {{ $produto->marca }}" disabled>
                                <input type="text" class="form-control mb-2" value="Preco: R${{ $produto->preco }}" disabled>
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
                                    @empty($promocao)
                                        <a class="btn btn-warning col-12" href="{{ route('telaAtualizaProduto', ['produto' => $produto->id]) }}" role="button">{{ __('Editar') }}</a>
                                    @else
                                        <form method="POST" action="{{ route('aplicarOuRemoverPromocao') }}">
                                            @method('PUT')
                                            @csrf
                                            <input type="text" id="promocao_id" name="promocao_id" value="{{ $promocao->id }}" hidden>
                                            <input type="text" id="produto_id" name="produto_id" value="{{ $produto->id }}" hidden>

                                            <button type="submit" class="btn btn-success col-12">
                                                {{ __('Aplicar promoção') }}
                                            </button>
                                        </form>
                                    @endempty
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <h3>Nenhum produto encontrado</h3>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
