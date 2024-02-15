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

    <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h3>{{ __('Carrinho') }}</h3></div>

                <div class="card-body">
                    <div class="row justify-content-center">
                        @forelse($itens_carrinho as $item)
                            <div class="col-md-10 mb-2">
                                <div class="card-header">
                                    <b>{{ $item->nome }} - (R$ {{ $item->preco }}) </b>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <form method="POST" action="{{ route('adicionarAoCarrinho') }}">
                                                @method('PUT')
                                                @csrf
                                                <input type="text" id="produto_id" name="produto_id" value="{{ $item->produto_id }}" hidden>
                                                @if($item->estoque_zerado)
                                                    <input type="number" class="form-control mb-2" min="0" step="1" id="quantidade" name="quantidade" value="0" hidden>
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="preco_total">Quantidade</label>
                                                        <input type="number" class="form-control mb-2" min="0" step="1" id="quantidade" name="quantidade" value="{{ $item->quantidade }}" @if($item->estoque_zerado) disabled @endif>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="preco_total">Desconto</label>
                                                        <input type="text" class="form-control mb-2" value="R$ {{ ($item->preco_total - $item->preco_com_desconto) }}" disabled>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="preco_total">Preço total</label>
                                                        <input type="text" class="form-control mb-2" value="R$ {{ $item->preco_com_desconto }}" disabled>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for=""></label>
                                                        <button type="submit" class="btn btn-info col-12">
                                                            {{ __('Atualizar') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col">
                                <h4 style="text-align: center; color:gray">Carrinho vazio</h4>
                            </div>
                        @endforelse
                    </div>

                    <!-- PREÇO TOTAL E BOTÃO PARA FINALIZAR COMPRA -->
                    @if($total_da_compra)
                        <div class="row justify-content-end">
                            <div class="col-md-3">
                                <h3>Total:</h3>
                                <input type="text" class="form-control" value="R$ {{ $total_da_compra }}" disabled>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-md-3 mt-2">
                                <a class="btn btn-success col-12" href="{{ route('finalizarCompra') }}" role="button">{{ __('Finalizar') }}</a>
                            </div>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
