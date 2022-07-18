@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Falta pouco agora, você só precisa validar seu email</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Um email de verificação foi reenviado com um novo link.
                        </div>
                    @endif

                    Antes de prosseguir você precisa validar o email 
                    Caso você não tenha recebido o email clique no link a seguir para receber um novo email,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Clique Aqui</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
