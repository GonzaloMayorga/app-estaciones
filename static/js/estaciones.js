	loadEstaciones().then( data => {
		data.forEach(function(element, index){
			addBtnEstacion(element)
		})
	})


// Petición asincrona de la lista de estaciones
async function loadEstaciones(){
	const response = await fetch("https://mattprofe.com.ar/proyectos/app-estacion/datos.php?mode=list-stations")
	const data = await response.json()

	return data
}

// Crea un nuevo botón con los datos de info
function addBtnEstacion(info){

	let tpl = document.querySelector("#tpl-btn-estacion")
	let clon = tpl.content.cloneNode(true)

	// cargamos los datos del botón clonado
	clon.querySelector(".cardEstacion").setAttribute("href", "./detalle/"+info.chipid)
	clon.querySelector(".estacion-ubicacion").innerHTML= '<i class="fas fa-map-marker-alt color-ubicacion"></i>&nbsp'+info.ubicacion
	clon.querySelector(".estacion-visitas").innerHTML = info.visitas+'&nbsp<i class="fa-solid fa-tower-observation color-visitas"></i>'
	clon.querySelector(".estacion-apodo").innerHTML = info.apodo
	
	// Agrega un nuevo botón de estación
	document.querySelector("#list-estacion").appendChild(clon)
}