@extends('layouts.app')

@section('content')
<style>

.postsDetalle{
    margin: 0 3% 3% 0;
}
.dato_cuatro img{
    width: auto !important;
    height: auto !important;
    max-width: 600px;
    max-height: 200px;
}
.dato_tres img{
    width: auto !important;
    height: auto !important;
    max-width: 600px;
    max-height: 200px;
}
.dato_dos img{
    width: auto !important;
    height: auto !important;
    max-width: 600px;
    max-height: 200px;
}
section img{
    width: auto !important;
    height: auto !important;
    max-width: 100%;
    max-height: 100%;
}
h5{ 
    font-size: clamp(2rem,5vh,5rem);
    overflow-wrap: break-word;            
    
}
.card {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: #353535;
    font-size: 3rem;
    color: #fff;
    box-shadow: rgba(3, 8, 20, 0.1) 0px 0.15rem 0.5rem, rgba(2, 8, 20, 0.1) 0px 0.075rem 0.175rem;
    height: 100%;
    width: 99%;
    border-radius: 4px;
    transition: all 500ms;
    overflow: hidden;
    margin: 0.5%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
 }
  

@media (max-width: 360px){
    .display_cuatro_template{
        display: grid;
        grid-template-areas:
                            "r1 r1 r1 r2"
                            "r1 r1 r1 r2" 
                            "r1 r1 r1 r3"
                            "r4 r4 r4 r3";                         
        grid-template-rows: 35% ;         
        gap: 1rem;        
        grid-template-columns: repeat(1, minmax(240px, 1fr));
        height: 35pc !important;
    }

    .display_tres_template{
        display: grid;
        grid-template-areas:
                            "r1 r1 r2"
                            "r1 r1 r2" 
                            "r1 r1 r3"
                            "r1 r1 r3";                         
        grid-template-rows: 35% ;                 
        grid-template-columns: repeat(1, minmax(240px, 1fr));
        height: 35pc !important;
    }
    .display_uno_template{
        display: grid;
        grid-template-areas:
                            "r1 r1 r1"
                            "r1 r1 r1" 
                            "r1 r1 r1"
                            "r1 r1 r1";                         
        grid-template-rows: 35% ;                 
        grid-template-columns: repeat(1, minmax(240px, 1fr));
        height: 35pc !important;
    }

    .dato_tres img{
        width: 100% !important;
        height: auto !important;
        max-width: 100% !important;
        max-height: 100% !important;
    }
    .dato_dos img{
        width: 100% !important;
        height: auto !important;
        max-width: 100% !important;
        max-height: 100% !important;
    }
}

@media (min-width: 1360px){
    .display_cuatro_template{
        display: grid;
        grid-template-areas:
                            "r1 r1 r1 r2"
                            "r1 r1 r1 r2" 
                            "r1 r1 r1 r3"
                            "r4 r4 r4 r3";                         
        grid-template-rows: 35% ;         
        gap: 1rem;        
        grid-template-columns: repeat(1, minmax(240px, 1fr));
        height: 35pc !important;
    }

    .display_tres_template{
        display: grid;
        grid-template-areas:
                            "r1 r1 r2"
                            "r1 r1 r2" 
                            "r1 r1 r3"
                            "r1 r1 r3";                         
        grid-template-rows: 35% ;                 
        grid-template-columns: repeat(1, minmax(240px, 1fr));
        height: 35pc !important;
    }
    .display_uno_template{
        display: grid;
        grid-template-areas:
                            "r1 r1 r1"
                            "r1 r1 r1" 
                            "r1 r1 r1"
                            "r1 r1 r1";                         
        grid-template-rows: 35% ;                 
        grid-template-columns: repeat(1, minmax(240px, 1fr));
        height: 35pc !important;
    }

    .dato_tres img{
        width: auto !important;
        height: auto !important;
        max-width: 100% !important;
        max-height: 100% !important;
    }
    .dato_dos img{
        width: auto !important;
        height: auto !important;
        max-width: 100% !important;
        max-height: 100% !important;
    }
}

.display_cuatro_template{
    display: grid;
    grid-template-areas:
                        "r1 r1 r1 r2"
                        "r1 r1 r1 r2" 
                        "r1 r1 r1 r3"
                        "r4 r4 r4 r3";                         
    grid-template-rows: 35% ;         
    gap: 1rem;        
    grid-template-columns: repeat(1, minmax(240px, 1fr));
    height: 55pc;
}

