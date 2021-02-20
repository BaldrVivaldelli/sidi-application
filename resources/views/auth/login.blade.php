@extends('layouts.app')

@section('content')

<!-- Wrapper -->
<div id="wrapper">

  <!-- Main -->
  <div id="main">

    <div class="inner">
      <div id="formlog">
        <h2>Bienvenido a SIDI</h2>
        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif

        <form id="loginForm" class="login-form" role=" form" method="POST" action="{{ url('/login') }}">
          {{ csrf_field() }}
          <div class="form">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
            <span class="help-block">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif

            <input type="password" class="form-control" name="password">
            @if ($errors->has('password'))
            <span class="help-block">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
            <!-- <button type="submit" class="btn btn-primary">
              <i class="fa fa-btn fa-sign-in"></i>Login
            </button>

 -->
            <button type="button" name="login" class="submitButton" id="login" value="Login">Login</button>

            <button type="button" class="submitButton btn btn-primary">
            <!-- <a href="{{ url('/register') }}">
            </a> -->
              <i class="fa fa-btn fa-sign-in"></i>Register
            </button>
        </form>        

            <!-- @foreach ($errors->all() as $error)
            <span class="help-block">
              <p class="text-danger">{{ $error }}</p>
            </span>
            @endforeach -->
        <h4>Ingresa con una cuenta <a href="{{ url('/redirect') }}">Google</a></h4>        
        <h6 class="message">No recordas tu contraseña? <a href="/forgot">Click aqui</a></h6>
      </div>
    </div>


  </div>
</div>

<!-- Sidebar -->

</div>

<script>
var buttons = document.getElementsByClassName("submitButton");

Array.prototype.forEach.call(buttons, function(button) {
    // Do stuff here
    button.addEventListener('click', function(){
      if(this.name === "login"){
        document.getElementById('loginForm').submit();
      }else{
        location.href ="{{ url('/register') }}";
      }
    });    
});

</script>
@endsection