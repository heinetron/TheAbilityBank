<?php

	require_once(dirname(__FILE__) . '/backend/config.php');

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
	// //$password = "usuario_p"; //correcta
	// $password = "incorrecta";
		// echo "</br>";echo "</br>";
	// if($user1->checkPassword($password)){
		// echo "Password verified";
	// } else {
		// echo "Wrong password";
	// }

	
	////////////////////////////////// service TESTS ///////////////////////////////////
	// // CREATE, UPDATE, DELETE: OK
	 // $service = new Service(Service::TYPE_DEMAND);
	 // $service->setName("Clases sueco");
	 // $service->setDescription("Se busca profesor de sueco");
	 // $category = Category::withName("Idiomas");
	 // $service->setCategory($category);
	 // $user = User::withName("Usuario3");
	 // $service->setUser($user);
	
	// $service->save();
	// //$service->delete();
	// //$service->update();
	// foreach(Service::getAll(Service::TYPE_DEMAND) as $service){
		// echo $service;
		// echo "</br>";
	// }	

?>