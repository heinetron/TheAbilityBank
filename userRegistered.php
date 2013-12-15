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
?>

<html>
	<head>
        <meta charset="utf-8" />
		<title>The Ability Bank</title>
        <link rel="shortcut icon" href="/icon.png">
		<link rel="stylesheet" href="estilos_heine.css" type="text/css">
		<link href=' http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="jQuery/jquery-2.0.3.min.js"></script>

	</head>

    <body>
        <div id="total">
			<div id="cabecera" class="menu">
				<div id="menucabecera">
					<ul>
                        <ul>
                            <li id="logo"></li>
                            <li><a href="/index.php">Home</a></li>
                            <li><a href="/signup.php">Log in</a></li>
                            <li><a href="#">Noticias</a></li>
                            <li><a href="#">Contacto</a></li>
                            <li><input id="buscar" type="text" placeholder="Buscar servicio" size="15"></li>
                        </ul>					
				</div>
				<div id="menusecundario">
					<ul>
						<li><a href="#">Todo</a></li>
						<li><a href="#">Jardinería</a></li>
						<li><a href="#">Fontanería </a></li>
						<li><a href="#">Electricidad</a></li>
						<li><a href="#">Cuidado de Personas</a></li>
						<li><a href="#">Música</a></li>
						<li><a href="#">Idiomas</a></li>
						<li><a href="#">Otros</a></li>
						
					</ul>
				</div>
                <hr>
			</div>
			<div id="principal" >			
				<div id="loginbox" >
				<div id="logincontent" style="height: 200px;">	

					<?php

						$name = $_POST["UserNameText"];
						$email = $_POST["EmailText"];
						$password = $_POST["PasswdText"];
						$confirmed_password = $_POST["ConfirmedPasswdText"];

						if($_POST['RegisterButton'] == 'Registrarse'){
							if(checkValidRegister($name, $email, $password, $confirmed_password)) {
								$user = new User();
								$user->setName($name);
								$user->setEmail($email);
								$user->setPassword($password);
								$user->setPremium(0);
								if($user->save())							
									echo "<h1>Usuario registrado correctamente</h1>";
								else 
									echo "<h1>Ese usuario ya existe</h1>";
									echo '<form Name="form1" Method="POST" Action="signup.php">	
									<p> <input type="Submit" Name="BackToSignupButton" Value="Prueba un nombre distinto"> </p>';
							}							
							else echo "<h1>Error en el registro. Comprueba los datos</h1>";
						}
						else {
							echo "<h1>Error</h1>";
						}
						
						echo '<form Name="form1" Method="POST" Action="index.php">
						<p> <input type="Submit" Name="BackToIndexButton" Value="Volver al inicio"> </p>

						</form>';

					?>
				</div>
				</div>
			</div>
		</div>
        <script>
            function Todo(){
                $(".ofertas").show();
                $(".demandas").show();
            }

            function Offer(){
                $(".ofertas").show();
                $(".demandas").hide();
            }

            function Demand(){
                $(".ofertas").hide();
                $(".demandas").show();
            }
			
			
			
        </script>
    </body>

</html>







