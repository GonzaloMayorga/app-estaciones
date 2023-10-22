<?php 
    $chipId = $_GET['chipid'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App-estacion <?php echo $chipId; ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500;900&amp;family=Ubuntu:wght@300;500;700&amp;display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2eb80ea257.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/estacionUnitaria.css">
</head>
<body>

	<!-- Template fecha y ubicacion -->
	<template id="fecUbi">	
		<div id='fecha'>			
		</div>
		<div id="ubicacion"></div>
	</template>
	<!-- Template Temperatura -->
	<template id='tpl__temperatura'>
		<div id="main-temp" class="info__estaciones">
			<div class="unitary__info">
				<p class="titulo">Temperatura ºC</p>
				<p id="temperatura"></p>
			</div>
			<div class="unitary__info">
				<p>Máxima ºC</p>
				<p id="tempmax"></p>
			</div>
			<div class="unitary__info">
				<p>Mínima ºC</p>
				<p id="tempmin"></p>
			</div>
		</div>

		<div id="main-sens" class="secondary__info">
			<div class="unitary__info">
				<p>SensaciónºC</p>
				<p id="sensacion"></p>
			</div>
			<div class="unitary__info">
				<p>Máxima ºC</p>
				<p id="sensamax"></p>
			</div>
			<div class="unitary__info"> 
				<p>Mínima 	ºC</p>
				<p id="sensamin"></p>
			</div>
		</div>
	</template>

	<!-- Template Humedad -->
	<template id="tpl__humedad">
		<div id="main-humedad" class="info__estaciones">
			<p>HUMEDAD %</p>
			<div >
				<p id="humedad" ></p>
			</div>
		</div>
	</template>

	<!-- Template Presion -->
	<template id="tpl__presion">
		<div id="main-presion" class="info__estaciones">
			<p>PRESION</p>
			<div id="presion">
				<p>hPa</p>
			</div>
		</div>
	</template>	

	<template id="tpl__viento">
		<div id="main-viento" class="info__estaciones">
			<p>VIENTO</p>
			<div >
				<p>Km/H</p>
				<p id="presion"></p>
			</div>
			<div>
				<p>Máximo Km/H</p>
				<p id="maxviento"></p>
			</div>
		</div>
	</template>	

	<!-- Template Fuego -->
	<template id="tpl__fuego">
		<div id="main-fuego" class="info__estaciones">
			<p>FUEGO</p>
			<div>
				<p>FFMC</p>
				<p id="ffmc"></p>
			</div>
			<div>
				<p>DMC</p>
				<p id="dmc"></p>
			</div>
			<div >
				<p>DC</p>
				<p id="dc"></p>
			</div>
			<div >
				<p>ISI</p>
				<p id="isi"></p>
			</div>
			<div >
				<p>BUI</p>
				<p id="bui"></p>
			</div>
			<div >
				<p>FWI</p>
				<p id="fwi"></p>
			</div>
		</div>
	</template>	


<div id="chipid" style="display: none;"><?php echo $chipId; ?></div>
	<div id="panelBtns">
		<div id="btn-temperatura" class="btn" onclick="refresh('temperatura')">Temperatura</div>
		<div id="btn-fuego" class="btn" onclick="refresh('fuego')">Fire</div>
		<div id="btn-humedad" class="btn" onclick="refresh('humedad')">Humedad</div>
		<div id="btn-presion" class="btn" onclick="refresh('presion')">Presión</div>
		<div id="btn-viento" class="btn" onclick="refresh('viento')">Viento</div>
	</div>

<div id="screen">
	<div id="fecUbi__"></div>
	<div id="info__estaciones">
		
	</div>
		<div id="grafico-container">
	            <canvas id="myChart"></canvas>

		</div>
</div>


    <script src="./api/detallePropio.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
