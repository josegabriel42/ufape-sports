@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cadastrar Promoção') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('cadastroPromocao') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="nome" class="col-md-3 col-form-label">{{ __('Nome') }}</label>
        
                                    <div class="col-md-9">
                                        <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autocomplete="nome" autofocus>
        
                                        @error('nome')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <label for="descricao" class="col-md-3 col-form-label">{{ __('Descricao') }}</label>

                                    <div class="col-md-9">
                                        <input id="descricao" type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ old('descricao') }}" required autocomplete="descricao" autofocus>

                                        @error('descricao')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="percentagem" class="col-md-2 col-form-label ">{{ __('Percentagem') }}</label>

                            <div class="col-md-10">
                                <input id="percentagem" type="number" step="0.01" min="0.00" max="100.00" class="form-control @error('percentagem') is-invalid @enderror" name="percentagem" value="{{ old('percentagem') }}" required autocomplete="percentagem" autofocus>

                                @error('percentagem')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="data_inicio" class="col-md-4 col-form-label">{{ __('Data Início') }}</label>
                                    <div class="col-md-8">
                                        <input id="data_inicio" type="date" class="form-control @error('data_inicio') is-invalid @enderror" name="data_inicio" value="{{ old('data_inicio') }}" required autocomplete="data_inicio" autofocus>
        
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
                                    <label for="data_fim" class="col-md-4 col-form-label ">{{ __('Data Fim') }}</label>
                                    <div class="col-md-8">
                                        <input id="cor" type="date" class="form-control @error('data_fim') is-invalid @enderror" name="data_fim" value="{{ old('data_fim') }}" required autocomplete="data_fim" autofocus>
        
                                        @error('data_fim')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Cadastrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <hr>

            <h2>Promoções</h2>

            <div class="row">
                @forelse($promocoes as $promocao)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <input type="text" class="form-control mb-2" value="Nome: {{ $promocao->nome }}" disabled>
                                <input type="text" class="form-control mb-2" value="Percentagem: {{ $promocao->percentagem }}%" disabled>
                                <input type="date" class="form-control mb-2" value="{{ $promocao->data_inicio }}" disabled>
                                <input type="date" class="form-control mb-2" value="{{ $promocao->data_fim }}" disabled>
                                
                                <a class="btn btn-info col-12" href="{{ route('visualizarPromocao', ['promocao' => $promocao->id]) }}" role="button">{{ __('Visualizar') }}</a>
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
