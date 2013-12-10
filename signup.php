<?php
require 'backend/config.php';
?>
<?php
function checkValidLogin($username, $password){
	$valid = false;
	if($username!="" and $password!=""){
		$user = User::withName($username);
		if($user->getName() != NULL){
			if($user->checkPassword($password)){
				$valid = true;
			}
		}
	}
	return $valid;
}

function validLogin($post){
	$valid = false;
	if($post['RegisterButton'] == 'Iniciar sesión'){
		if(checkValidLogin($post['UserNameText'], $post['PasswdText'])){
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
						<li id="logo"></li>
						<li><a href="/perfil.php">Perfil</a>
							<!--ul class="dropdown">
								<li><a href="#">Correo interno</a></li>
								<li><a href="#">Editar perfil</a></li>
								<li><a href="#">Salir</a></li>
							</ul-->
						</li>
						<li><a href="#">Publicaciones</a>
						</li>
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
			<div id="principal">			
				<div id="loginbox">
				<div id="logincontent">	
				
					<div id="registerform">
						
						<h2>Regístrate</h2>
						<h5>Si todavía no tienes una cuenta</h5>

						<form Name="form1" Method="POST" Action="registro.php">
						
						<p>Nombre de usuario:</p>
						<input type="Text" Name="UserNameText" placeholder="Nombre de usuario">
						
						<p>Email</p>
						<input type="Text" Name="EmailText" placeholder="Email">
						
						<p>Contraseña</p>
						<input type="password" Name="PasswdText" placeholder="Contraseña" autocomplete="off">
						
						<p>Confirma la contraseña:</p>
						<input type="password" Name="ConfirmedPasswdText" placeholder="Contraseña (otra vez)" autocomplete="off">
						
						<p> <input type="Submit" Name="RegisterButton" Value="Registrarse"> </p>
						
						</form>
						
					</div>				
					<div id="loginform">
			
						<h2>Inicia sesión</h2>
						<h5>Si ya eres cliente</h5>
							
						<form name="form1" method="POST" action="signup.php">
						<?php if ($_POST){
							$style="";
							if(validLogin($_POST)){
								// meter cookies
								setcookie('usuariotab', $_POST['UserNameText'], time() + 365 * 24 * 60 * 60);
								echo "<script>window.location = 'http://theabilitybank.dyndns.org/'</script>";	
							} else {
								$style='style="border: 2px solid red"';
								echo '<div class="wrongdata">Datos incorrectos</div>';
							}
						}
						?>						
						<p>Nombre de usuario</p>
						<input type="Text" name="UserNameText" placeholder="Nombre de usuario" <?php echo $style?>>
						
						<p>Contraseña</p>
						<input type="password" name="PasswdText" placeholder="Contraseña" autocomplete="off" <?php echo $style?>>
						
						<p> <input type="Submit" name="RegisterButton" value="Iniciar sesión"> </p>
						
						</form>
						
					</div>	
				
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
