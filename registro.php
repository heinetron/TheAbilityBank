<?php

include 'backend/config.php';

function checkValidRegister($name, $email, $password, $re_password) {
	$valid=false;
	if(($name != "") && ($email != "") && ($password != "") && ($re_password != "")) {
		// FALTA COMPROBAR QUE EL USUARIO NO EXISTE YA
		if($password == $re_password) {
			$valid = true;
		}
	}
	return $valid;
}

	$name = $_POST["UserNameText"];
	$email = $_POST["EmailText"];
	$password = $_POST["PasswdText"];
	$confirmed_password = $_POST["ConfirmedPasswdText"];

if($_POST['RegisterButton'] == 'Registrarse'){

	print($name . "\n");
	print($email . "\n");
	print($password . "\n");
	print($confirmed_password . "\n");
	
	
	if(checkValidRegister($name, $email, $password, $confirmed_password)) {
		$user = new User();
		$user->setName($name);
		$user->setEmail($email);
		$user->setPassword($password);
		$user->setPremium(0);
		$user->save();
		
		echo "Usuario registrado correctamente";
	}
	
	else echo "Registro no válido, comprueba los datos";
}

else {
	echo "Error";
}

?>
