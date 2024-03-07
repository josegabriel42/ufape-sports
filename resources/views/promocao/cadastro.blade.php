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
            <div class="card-header"><h5 class="card-title">@isset($promocao) {{ __('Editar Promoção') }} @else {{ __('Cadastrar Promoção') }} @endisset</h5></div>

                <div class="card-body">
                    <form method="POST" action="@isset($promocao) {{ route('atualizaPromocao') }} @else {{ route('cadastroPromocao') }} @endisset">
                        @csrf
                        @isset($promocao)
                            @method('PUT')
                            <input type="hidden" id="promocao_id" name="promocao_id" value="{{ $promocao->id }}">
                        @endisset

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="nome" class="col-md-3 col-form-label">{{ __('Nome') }}</label>
        
                                    <div class="col-md-9">
                                        <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') ?? $promocao->nome ?? ''}}" required autocomplete="nome" autofocus>
        
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
                                        <input id="descricao" type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ old('descricao') ?? $promocao->descricao ?? '' }}" required autocomplete="descricao" autofocus>

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
                                <input id="percentagem" type="number" step="0.01" min="0.00" max="100.00" class="form-control @error('percentagem') is-invalid @enderror" name="percentagem" value="{{ old('percentagem') ?? $promocao->percentagem ?? '' }}" required autocomplete="percentagem" autofocus>

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
                                        <input id="data_inicio" type="date" class="form-control @error('data_inicio') is-invalid @enderror" name="data_inicio" value="{{ old('data_inicio') ?? $promocao->data_inicio ?? '' }}" required autocomplete="data_inicio" autofocus>
        
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
                                        <input id="cor" type="date" class="form-control @error('data_fim') is-invalid @enderror" name="data_fim" value="{{ old('data_fim') ?? $promocao->data_fim ?? '' }}" required autocomplete="data_fim" autofocus>
        
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
                            @isset($promocao)
                                <button type="submit" class="btn btn-success col-md-12">
                                    {{ __('Atualizar') }}
                                </button>
                                <a class="btn btn-danger col-md-12 mt-1" href="{{ route('cadastroPromocao') }}">
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

        <div class="col-md-12 mt-3">
            <hr>

            <h2>Promoções Cadastradas</h2>

            <div class="row">
                @forelse($promocoes as $promocao)
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <input type="text" class="form-control mb-2" value="Nome: {{ $promocao->nome }}" disabled>
                                <input type="text" class="form-control mb-2" value="Descrição: {{ $promocao->descricao }}" disabled>
                                <input type="text" class="form-control mb-2" value="Percentagem: {{ $promocao->percentagem }}%" disabled>
                                <input type="date" class="form-control mb-2" value="{{ $promocao->data_inicio }}" disabled>
                                <input type="date" class="form-control mb-2" value="{{ $promocao->data_fim }}" disabled>
                                
                                <a class="btn btn-warning col-12" href="{{ route('telaAtualizaPromocao', ['promocao' => $promocao->id]) }}" role="button">{{ __('Editar') }}</a>
                                <a class="btn btn-info col-12 mt-2" href="{{ route('visualizarPromocao', ['promocao' => $promocao->id]) }}" role="button">{{ __('Marcar produtos') }}</a>
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
