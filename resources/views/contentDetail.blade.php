@extends('layouts.app')

@section('content')
<style>

h5{
color: #9fa3a6;
text-transform: uppercase;
text-align: justify;
vertical-align: middle;
text-overflow: ellipsis;
overflow: hidden;
}
.postsDetalle article{
	width: 90%;
	
}
.postsDetalle article div{
	height: 50em;
	
}
.postsDetalle article a img{
	width: auto;
	
}


.region_tres_archivo_uno{
	top: 0%;
    width: 70%;
    height: 40em !important;
    margin: 0%;
    display: inline-block;
    padding: 0;
    border-style: solid;
    border-width: 4px

}
.region_tres_archivo_uno a{
	margin: 0;
	max-height: 40em;

}

.region_tres_archivo_uno a img{
	width: auto;
	max-height: 40em;
	height:auto;
	margin: 20% 0;
}

.region_tres_archivo_uno a video{
	max-height: 40em;
	width: 100%;
	margin: 20% 0;

}
.region_tres_archivo_uno a iframe{
	width: 100%;
    height: 40em;
	
}








.region_tres_archivo_dos{
left: 70%;
    width: 30%;
    height: 20em !important;
    position: absolute;
    top: 0.000000000000001%;
    float: right;
    border-style: solid;
    border-width: 4px
}

.region_tres_archivo_dos a{
	margin: 0;
	height: 20em;

}
.region_tres_archivo_dos a img{
	width: auto;
	max-height: 20em;
	height:auto;
	margin: 20% 0;
}
.region_tres_archivo_dos a video{
	max-height: 20em;
	width: 100%;
	margin: 20% 0;

}
.region_tres_archivo_dos a iframe{
	width: 100%;
    height: 20em;
	
}






.region_tres_archivo_tres{
left: 70%;
    width: 30%;
    height: 20em !important;
    position: absolute;
    top: 40%;
    float: right;
    border-style: solid;
    border-width: 4px
}
.region_tres_archivo_tres a{
	margin: 0;
	height: 20em;

}

.region_tres_archivo_tres a img{
	width: auto;
	height: auto;
	max-height: 20em;
	margin: 20% 0;
}

.region_tres_archivo_tres a video{
	max-height: 20em;
	width: 100%;
	margin: 20% 0;

}
.region_tres_archivo_tres a iframe{
	width: 100%;
    height: 20em;
	
}



.region_cuatro_archivo_uno{
	top: 0%;
    width: 60%;
    height: 40em;
	max-height: 40em !important;
    margin: 0%;
    display: inline-block;
    padding: 0;
    border-style: solid;
    border-width: 4px

}

.region_cuatro_archivo_uno a{
	margin: 0;
	height: 40em;
}

.region_cuatro_archivo_uno a img{
	max-height: 40em;
	width: auto;
    height: auto;
	margin: 20% 0;
}

.region_cuatro_archivo_uno a video{
	max-height: 40em;
	

}
.region_cuatro_archivo_uno a iframe{
	width: 100%;
    height: 40em;
	
}


.region_cuatro_archivo_dos{
	left: 60%;
    width: 30%;
    height: 25em !important;
	max-height: 25em;
    position: absolute;
    top: 0.000000000000001%;
    float: right;
    border-style: solid;
    border-width: 4px
}

.region_cuatro_archivo_dos a{
	margin: 0;
	 height: 25em;

}

.region_cuatro_archivo_dos a img{
	
	max-height: 25em;
	width: auto;
    height: auto;
	margin: 20% 0;
}

.region_cuatro_archivo_dos a video{
	max-height: 25em;
	width: 100%;
	margin: 20% 0;

}
.region_cuatro_archivo_dos a iframe{
	width: 100%;
    height: 25em;
	
}


.region_cuatro_archivo_tres{
left: 60%;
    width: 30%;
    height: 25em !important;
    position: absolute;
    top: 50%;
    float: right;
    border-style: solid;
    border-width: 4px
}
.region_cuatro_archivo_tres a img{
	margin: 20% 0;
	max-height: 25em;
	width: auto;
    height: auto;

}
.region_cuatro_archivo_tres a{
	margin: 0;
	max-height: 25em;
}
.region_cuatro_archivo_tres a video{
	max-height: 25em;
	width: 100%;
	margin: 20% 0;

}
.region_cuatro_archivo_tres a iframe{
	width: 100%;
    height: 25em;
	
}