.display_tres_template{
    display: grid;
    grid-template-areas:
                        "r1 r1 r2"
                        "r1 r1 r2" 
                        "r1 r1 r3"
                        "r1 r1 r3";                         
    grid-template-rows: 35% ;                 
    grid-template-columns: repeat(1, minmax(240px, 1fr));
    height: 55pc;
}
.display_uno_template{
    display: grid;
    grid-template-areas:
                        "r1 r1 r1"
                        "r1 r1 r1" 
                        "r1 r1 r1"
                        "r1 r1 r1";                         
    grid-template-rows: 35% ;                 
    grid-template-columns: repeat(1, minmax(240px, 1fr));
    height: 55pc;
}
button {
        transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
        background-color: transparent;
        border-radius: 0.375em;
        border: 0;
        box-shadow: inset 0 0 0 2px #f56a6a;
        color: #f56a6a !important;
        cursor: pointer;
        display: inline-block;
        font-family: "Roboto Slab", serif;
        font-size: 0.8em;
        font-weight: 700;
        height: 3.5em;
        letter-spacing: 0.075em;
        line-height: 3.5em;
        padding: 0 2.25em;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        white-space: nowrap;
		position: absolute;
		left: 2px;
		bottom: 3px;
    }
.dato_uno{
    grid-area:r1
}
.dato_dos{
    grid-area:r2
}
.dato_tres{
    grid-area:r3
}
.dato_cuatro{
    grid-area:r4
}

.right_text {
  position: relative;
  z-index: 1;
  font-family: Raleway;
  font-size: large;
  
  justify-self: center;
  align-self: center;
}
.basic-grid {
    display: grid;
    gap: 1rem;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
}
</style>

