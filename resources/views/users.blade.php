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
				<h3>Panel de Usuario</h3>
			</header>
			</br>

			<!-- Form -->
			<table style="width:100%">
				<h5 id="warning" style="display:none"> No se permiten hacer modificaciones en usuario admin </h5>
				<tr>
					<th>Nombre</th>
					<th>Mail</th>
					<th>Permisos</th>
					<th>Estado</th>
					<th></th> <!-- NO BORRAR CLAVE ESTE -->
					<th>Eliminar</th>
				</tr>
				@foreach ($users as $indexKey => $user)
				<tr>
					<td class="cliente">{{ $user['name']  }}</td>
					<td class="email">{{ $user['email'] }}</td>
					<td><select  class ="cambiar-rol" >
						@foreach ($roles as $indexKey => $rol)
						@if($rol == $user['permisos'])
						<option selected class="rol">{{$rol}}</option>
						@else
						<option >{{$rol}}</option>
						@endif
						@endforeach
						</select>
					</td>

					<td>
						<!-- <form id="changeStateUser-post-{{$user['estado']}}" action="/changestate" method="POST" style="display: none;">
							{{ csrf_field() }}
							<input id="email" name="email" type="hidden" value="{{$user["email"]}}">
						</form>
						<a href="#" onclick="event.preventDefault(); document.getElementById('changeStateUser-post-{{$user["estado"]}}').submit();">
							{{ $user['estado'] }}
						</a> -->
						<form id="changeStateUser-post-{{$user['email']}}" action="/users/changestate" method="POST" style="display: none;">
							{{ csrf_field() }}
							<input name="email" type="hidden" value="{{$user["email"]}}">
						</form>
						<a href="#" onclick=processChangeState("{{$user["email"]}}")>
							{{ $user['estado'] }}
						</a>


					</td>
					<td>
						<!-- <form id="delete-post-{{$user['email']}}" action="/deleteUser/{{$user['email']}}" method="POST" style="display: none;">
							{{ csrf_field() }}
							<input name="email" type="hidden" value="{{$user["email"]}}">
						</form>
						<a href="#" onclick="event.preventDefault(); document.getElementById('delete-post-{{$user["email"]}}').submit();">
							X
						</a> -->
					<td><button value={{$user["email"]}} class="eliminar-usuario">Eliminar</button></td>
					</td>

				</tr>
				@endforeach
			</table>

			<!-- <table style="width:100%">
				<h5> Logs de actividad</h5>
				<tr>
					<th>Nombre de Log</th>
					<th>Fecha</th>
				</tr>
	
			</table> -->
		</div>
	</div>

	<div id="modal-eliminar-usuario" class="modal">
		<!-- Modal content estado -->
		<div class="modal-content">

			<span class="close-eliminar-usuario-modal">&times;</span>
			<p>¿Seguro quiere Eliminar el usuario ?</p>
			<button id="submit-delete-usuario">Si, muy seguro</button>
			<button>No, cambie de opinion</button>
		</div>
	</div>

	<div id="modal-cambiarRol-usuario" class="modal">
		<!-- Modal content estado -->
		<div class="modal-content">

			<span class="close-cambiarRol-modal">&times;</span>
			<p>¿Seguro quiere cambiar el Rol del usuario ?</p>
			<button id="submit-cambiarRol-usuario">Si, muy seguro</button>
			<button>No, cambie de opinion</button>
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
					<li><a href="/logout">Salir</a></li>
				</ul>
			</nav>
		</div>
	</div>
</div>


