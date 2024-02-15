@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Pagamento') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('finalizarPagamento') }}">
                        @csrf

                        <input type="hidden" id="compra_id" name="compra_id" value="{{ $compra_id }}">
                        
                        <div class="row mb-3">
                            <label for="nome_titular" class="col-md-4 col-form-label text-md-end">{{ __('Nome do titular') }}</label>

                            <div class="col-md-6">
                                <input id="nome_titular" type="text" class="form-control @error('nome_titular') is-invalid @enderror" name="nome_titular" value="{{ $pagamento->nome_titular ?? old('nome_titular') }}" required autocomplete="nome_titular" autofocus>

                                @error('nome_titular')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="data_vencimento_cartao" class="col-md-4 col-form-label text-md-end">{{ __('Data de vencimento do cartão') }}</label>

                            <div class="col-md-6">
                                <input id="data_vencimento_cartao" type="text" class="form-control @error('data_vencimento_cartao') is-invalid @enderror" name="data_vencimento_cartao" value="{{ $pagamento->data_vencimento_cartao ?? old('data_vencimento_cartao') }}" required autocomplete="data_vencimento_cartao" autofocus>

                                @error('data_vencimento_cartao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="numero_cartao" class="col-md-4 col-form-label text-md-end">{{ __('Numero cartao') }}</label>

                            <div class="col-md-6">
                                <input id="numero_cartao" type="number" min="0" step="1" class="form-control @error('numero_cartao') is-invalid @enderror" name="numero_cartao" value="{{ $pagamento->numero_cartao ?? old('numero_cartao') }}" required autocomplete="numero_cartao" autofocus>

                                @error('numero_cartao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="endereco_entrega" class="col-md-4 col-form-label text-md-end">{{ __('Data de vencimento do cartão') }}</label>

                            <div class="col-md-6">
                                <input id="endereco_entrega" type="text" class="form-control @error('endereco_entrega') is-invalid @enderror" name="endereco_entrega" value="{{ $pagamento->endereco_entrega ?? old('endereco_entrega') }}" required autocomplete="endereco_entrega" disabled>

                                @error('endereco_entrega')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="total" class="col-md-4 col-form-label text-md-end">{{ __('Total') }}</label>

                            <div class="col-md-6">
                                <input id="total" type="number" step="0.01" class="form-control @error('total') is-invalid @enderror" name="total" value="{{ $pagamento->total ?? old('total') }}" required autocomplete="total" disabled>

                                @error('total')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <button type="submit" class="btn col-12 btn-success">
                                {{ __('Finalizar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
