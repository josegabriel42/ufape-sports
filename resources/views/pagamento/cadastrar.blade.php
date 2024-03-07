@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h5 class="card-tile">{{ __('Pagamento') }}</h5></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('finalizarPagamento') }}">
                        @csrf

                        <input type="hidden" id="compra_id" name="compra_id" value="{{ $compra_id }}">
                        
                        <div class="row mb-3">
                            <label for="nome_titular" class="col-md-4 col-form-label text-md-end">{{ __('Nome do titular') }}</label>

                            <div class="col-md-6">
                                <input id="nome_titular" type="text" class="form-control @error('nome_titular') is-invalid @enderror" name="nome_titular" value="{{ old('nome_titular') ?? $pagamento->nome_titular ?? '' }}" required autocomplete="nome_titular" autofocus>

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
                                <input id="data_vencimento_cartao" type="text" class="form-control @error('data_vencimento_cartao') is-invalid @enderror" name="data_vencimento_cartao" value="{{ old('data_vencimento_cartao') ?? $pagamento->data_vencimento_cartao ?? '' }}" required autocomplete="data_vencimento_cartao" autofocus>

                                @error('data_vencimento_cartao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="numero_cartao" class="col-md-4 col-form-label text-md-end">{{ __('Número cartão') }}</label>

                            <div class="col-md-6">
                                <input id="numero_cartao" type="text" class="form-control @error('numero_cartao') is-invalid @enderror" name="numero_cartao" value="{{ old('numero_cartao') ?? $pagamento->numero_cartao ?? '' }}" required autocomplete="numero_cartao" autofocus>

                                @error('numero_cartao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cod_seguranca" class="col-md-4 col-form-label text-md-end">{{ __('Código de segurança') }}</label>

                            <div class="col-md-4">
                                <input id="cod_seguranca" type="text" class="form-control @error('cod_seguranca') is-invalid @enderror" name="cod_seguranca" value="{{ old('cod_seguranca') ?? $pagamento->cod_seguranca ?? '' }}" required autocomplete="cod_seguranca" autofocus>

                                @error('cod_seguranca')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="endereco_entrega" class="col-md-4 col-form-label text-md-end">{{ __('Endereço de entrega') }}</label>

                            <div class="col-md-6">
                            <input id="endereco_entrega" type="text" class="form-control @error('endereco_entrega') is-invalid @enderror" name="endereco_entrega" value="{{ old('endereco_entrega') ?? $pagamento->endereco_entrega ?? ''}}" required autocomplete="endereco_entrega" hidden>
                                <input id="endereco_entrega" type="text" class="form-control @error('endereco_entrega') is-invalid @enderror" name="endereco_entrega" value="{{ old('endereco_entrega') ?? $pagamento->endereco_entrega ?? ''}}" required autocomplete="endereco_entrega" disabled>

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
                                <input id="total" type="number" step="0.01" class="form-control @error('total') is-invalid @enderror" name="total" value="{{ $total }}" hidden>
                                <input id="total" type="number" step="0.01" class="form-control @error('total') is-invalid @enderror" name="total" value="{{ $total }}" disabled>

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
