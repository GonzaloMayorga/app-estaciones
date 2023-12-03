<?php 
	

	/**
	 * 
	 */
	class User extends DBAbstract
	{

		public $email;
		private $password;
		private $register;
		
		function __construct($email)
		{
			$this->register = false;

			$sql = "SELECT * FROM `app-estacionUser` WHERE email = '$email'";

			$result = $this->query($sql);
			
			if($result->num_rows==0){
				$this->register = true;	
			}else{

				$row = $result->fetch_all(MYSQLI_ASSOC);

				$this->email = $email;
				// query que busca el email
				$this->password = $row[0]["contraseña"];	
 			
			}
		}

		public function login($pass){

			if(!$this->register){
				if($this->password==$pass){
					return array("errno" => 200, "error" =>"Usuario valido");
				}
				if($this->password != $pass){
					return array("errno" => 402, "error" => 'Contraseña incorrecta');
				}
				return array("errno" => 401, "error" => "Error de credenciales");
			}

			return array("errno" => 400, "error" => "<h1>Credenciales no válidas</h1>");
		}

		public function add($pass,$email){

			if($this->register){
				
				$token = md5($email);
				$token_action = md5($email);

				$sql = "INSERT INTO `app-estacionUser` ( `email`, `contraseña`, `token`, `token_action`) VALUES ( '$email', '$pass', '$token', '$token_action')";

				$this->query($sql);

				return array("errno" => 200, "error" => "Se agrego el usuario");
			}

			return array("errno" => 402, "error" => "el usuario ya existe en nuestra aplicacion, Inicie Sesion");

		}
		public function userState(){
			$sql = "SELECT `activo`, `bloqueado`, `recupero` FROM `app-estacionUser` WHERE email = '$this->email'";
			$result = $this->query($sql);
	  			if($result){
	  				$row = $result->fetch_all(MYSQLI_ASSOC);
	  				return $row[0];
	  			}else{
	  				return null;
	  			}
		}

		public function token_action($email){
	  			$sql = "SELECT `token_action` FROM `app-estacionUser` WHERE email = '$email'";
	  			$result = $this->query($sql);
	  			if($result){
	  				$row = $result->fetch_all(MYSQLI_ASSOC);
	  				return $row[0]['token_action'];
	  			}else{
	  				return null;
	  			}
	  	}	
		
		public function validate_token($token_action){
			$sql = "SELECT `activo` FROM `app-estacionUser` WHERE token_action = '$token_action'";
			$result = $this->query($sql);
			if($result){
				$row = $result->fetch_all(MYSQLI_ASSOC);
				if ($row == null) {
					return array("errno" => 405, "error" => "El token no corresponde a un usuario");
				}
				if($row[0]['activo'] == 0){
				 	$date = date("Y-m-d H:i:s");
				    $second = "UPDATE `app-estacionUser` SET `activo`='1', `token_action`= Null ,`active_date` = '$date' WHERE `token` = '$token_action'";
				    $secondR = $this->query($second);
				    return 1;
				}else{
					return 2;
				}
			}else{
				return null;
			}
		}

		public function newPass($email,$pass){
			$date = date("Y-m-d H:i:s");
			$sql = "UPDATE `app-estacionUser` SET `contraseña`='$pass',`bloqueado`='0',`recupero`='0',`token_action`=null WHERE email = '$email'";
			$result = $this->query($sql);
			return array("errno" => 200, "error" => "Contraseña actualizada");
		}

		public function searchUser($email){
			$sql = "SELECT `email` FROM `app-estacionUser` WHERE email = '$email'";
			$result = $this->query($sql);
			if($result){
				$row = $result->fetch_all(MYSQLI_ASSOC);
				if ($row == null) {
					return array("errno" => 409, "error" => "Ese email no esta registrado");
				}
				if($row[0]['email'] != ''){
					$token_action = md5($email);
					$date = date("Y-m-d H:i:s");
					$sql = "UPDATE `app-estacionUser` SET `recupero`='1', `token_action`='$token_action', `recover_date`='$date' WHERE `email` = '$email'";
					$this->query($sql);
					return array("errno" => 200, "error" => "El usuario paso a estado recuperado");
				}else{
					return 2;
				}
			}else{
				return null;
			}
		}

		public function blocked_token($token_action){
					$sql = "SELECT `bloqueado` FROM `app-estacionUser` WHERE token = '$token_action'";
					$result = $this->query($sql);
					if($result){
						$row = $result->fetch_all(MYSQLI_ASSOC);
						if ($row == null) {
							return array("errno" => 407, "error" => "El token no corresponde a un usuario");
						}
						if($row[0]['bloqueado'] == 0){
						 	$date = date("Y-m-d H:i:s");
						    $second = "UPDATE `app-estacionUser` SET `bloqueado`='1', `token_action`= '$token_action' ,`blocked_date` = '$date' WHERE `token` = '$token_action'";
						    $secondR = $this->query($second);
						    return 1;
						}else{
							return 2;
						}
					}else{
						return null;
					}
		}		

		public function getEmaiByToken($token){
			$sql = "SELECT `email`FROM `app-estacionUser` WHERE token = '$token'";
			$result = $this->query($sql);
	  			if($result){
	  				$row = $result->fetch_all(MYSQLI_ASSOC);
	  				if ($row == null) {
	  					return null;
	  				}
	  				return $row[0]['email'];
	  			}else{
	  				return null;
	  			}
		}

	  	public function token(){
	  			$sql = "SELECT `token` FROM `app-estacionUser` WHERE email = '$this->email'";
	  			$result = $this->query($sql);
	  			if($result){
	  				$row = $result->fetch_all(MYSQLI_ASSOC);
	  				return $row[0]['token'];
	  			}else{
	  				return null;
	  			}
		}
		public function getUsers(){
			$sql = "SELECT COUNT(*) as total_registros FROM `app-estacionUser`"; 
			$result = $this->query($sql);
			if($result){
				$row = $result->fetch_all(MYSQLI_ASSOC);
				return $row[0]["total_registros"];
		}	
	}
}

 ?>