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

	
	////////////////////////////////// OFFER TESTS ///////////////////////////////////
	// CREATE, UPDATE, DELETE: PENDING
	// $offer = new Offer();
	// $offer->setName("Oferta3");
	// $offer->setDescription("Descripcion oferta 3");
	// $category = Category::withName("Pintura");
	// $offer->setCategory($category);
	// $user = User::withName("usuario");
	// $offer->setUser($user);
	
	
	// //$offer->save();
	// //$offer->delete();
	// //$offer->update();
	// foreach(Offer::getAll() as $offer){
		// echo $offer;
		// echo "</br>";
	// }	
	
	// //
	// // LOAD: OK
	//$offer1 = Offer::withID(1);
	//echo $offer1;
	//$offer2 = Offer::withName("Offer2");
	//echo $offer2;
?>
