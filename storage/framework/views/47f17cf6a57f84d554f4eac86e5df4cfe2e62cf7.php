<?php $__env->startSection('content'); ?>

<!-- Wrapper -->
<div id="wrapper">
    <!-- Main -->
    <div id="main">
        <div class="inner">
            <!-- Header -->
            <header id="header">
                <a href="index.html" class="logo"><strong>Listar dispositivos</strong></a>
            </header>
            <!-- Form -->
            <h3></h3>
            <!-- Header -->
            <header id="header">
                <h3>Listado de dispositivos</h3>
            </header>
            </br>

            <!-- Form -->
            <table style="width:100%">

                <tr>
                    <th>Nombre</th>
                    <th>Nombre del contenido </th>
                    <th>Estado</th>
                    <th>Ultima Conexion</th>
                    <th>Accion</th>
                </tr>
                <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indexKey => $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="cliente"><span> <?php echo e($cliente['name']); ?></span></td>
                    <td>
                        <select name="nombre-contenidos" class="nombre-contenidos">
                            <?php $__currentLoopData = $cliente['total_nombreContenido']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indexKey => $nombreContenidos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($cliente['nombre_contenido'] == $nombreContenidos): ?>{
                            <option value="<?php echo e($nombreContenidos); ?>" selected="selected"> <?php echo e($nombreContenidos); ?></option>
                            <?php else: ?>
                            <option value="<?php echo e($nombreContenidos); ?>"> <?php echo e($nombreContenidos); ?></option>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td>

                        <select name="estados-contenidos" class="estados-contenidos" data-target="#cambioDeContenido">
                            <?php $__currentLoopData = $cliente['total_estados']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indexKey => $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if( $cliente['estado'] == $estado): ?>{
                            <option value=<?php echo e($estado); ?> selected="selected"> <?php echo e($estado); ?></option>
                            <?php else: ?>
                            <option value=<?php echo e($estado); ?>> <?php echo e($estado); ?></option>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>


                    </td>
                    <td><?php echo e($cliente['ultima_conexion']); ?></td>
                    <td><button value=<?php echo e($nombreContenidos); ?> class="eliminar-contenido">Eliminar</button></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
            <!-- Section -->
            <section>

            </section>
        </div>
    </div>
    <!-- The Modal -->
    <div id="modalEstado" class="modal">
        <!-- Modal content estado -->
        <div class="modal-content">
            <span class="close_estado_modal">&times;</span>
            <p>??Seguro que quiere cambiar el estado del dispositivo?</p>
            <button id="submitChangeState">Si, muy seguro</button>
            <button  class="close_estado_modal">No, cambie de opinion</button>
        </div>
    </div>

    <div id="modalContenido" class="modal">
        <!-- Modal content estado -->
        <div class="modal-content">
            <span class="close_contenido_modal">&times;</span>
            <p>??Seguro quiere mover el dispositivo a otra transmision?</p>
            <button id="submitChangeContent">Si, muy seguro</button>
            <button  class="close_contenido_modal">No, cambie de opinion</button>
        </div>
    </div>

    <div id="modalEliminarContenido" class="modal">
        <!-- Modal content estado -->
        <div class="modal-content">
            <span class="close_eliminar_contenido_modal">&times;</span>
            <p>??Seguro quiere Eliminar el dispositivo ?</p>
            <button id="submitDeleteContent">Si, muy seguro</button>
            <button  class="close_eliminar_contenido_modal">No, cambie de opinion</button>
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

                    <?php if(Auth::user()->id_estado != 2): ?>

                    <?php if(Auth::user()->id_rol == 2): ?>
                    <li><a href="/users">Administracion de Usuarios</a></li>
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

<script>
    // Get the modal
    var modalEstado = document.getElementById("modalEstado");
    var modaContenido = document.getElementById("modalContenido");

    var modalEliminarContenido = document.getElementById("modalEliminarContenido");

    // this.parentNode.parentNode
    // Get the <span> element that closes the modal
    var spanEstado = document.getElementsByClassName("close_estado_modal");
    var spanContenido = document.getElementsByClassName("close_contenido_modal");
    var spanEliminarContenido = document.getElementsByClassName("close_eliminar_contenido_modal");



    var headerCliente
    var headerContent
    // When the user clicks the button, open the modal 
    var elsNomCont = document.getElementsByClassName("nombre-contenidos");

    Array.prototype.forEach.call(elsNomCont, function(el) { 
        el.addEventListener('change', function() {
            headerCliente = this.parentNode.parentNode.getElementsByClassName("cliente")[0].innerText;
            headerContent = this.value;
            console.log('agarre el cliente ' + headerCliente);
            modaContenido.style.display = "block";
        });
    });

    // When the user clicks the button, open the modal 
    var elsEstCont = document.getElementsByClassName("estados-contenidos");

    Array.prototype.forEach.call(elsEstCont, function(el) {
        el.addEventListener('change', function() {
            headerCliente = this.parentNode.parentNode.getElementsByClassName("cliente")[0].innerText;
            console.log('agarre el cliente ' + headerCliente);
            headerContent = this.value;
            console.log('se cambia el estado' + headerContent);
            modalEstado.style.display = "block";
        });
    });
        
    // When the user clicks the button, open the modal 
    var elsDelCont = document.getElementsByClassName("eliminar-contenido");

    Array.prototype.forEach.call(elsDelCont, function(el) { 
            el.addEventListener('click', function() {
            headerCliente = this.parentNode.parentNode.getElementsByClassName("cliente")[0].innerText;
            console.log('agarre el cliente ' + headerCliente);
            headerContent = this.value;
            console.log('se va a eliminar el dispositivo' + headerContent);
            modalEliminarContenido.style.display = "block";
        });
    });

    // When the user clicks on <span> (x), close the modal
    Array.prototype.forEach.call(spanEstado, function(el) { 
        el.addEventListener('click', function(){
            modalEstado.style.display = "none";
        })
    });
    // .onclick = function() {
    // }

    // When the user clicks on <span> (x), close the modal
    // spanContenido.onclick = function() {
    //     modaContenido.style.display = "none";

    // }
    // When the user clicks on <span> (x), close the modal
    Array.prototype.forEach.call(spanContenido, function(el) { 
        el.addEventListener('click', function(){
            modaContenido.style.display = "none";

        })
    });
    // When the user clicks on <span> (x), close the modal
    // spanEliminarContenido.onclick = function() {
    //     modalEliminarContenido.style.display = "none";

    // }
    Array.prototype.forEach.call(spanEliminarContenido, function(el) { 
        el.addEventListener('click', function(){
            modalEliminarContenido.style.display = "none";

        })
    });
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modalEstado) {
            modalEstado.style.display = "none";
        }
        if (event.target == modaContenido) {
            modaContenido.style.display = "none";
        }
        if (event.target == modalEliminarContenido) {
            modalEliminarContenido.style.display = "none";
        }
    }

    document.getElementById("submitDeleteContent").addEventListener('click', function() {
        // var selectedValue = document.getElementById('nombre-contenidos').value;

        // $.ajax({
        //     type: 'POST',
        //     url: 'http://localhost:8000/api/display/delete',
        //     data: {
        //         _token: "<?php echo e(csrf_token()); ?>",
        //         'cliente': `${headerCliente}`
        //     },
        //     success: function(msg) {          
        //         };

        //     }
        // });

        // window.ws = new WebSocket('ws://192.168.1.100:8090');     
        window.ws = new WebSocket('ws://<?php echo e(config('app.socket_url')); ?>');             
        window.ws.onopen = function(e) {
            ws.send(
                JSON.stringify({
                    'type': 'deleteDisplay',
                    'cliente': `${headerCliente}`,
                    'nuevoContenido': `${ headerContent}`
                })
            )
            setTimeout(function(){
                window.location.reload(1);
            }, 2000);
        };
    });

    document.getElementById("submitChangeState").addEventListener('click', function() {
        // var selectedValue = document.getElementById('nombre-contenidos').value;
        // window.ws = new WebSocket("ws://localhost:8090");
        // window.ws = new WebSocket('ws://192.168.1.100:8090');                 
        window.ws = new WebSocket('ws://<?php echo e(config('app.socket_url')); ?>'); 

        window.ws.onopen = function(e) {
            console.log('Connected to sidi');
            //en el momento que vuelve el "conectado" desde el back end se envia el pedido para obtener el contenido que se clickeo anteriormente                  
            ws.send(
                JSON.stringify({
                    'type': 'changeStateDisplay',
                    'cliente': `${headerCliente}`,
                    'nuevoContenido': `${ headerContent}`
                })
            );
            setTimeout(function(){
                window.location.reload(1);
            }, 2000);

        }

    })


    document.getElementById("submitChangeContent").addEventListener('click', function() {
        // var selectedValue = document.getElementById('nombre-contenidos').value;
        // window.ws = new WebSocket('ws://192.168.1.100:8090');                 
        window.ws = new WebSocket('ws://<?php echo e(config('app.socket_url')); ?>'); 
        window.ws.onopen = function(e) {
            ws.send(
                JSON.stringify({
                    'type': 'updateDisplay',
                    'cliente': `${headerCliente}`,
                    'nuevoContenido': `${ headerContent}`
                })
            );
            setTimeout(function(){
                window.location.reload(1);
            }, 2000);
        }

    })
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>