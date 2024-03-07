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
            <div class="row">
                
            </div>
            <div class="card">
                <div class="card-header"><h5 class="card-title">{{ __(Gerar relatório) }}</h5></div>

                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>

@endsection