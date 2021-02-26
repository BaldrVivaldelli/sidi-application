@extends('layouts.app')

@section('content')
<!-- Wrapper -->
<div id="wrapper">
    <!-- Main -->
    <div id="main">
        <div class="inner">
            <!-- Header -->
            <header id="header">
                <a href="/content/create" class="logo"><strong>Crear Contenido</strong></a>
            </header>
            <!-- Form -->
            <h3></h3>
            @if($errors->any())
            <h4>{{$errors->first()}}</h4>
            @endif

            <form method="post" action="/content/store" enctype="multipart/form-data">
                <div class="row gtr-uniform">
                    <div class="col-7 col-4-xsmall">
                        <input type="text" name="content-name" id="content-name" placeholder="Nombre del contenido" />
                    </div>
                    <div class="col-2 col-2-small">
                        <input type="radio" id="deshabilitada"  value="off" name="estado-contenido">
                        <label for="deshabilitada">Deshabilitada</label>
                    </div>
                    <div class="col-2 col-2-small">
                        <input type="radio" id="habilitada"  value="on" name="estado-contenido" />
                        <label for="habilitada">Habilitada</label>
                    </div>
                </div>

                {{ csrf_field() }}


                <div class="row gtr-uniform">
                    <!-- Break -->
                    <div id="titulo">
                        <h3>Selecciona un tipo de template</h3>
                    </div>
                    <div class="col-4 col-12-small">
                        <input type="radio" name="tipo-region" value="1" id="region-total-uno" />
                        <label for="region-total-uno">Una region</label>
                        <div>
                            <img class="imgTemp" src="\images\1Pantallas.png">
                        </div>
                        <div>
                            <h4>Elegi el contenido a subir</h4>

                            <div id="FormatoUno">
                                <h5>Region A</h5>

                                <select name="regionUnoDetalleUno" id="regionUnoDetalleUno">
                                    <option value="default"></option>
                                    <option value="imagen">imagen</option>
                                    <option value="texto">texto</option>
                                    <option value="video">video</option>
                                </select>
                                <!-- 
                                <label id="regionUnoDetalleUnoImagen" style="display:none" class="file" title="" for="region-uno-imagen">
                                    <input name="file-seccion-una" id="region-uno-imagen" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                                </label> 
