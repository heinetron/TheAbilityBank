<?php

	require 'backend/config.php';

	////////////////////////////////// USER TESTS ///////////////////////////////////
	// // CREATE, UPDATE, DELETE: OK
	// $user = new User();
	// $user->setName("Usuario3");
	// $user->setEmail("usuario3@mail.com");
	// $user->setPremium(1);
	// $user->setPassword("usuario_p");
	
	// //$user->save();
	// //$user->delete();
	// //$user->update();
	// foreach(User::getAll() as $user){
		// echo $user;
		// echo "</br>";
	// }

	// // LOAD : OK
	 // $user1 = User::withID(1);
	// echo $user1;
	// $user2 = User::withName("usuario2");
	// echo $user2;

	// PASSWORD TEST: OK
	// $password = "usuario_p"; //correcta
	// $password = "incorrecta";
		// echo "</br>";echo "</br>";

	// if($user1->checkPassword($password)){
		 // echo "Password verified</br>";
		 // echo $user1->getName();
	// } else {
		 // echo "Wrong password";
	// }
	// foreach(User::getAll() as $user){
		// echo $user;
		// echo "</br>";
	// }
	
	////////////////////////////////// service TESTS ///////////////////////////////////
	// // CREATE, UPDATE, DELETE: OK
	 // $service = new Service(Service::TYPE_DEMAND);
	 // $service->setName("Mecanico de bicicletas");
	 // $service->setDescription("Se busca mecanico de bibicletas para arreglar la rueda de atras de mi Yamaha");
	 // $category = Category::withName("Otros");
	 // $service->setCategory($category);
	 // $user = User::withName("Usuario3");
	 // $service->setUser($user);
	// $service->save();
	// //$service->delete();
	// //$service->update();
	//foreach(Service::getAll(Service::TYPE_DEMAND) as $service){
	//	echo $service;
	//	echo "</br>";
	//}	
	
	
		////////////////////////////////// message TESTS ///////////////////////////////////
	// $asunto="Paco como estas?";
	// $cuerpo="Ieeeeeee Paco que es de tu vida etc.";
	// $leido=0;
	// $fecha_envio=12122013;
	// $emisor=12;
	// $receptor=54;
	
	// $db = new DB();
	// $db->createMessageTable();
	// $db->insertMessage($asunto, $cuerpo, $leido, $fecha_envio, $emisor, $receptor);
	// $db->insertMessage($asunto, $cuerpo, $leido, $fecha_envio, $emisor, $receptor);
	// $db->insertMessage($asunto, $cuerpo, $leido, $fecha_envio, $emisor, $receptor);
	// $db->insertMessage($asunto, $cuerpo, $leido, $fecha_envio, $emisor, $receptor);
	
	// $db->updateMessage(42,"Fila modificada", "Esta fila ha sido modificada", $leido, "666666", $emisor, $receptor);
	
	// $db->deleteMessage(1);
	
	//$db->printTable('Mensaje');
	
	
	// echo Message::withID(45);
	
	//echo Message::toString();
	
	 // $mensajitos=Message::getMessagesByUserId(12);
	 // var_dump($mensajitos);
	
?>