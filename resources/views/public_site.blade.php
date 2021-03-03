<!DOCTYPE html>
<html>


<style>  

@import url('https://fonts.googleapis.com/css?family=Noto+Sans&display=swap');

body {
    color: #fff;
    font-family: 'Noto Sans', sans-serif;
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

@media (min-width: 1366px){
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
        height: 55pc !important;
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
        height: 55pc !important;
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
        height: 55pc !important;
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
    height: 35pc;
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
    height: 35pc;
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
    height: 35pc;
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


<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Cliente SIDI</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>

<body>
    <!-- <button id="find-me">Show my location</button><br />
    <p id="status"></p>
    <a id="map-link" target="_blank"></a> -->


    <div class="basic-grid" id="container">
    </div>
    <!-- <video controls="controls" preload="auto" id="_video" width="640" height="360" autoplay="autoplay" loop="loop"></video>

    <img id="_img" /> -->
</body>
<script>
    let dataMc;
    let nombreDispositivo;
    fetch('{{ env('APP_URL')}}' +'/api/contenido/getAll/')
        .then(response => response.json())
        .then(data =>
            data.contenidos.forEach(contenido => {
                console.log(contenido);
                // var url = "https://sidi.dev/api/" + contenido;
                
                var url = "{{ env('APP_URL')}} " + contenido;
                var a = document.createElement('a');
                var link = document.createTextNode(contenido);
                a.appendChild(link);
                a.title = contenido;
                a.href = url;
                a.className ="card"
                a.addEventListener('click', showContentFromUrl);
                document.body.appendChild(a);
            })
        );

    window.addEventListener("beforeunload", function(e) {
        // var xhr = new XMLHttpRequest();
        // url = "https://sidi.dev/api/contenido/logout";
        // xhr.open("POST", url, true);
        // xhr.setRequestHeader('Content-Type', 'application/json');
        // xhr.send(JSON.stringify({
        //     value: value
        // }));
        window.ws.send(
                JSON.stringify({
                    'type': 'logout',
                    'content': `${dataMc}`,
                })
        );
        setTimeout(function(){
                window.location.reload(1);
        }, 2000);
      
    });

    function sendLogoutContent() {
        console.log('se va a desconectar')
        window.ws.close();
    }

    function reloadPage() {
        window.ws.send(
                JSON.stringify({
                    'type': 'logout',
                    'content': `${dataMc}`,
                })
        );
        setTimeout(function(){
                window.location.reload(1);
        }, 2000);
    }

    
    function showContentFromUrl(event) {
        var cantidadDeCuatros = 0;
        var cuadrosActuales= 0;
        event.preventDefault();
        console.log('Se va a borrar todo el contenido');
        console.log('el contenido que se desea ver es el siguiente ' + this.href);
        if(dataMc == null){
            dataMc = this.title;
        }
      
        document.body.innerHTML = '';
        var containerDiv = document.createElement("div");
        containerDiv.id = "container";
        // containerDiv.className = "display_cuatro_template"
        document.body.appendChild(containerDiv);

        //se crea el boton de vuelta
        var goback = document.createElement('button');

        goback.title = "volver";
        goback.value = "volver";
        goback.innerHTML = "Volver"
        goback.addEventListener('click', reloadPage);
        document.body.appendChild(goback);


        //abro el canal y me traigo la imagen   
        // window.ws = new WebSocket("wss://sidi.dev/wss");
        
        // window.ws = new WebSocket('ws://192.168.1.100:8090');                 
        window.ws = new WebSocket('ws://{{ config('app.socket_url')}}');        
        // window.ws = new WebSocket('ws://4.tcp.ngrok.io:17276');        
                 
        window.ws.onopen = function(e) {
            console.log('Connected to sidi');
            //en el momento que vuelve el "conectado" desde el back end se envia el pedido para obtener el contenido que se clickeo anteriormente     
            ws.send(
                JSON.stringify({
                    'type': 'snapshot',
                    'content': `${dataMc}`,
                    'nombreDispositivo': `${nombreDispositivo}`
                })
            );
        }

     
        ws.onclose = function(e) {
            console.log('Socket is closed. Reconnect will be attempted in 1 second.', e.reason);
            timeOut = setTimeout(function() {
                if(!ws || ws.readyState == 3){
                    showContentFromUrl(e);
                }else{
                    clearInterval(timeOut);
                }
            }, 5000);
        };


        window.ws.onmessage = function(e) {
            console.log('llego algo');
            var response = JSON.parse(e.data);
            console.log('el numero de session es el siguiente : ' + response.numero_session);
            console.log(response);
            // if(response.region_size == "region_cuatro"){
            //     document.getElementById("container").classList.add("display_cuatro_template");
            // }else if(response.region_size == "region_tres"){
            //     document.getElementById("container").classList.add("display_tres_template");
            // }else{
            //     document.getElementById("container").classList.add("display_uno_template");
            // }
            updateContainerValue(document.getElementById("container"),response.region_size);
            switch (response.type) {
                case "snapshot":
                    console.log('volvio el contenido ')
                    console.log(e)
                    var json = JSON.parse(e.data);
                    if(nombreDispositivo == null){
                        nombreDispositivo = response.nombreDispositivo;
                    }
                    if(json.archivo_nombre.includes("--CONTIENE DATO TEXTO--")){
                        var textValue = json.archivo_nombre.replace("--CONTIENE DATO TEXTO--","");                        
                        var section = document.createElement('section')
                        // var className = "region_uno_archivo_uno";
                        var className = json.region_size + "_archivo_" + json.numeroDeCuadro;
                        
                        section.className += className;    
                        
                        //voy a preguntar si existen otros elementos predecesores, en caso de ser asi voy a ver si es el primer, segundo, tercer o cuarto elemento que ingresa
                        // if(json.numeroDeCuadro ==="uno"){                            
                        //     section.className += " card dato_uno right_text"                    
                        // }
                        // if (json.numeroDeCuadro === "dos"){
                        //     section.className += " card dato_dos right_text"                    

                        // }
                        // if (json.numeroDeCuadro === "tres"){
                        //     section.className += " card dato_tres right_text"                    
                        // }
                        // if (json.numeroDeCuadro === "cuatro"){
                        //     section.className += " card dato_cuatro right_text"                    
                        // }
                        placeValueInTemplate(section,json.numeroDeCuadro);    
                        var dynLbl = document.createElement('h5');
                        dynLbl.innerHTML  = textValue;
                        dynLbl.className = className + "_data";
                        placeValueInTemplate(dynLbl,json.numeroDeCuadro);    

                        document.getElementById("container").appendChild(section);
                        section.appendChild(dynLbl);

                    }else if (json.archivo_nombre.includes("www.youtube.com/embed/")) {
                        var section = document.createElement('section')
                        // var className = "region_uno_archivo_uno";
                        var className = json.region_size + "_archivo_" + json.numeroDeCuadro;
                        section.className += className;    
                        placeValueInTemplate(section,json.numeroDeCuadro);    
                        var dynIframe = document.createElement('iframe');
                        dynIframe.className = className + "_data";
                        dynIframe.src = json.archivo_nombre +"?autoplay=1&mute=1&enablejsapi=1";
                        dynIframe.autoplay = 1;
            
                        placeValueInTemplate(dynIframe,json.numeroDeCuadro);    

                        document.getElementById("container").appendChild(section);
                        section.appendChild(dynIframe);

                    } else {
                        //var url = "http://192.168.1.100:90/api/contenido/getById/" + json.archivo_nombre;
                        var url = "{{ config('app.url')}}/api/contenido/getById/" + json.archivo_nombre;
                        var response = fetch(url)
                            .then(resp => resp.blob())
                            .then(blob => {
                                console.log(blob.type);
                                updateContentData(blob, url, json.region_size, json.numeroDeCuadro);
                            });
                    }
                    break;
                case "updateDisplay":


                    
                    var json = JSON.parse(e.data);                    
                    console.log('se actualizo el contenido ')
                    dataMc = response.nombreContenido;
                    cuadrosActuales++;

                    var numeroParse;
                    if(json.numeroDeCuadro == "uno"){
                        numeroParse = 1;
                    }else if(json.numeroDeCuadro == "dos"){
                        numeroParse = 2;
                    }else if(json.numeroDeCuadro == "tres"){
                        numeroParse = 3;
                    }if(json.numeroDeCuadro == "cuatro"){
                        numeroParse = 4;
                    }

                    if(numeroParse < cuadrosActuales || json.region_size != cantidadDeCuatros){
                    // if(json.numeroDeCuadro < cuadrosActuales || json.numeroDeCuadro != cantidadDeCuatros){

                        console.log('Se va a borrar todo el contenido para poder actualizar');
                        console.log('el contenido que se desea ver despues es el siguiente ' + this.href);
                        document.body.innerHTML = '';
                        // cantidadDeCuatros = json.numeroDeCuadro;
                        cantidadDeCuatros = json.region_size;
                        var containerDiv = document.createElement("div");
                        containerDiv.id = "container";
                        document.body.appendChild(containerDiv);
                        updateContainerValue(document.getElementById("container"),cantidadDeCuatros);

                        console.log('se actualiza el contenido ')
                        console.log(e)
                        cuadrosActuales = 1;
                    }

                    
                    if(json.archivo_nombre.includes("--CONTIENE DATO TEXTO--")){
                        var textValue = json.archivo_nombre.replace("--CONTIENE DATO TEXTO--","");                        
                        var section = document.createElement('section')
                        // var className = "region_uno_archivo_uno";
                        var className = json.region_size + "_archivo_" + json.numeroDeCuadro;

                        
                        section.className = className;   
                        placeValueInTemplate(section,json.numeroDeCuadro);                                 
                        var dynLbl = document.createElement('h5');
                        dynLbl.innerHTML  = textValue;
                        dynLbl.className = className + "_data";
                        placeValueInTemplate(dynLbl,json.numeroDeCuadro);             
                        document.getElementById("container").appendChild(section);
                        section.appendChild(dynLbl);

                    }else if (json.archivo_nombre.includes("www.youtube.com/embed/")) {
                        var section = document.createElement('section')
                        // var className = "region_uno_archivo_uno";
                        var className = json.region_size + "_archivo_" + json.numeroDeCuadro;
                        section.className = className;
                        placeValueInTemplate(section,json.numeroDeCuadro);                        
                        var iframe = document.createElement('iframe');
                        iframe.className = className + "_data";
                        placeValueInTemplate(iframe,json.numeroDeCuadro);                        
                        iframe.src = json.archivo_nombre +"?autoplay=1&mute=1&enablejsapi=1";
                        iframe.autoplay = 1;
                        iframe.muted = 1;
                        document.getElementById("container").appendChild(section);
                        section.appendChild(dynImg);


                    }else{
                        
                        // var url = "http://192.168.1.100:90/api/contenido/getById/" + json.archivo_nombre;
                        var url = "{{ config('app.url')}}/api/contenido/getById/" + json.archivo_nombre;
                        var response = fetch(url)
                        .then(resp => resp.blob())
                        .then(blob => {
                            console.log(blob.type);
                            updateContentData(blob, url, json.region_size, json.numeroDeCuadro);
                        });
                    }               
                    

                    //si es el ultimo valor se agrega el boton volver
                        //se crea el boton de vuelta
                    if( numeroParse == cuadrosActuales  && json.region_size == cantidadDeCuatros){
                        var goback = document.createElement('button');
                        goback.title = "volver";
                        goback.value = "volver";
                        goback.innerHTML = "Volver"
                        goback.addEventListener('click', reloadPage);
                        document.body.appendChild(goback);
                    }

                    break;
                case "userBlocked":

                    console.log('Se va a borrar todo el contenido para poder actualizar');
                    console.log('el contenido que se desea ver despues es el siguiente ' + this.href);

                    document.body.innerHTML = '';
                    var containerDiv = document.createElement("div");
                    containerDiv.id = "container";
                    document.body.appendChild(containerDiv);

                    console.log('se actualiza el contenido ')
                    console.log(e)
                    // var url = "http://192.168.1.100:90/api/contenido/EnableDisableContent";
                    var url = "{{ config('app.url')}}/api/contenido/EnableDisableContent";
                    var response = fetch(url)
                        .then(resp => resp.json())
                        .then(json => {
                            console.log(json.type);
                            // updateContentData(blob,url);                                                   
                        });
                    break;
                case "deleteDisplay":
                    location.reload();
                    break;
                case "incremental":
                    var json = JSON.parse(e.data);                    
                    console.log('se actualizo el contenido ')
                    cuadrosActuales++;
                    var numeroParse;
                    if(json.numeroDeCuadro == "uno"){
                        numeroParse = 1;
                    }else if(json.numeroDeCuadro == "dos"){
                        numeroParse = 2;
                    }else if(json.numeroDeCuadro == "tres"){
                        numeroParse = 3;
                    }if(json.numeroDeCuadro == "cuatro"){
                        numeroParse = 4;
                    }

                    if(numeroParse < cuadrosActuales || json.region_size != cantidadDeCuatros){

                        console.log('Se va a borrar todo el contenido para poder actualizar');
                        console.log('el contenido que se desea ver despues es el siguiente ' + this.href);
                        document.body.innerHTML = '';
                        cantidadDeCuatros = json.region_size;
                        var containerDiv = document.createElement("div");
                        containerDiv.id = "container";
                        document.body.appendChild(containerDiv);
                        updateContainerValue(document.getElementById("container"),cantidadDeCuatros);
                        console.log('se actualiza el contenido ')
                        console.log(e)
                        cuadrosActuales = 1;
                    }
                    
                    if(json.archivo_nombre.includes("--CONTIENE DATO TEXTO--")){
                        var textValue = json.archivo_nombre.replace("--CONTIENE DATO TEXTO--","");                        
                        var section = document.createElement('section')
                        // var className = "region_uno_archivo_uno";
                        var className = json.region_size + "_archivo_" + json.numeroDeCuadro;
                        placeValueInTemplate(section,json.numeroDeCuadro);                        
                        section.className = className;                        
                        var dynLbl = document.createElement('h5');
                        dynLbl.innerHTML  = textValue;
                        dynLbl.className = className + "_data";
                        placeValueInTemplate(dynLbl,json.numeroDeCuadro);                        
                        document.getElementById("container").appendChild(section);
                        section.appendChild(dynLbl);

                    }else if (json.archivo_nombre.includes("www.youtube.com/embed/")) {
                        var section = document.createElement('section')
                        // var className = "region_uno_archivo_uno";
                        // var className = region_size + "_archivo_" + numeroDeCuadro;
                        var className = json.region_size + "_archivo_" + json.numeroDeCuadro;
                        section.className = className;
                        placeValueInTemplate(section,json.numeroDeCuadro);                        

                        var iframe = document.createElement('iframe');
                        iframe.className = className + "_data";
                        placeValueInTemplate(iframe,json.numeroDeCuadro);
                        iframe.src = json.archivo_nombre +"?autoplay=1&mute=1&enablejsapi=1";
                        iframe.autoplay = 1;
                        iframe.muted = 1;
                        document.getElementById("container").appendChild(section);
                        section.appendChild(iframe);


                    }else{
                        // var url = "http://192.168.1.100:90/api/contenido/getById/" + json.archivo_nombre;
                        var url = "{{ config('app.url')}}/api/contenido/getById/" + json.archivo_nombre;
                        var response = fetch(url)
                        .then(resp => resp.blob())
                        .then(blob => {
                            console.log(blob.type);
                            updateContentData(blob, url, json.region_size, json.numeroDeCuadro);
                        });
                    }                    
                          //si es el ultimo valor se agrega el boton volver
                        //se crea el boton de vuelta
                        if( numeroParse == cuadrosActuales  && json.region_size == cantidadDeCuatros){
                        var goback = document.createElement('button');
                        goback.title = "volver";
                        goback.value = "volver";
                        goback.innerHTML = "Volver"
                        goback.addEventListener('click', reloadPage);
                        document.body.appendChild(goback);
                    }    
                    break;
                case "notifyChangeDisplayName":          
                    console.log("el cambio es el siguiente");
                    nombreDispositivo = response.value;
                    break;
            }
        }
    }


    function updateContentData(blob, url, region_size, numeroDeCuadro) {

        var section = document.createElement('section')
                var className = region_size + "_archivo_" + numeroDeCuadro;
                section.className += className;    
                // section.className += " card card-tall card-wide right_text"                    
                //voy a preguntar si existen otros elementos predecesores, en caso de ser asi voy a ver si es el primer, segundo, tercer o cuarto elemento que ingresa
                placeValueInTemplate(section,numeroDeCuadro);
        switch (blob.type) {
            case "image/jpeg":                
                var dynImg = new Image();
                dynImg.className = className + "_data";
                dynImg.src = url;

                // if(numeroDeCuadro ==="uno"){                            
                //     dynImg.className +=  " card dato_uno"                    
                // }
                // if (numeroDeCuadro === "dos"){
                //     dynImg.className += " card dato_dos"                    
                // }
                // if (numeroDeCuadro === "tres"){
                //     dynImg.className += " card dato_tres"                    
                // }
                // if (numeroDeCuadro === "cuatro"){
                //     dynImg.className += " card dato_cuatro"                    
                // } 
                placeValueInTemplate(dynImg,numeroDeCuadro)
                document.getElementById("container").appendChild(section);
                section.appendChild(dynImg);
                break;
            case "image/png":          
                var dynImg = new Image();
                dynImg.className = className + "_data";
                dynImg.src = url;
                // if(numeroDeCuadro ==="uno"){                            
                //     dynImg.className += " card card-tall card-wide right_text"                    
                // }
                // if (numeroDeCuadro === "dos"){
                //     dynImg.className += " card card-wide right_text"                    
                // }
                // if (numeroDeCuadro === "tres"){
                //     dynImg.className += " card card-wide right_text"                    
                // }
                // if (numeroDeCuadro === "cuatro"){
                //     dynImg.className += " card card-wide right_text"                    
                // }
                placeValueInTemplate();
                // if(numeroDeCuadro ==="uno"){                            
                //     dynImg.className +=  " card dato_uno"                    
                // }
                // if (numeroDeCuadro === "dos"){
                //     dynImg.className += " card dato_dos"                    
                // }
                // if (numeroDeCuadro === "tres"){
                //     dynImg.className += " card dato_tres"                    
                // }
                // if (numeroDeCuadro === "cuatro"){
                //     dynImg.className += " card dato_cuatro"                    
                // } 
                placeValueInTemplate(dynImg,numeroDeCuadro);
                document.getElementById("container").appendChild(section);
                section.appendChild(dynImg);
                break;
            case "video/mp4":           
                var video = document.createElement('video');
                video.src = url;
                video.type = blob.type;
                video.muted = "muted";
                video.autoplay = true;
                video.className = className + "_data";
                // if(numeroDeCuadro ==="uno"){                            
                //     video.className += " card card-tall card-wide right_text"                    
                // }
                // if (numeroDeCuadro === "dos"){
                //     video.className += " card card-wide right_text"                    
                // }
                // if (numeroDeCuadro === "tres"){
                //     video.className += " card card-wide right_text"                    
                // }
                // if (numeroDeCuadro === "cuatro"){
                //     video.className += " card card-wide right_text"                    
                // }
                // if(numeroDeCuadro ==="uno"){                            
                //     video.className +=  " card dato_uno"                    
                // }
                // if (numeroDeCuadro === "dos"){
                //     video.className += " card dato_dos"                    
                // }
                // if (numeroDeCuadro === "tres"){
                //     video.className += " card dato_tres"                    
                // }
                // if (numeroDeCuadro === "cuatro"){
                //     video.className += " card dato_cuatro"                    
                // }
                placeValueInTemplate(video,numeroDeCuadro);
                video.src = url;
                document.getElementById("container").appendChild(section);
                section.appendChild(video);

                break;
        }

    }
    var myVar = setInterval(checkFontSize,10000);    
    function checkFontSize(){        
            document.querySelectorAll("h5").forEach($quote =>{            
            var $numWords = $quote.innerHTML.split(" ").length;        
            if (($numWords >= 1) && ($numWords < 10)) {
                $quote.style["font-size"]= "50px";
            }
            else if (($numWords >= 10) && ($numWords < 20)) {
                $quote.style["font-size"]= "32px";
            }
            else if (($numWords >= 20) && ($numWords < 30)) {
                $quote.style["font-size"]= "28px";
            }
            else if (($numWords >= 30) && ($numWords < 40)) {
                $quote.style["font-size"]= "24px";
            }
            else {
                $quote.style["font-size"]= "20px";
            }      
        })
    }
    function placeValueInTemplate(value, numeroDeCuadro){

        if(numeroDeCuadro ==="uno"){                            
            value.className += " card dato_uno"                    
        }
        if (numeroDeCuadro === "dos"){
            value.className += " card dato_dos"                    
        }
        if (numeroDeCuadro === "tres"){
            value.className += " card dato_tres"                    
        }
        if (numeroDeCuadro === "cuatro"){
            value.className += " card dato_cuatro"                    
        }
    }
    function updateContainerValue(container, response){
        if(response == "region_cuatro"){
            container.classList.add("display_cuatro_template");
        }else if(response == "region_tres"){
            container.classList.add("display_tres_template");
        }else if(response == "region_uno"){
            container.classList.add("display_uno_template");
        }
    }
</script>


</html>