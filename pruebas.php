<?php

	require_once(dirname(__FILE__) . '/backend/config.php');

	$user1 = User::withID(1);
	echo $user1;
	
	$user2 = User::withName("usuario2");
	echo $user2;

	//$password = "usuario_p"; //correcta
	$password = "incorrecta";
		echo "</br>";echo "</br>";
	if($user1->checkPassword($password)){
		echo "Password verified";
	} else {
		echo "Wrong password";
	}
	
	$db = new DB();
	//$db->createUserTable();//OK
	//$name = "usuario2";  $password = "usuario_p"; $email = "usuario2@usuario.com";	$premium = 0;
	//$salt = md5( time() ); $password = hash('ripemd320',$salt . $password . $salt);
	//$db->insertUser($name, $email, $password, $salt, $premium); // OK
	$db->printTable("User");
	//echo $user;
	
?>