@extends('layouts.app')

@section('content')

<div id="wrapper">

<!-- Main -->
    <div id="main">
    
        <div class="inner">
            <div id="formlogrestart">
            <h2>Blanqueo de contraseña</h2>
              <div class="form">
                <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('Para poder blanquear la contraseña por favor ingresar su correo') }}</div>
                            @if($errors->any())
                                <h3>{{$errors->first()}}</h3>
                            @endif

                            <div class="card-body">
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Ingresa tu correo') }}</label>

                                        <div class="col-md-6">
                                            <input id="emailrestart" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Enviar link de reinicio') }}
                                            </button>
                                            <p class="message">Recordaste tu pass? <a href="/login">Volver al login</a></p>
                                        </div>
                                    </div>
                        </div>
                        @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
