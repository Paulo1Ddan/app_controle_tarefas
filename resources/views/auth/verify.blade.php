@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Falta pouco agora. Precisamos apenas que você verifique seu email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Um link de validação foi enviado ao seu email.') }}
                        </div>
                    @endif

                    {{ __('Antes de prosseguir, verifique o link de validação enviado ao seu email.') }}
                    {{ __('Se você não recebeu o link de validação') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('clique aqui para reenviar outro link') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
