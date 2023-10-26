let chipid = document.querySelector("#chipid").innerHTML;
let myChart = null;
const MAX_DATOS = 7;
const INTERVAL_REFRESH = 5000;
let sectionVisible = ""
let dataJsonActual = ""

function fillData(padre,data,tpl){
	let template_clon = tpl.content.cloneNode(true);
    for (let index in data){
        if(template_clon.querySelector('#'+index)){
        	template_clon.querySelector('#'+index).textContent = data[index]
        }
    }
    padre.appendChild(template_clon) 
}
document.addEventListener("DOMContentLoaded", function(event){
	refreshDatos(MAX_DATOS)
	procesar(dataJsonActual, false)
})

let refresh = async (tpl) => {

 	info__estaciones.innerHTML = '';
    
    switch (tpl) {
        case 'temperatura':
            fillData(info__estaciones, dataJsonActual[0], tpl__temperatura);
            sectionVisible = "tpl__temperatura";
            procesar(dataJsonActual, true);
            break;
        case 'fuego':
            fillData(info__estaciones, dataJsonActual[0], tpl__fuego);
            sectionVisible = "tpl__fuego";
            procesar(dataJsonActual, true);
            break;
        case 'humedad':
            fillData(info__estaciones, dataJsonActual[0], tpl__humedad);
            sectionVisible = "tpl__humedad";
            procesar(dataJsonActual, true);
            break;
        case 'viento':
            fillData(info__estaciones, dataJsonActual[0], tpl__viento);
            sectionVisible = "tpl__viento";
            procesar(dataJsonActual, true);
            break;
        case 'presion':
            fillData(info__estaciones, dataJsonActual[0], tpl__presion);
            sectionVisible = "tpl__presion";
            procesar(dataJsonActual, true);
            break;
        default:

            break;
    }
}


async function refreshDatos(cantfilas){
	const response = await fetch("https://mattprofe.com.ar/proyectos/app-estacion/datos.php?chipid=" + chipid + "&cant=" + cantfilas)
	const data = await response.json()
	dataJsonActual = data
	console.log(dataJsonActual)
	        	fillData(info__estaciones,dataJsonActual[0],tpl__temperatura)
			fillData(fecUbi__,dataJsonActual[0],fecUbi)
	procesar(data)
}
function procesar(datos, addData = true){
	let fec = []; 
	let tem = []; 
	let hum = []; 
	let vie = []; 
	let fwi = []; 
	let pre = []; 
	let hora = ""

	console.log("Filas Json: " + datos.length);

	if(addData == true){
		// Recorremos el Json pero al reves. datos viejos a la izquierda nuevos derecha
		for (let i = datos.length-1; i >= 0; i--) {

			console.log("Vigia Json [" + i + "]" + datos[i].fecha);

			hora = datos[i].fecha.split(" ")[1]

			// Carga de vectores para generar el gráfico
			fec.push(hora.split(":")[0]+":"+hora.split(":")[1]);
			tem.push(datos[i].temperatura);
			hum.push(datos[i].humedad);
			vie.push(datos[i].viento);
			fwi.push(datos[i].fwi);
			pre.push(datos[i].presion);
		}

		// Elimina los ultimos datos de los vectores si el último fec es igual al anteúltimo.
		if(fec[fec.length-1] == fec[fec.length-2]){
			fec.splice(fec.length-1,1);
			hum.splice(fec.length-1,1);
			tem.splice(fec.length-1,1);
			vie.splice(fec.length-1,1);
			fwi.splice(fec.length-1,1);
			pre.splice(fec.length-1,1);
		}else{ // Elimina el primer dato de los vectores
			fec.splice(0,1);
			hum.splice(0,1);
			tem.splice(0,1);
			vie.splice(0,1);
			fwi.splice(0,1);
			pre.splice(0,1);
		}
		
	}
	
	// Gráfico
	// =================================

	let itemsGrafico = ""
	console.log(sectionVisible)
	switch (sectionVisible) {
		case "tpl__temperatura":
			itemsGrafico =
				[{
					label: 'Temperatura',
					borderColor: '#ffbf69',
					data: tem
				}]	
			break;
		case "tpl__humedad":
			itemsGrafico = 
						[{
							label: 'Humedad',
							borderColor: '#284b63',
							data: hum
						}]
			break;
		case "tpl__viento":
			itemsGrafico = 
				[{
					label: 'Viento',
					borderColor: '#6c757d',
					data: vie
				}]
			break;
		case "tpl__presion":
			itemsGrafico =
				itemsGrafico = 
					[{
						label: 'Presion',
						borderColor: '#2d6a4f',
						data: pre
					}]
			break;
		case "tpl__fuego":
			itemsGrafico =
				itemsGrafico = 
					[{
						label: 'FWI',
						borderColor: '#ec512b',
						data: fwi
					}]
			break;												
		default:
			itemsGrafico =
				[{
					label: 'Temperatura',
					borderColor: '#ffbf69',
					data: tem
				}]	
			break;
	}
				

	// invocamos a la funcion que carga y actualiza los datos en el gráfico
	renderCharts(datos[0].ubicacion, fec, itemsGrafico);
}

// renderizamos el gráfico
// =================================
function renderCharts(estacion, fecha, itemsGrafico){

	// si el objeto gráfico ya esta instanciado lo destruyo para que se vuelva a crear limpio
	if(myChart!=null){
        myChart.destroy();
    }

	const ctx= document.querySelector("#myChart").getContext("2d")

	myChart= new Chart(ctx, {
	type: "line",
	data:{
		labels: fecha,
		datasets: itemsGrafico
		},
		options: {
			/*title: {
				display: true,
				text: 'Estacion #' + estacion,
				fontSize: 30,
				padding: 30,
				fontColor: 'black'
			},*/
			scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero:true,
	                    fontColor: 'white'
	                },
	            }],
	         	xAxes: [{
	                ticks: {
	                    fontColor: 'white'
	                },
	            }]
	        } ,
			legend: {
				display: false,
				position: 'top',
				labels: {
					padding: 15,
					boxWidth: 40,
					fontFamily: 'system-ui',
					fontColor: 'white',
				}
			},
			tooltips: {
				backgroundColor: '#0584f6',
				titleFontSize: 20,
				xPadding: 20,
				yPadding: 20,
				mode: 'index', 
			},
			elements: {
				
				line: {
					borderWidth: 2,
					fill: false,
				},
				point: {
					radius: 6,
					borderWidth: 4,
					backgroundColor: 'white',
					hoverRadius: 8,
					hoverRadiusWidth: 4,	
				}
			},
			animation: {
				duration: 0
			},
			responsiveAnimationDuration: 0,
			responsive: true,
			maintainAspectRatio: false
		}
	})


}