<div id="wrapper">

    <!-- Main -->
    <div id="main">
        <div class="inner">
            <!-- Header -->
            <header id="header">
                <a href="/content/getById/{{$detalle_contenido['nombre_region']}}" class="logo"><strong>Detalle</strong></a>
            </header>
            <!-- Section -->
            <section>
                <header class="major">
                    <h2>Region {{$detalle_contenido['nombre_region']}}</h2>
                </header>
                <div class="postsDetalle">
                        @if($region['region_size'] == "1")
                        <div class ="display_uno_template">
                            <section class ="card dato_uno"> 
                            @if( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'imag'))
                            <a class="image"><img class="card dato_uno" src="{{Storage::disk('s3')->url( $region['archivoUnoUbicacion'] )}}"></a>
                            @elseif( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'texto'))
                            <a href="#" class="card dato_uno">
                                <h5>{{$region['archivoUnoTexto']}}</h5>
                            </a>
                            @else
                                @if( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'video'))
                                <a class="image">
                                    <video>
                                        <source class="card dato_uno" src="{{Storage::disk('s3')->url( $region['archivoUnoUbicacion'] )}}"> >
                                    </video>
                                </a>
                                @else
                                <a class="image">
                                    <iframe class="card dato_uno" width="400" height="200" src="{{$region['archivoUnoUrl']}}">
                                        </iframe>
                                    </a>
                                @endif
                            @endif
                            </section>
                        </div>
                        @endif
                        @if($region['region_size'] == "3")
                        <div class ="display_tres_template">
                            <section class ="card dato_uno"> 
                                @if( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'imag'))
                                <a href="" class="card dato_uno"><img class="card dato_uno" src="{{Storage::disk('s3')->url( $region['archivoUnoUbicacion'] )}}" width="400" height="10"></a>
                                @elseif( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'texto'))
                                <a href=""class="card dato_uno">
                                    <h5>{{$region['archivoUnoTexto']}}</h5>
                                </a>
                                @else
                                @if( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'video'))
                                <a href=""class="card dato_uno">
                                    <video>
                                        <source class="card dato_uno" src="{{Storage::disk('s3')->url( $region['archivoUnoUbicacion'] )}}"> >
                                    </video>
                                </a>
                                @else
                                <a href=""class="card dato_uno">
                                    <iframe class="card dato_uno" src="{{$region['archivoUnoUrl']}}">
                                    </iframe>
                                </a>
                                @endif
                                @endif
                            </section>
                            <section class ="card dato_dos"> 
                                @if( Illuminate\Support\Str::contains($region['archivoDosTipo'], 'imag'))
                                <a href="" class="card dato_dos"><img class="card dato_dos" src="{{Storage::disk('s3')->url( $region['archivoDosUbicacion'] )}}" width="400" height="10"></a>
                                @elseif( Illuminate\Support\Str::contains($region['archivoDosTipo'], 'texto'))
                                <a href="" class="card dato_dos">
                                    <h5>{{$region['archivoDosTexto']}}</h5>
                                </a>
                                @else
                                @if( Illuminate\Support\Str::contains($region['archivoDosTipo'], 'video'))
                                <a href="" class="card dato_dos">
                                    <video>
                                        <source class="card dato_dos" src="{{Storage::disk('s3')->url( $region['archivoDosUbicacion'] )}}"> >
                                    </video>
                                </a>
                                @else
                                <a href="" class="card dato_dos">
                                    <iframe class="card dato_dos" src="{{$region['archivoDosUrl']}}">
                                    </iframe>
                                </a>
                                @endif
                                @endif
                            </section>
                            <section class ="card dato_tres"> 
                                @if( Illuminate\Support\Str::contains($region['archivoTresTipo'], 'imag'))
                                <a href="" class="card dato_tres"><img class="card dato_tres" src="{{Storage::disk('s3')->url( $region['archivoTresUbicacion'] )}}" width="200" height="10"></a>
                                @elseif( Illuminate\Support\Str::contains($region['archivoTresTipo'], 'texto'))
                                <a href="" class="card dato_tres">
                                    <h5>{{$region['archivoTresTexto']}}</h5>
                                </a>
                                @else
                                @if( Illuminate\Support\Str::contains($region['archivoTresTipo'], 'video'))
                                <a href="" class="card dato_tres">
                                    <video>
                                        <source class="card dato_tres" src="{{Storage::disk('s3')->url( $region['archivoTresUbicacion'] )}}"> >
                                    </video>
                                </a>
                                @else
                                <a href="" class="card dato_tres">
                                    <iframe class="card dato_tres" src="{{$region['archivoTresUrl']}}">
                                    </iframe>
                                </a>
                                @endif
                                @endif
                            </section>
                        </div>
                        @endif
                        @if($region['region_size'] == "4")

                        <div class ="display_cuatro_template">
                            <section class ="card dato_uno"> 
                                @if( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'imag'))
                                <a href="" class="card dato_uno"><img class="card dato_uno" src="{{Storage::disk('s3')->url( $region['archivoUnoUbicacion'] )}}" width="400" height="10"></a>
                                @elseif( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'texto'))
                                <a>
                                    <h5>{{$region['archivoUnoTexto']}}</h5>
                                </a>
                                @else
                                @if( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'video'))
                                <a href="" class="card dato_uno">
                                    <video>
                                        <source class="card dato_uno" src="{{Storage::disk('s3')->url( $region['archivoUnoUbicacion'] )}}"> >
                                    </video>
                                </a>
                                @else
                                <a href="" class="card dato_uno">
                                    <iframe class="card dato_uno" src="{{$region['archivoUnoUrl']}}">
                                    </iframe>
                                </a>
                                @endif
                                @endif
                            </section>
                            <section class ="card dato_dos"> 
                                @if( Illuminate\Support\Str::contains($region['archivoDosTipo'], 'imag'))
                                <a href="" class="card dato_dos"><img class="card dato_dos" src="{{Storage::disk('s3')->url( $region['archivoDosUbicacion'] )}}" width="400" height="10"></a>
                                @elseif( Illuminate\Support\Str::contains($region['archivoDosTipo'], 'texto'))
                                <a href="" class="card dato_dos">
                                    <h5>{{$region['archivoDosTexto']}}</h5>
                                </a>
                                @else
                                    @if( Illuminate\Support\Str::contains($region['archivoDosTipo'], 'video'))
                                    <a href="" class="card dato_dos">
                                        <video>
                                            <source class="card dato_dos" src="{{Storage::disk('s3')->url( $region['archivoDosUbicacion'] )}}"> >
                                        </video>
                                    </a>
                                    @else
                                    <a href="" class="card dato_dos">
                                        <iframe class="card dato_dos" src="{{$region['archivoDosUrl']}}">
                                        </iframe>
                                    </a>
                                    @endif
                                @endif

                            </section>
                            <section class ="card dato_tres"> 
                                @if( Illuminate\Support\Str::contains($region['archivoTresTipo'], 'imag'))
                                <a href="" class="card dato_tres"><img class="card dato_tres" src="{{Storage::disk('s3')->url( $region['archivoTresUbicacion'] )}}" width="200" height="10"></a>
                                @elseif( Illuminate\Support\Str::contains($region['archivoTresTipo'], 'texto'))
                                <a href="" class="card dato_tres">
                                    <h5>{{$region['archivoTresTexto']}}</h5>
                                </a>
                                @else
                                    @if( Illuminate\Support\Str::contains($region['archivoTresTipo'], 'video'))
                                    <a href="" class="card dato_tres">
                                        <video>
                                            <source class="card dato_tres" src="{{Storage::disk('s3')->url( $region['archivoTresUbicacion'] )}}"> >
                                        </video>
                                    </a>
                                    @else
                                    <a href="" class="card dato_tres">
                                        <iframe class="card dato_tres" src="{{$region['archivoTresUrl']}}">
                                        </iframe>
                                    </a>
                                    @endif
                                @endif
                            </section>
                            <section class ="card dato_cuatro"> 
                                @if( Illuminate\Support\Str::contains($region['archivoCuatroTipo'], 'imag'))
                                <a href="" class="card dato_cuatro"><img class="card dato_cuatro" src="{{Storage::disk('s3')->url( $region['archivoCuatroUbicacion'] )}}" width="200" height="10"></a>
                                @elseif( Illuminate\Support\Str::contains($region['archivoCuatroTipo'], 'texto'))
                                <a href="" class="card dato_cuatro">
                                    <h5>{{$region['archivoCuatroTexto']}}</h5>
                                </a>
                                @else
                                @if( Illuminate\Support\Str::contains($region['archivoCuatroTipo'], 'video'))
                                <a href="" class="card dato_cuatro">
                                    <video>
                                        <source class="card dato_cuatro" src="{{Storage::disk('s3')->url( $region['archivoCuatroUbicacion'] )}}"> >
                                    </video>
                                </a>
                                @else
                                <a href="" class="card dato_cuatro">
                                    <iframe class="card dato_cuatro" src="{{$region['archivoCuatroUrl']}}">
                                    </iframe>
                                </a>
                                @endif
                                @endif

                            </section>
                        </div>
                </div>
                        @endif

                        <!-- <a href="#" class="image"><img src="images/pic01.jpg" alt="" /></a> -->
                    </div>                    
                    <article>
                        <h2>Listado de dispositivos</h2>
                        <hr />
                        @foreach ($detalle_contenido['data'] as $display)
                        <!-- <p>Contenido Selecionado: {{$display['name']}} </p> -->
                        <p>CLAVE : {{$display['adress']}} </p>
                        <p>Estado: {{$display['status']}}</p>
                        <!-- <button>Modificar</button> -->
                        <!-- @if($display['status']=="HABILITADO")
                                <button>Habilitar</button>
                            @else
                                <button>INHABILITAR</button>
                            @endif -->
                        @endforeach
                    </article>
            </section>
        </div>
    </div>

    <!-- Sidebar -->

    <!-- Sidebar -->
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



@if($messageType == 'modificacion')
<script>
    // const ws = new WebSocket("ws://localhost:8090");

    // const ws = new WebSocket('ws://192.168.1.100:8090');           
    const ws = new WebSocket('ws://{{ config('
        app.socket_url ')}}');
    ws.onopen = function(e) {
        console.log('Connected a sidi');

        function success(position) {
            console.log('me conecte mando una actualizacion');

            @if($messageType == 'modificacion')
            ws.send(
                JSON.stringify({
                    'type': 'incremental',
                    'region_id': "{{$detalle_contenido['hash_region_key']}}",
                    'state': 'change'
                }));
            @endif
        }

    }

    function error() {
        status.textContent = 'Unable to retrieve your location';
    }

    var isDataSend = false;


    ws.onmessage = function(e) {

        if (!isDataSend) {
            @if($messageType == 'modificacion')
            console.log('llego algo, mando una modificacion');
            if (!isDataSend) {
                ws.send(
                    JSON.stringify({
                        'type': 'incremental',
                        'region_id': "{{$detalle_contenido['hash_region_key']}}",
                        'state': 'change'
                    }));
            }
            @endif
        }
        isDataSend = true;

    }
</script>
@endif

@endsection