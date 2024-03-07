@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(session('mensagem_status'))
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>{{ session('mensagem_status') }}</strong> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="col-md-8">
            <div class="card">
            <div class="card-header"><h5 class="card-title">@isset($produto) {{ __('Editar Produto') }} @else {{ __('Cadastrar Produto') }} @endisset</h5></div>

                <div class="card-body">
                    <form method="POST" action="@isset($produto) {{ route('atualizaProduto') }} @else {{ route('cadastroProduto') }} @endif">
                        @csrf
                        @isset($produto)
                            @method('PUT')

                            <input type="hidden" id="produto_id" name="produto_id" value="{{ $produto->id }}">
                        @endif

                        <div class="row mb-3">
                            <label for="categoria" class="col-md-4 col-form-label text-md-end">{{ __('Categoria') }}</label>

                            <div class="col-md-6">
                                <select id="categoria" class="form-select @error('categoria') is-invalid @enderror" aria-label="Default select example" name="categoria">
                                    @foreach($categorias as $categoria)
                                        @if(old('categoria') == $categoria->id)
                                            <option value="{{ $categoria->id }}" selected>{{ $categoria->nome }}</option>
                                        @elseif(isset($produto) && $produto->categoria_id == $categoria->id)
                                            <option value="{{ $categoria->id }}" selected>{{ $categoria->nome }}</option>
                                        @else
                                            <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                        @endisset
                                    @endforeach
                                </select>

                                @error('categoria')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nome" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ $produto->nome ?? old('nome') ?? '' }}" required autocomplete="nome" autofocus>

                                @error('nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="descricao" class="col-md-4 col-form-label text-md-end">{{ __('Descricao') }}</label>

                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ old('descricao') ?? $produto->descricao ?? '' }}" required autocomplete="descricao" autofocus>

                                @error('descricao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="marca" class="col-md-4 col-form-label text-md-end">{{ __('Marca') }}</label>

                            <div class="col-md-6">
                                <input id="marca" type="text" class="form-control @error('marca') is-invalid @enderror" name="marca" value="{{ old('marca') ?? $produto->marca ?? '' }}" required autocomplete="marca" autofocus>

                                @error('marca')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cor" class="col-md-4 col-form-label text-md-end">{{ __('Cor') }}</label>

                            <div class="col-md-6">
                                <input id="cor" type="color" class="form-control form-control-color @error('cor') is-invalid @enderror" name="cor" value="{{ old('cor') ?? $produto->cor ?? '' }}" required autocomplete="cor" autofocus>

                                @error('cor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="preco" class="col-md-4 col-form-label text-md-end">{{ __('Preço') }}</label>

                            <div class="col-md-6">
                                <input id="preco" type="number" step="0.01" class="form-control @error('preco') is-invalid @enderror" name="preco" value="{{  old('preco') ?? $produto->preco ?? '' }}" required autocomplete="preco" autofocus>

                                @error('preco')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="peso" class="col-md-4 col-form-label text-md-end">{{ __('Peso') }}</label>

                            <div class="col-md-6">
                                <input id="peso" type="number" step="0.01" class="form-control @error('peso') is-invalid @enderror" name="peso" value="{{ old('peso') ?? $produto->peso ?? '' }}" required autocomplete="peso" autofocus>

                                @error('peso')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="estoque" class="col-md-4 col-form-label text-md-end">{{ __('Estoque') }}</label>

                            <div class="col-md-6">
                                <input id="estoque" type="number" class="form-control @error('estoque') is-invalid @enderror" name="estoque" value="{{ old('estoque') ?? $produto->estoque ?? '' }}" required autocomplete="estoque" autofocus>

                                @error('estoque')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            @isset($produto)
                                <button type="submit" class="btn btn-success col-md-12">
                                    {{ __('Atualizar') }}
                                </button>
                                <a class="btn btn-danger col-md-12 mt-1" href="{{ route('home') }}">
                                    {{ __('Voltar') }}
                                </a>
                            @else
                                <button type="submit" class="btn btn-success col-md-12">
                                    {{ __('Cadastrar') }}
                                </button>
                                <a class="btn btn-danger col-md-12 mt-1" href="{{ route('home') }}">
                                    {{ __('Voltar') }}
                                </a>
                            @endisset
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
