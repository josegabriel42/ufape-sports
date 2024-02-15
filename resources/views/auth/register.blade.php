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
                <div class="card-header">{{ __('Cadastrar-se') }}</div>

                <div class="card-body">
                    <form method="POST" action="@isset($user) {{ route('update') }} @else {{ route('register') }} @endisset">
                        @csrf
                        @isset($user)
                            @method('PUT')
                        @endisset

                        @isset($endereco)
                            <input type="hidden" id="endereco_id" name="endereco_id" value="{{ $endereco->id }}">
                        @endisset

                        <div class="row mb-3 justify-content-center">
                            
                            <div class="col-md-8">
                                <label for="name" class="col-form-label">{{ __('Nome') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name ?? old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                        
                            <div class="col-md-8">
                                <label for="cpf" class="col-form-label">{{ __('Cpf') }}</label>
                                <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ $user->cpf ?? old('cpf') }}" required autocomplete="cpf" autofocus>

                                @error('cpf')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            
                            <div class="col-md-8">
                                <label for="telefone" class="col-form-label">{{ __('Telefone') }}</label>
                                <input id="telefone" type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ $user->telefone ?? old('telefone') }}" required autocomplete="telefone" autofocus>

                                @error('telefone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            Endereço
                                        </h5>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="estado" class="col-form-label">{{ __('Estado') }}</label>
                                                <input id="estado" type="text" class="form-control @error('estado') is-invalid @enderror" name="estado" value="{{ $endereco->estado ?? old('estado') }}" required autocomplete="estado" autofocus>
                                                @error('estado')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <label for="cidade" class="col-form-label">{{ __('Cidade') }}</label>
                                                <input id="cidade" type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" value="{{ $endereco->cidade ?? old('cidade') }}" required autocomplete="cidade" autofocus>
                                                @error('cidade')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <label for="bairro" class="col-form-label">{{ __('Bairro') }}</label>
                                                <input id="bairro" type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro" value="{{ $endereco->bairro ?? old('bairro') }}" required autocomplete="bairro" autofocus>
                                                @error('bairro')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <label for="logradouro" class="col-form-label">{{ __('Logradouro') }}</label>
                                                <input id="logradouro" type="text" class="form-control @error('logradouro') is-invalid @enderror" name="logradouro" value="{{ $endereco->logradouro ?? old('logradouro') }}" required autocomplete="logradouro" autofocus>
                                                @error('logradouro')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <label for="cep" class="col-form-label">{{ __('CEP') }}</label>
                                                <input id="cep" type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" value="{{ $endereco->cep ?? old('cep') }}" required autocomplete="cep" autofocus>

                                                @error('cep')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            
                            <div class="col-md-8">
                                <label for="email" class="col-form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email ?? old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            
                            <div class="col-md-8">
                                <label for="password" class="col-form-label">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            
                            <div class="col-md-8">
                                <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row">
                            <button type="submit" class="btn btn-success">
                                {{ __('Cadastrar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
