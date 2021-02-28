@extends('layouts.app')

@section('content')

<!-- Wrapper -->
<div id="wrapper">
    <!-- Main -->
    <div id="main">
        <div class="inner">
            <!-- Header -->
            <header id="header">
                <a href="/display/getAll" class="logo"><strong>Listar dispositivos</strong></a>
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
                    <th>ID conexion</th>
                    <th>Nombre dispositivo</th>
                    <th>Nombre del contenido </th>
                    <th>Estado</th>
                    <th>Ultima Conexion</th>
                    <th>Accion</th>
                </tr>
                @foreach ($clientes as $indexKey => $cliente)
                <tr>
                    <td class="idConnecion"><span> {{ $cliente['name'] }}</span></td>
                    <td class="cliente">
                    @if( Illuminate\Support\Str::contains($cliente['nombre_dispositivo'], "nombre-sin-asignar"))
                        <input type="text" class="nombre-dispositivos" placeholder="sin nombre asociado" ></input>                                                                        
                        <input type="hidden" class="nombre-dispositivos-anterior" name="custId" value="{{$cliente['nombre_dispositivo']}}">
                    @else
                        <input type="text" class="nombre-dispositivos" placeholder="sin nombre asociado" value="{{$cliente['nombre_dispositivo']}}"></input>                                                                        
                        <input type="hidden" class="nombre-dispositivos-anterior" name="custId" value="{{$cliente['nombre_dispositivo']}}">                    
                    @endif
                    </td>
                    <td>
                        <select name="nombre-contenidos" class="nombre-contenidos">
                            @foreach ($cliente['total_nombreContenido'] as $indexKey => $nombreContenidos)
                            @if($cliente['nombre_contenido'] == $nombreContenidos){
                            <option value="{{$nombreContenidos}}" selected="selected"> {{$nombreContenidos}}</option>
                            @else
                            <option value="{{$nombreContenidos}}"> {{$nombreContenidos}}</option>
                            @endif
                            @endforeach
                        </select>
                    </td>
                    <td>

                        <select name="estados-contenidos" class="estados-contenidos" data-target="#cambioDeContenido">
                            @foreach ($cliente['total_estados'] as $indexKey => $estado)
                            @if( $cliente['estado'] == $estado){
                            <option value={{$estado}} selected="selected"> {{$estado}}</option>
                            @else
                            <option value={{$estado}}> {{$estado}}</option>
                            @endif
                            @endforeach
                        </select>


                    </td>
                    <td>{{ $cliente['ultima_conexion']  }}</td>
                    <td><button value={{$nombreContenidos}} class="eliminar-contenido">Eliminar</button></td>
                </tr>
                @endforeach
            </table>
            <!-- Section -->
            <section>

            </section>
        </div>
    </div>


    <!-- The Modal -->
    <div id="modalNombre" class="modal">
        <!-- Modal content nombre -->
        <div class="modal-content">
            <span class="close_nombre_modal">&times;</span>
            <p style="display:none" id="errorMessageModalNombre"></p>
            <p>¿Seguro que quiere cambiar el nombre del dispositivo?</p>
            <button id="submitChangeNombre">Si, muy seguro</button>
            <button  class="close_nombre_modal">No, cambie de opinion</button>
        </div>
    </div>


    <!-- The Modal -->
    <div id="modalEstado" class="modal">
        <!-- Modal content estado -->
        <div class="modal-content">
            <span class="close_estado_modal">&times;</span>
            <p>¿Seguro que quiere cambiar el estado del dispositivo?</p>
            <button id="submitChangeState">Si, muy seguro</button>
            <button  class="close_estado_modal">No, cambie de opinion</button>
        </div>
    </div>

    <div id="modalContenido" class="modal">
        <!-- Modal content estado -->
        <div class="modal-content">
            <span class="close_contenido_modal">&times;</span>
            <p>¿Seguro quiere mover el dispositivo a otra transmision?</p>
            <button id="submitChangeContent">Si, muy seguro</button>
            <button  class="close_contenido_modal">No, cambie de opinion</button>
        </div>
    </div>

    <div id="modalEliminarContenido" class="modal">
        <!-- Modal content estado -->
        <div class="modal-content">
            <span class="close_eliminar_contenido_modal">&times;</span>
            <span class="close_eliminar_contenido_modal">&times;</span>
            <p>¿Seguro quiere Eliminar el dispositivo ?</p>
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
    var modalNombre = document.getElementById("modalNombre");
    var modaContenido = document.getElementById("modalContenido");

    var modalEliminarContenido = document.getElementById("modalEliminarContenido");

    // this.parentNode.parentNode
    // Get the <span> element that closes the modal
    var spanNombre = document.getElementsByClassName("close_nombre_modal");
    var spanEstado = document.getElementsByClassName("close_estado_modal");
    var spanContenido = document.getElementsByClassName("close_contenido_modal");
    var spanEliminarContenido = document.getElementsByClassName("close_eliminar_contenido_modal");



    var headerCliente
    var headerContent
    var displayNewName
    var displayOriginalName


    var elsNomDisp = document.getElementsByClassName("nombre-dispositivos");

    Array.prototype.forEach.call(elsNomDisp, function(el) { 
        el.addEventListener('keypress', function(eventKey) {
            if (eventKey.key === 'Enter') {
                displayNewName = this.parentNode.parentNode.getElementsByClassName("cliente")[0].children[0].value
                displayOriginalName = this.parentNode.parentNode.getElementsByClassName("cliente")[0].children[1].value;            
                modalNombre.style.display = "block";
            }
        });
    });

    // When the user clicks the button, open the modal 
    var elsNomCont = document.getElementsByClassName("nombre-contenidos");

    Array.prototype.forEach.call(elsNomCont, function(el) { 
        el.addEventListener('change', function() {
            headerCliente = this.parentNode.parentNode.getElementsByClassName("cliente")[0].children[0].value
            if(headerCliente ==""){
                headerCliente = this.parentNode.parentNode.getElementsByClassName("cliente")[0].children[1].value
            }
            headerContent = this.value;            
            console.log('agarre el cliente ' + headerCliente);
            modaContenido.style.display = "block";
        });
    });

    // When the user clicks the button, open the modal 
    var elsEstCont = document.getElementsByClassName("estados-contenidos");

    Array.prototype.forEach.call(elsEstCont, function(el) {
        el.addEventListener('change', function() {
            headerCliente = this.parentNode.parentNode.getElementsByClassName("cliente")[0].children[0].value
            if(headerCliente ==""){
                headerCliente = this.parentNode.parentNode.getElementsByClassName("cliente")[0].children[1].value
            }
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
            headerCliente = this.parentNode.parentNode.getElementsByClassName("cliente")[0].children[0].value
            if(headerCliente ==""){
                headerCliente = this.parentNode.parentNode.getElementsByClassName("cliente")[0].children[1].value
            }
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
            window.location.reload(1);
        })
    });
    Array.prototype.forEach.call(spanNombre, function(el) { 
        el.addEventListener('click', function(){
            modalNombre.style.display = "none";
            document.getElementById("errorMessageModalNombre").style.display = "none"
            window.location.reload(1);
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
            window.location.reload(1);
        })
    });
    // When the user clicks on <span> (x), close the modal
    // spanEliminarContenido.onclick = function() {
    //     modalEliminarContenido.style.display = "none";

    // }
    Array.prototype.forEach.call(spanEliminarContenido, function(el) { 
        el.addEventListener('click', function(){
            modalEliminarContenido.style.display = "none";
            window.location.reload(1);
        })
    });
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modalEstado) {
            modalEstado.style.display = "none";
            window.location.reload(1);
        }
        if (event.target == modaContenido) {
            modaContenido.style.display = "none";
            window.location.reload(1);
        }
        if (event.target == modalEliminarContenido) {
            modalEliminarContenido.style.display = "none";
            window.location.reload(1);
        }
        if (event.target == modalNombre) {
            modalNombre.style.display = "none";
            document.getElementById("errorMessageModalNombre").style.display = "none"
            window.location.reload(1);
        }
    }

    document.getElementById("submitDeleteContent").addEventListener('click', function() {
        // var selectedValue = document.getElementById('nombre-contenidos').value;

        // $.ajax({
        //     type: 'POST',
        //     url: 'http://localhost:8000/api/display/delete',
        //     data: {
        //         _token: "{{ csrf_token() }}",
        //         'cliente': `${headerCliente}`
        //     },
        //     success: function(msg) {          
        //         };

        //     }
        // });

        // window.ws = new WebSocket('ws://192.168.1.100:8090');     
        window.ws = new WebSocket('ws://{{ config('app.socket_url')}}');             
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

    
    document.getElementById("submitChangeNombre").addEventListener('click', function() {
        console.log("nuevo nombre dispositivo " + displayNewName);
        console.log("nuevo viejo dispositivo " + displayOriginalName);


        $.ajax({
             type: 'POST',
             url: "{{ config('app.url')}}/api/display/updateName",
             data: {
                 _token: "{{ csrf_token() }}",
                 'displayNewName': `${displayNewName}`,
                 'displayOriginalName': `${ displayOriginalName}`
             },
            success: function(msg) {       
                if(msg.status == "ok"){                
                    
                    window.ws = new WebSocket('ws://{{ config('app.socket_url')}}'); 
                    window.ws.onopen = function(e) {
                    console.log('Connected to sidi');
                    //en el momento que vuelve el "conectado" desde el back end se envia el pedido para obtener el contenido que se clickeo anteriormente                  
                    ws.send(
                        JSON.stringify({
                            'type': 'notifyChangeDisplayName',
                            'displayNewName': `${displayNewName}`,
                            
                        })
                    );
                    setTimeout(function(){
                        window.location.reload(1);
                    }, 2000);
                    }
                }else{
                        document.getElementById("errorMessageModalNombre").value= msg.desc;
                        document.getElementById("errorMessageModalNombre").style.display = "block";
                        document.getElementById("errorMessageModalNombre").innerHTML = msg.desc;                    
                }

            }

        });
    });

    document.getElementById("submitChangeState").addEventListener('click', function() {
        // var selectedValue = document.getElementById('nombre-contenidos').value;
        // window.ws = new WebSocket("ws://localhost:8090");
        // window.ws = new WebSocket('ws://192.168.1.100:8090');                 
        window.ws = new WebSocket('ws://{{ config('app.socket_url')}}'); 

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
        window.ws = new WebSocket('ws://{{ config('app.socket_url')}}'); 
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

@endsection