<script>

	var spanCambiarRol  = document.getElementsByClassName("close-cambiarRol-modal")[0];
	var modalCambiarRol = document.getElementById("modal-cambiarRol-usuario");

	var spanEliminarUsuario = document.getElementsByClassName("close-eliminar-usuario-modal")[0];
	var modalEliminarUsuario = document.getElementById("modal-eliminar-usuario");	
	var usuario;
	var rol;
	// When the user clicks the button, open the modal 
	Array.prototype.forEach.call(document.getElementsByClassName("eliminar-usuario"), (buttonEliminar) => {

		buttonEliminar.addEventListener('click', function() {
			headerCliente = this.parentNode.parentNode.getElementsByClassName("email")[0].innerText;
			console.log('agarre el cliente ' + headerCliente);
			headerContent = this.value;
			usuario = headerContent;
			console.log('se cambia el estado' + headerContent);
			modalEliminarUsuario.style.display = "block";
		});
	});

	Array.prototype.forEach.call(document.getElementsByClassName("cambiar-rol"), (botonCambiarRol) => {

				botonCambiarRol.addEventListener('change', function() {
				headerCliente = this.parentNode.parentNode.getElementsByClassName("email")[0].innerText;
				rol = this.parentNode.parentNode.getElementsByClassName("rol")[0].innerText;
				console.log('agarre el cliente ' + headerCliente);
				headerContent = this.value;
				usuario = headerCliente;
				console.log('se cambia el estado' + headerContent);
				modalCambiarRol.style.display = "block";
			});
		});

		

	// When the user clicks on <span> (x), close the modal
	modalCambiarRol.onclick = function() {
		modalCambiarRol.style.display = "none";

	}

	spanCambiarRol.onclick = function() {
		modalCambiarRol.style.display = "none";
	}		
		
	// When the user clicks on <span> (x), close the modal
	modalEliminarUsuario.onclick = function() {
		modalEliminarUsuario.style.display = "none";

	}
	// When the user clicks on <span> (x), close the modal
	spanEliminarUsuario.onclick = function() {
		modalEliminarUsuario.style.display = "none";
	}

	document.getElementById("submit-cambiarRol-usuario").addEventListener('click', function() {
		if (usuario === "admin@admin.com" || usuario === "{{Auth::user()->user}}" ) {
			document.getElementById("warning").style.display = "block";
		} else {

			$.ajax({
				type: 'POST',
				url: '{{ config('app.url')}}'+'/users/changeRoleUser',
				data: {
					_token: "{{ csrf_token() }}",
					'email': `${headerCliente}`,
					'rol': `${headerContent}`, 
				},
				success: function(msg) {
					location.reload();

				}
			});
		}
	});

	document.getElementById("submit-delete-usuario").addEventListener('click', function() {
		if (usuario === "admin@admin.com" || usuario === "{{Auth::user()->user}}" ) {
			document.getElementById("warning").style.display = "block";
		} else {

			$.ajax({
				type: 'POST',
				url:  '{{ config('app.url')}}'+'/users/deleteUser',
				data: {
					_token: "{{ csrf_token() }}",
					'email': `${usuario}`
				},
				success: function(msg) {
					location.reload();

				}
			});
		}
	});

	function processChangeState(nameButton){

		event.preventDefault();
		if (usuario === "admin@admin.com" || usuario === "{{Auth::user()->user}}" ) {
			document.getElementById("warning").style.display = "block";
		} else {
			// document.getElementById('changeStateUser-post-{{$user["email"]}}').submit();
			document.getElementById('changeStateUser-post-'+nameButton).submit();
			
		}
	}
		
</script>

<style>
	/* The Modal (background) */
	.modal {
		display: none;
		/* Hidden by default */
		position: fixed;
		/* Stay in place */
		z-index: 1;
		/* Sit on top */
		left: 0;
		top: 0;
		width: 100%;
		/* Full width */
		height: 100%;
		/* Full height */
		overflow: auto;
		/* Enable scroll if needed */
		background-color: rgb(0, 0, 0);
		/* Fallback color */
		background-color: rgba(0, 0, 0, 0.4);
		/* Black w/ opacity */
	}

	/* Modal Content/Box */
	.modal-content {
		background-color: #fefefe;
		margin: 15% auto;
		/* 15% from the top and centered */
		padding: 20px;
		border: 1px solid #888;
		width: 80%;
		/* Could be more or less, depending on screen size */
	}

	/* The Close Button */
	.close {
		color: #aaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}

	.close:hover,
	.close:focus {
		color: black;
		text-decoration: none;
		cursor: pointer;
	}
</style>

@endsection