.region_cuatro_archivo_cuatro{
    width: 60%;
    height: 10em !important;
    position: absolute;
    top: 80%;
    float: right;
    border-style: solid;
    border-width: 4px
}

.region_cuatro_archivo_cuatro a img{
	width: auto;
	max-height: 10em;
	margin: 20% 0;

}
.region_cuatro_archivo_cuatro a{
	margin: 0;

}
.region_cuatro_archivo_cuatro a video{
	max-height: 10em;

}
.region_cuatro_archivo_cuatro a iframe{
	width: 100%;
    height: 10em;
	
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


                    <article>

                        @if($region['region_size'] == "1")
                            @if( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'imag'))
                            <a href="contendorTemplateUnoArchivoUno" class="image"><img class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoUnoUbicacion'] )}}"></a>
                            @elseif( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'texto'))
                            <a href="#" class="image">
                                <h5>{{$region['archivoUnoTexto']}}</h5>
                            </a>
                            @else
                                @if( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'video'))
                                <a href="contendorTemplateUnoArchivoUno" class="image">
                                    <video>
                                        <source class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoUnoUbicacion'] )}}"> >
                                    </video>
                                </a>
                                @else
                                <a href="contendorTemplateUnoArchivoUno" class="image">
                                    <iframe class="imgTemp" width="400" height="200" src="{{$region['archivoUnoUrl']}}">
                                    </iframe>
                                </a>
                                @endif
                            @endif
                        @endif
                        @if($region['region_size'] == "3")
                        <div class="contendor-general">
                            <div class="region_tres_archivo_uno">
                                @if( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'imag'))
                                <a href="" class="image"><img class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoUnoUbicacion'] )}}" width="400" height="10"></a>
                                @elseif( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'texto'))
                                <a href="" class="image">
                                    <h5>{{$region['archivoUnoTexto']}}</h5>
                                </a>
                                @else
                                @if( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'video'))
                                <a href="" class="image">
                                    <video>
                                        <source class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoUnoUbicacion'] )}}"> >
                                    </video>
                                </a>
                                @else
                                <a href="" class="image">
                                    <iframe class="imgTemp" src="{{$region['archivoUnoUrl']}}">
                                    </iframe>
                                </a>
                                @endif
                                @endif
                            </div>
                            <div class="region_tres_archivo_dos">
                                @if( Illuminate\Support\Str::contains($region['archivoDosTipo'], 'imag'))
                                <a href="" class="image"><img class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoDosUbicacion'] )}}" width="400" height="10"></a>
                                @elseif( Illuminate\Support\Str::contains($region['archivoDosTipo'], 'texto'))
                                <a href="" class="image">
                                    <h5>{{$region['archivoDosTexto']}}</h5>
                                </a>
                                @else
                                @if( Illuminate\Support\Str::contains($region['archivoDosTipo'], 'video'))
                                <a href="" class="image">
                                    <video>
                                        <source class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoDosUbicacion'] )}}"> >
                                    </video>
                                </a>
                                @else
                                <a href="" class="image">
                                    <iframe class="imgTemp" src="{{$region['archivoDosUrl']}}">
                                    </iframe>
                                </a>
                                @endif
                                @endif
                            </div>
                            <div class="region_tres_archivo_tres">
                                @if( Illuminate\Support\Str::contains($region['archivoTresTipo'], 'imag'))
                                <a href="" class="image"><img class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoTresUbicacion'] )}}" width="200" height="10"></a>
                                @elseif( Illuminate\Support\Str::contains($region['archivoTresTipo'], 'texto'))
                                <a href="" class="image">
                                    <h5>{{$region['archivoTresTexto']}}</h5>
                                </a>
                                @else
                                @if( Illuminate\Support\Str::contains($region['archivoTresTipo'], 'video'))
                                <a href="" class="image">
                                    <video>
                                        <source class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoTresUbicacion'] )}}"> >
                                    </video>
                                </a>
                                @else
                                <a href="" class="image">
                                    <iframe class="imgTemp" src="{{$region['archivoTresUrl']}}">
                                    </iframe>
                                </a>
                                @endif
                                @endif
                            </div>
                        </div>
                        @endif
                        @if($region['region_size'] == "4")

                        <div class="contendor-general">
                            <div class="region_cuatro_archivo_uno">
                                @if( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'imag'))
                                <a href="" class="image"><img class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoUnoUbicacion'] )}}" width="400" height="10"></a>
                                @elseif( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'texto'))
                                <a>
                                    <h5>{{$region['archivoUnoTexto']}}</h5>
                                </a>
                                @else
                                @if( Illuminate\Support\Str::contains($region['archivoUnoTipo'], 'video'))
                                <a href="" class="image">
                                    <video>
                                        <source class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoUnoUbicacion'] )}}"> >
                                    </video>
                                </a>
                                @else
                                <a href="" class="image">
                                    <iframe class="imgTemp" src="{{$region['archivoUnoUrl']}}">
                                    </iframe>
                                </a>
                                @endif
                                @endif
                            </div>
                            <div class="region_cuatro_archivo_dos">
                                @if( Illuminate\Support\Str::contains($region['archivoDosTipo'], 'imag'))
                                <a href="" class="image"><img class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoDosUbicacion'] )}}" width="400" height="10"></a>
                                @elseif( Illuminate\Support\Str::contains($region['archivoDosTipo'], 'texto'))
                                <a href="" class="image">
                                    <h5>{{$region['archivoDosTexto']}}</h5>
                                </a>
                                @else
                                @if( Illuminate\Support\Str::contains($region['archivoDosTipo'], 'video'))
                                <a href="" class="image">
                                    <video>
                                        <source class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoDosUbicacion'] )}}"> >
                                    </video>
                                </a>
                                @else
                                <a href="" class="image">
                                    <iframe class="imgTemp" src="{{$region['archivoDosUrl']}}">
                                    </iframe>
                                </a>
                                @endif
                                @endif

                            </div>
                            <div class="region_cuatro_archivo_tres">
                                @if( Illuminate\Support\Str::contains($region['archivoTresTipo'], 'imag'))
                                <a href="" class="image"><img class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoTresUbicacion'] )}}" width="200" height="10"></a>
                                @elseif( Illuminate\Support\Str::contains($region['archivoTresTipo'], 'texto'))
                                <a href="" class="image">
                                    <h5>{{$region['archivoTresTexto']}}</h5>
                                </a>
                                @else
                                @if( Illuminate\Support\Str::contains($region['archivoTresTipo'], 'video'))
                                <a href="" class="image">
                                    <video>
                                        <source class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoTresUbicacion'] )}}"> >
                                    </video>
                                </a>
                                @else
                                <a href="" class="image">
                                    <iframe class="imgTemp" src="{{$region['archivoTresUrl']}}">
                                    </iframe>
                                </a>
                                @endif
                                @endif

                            </div>
                            <div class="region_cuatro_archivo_cuatro">
                                @if( Illuminate\Support\Str::contains($region['archivoCuatroTipo'], 'imag'))
                                <a href="" class="image"><img class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoCuatroUbicacion'] )}}" width="200" height="10"></a>
                                @elseif( Illuminate\Support\Str::contains($region['archivoCuatroTipo'], 'texto'))
                                <a href="" class="image">
                                    <h5>{{$region['archivoCuatroTexto']}}</h5>
                                </a>
                                @else
                                @if( Illuminate\Support\Str::contains($region['archivoCuatroTipo'], 'video'))
                                <a href="" class="image">
                                    <video>
                                        <source class="imgTemp" src="{{Storage::disk('s3')->url( $region['archivoCuatroUbicacion'] )}}"> >
                                    </video>
                                </a>
                                @else
                                <a href="" class="image">
                                    <iframe class="imgTemp" src="{{$region['archivoCuatroUrl']}}">
                                    </iframe>
                                </a>
                                @endif
                                @endif

                            </div>
                        </div>

                        @endif

                        <!-- <a href="#" class="image"><img src="images/pic01.jpg" alt="" /></a> -->
                    </article>
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
                </div>
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