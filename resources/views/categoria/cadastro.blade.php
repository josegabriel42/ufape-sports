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
                <div class="card-header">@isset($categoria) {{ __('Editar Categoria') }} @else {{ __('Cadastrar Categoria') }} @endisset</div>

                <div class="card-body">
                    <form method="POST" action="@isset($categoria) {{ route('atualizaCategoria') }} @else {{ route('cadastroCategoria') }} @endisset">
                        @csrf
                        @isset($categoria)
                            @method('PUT')
                            <input type="hidden" id="categoria_id" name="categoria_id" value="{{ $categoria->id }}">
                        @endisset

                        <div class="row mb-3">
                            <label for="nome" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') ?? $categoria->nome ?? '' }}" required autocomplete="nome" autofocus>

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
                                <input id="descricao" type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ old('descricao') ?? $categoria->descricao ?? '' }}" required autocomplete="descricao" autofocus>

                                @error('descricao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            @isset($categoria)
                                <button type="submit" class="btn btn-success">
                                    {{ __('Atualizar') }}
                                </button>
                                <a class="btn btn-danger col-md-12 mt-1" href="{{ route('cadastroCategoria') }}">
                                    {{ __('Voltar') }}
                                </a>
                            @else
                                <button type="submit" class="btn btn-success">
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

        <div class="col-md-12 mt-3">
            <hr>

            <h2>Categorias Cadastradas</h2>

            <div class="row">
                @forelse($categorias as $categoria)
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <input type="text" class="form-control mb-2" value="Nome: {{ $categoria->nome }}" disabled>
                                <input type="text" class="form-control mb-2" value="Descrição: {{ $categoria->descricao }}" disabled>
                                
                                <a class="btn btn-warning col-12" href="{{ route('telaAtualizaCategoria', ['categoria' => $categoria->id]) }}" role="button">{{ __('Editar') }}</a>
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
