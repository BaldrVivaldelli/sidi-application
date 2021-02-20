@extends('layouts.app')

@section('content')
<!-- Wrapper -->
<div id="wrapper">
    <!-- Main -->
    <div id="main">
        <div class="inner">
            <!-- Header -->
            <header id="header">
                <a href="index.html" class="logo"><strong>Agregar Dispositivo</strong></a>
            </header>
            <!-- Form -->
            <h3></h3>
            <form method="post" action="/display/add">
                {{ csrf_field() }}
                <div class="row gtr-uniform">
                    <div class="col-6 col-12-xsmall">
                        <input type="text" name="display-name" id="display-name" value="" placeholder="Nombre Dispositivo" />
                    </div>
                    <div class="col-3 col-12-xsmall">
                        <input type="radio" id="habilitado" name="habilitado">
                        <label for="habilitado">Habilitado</label>
                    </div>
                    <div class="col-3 col-12-xsmall">
                        <input type="radio" id="inhabilitado" name="habilitado">
                        <label for="inhabilitado">Inhabilitado </label>
                    </div>
                    <!-- Break -->
                    <div class="col-12">
                        <select name="region-category" id="region-category">
                            @foreach ($regions as $indexKey => $region) {
                            <option value={{$region['name'] }}>{{$region['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Break -->

                    <div class="col-12">
                        <ul class="actions">
                            <li><input type="submit" value="Crear" class="primary" /></li>
                            <li><input type="reset" value="Borrar valores" /></li>
                        </ul>
                    </div>
                </div>
            </form>
            <!-- Section -->
            <section>

            </section>
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

    <script>
        function obtenerLocacion() {
            let url = "https://ipapi.co/json/";
            const response = fetch(url).then(resp => resp.json()).then(data => {
                document.getElementById('display-detail').value = "{" + 'latitud: "' + data.latitude + '", longitud : "' + data.longitude + '"}"'
                document.getElementById('display-mac-adress').value = data.ip

                console.log(data)
            });
        }
        document.getElementById('my-location').addEventListener('click', obtenerLocacion);
    </script>

    @endsection