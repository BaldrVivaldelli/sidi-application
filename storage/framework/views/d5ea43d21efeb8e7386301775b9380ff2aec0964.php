<?php $__env->startSection('content'); ?>
<!-- Wrapper -->
<div id="wrapper">
	<!-- Main -->
	<div id="main">
		<div class="inner">
			<!-- Header -->
			<header id="header">
				<a href="index.html" class="logo"><strong>Borrar Contenido</strong></a>
			</header>

			<!-- Form -->
			<form>
				<?php echo e(csrf_field()); ?>

				<div class="col-12">
					<select name="content-name" id="content-name">
						<?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indexKey => $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> {
						<option value="<?php echo e($region['name']); ?>"><?php echo e($region['name']); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</div>
				<input type="button" id="eliminarContenido" value="Borrar contenido" class="primary" />
			</form>
		</div>
	</div>


	<div id="modal-eliminar-contenido" class="modal">
		<!-- Modal content estado -->
		<div class="modal-content">

			<span class="close-eliminar-contenido-modal">&times;</span>
			<p>¿Seguro quiere Eliminar el contenido ?</p>
			<button id="submit-delete-contenido">Si, muy seguro</button>
			<button>No, cambie de opinion</button>
		</div>
	</div>
	<!-- Sidebar -->
	<!-- Sidebar -->
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

					<?php if(Auth::user()->id_estado != 2): ?>

					<?php if(Auth::user()->id_rol == 2): ?>
					<li><a href="/users">Administracion de contenidos</a></li>
					<li><a href="/logs">Ver Logs</a></li>
					<?php endif; ?>

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
					<?php else: ?>
					<li><a href="/profile">Perfil</a></li>
					<?php endif; ?>
					<li><a href="/logout">Salir</a></li>

				</ul>
			</nav>

		</div>
	</div>
</div>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('styles'); ?>
<script>
	var spanEliminarcontenido = document.getElementsByClassName("close-eliminar-contenido-modal")[0];
	var modalEliminarcontenido = document.getElementById("modal-eliminar-contenido");
	var contenido;
	// When the user clicks the button, open the modal 
	document.getElementById("eliminarContenido").addEventListener('click', function() {
		headerCliente = document.getElementById("content-name").value;
		console.log('agarre el cliente ' + headerCliente);
		headerContent = this.value;
		contenido = headerCliente;
		console.log('se cambia el estado' + headerContent);
		modalEliminarcontenido.style.display = "block";
	});

	// When the user clicks on <span> (x), close the modal
	modalEliminarcontenido.onclick = function() {
		modalEliminarcontenido.style.display = "none";

	}
	// When the user clicks on <span> (x), close the modal
	spanEliminarcontenido.onclick = function() {
		modalEliminarcontenido.style.display = "none";
	}


	document.getElementById("submit-delete-contenido").addEventListener('click', function() {

		// window.ws = new WebSocket("ws://localhost:8090");

		// window.ws = new WebSocket('ws://192.168.1.100:8090');          
		window.ws = new WebSocket('ws://<?php echo e(config('app.socket_url')); ?>');              

        window.ws.onopen = function(e) {
            ws.send(
                JSON.stringify({
                	'type': 'deleteContent',
					'nuevoContenido': `${contenido}`
                })
            )
            setTimeout(function(){
                window.location.reload(1);
            }, 2000);
        };


		// $.ajax({
		// 	type: 'POST',
		// 	url: 'http://localhost:8000/content/delete/' + contenido,
		// 	data: {
		// 		_token: "<?php echo e(csrf_token()); ?>",
		// 		'content-name': `${contenido}`
		// 	},
		// 	success: function(contenido) {

		// 		window.ws = new WebSocket("ws://localhost:8090");
		// 		window.ws.onopen = function(e) {
		// 			ws.send(
		// 				JSON.stringify({
		// 					'type': 'deleteContent',							
		// 					'nuevoContenido': `${ contenido}`
		// 				})
		// 			)
		// 		};
		// 		location.reload();

		// 	},
		// 	fail: function(msg) {
		// 		console.log(msg);
		// 	}
		// });
	});
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>