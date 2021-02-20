function tipoDeContenido(){	
	var selectorId = this.id
	var selectorValue = this.value;
	
	switch(selectorValue) {
		case "imagen":			
			mostrarimagen(selectorId)
		  break;
		case "texto":
			mostrartexto(selectorId)
		  break;
		case "video":
			mostrarvideo(selectorId);
		break;
		default:
	  }

	console.log(selectorValue);
}

function clearOtherValues(selectorId){
	var selectorIdImagen = 	document.getElementById(selectorId + "Imagen");
	var selectorIdTexto =	document.getElementById(selectorId + "Texto");
	var selectorIdVideo = 	document.getElementById(selectorId + "Video");
	var selector = document.getElementById(selectorId);

	switch(selector.value) {
		case "imagen":
			selectorIdTexto.style.display = "none";
			selectorIdVideo.style.display = "none";
		  break;
		case "texto":
			selectorIdImagen.style.display = "none";
			selectorIdVideo.style.display = "none";
		  break;
		case "video":
			selectorIdTexto.style.display = "none";
			selectorIdImagen.style.display = "none";
		break;
		default:
	  }
	console.log(document.getElementById(selectorId));	
}

function mostrarimagen(selectorId) {	
	clearOtherValues(selectorId);
	var selectorIdImagen = 	document.getElementById(selectorId + "Imagen");	
	selectorIdImagen.style.display = "block";		
}
function mostrartexto(selectorId) {
	clearOtherValues(selectorId);
	var selectorIdImagen = 	document.getElementById(selectorId + "Texto");	
	selectorIdImagen.style.display = "block";		
}
function mostrarvideo(selectorId) {
	clearOtherValues(selectorId);
	var selectorIdVideo = 	document.getElementById(selectorId + "Video");	
	selectorIdVideo.style.display = "block";		
}

function mostrarDetalleVideo(selectorId){
	console.log(document.getElementById(selectorId));	

	var comboBoxSelected = this.id;
	if(comboBoxSelected.includes("VideoUpload")){	
		var strOtherOption = comboBoxSelected.replace("VideoUpload","VideoUrl")
	}else{
		var strOtherOption = comboBoxSelected.replace("VideoUrl","VideoUpload")
	}	
	
	var otherVideoUrl =	document.getElementById(strOtherOption + "Selected");
	if(otherVideoUrl != null){
		otherVideoUrl.style.display = "none";	
	}
	document.getElementById(comboBoxSelected + "Selected").style.display = "block";
}

function ocultarOtrosFormatos() {
		var comboBoxSelected = this.id;
		switch(comboBoxSelected) {
			case "region-total-uno":				
				document.getElementById("FormatoUno").style.display = "block";
				document.getElementById("FormatoDos").style.display = "none";
				document.getElementById("FormatoTres").style.display = "none";				
			  break;
			case "region-total-tres":
				document.getElementById("FormatoUno").style.display = "none";
				document.getElementById("FormatoDos").style.display = "block";
				document.getElementById("FormatoTres").style.display = "none";
			  break;
			case "region-total-cuatro":
				document.getElementById("FormatoUno").style.display = "none";
				document.getElementById("FormatoDos").style.display = "none";
				document.getElementById("FormatoTres").style.display = "block";
			break;
			default:
		  }
		
		// var text1 = document.getElementById("detallesB");
		// var text2 = document.getElementById("detallesC");

		// if (checkBox.checked == true) {
		// 	text1.style.display = "none";
		// 	text2.style.display = "none";
		// }
		// else {
		// 	text1.style.display = "block";
		// 	text2.style.display = "block";
		// }
}

//Combo de regiones
document.getElementById("region-total-uno").addEventListener('change',ocultarOtrosFormatos,false);
document.getElementById("region-total-tres").addEventListener('change',ocultarOtrosFormatos,false);
document.getElementById("region-total-cuatro").addEventListener('change',ocultarOtrosFormatos,false);

//Region uno
document.getElementById("regionUnoDetalleUno").addEventListener('change',tipoDeContenido,false);
document.getElementById("regionUnoDetalleUnoVideoUrl").addEventListener('change',mostrarDetalleVideo,false);
document.getElementById("regionUnoDetalleUnoVideoUpload").addEventListener('change',mostrarDetalleVideo,false);

//Region tres

document.getElementById("regionTresDetalleUno").addEventListener('change',tipoDeContenido,false);
document.getElementById("regionTresDetalleDos").addEventListener('change',tipoDeContenido,false);
document.getElementById("regionTresDetalleTres").addEventListener('change',tipoDeContenido,false);

document.getElementById("regionTresDetalleUnoVideoUrl").addEventListener('change',mostrarDetalleVideo,false);
document.getElementById("regionTresDetalleUnoVideoUpload").addEventListener('change',mostrarDetalleVideo,false);
document.getElementById("regionTresDetalleDosVideoUrl").addEventListener('change',mostrarDetalleVideo,false);
document.getElementById("regionTresDetalleDosVideoUpload").addEventListener('change',mostrarDetalleVideo,false);
document.getElementById("regionTresDetalleTresVideoUrl").addEventListener('change',mostrarDetalleVideo,false);
document.getElementById("regionTresDetalleTresVideoUpload").addEventListener('change',mostrarDetalleVideo,false);


//Region Cuatro

document.getElementById("regionCuatroDetalleUno").addEventListener('change',tipoDeContenido,false);
document.getElementById("regionCuatroDetalleDos").addEventListener('change',tipoDeContenido,false);
document.getElementById("regionCuatroDetalleTres").addEventListener('change',tipoDeContenido,false);
document.getElementById("regionCuatroDetalleCuatro").addEventListener('change',tipoDeContenido,false);

document.getElementById("regionCuatroDetalleUnoVideoUrl").addEventListener('change',mostrarDetalleVideo,false);
document.getElementById("regionCuatroDetalleUnoVideoUpload").addEventListener('change',mostrarDetalleVideo,false);
document.getElementById("regionCuatroDetalleDosVideoUrl").addEventListener('change',mostrarDetalleVideo,false);
document.getElementById("regionCuatroDetalleDosVideoUpload").addEventListener('change',mostrarDetalleVideo,false);
document.getElementById("regionCuatroDetalleTresVideoUrl").addEventListener('change',mostrarDetalleVideo,false);
document.getElementById("regionCuatroDetalleTresVideoUpload").addEventListener('change',mostrarDetalleVideo,false);
document.getElementById("regionCuatroDetalleCuatroVideoUrl").addEventListener('change',mostrarDetalleVideo,false);
document.getElementById("regionCuatroDetalleCuatroVideoUpload").addEventListener('change',mostrarDetalleVideo,false);
