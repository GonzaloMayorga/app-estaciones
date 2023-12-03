<?php 

/**
 * 
 */
class trackerModel extends DBAbstract
{
	
	function __construct()
	{
		
	}
	public function captureClientInfo() {
        $clientIP = $_SERVER['REMOTE_ADDR'];

        /* Protección para evitar leer una ip local */
        if($clientIP == "127.0.0.1"){
			$clientIP = "181.47.205.193"; /* Usamos un ip pública */
		}
		/* Consulta a la api para obtener más información de la ip */
		$web = file_get_contents("http://ipwho.is/".$clientIP);

		/* Convierte el json recuperado en un objeto */
		$response = json_decode($web);

		// Obtener información adicional de la IP
		$latitud = $response->latitude;
		$longitud = $response->longitude;
		$pais = $response->country;

        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $info = explode(' ', $userAgent);

        $browserName = implode(' ', array_slice($info, 0, 1)); 
        $system = implode(' ', array_slice($info, 1));

        $addDate = date('Y-m-d H:i:s');

        // Insertar la información en la tabla "tracker"
        $sql = "INSERT INTO `app-estacionTracker`(`ip`, `latitud`, `longitud`, `pais`, `navegador`, `sistema`, `add_date`) VALUES ('$clientIP','$latitud','$longitud','$pais','$browserName','$system','$addDate')";
        $result = $this->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
	}
	public function getClients(){
		$sql = "SELECT count(DISTINCT ip) as 'visitas' FROM `app-estacionTracker`"; 
		$result = $this->query($sql);
			if($result){
				$row = $result->fetch_all(MYSQLI_ASSOC);
				return $row[0]["visitas"];
		}	
	}
	public function Api(){
        $sql = "SELECT DISTINCT `ip`, `latitud`, `longitud`, COUNT(ip) as `cantidad_accesos` FROM `app-estacionTracker` GROUP BY `ip`";
        $result = $this->query($sql);

        if ($result->num_rows > 0) {
            $clientsLocation = array();

            while ($row = $result->fetch_assoc()) {
                $clientsLocation[] = array(
                    'ip' => $row['ip'],
                    'latitud' => $row['latitud'],
                    'longitud' => $row['longitud'],
                    'cantidad_accesos' => $row['cantidad_accesos']
                );
            }

            $response = json_encode($clientsLocation);

            header('Content-Type: application/json');
            echo $response;
		}
	}
}


 ?>