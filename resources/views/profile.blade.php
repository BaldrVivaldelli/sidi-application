@extends('layouts.app')

@section('content')
<!-- Wrapper -->
<!-- Wrapper -->
<div id="wrapper">

	<!-- Main -->
	<div id="main">
		<div class="inner">

			<!-- Header -->
			<header id="header">
				<h3>Perfil</h3>
			</header>
			<!-- Form -->			
			@if(session('success'))
    			<h3>{{session('success')}}</h3>
			@endif
			<section>                
                <h5>NOMBRE</h5>
				<div class="col-6 col-12-xsmall">
					{{ Auth::user()->name }}
				</div>
				<h5>APELLIDO</h5>
				<div class="col-6 col-12-xsmall">
					{{ Auth::user()->lastname }}
				</div>
				<h5>MAIL</h5>
				<div class="col-6 col-12-xsmall">
					{{ Auth::user()->email }}
				</div>
			</section>

			@if(Auth::user()->tipoLogeo == 'google')
			<h5>El usuario se registro por un medio externo, no se le permite cambiar la contraseña</h5>
			@elseif(Auth::user()->email == 'admin@admin.com')
			
			<h5>No se permiten hacer modificaciones en usuario admin</h5>
			@else
			<h5>CAMBIAR CONTRASEÑA</h5>
			<form method="post" action="/changePassword">
				@csrf

				@foreach ($errors->all() as $error)
				<p class="text-danger">{{ $error }}</p>
				@endforeach
				
				<div class="row gtr-uniform">
					<div class="col-6 col-12-xsmall">
						<input type="password" name="current_password" id="current_password" value="" placeholder="Contraseña antigua" required />
					</div>
					<div class="col-6 col-12-xsmall">

					</div>
					<div class="col-6 col-12-xsmall">
						<input type="password" name="password" id="password" value="" placeholder="Contraseña nueva" required />
					</div>
					<div class="col-6 col-12-xsmall">

					</div>
					<div class="col-6 col-12-xsmall">
						<input type="password" name="password_confirmation" id="password_confirmation" value="" placeholder="Repita la contraseña" required />
					</div>
					<div class="col-6 col-12-xsmall">

					</div>

					<!-- Break -->
					<div class="col-12">
						<ul class="actions">
							<li><input type="submit" value="Cambiar contraseña" class="primary" /></li>

						</ul>
					</div>
				</div>
				<div class="col-12">
                                    <div class="col-12">
                                        <p>
                                            La password tiene que tener el siguiente formato:</br>
                                                Un caracter en minuscula</br>
                                                Un caracter en mayuscula</br>
                                                Un caracter un digito del 0 al 9</br>
                                                Un caracter un caracter especial</br>
                                                Minimo 8 caracteres</br>
                                                Maximo 12 caracteres</br>
                                        </p>
                                    </div>                                    
				</div>
				@endif
			</form>
		</div>
	</div>


    <!-- Sidebar -->
    <div id="sidebar">
        <div class="inner">

            <!-- Menu -->
            <nav id="menu">
                <header class="major">
                    <h2>Menu</h2>
                </header>
                <ul>
                    <li><a href="/home">Inicio</a></li>

                    @if(Auth::user()->id_estado != 2)

                        @if(Auth::user()->id_rol == 2)
                        <li><a href="/users">Administracion de Usuarios</a></li>
						<li><a href="/logs">Ver Logs</a></li>
                        @endif

                        <li><a href="/profile">Perfil</a></li>
                        <li>
                            <span class="opener">Contenidos</span>
                            <ul>
                                <li><a href="/content/create">Agregar Contenido</a></li>
                                <li><a href="/content/delete">Borrar Contenido</a></li>
                                <li><a href="/content/modify">Modificar Contenido</a></li>

                            </ul>
                        </li>
                        <li>
                            <span class="opener">Dispositivos</span>
                            <ul>
                                <li><a href="/display/getAll">Administrar Dispositivos</a></li>                            
                            </ul>
                        </li>
                    @else
                    <li><a href="/profile">Perfil</a></li>
                    @endif
                    <li><a href="/logout">Salir</a></li>

                </ul>
            </nav>

        </div>
    </div>
</div>


@endsection