-->
                                <label class="file" id="regionUnoDetalleUnoImagen" style="display:none" title="">
                                    <input name="file-seccion-una-a" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                                </label>
                                <div>
                                    <textarea id="regionUnoDetalleUnoTexto" style="display:none" name="mensaje-seccion-una-a" placeholder="Ingresa el texto a subir"></textarea>
                                </div>

                                <div id="regionUnoDetalleUnoVideo" style="display:none">
                                    <input type="radio" id="regionUnoDetalleUnoVideoUrl" value="url" name="tipoVideo">
                                    <label for="regionUnoDetalleUnoVideoUrl">
                                        <h5>Video Url</h5>
                                    </label>
                                    </input>


                                    <input type="radio" id="regionUnoDetalleUnoVideoUpload" value="upload" name="tipoVideo">
                                    <label for="regionUnoDetalleUnoVideoUpload">
                                        <h5>Subir Video </h5>
                                    </label>
                                    </input>

                                    <div class="regionUnoDetalleUnoVideoUrlSelected">
                                        <input type="text" name="file-seccion-una-a-url" id="regionUnoDetalleUnoVideoUrlSelected" style="display:none" placeholder="url del video" />
                                    </div>
                                    <div id="regionUnoDetalleUnoVideoUploadSelected" style="display:none">
                                        <label name="regionUnoDetalleUnoVideoUploadSelected" class="file" title="" for="region-uno-video">
                                            <input name="file-seccion-una-a-upload-manual" id="region-uno-video" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>













                    <div class="col-4 col-12-small">
                        <input type="radio" name="tipo-region" value="3" id="region-total-tres" />
                        <label for="region-total-tres">Tres regiones</label>
                        <div>
                            <img class="imgTemp" src="\images\3Pantallas.png">
                        </div>
                        <h4>Elegi los contenidos a subir en las regiones</h4>

                        <div id="FormatoDos">
                            <h4>Region A</h4>

                            <select name="regionTresDetalleUno" id="regionTresDetalleUno">
                                <option value="default"></option>                                
                                <option value="imagen">imagen</option>
                                <option value="texto">texto</option>
                                <option value="video">video</option>
                            </select>


                            <label id="regionTresDetalleUnoImagen" style="display:none" class="file" title="" for="region-tres-uno-imagen">
                                <input name="file-seccion-tres-a" id="region-tres-uno-imagen" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                            </label>

                            <div>
                                <textarea id="regionTresDetalleUnoTexto" style="display:none" name="mensaje-seccion-tres-a" placeholder="Ingresa el texto a subir"></textarea>
                            </div>

                            <div id="regionTresDetalleUnoVideo" style="display:none">


                                <input type="radio" id="regionTresDetalleUnoVideoUrl" value="url" name="tipoVideo">
                                <label for="regionTresDetalleUnoVideoUrl">
                                    <h5>Video Url</h5>
                                </label>
                                </input>


                                <input type="radio" id="regionTresDetalleUnoVideoUpload" value="upload" name="tipoVideo">
                                <label for="regionTresDetalleUnoVideoUpload">
                                    <h5>Subir Video </h5>
                                </label>
                                </input>


                                <div class="regionTresDetalleUnoVideoUrlSelected">
                                    <input type="text" name="file-seccion-tres-a-url" id="regionTresDetalleUnoVideoUrlSelected" style="display:none" placeholder="url del video" />
                                </div>

                                <div id="regionTresDetalleUnoVideoUploadSelected" style="display:none">
                                    <label name="regionTresDetalleUnoVideoUploadSelected" class="file" title="" for="region-tres-uno-video">
                                        <input name="file-seccion-tres-a-upload-manual" id="region-tres-uno-video" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                                    </label>
                                </div>
                            </div>



                            <h4>Region B</h4>

                            <select name="regionTresDetalleDos" id="regionTresDetalleDos">
                                <option value="default"></option>
                                <option value="imagen">imagen</option>
                                <option value="texto">texto</option>
                                <option value="video">video</option>
                            </select>

                            <label id="regionTresDetalleDosImagen" style="display:none" class="file" title="" for="region-tres-dos-imagen">
                                <input name="file-seccion-tres-b" id="region-tres-dos-imagen" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                            </label>


                            <div>
                                <textarea id="regionTresDetalleDosTexto" style="display:none" name="mensaje-seccion-tres-b" placeholder="Ingresa el texto a subir"></textarea>
                            </div>


                            <div id="regionTresDetalleDosVideo" style="display:none">

                                <input type="radio" id="regionTresDetalleDosVideoUrl" value="url" name="tipoVideo">
                                <label for="regionTresDetalleDosVideoUrl">
                                    <h5>Video Url</h5>
                                </label>
                                </input>


                                <input type="radio" id="regionTresDetalleDosVideoUpload" value="upload" name="tipoVideo">
                                <label for="regionTresDetalleDosVideoUpload">
                                    <h5>Subir Video </h5>
                                </label>
                                </input>


                                <div class="regionTresDetalleDosVideoUrlSelected">
                                    <input type="text" name="file-seccion-tres-b-url" id="regionTresDetalleDosVideoUrlSelected" style="display:none" placeholder="url del video" />
                                </div>

                                <div id="regionTresDetalleDosVideoUploadSelected" style="display:none">
                                    <label name="regionTresDetalleDosVideoUploadSelected" class="file" title="" for="region-tres-dos-video">
                                        <input name="file-seccion-tres-b-upload-manual" id="region-tres-dos-video" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                                    </label>
                                </div>

                            </div>

                            <h4>Region C</h4>

                            <select name="regionTresDetalleTres" id="regionTresDetalleTres">
                                <option value="default"></option>
                                <option value="imagen">imagen</option>
                                <option value="texto">texto</option>
                                <option value="video">video</option>
                            </select>

                            <label id="regionTresDetalleTresImagen" style="display:none" class="file" title="" for="region-tres-tres-imagen">
                                <input name="file-seccion-tres-c" id="region-tres-tres-imagen" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                            </label>

                            <div>
                                <textarea id="regionTresDetalleTresTexto" style="display:none" name="mensaje-seccion-tres-c" placeholder="Ingresa el texto a subir"></textarea>
                            </div>

                            <div id="regionTresDetalleTresVideo" style="display:none">

                                <input type="radio" id="regionTresDetalleTresVideoUrl" value="url" name="tipoVideo">
                                <label for="regionTresDetalleTresVideoUrl">
                                    <h5>Video Url</h5>
                                </label>
                                </input>


                                <input type="radio" id="regionTresDetalleTresVideoUpload" value="upload" name="tipoVideo">
                                <label for="regionTresDetalleTresVideoUpload">
                                    <h5>Subir Video </h5>
                                </label>
                                </input>


                                <div class="regionTresDetalleTresVideoUrlSelected">
                                    <input type="text" name="file-seccion-tres-c-url" id="regionTresDetalleTresVideoUrlSelected" style="display:none" placeholder="url del video" />
                                </div>

                                <div id="regionTresDetalleTresVideoUploadSelected" style="display:none">
                                    <label name="regionTresDetalleTresVideoUploadSelected" class="file" title="" for="region-tres-tres-video">
                                        <input name="file-seccion-tres-c-upload-manual" id="region-tres-tres-video" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                                    </label>
                                </div>

                            </div>



                        </div>
                    </div>





























                    <div class="col-4 col-12-small">
                        <input type="radio" name="tipo-region" value="4" id="region-total-cuatro" />
                        <label for="region-total-cuatro">Cuatro regiones</label>
                        <div>
                            <img class="imgTemp" src="\images\4Pantallas.png">
                        </div>

                        <h4>Elegi los contenidos a subir en las regiones</h4>

                        <div id="FormatoTres">



                            <h4>Region A</h4>

                            <select name="regionCuatroDetalleUno" id="regionCuatroDetalleUno">
                                <option value="default"></option>
                                <option value="imagen">imagen</option>
                                <option value="texto">texto</option>
                                <option value="video">video</option>
                            </select>


                            <label id="regionCuatroDetalleUnoImagen" style="display:none" class="file" title="" for="region-cuatro-uno-imagen">
                                <input name="file-seccion-cuatro-a" id="region-cuatro-uno-imagen" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                            </label>

                            <div>
                                <textarea id="regionCuatroDetalleUnoTexto" style="display:none" name="mensaje-seccion-cuatro-a" placeholder="Ingresa el texto a subir"></textarea>
                            </div>

                            <div id="regionCuatroDetalleUnoVideo" style="display:none">

                                <input type="radio" id="regionCuatroDetalleUnoVideoUrl" value="url" name="tipoVideo">
                                <label for="regionCuatroDetalleUnoVideoUrl">
                                    <h5>Video Url</h5>
                                </label>
                                </input>


                                <input type="radio" id="regionCuatroDetalleUnoVideoUpload" value="upload" name="tipoVideo">
                                <label for="regionCuatroDetalleUnoVideoUpload">
                                    <h5>Subir Video </h5>
                                </label>
                                </input>

                                <div class="regionCuatroDetalleUnoVideoUrlSelected">
                                    <input type="text" name="file-seccion-cuatro-a-url" id="regionCuatroDetalleUnoVideoUrlSelected" style="display:none" placeholder="url del video" />
                                </div>


                                <div id="regionCuatroDetalleUnoVideoUploadSelected" style="display:none">
                                    <label name="regionCuatroDetalleUnoVideoUploadSelected" class="file" title="" for="region-cuatro-uno-video">
                                        <input name="file-seccion-cuatro-a-upload-manual" id="region-cuatro-uno-video" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                                    </label>
                                </div>



                            </div>



                            <h4>Region B</h4>

                            <select name="regionCuatroDetalleDos" id="regionCuatroDetalleDos">
                                <option value="default"></option>
                                <option value="imagen">imagen</option>
                                <option value="texto">texto</option>
                                <option value="video">video</option>
                            </select>

                            <label id="regionCuatroDetalleDosImagen" style="display:none" class="file" title="" for="region-cuatro-dos-imagen">
                                <input name="file-seccion-cuatro-b" id="region-cuatro-dos-imagen" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                            </label>


                            <div>
                                <textarea id="regionCuatroDetalleDosTexto" style="display:none" name="mensaje-seccion-cuatro-b" placeholder="Ingresa el texto a subir"></textarea>
                            </div>


                            <div id="regionCuatroDetalleDosVideo" style="display:none">


                                <input type="radio" id="regionCuatroDetalleDosVideoUrl" value="url" name="tipoVideo">
                                <label for="regionCuatroDetalleDosVideoUrl">
                                    <h5>Video Url</h5>
                                </label>
                                </input>


                                <input type="radio" id="regionCuatroDetalleDosVideoUpload" value="upload" name="tipoVideo">
                                <label for="regionCuatroDetalleDosVideoUpload">
                                    <h5>Subir Video </h5>
                                </label>
                                </input>

                                <div class="regionCuatroDetalleDosVideoUrlSelected">
                                    <input type="text" name="file-seccion-cuatro-b-url" id="regionCuatroDetalleDosVideoUrlSelected" style="display:none" placeholder="url del video" />
                                </div>

                                <div id="regionCuatroDetalleDosVideoUploadSelected" style="display:none">
                                    <label name="regionCuatroDetalleDosVideoUploadSelected" class="file" title="" for="region-cuatro-dos-video">
                                        <input name="file-seccion-cuatro-b-upload-manual" id="region-cuatro-dos-video" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                                    </label>
                                </div>
                            </div>

                            <h4>Region C</h4>

                            <select name="regionCuatroDetalleTres" id="regionCuatroDetalleTres">
                                <option value="default"></option>
                                <option value="imagen">imagen</option>
                                <option value="texto">texto</option>
                                <option value="video">video</option>
                            </select>

                            <label id="regionCuatroDetalleTresImagen" style="display:none" class="file" title="" for="region-cuatro-tres-imagen">
                                <input name="file-seccion-cuatro-c" id="region-cuatro-tres-imagen" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                            </label>

                            <div>
                                <textarea id="regionCuatroDetalleTresTexto" style="display:none" name="mensaje-seccion-cuatro-c" placeholder="Ingresa el texto a subir"></textarea>
                            </div>

                            <div id="regionCuatroDetalleTresVideo" style="display:none">

                                <input type="radio" id="regionCuatroDetalleTresVideoUrl" value="url" name="tipoVideo">
                                <label for="regionCuatroDetalleTresVideoUrl">
                                    <h5>Video Url</h5>
                                </label>
                                </input>


                                <input type="radio" id="regionCuatroDetalleTresVideoUpload" value="upload" name="tipoVideo">
                                <label for="regionCuatroDetalleTresVideoUpload">
                                    <h5>Subir Video </h5>
                                </label>
                                </input>


                                <div class="regionCuatroDetalleTresVideoUrlSelected">
                                    <input type="text" name="file-seccion-cuatro-c-url" id="regionCuatroDetalleTresVideoUrlSelected" style="display:none" placeholder="url del video" />
                                </div>

                                <div id="regionCuatroDetalleTresVideoUploadSelected" style="display:none">
                                    <label name="regionCuatroDetalleTresVideoUploadSelected" class="file" title="" for="region-cuatro-tres-video">
                                        <input name="file-seccion-cuatro-c-upload-manual" id="region-cuatro-tres-video" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                                    </label>
                                </div>

                            </div>




                            <h4>Region D</h4>

                            <select name="regionCuatroDetalleCuatro" id="regionCuatroDetalleCuatro">
                                <option value="default"></option>                            
                                <option value="imagen">imagen</option>
                                <option value="texto">texto</option>                                
                            </select>

                            <label id="regionCuatroDetalleCuatroImagen" style="display:none" class="file" title="" for="region-cuatro-cuatro-imagen">
                                <input name="file-seccion-cuatro-d" id="region-cuatro-cuatro-imagen" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                            </label>

                            <div>
                                <textarea id="regionCuatroDetalleCuatroTexto" style="display:none" name="mensaje-seccion-cuatro-d" placeholder="Ingresa el texto a subir"></textarea>
                            </div>

                            <div id="regionCuatroDetalleCuatroVideo" style="display:none" disabled>

                                <input type="radio" id="regionCuatroDetalleCuatroVideoUrl" value="url" name="tipoVideo">
                                <label for="regionCuatroDetalleCuatroVideoUrl">
                                    <h5>Video Url</h5>
                                </label>
                                </input>


                                <input type="radio" id="regionCuatroDetalleCuatroVideoUpload" value="upload" name="tipoVideo">
                                <label for="regionCuatroDetalleCuatroVideoUpload">
                                    <h5>Subir Video </h5>
                                </label>
                                </input>

                                <div class="regionCuatroDetalleCuatroVideoUrlSelected">
                                    <input type="text" name="file-seccion-cuatro-d-url" id="regionCuatroDetalleCuatroVideoUrlSelected" style="display:none" placeholder="url del video" />
                                </div>
                                <div id="regionCuatroDetalleCuatroVideoUploadSelected" style="display:none">
                                    <label name="regionCuatroDetalleCuatroVideoUploadSelected" class="file" title="" for="region-cuatro-cuatro-video">
                                        <input name="file-seccion-cuatro-d-upload-manual" id="region-cuatro-cuatro-video" type="file" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                                    </label>
                                </div>

                            </div>





























                        </div>
                    </div>


                    <!-- Break -->

                    <!-- Break -->
                    <div class="col-12">

                        <ul class="actions">
                            <li><input type="submit" value="Crear" class="primary" /></li>
                            <li><input type="reset" value="Borrar valores" /></li>
                        </ul>
                    </div>
                </div>
            </form>

            <!-- Banner -->

            <!-- Section -->


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
</div>



@endsection