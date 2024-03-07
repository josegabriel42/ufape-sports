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
                <div class="card-header"><h5 class="card-title">{{ __('Buscar Compras') }}</h5></div>

                <div class="card-body">
                    <form method="GET" action="{{ route('telaHistoricoCompras') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="data_inicio" class="col-md-4 col-form-label">{{ __('Data início') }}</label>
                                    <div class="col-md-8">
                                        <input id="data_inicio" type="date" class="form-control @error('data_inicio') is-invalid @enderror" name="data_inicio" value="{{ old('data_inicio') ?? '' }}" autocomplete="data_inicio" autofocus>
        
                                        @error('data_inicio')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <label for="data_fim" class="col-md-4 col-form-label ">{{ __('Data fim') }}</label>
                                    <div class="col-md-8">
                                        <input id="cor" type="date" class="form-control @error('data_fim') is-invalid @enderror" name="data_fim" value="{{ old('data_fim') ?? '' }}" autocomplete="data_fim" autofocus>
        
                                        @error('data_fim')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
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

                        @if(Auth::user()->email == 'adm@adm')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="cpf" class="col-md-4 form-label">{{ __('CPF') }}</label>
                                        <div class="col-md-8">
                                            <input id="cpf" type="text" class="form-control" name="cpf" value="{{ old('cpf') ?? '' }}" autocomplete="cpf">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row mb-0">
                            <button type="submit" class="btn btn-primary col-md-12">
                                {{ __('Buscar') }}
                            </button>
                            <a class="btn btn-danger col-md-12 mt-1" href="{{ route('home') }}">
                                    {{ __('Voltar') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Compras -->
        <div class="col-12 mt-3">
            <hr>
            <h3>Histórico</h3>

            <div class="row">
                @forelse($compras as $compra)
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body">
                                @if($compra->cpf_cliente)
                                    <input type="text" class="form-control mb-2" value="CPF: {{ $compra->cpf_cliente }}" disabled>
                                @endif
                                <input type="text" class="form-control mb-2" value="Data: {{ $compra->data_compra }}" disabled>
                                <input type="text" class="form-control mb-2" value="Total: R${{ $compra->total }}" disabled>
                                <a class="btn btn-info col-12" href="{{ route('visualizarCompra', ['compra' => $compra->id]) }}" role="button">{{ __('Visualizar') }}</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <h3>Nenhuma compra encontrada para a data selecionada.</h3>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection