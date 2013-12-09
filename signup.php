<?php
include 'backend/config.php';
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

function correctLogin($post){
	$valid = false;
	if($post['RegisterButton'] == 'Entrar'){
		if(checkValidLogin($post['FullNameText'], $post['PasswdText'])){
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
							<!--ul class="dropdown">
								<li><a href="#">Crear demanda</a></li>
								<li><a href="#">Crear oferta</a></li>
								<!--<li><h3><a href="javascript:void(0)" onclick = "document.getElementById('light').style.display='block';
									   document.getElementById('fade').style.display='block'">Crear oferta</a></h3></li>
								<div id="light" class="white_content">

									<form action="crear_oferta.php" method="post">
										<div id="titformO">Título </div>

										<input id="tittxtformO" type=text name="tituloOferta"  width="...">
										<br>
										<br>
										<label id="catformO">Categoría</label>
										<select id="selformO" name="CategoriaOferta">
											<option value="Todo">Todo</option>
											<option value="Jardineria">Jardinería</option>
											<option value="Fontaneria">Fontanería</option>
											<option value="Electricidad">Electricidad</option>
											<option value="Cuidados de Personas">Cuidados de Personas</option>
											<option value="Idiomas">Idiomas</option>
											<option value="Musica">Música</option>
											<option value="Otros">Otros</option>
										</select>
										<br>
										<br>
										<label id="descformO" >Descripción</label>
										<textarea rows= "6" cols="40" id="desctxtformO" name="DescripcionOferta">
										</textarea>
										<br>
										<br>
										<a href="/index.php"><input type="submit" id="pubformO" name="Publicar" value="Publicar" onclick="irInicio()"/></a>
										<a href="/index.php"><input type="button" id="cancformO"name="Cancelar" value="Cancelar" /></a>
									</form>

									<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';
									document.getElementById('fade').style.display='none'">Close</a>
								</div>
								<div id="fade" class="black_overlay"></div>
								<li><h3><a href="javascript:void(0)" onclick = "document.getElementById('light').style.display='block';
									   document.getElementById('fade').style.display='block'">Crear demanda</a></h3></li>
								<div id="light" class="white_content">

									<form action="crear_demanda.php" method="post">
										<div id="titform">Título </div>


										<input id="tittxtform" type="text" name="tituloDemanda" style="width:320px">
										<br>
										<br>
										<label id="catform">Categoría</label>
										<select id="selform" name="CategoriaDemanda">
											<option value="todo">Todo</option>
											<option value="Jardineria">Jardinería</option>
											<option value="Fontaneria">Fontanería</option>
											<option value="Electricidad">Electricidad</option>
											<option value="Cuidados de Personas">Cuidados de Personas</option>
											<option value="Idiomas">Idiomas</option>
											<option value="Musica">Música</option>
											<option value="Otros">Otros</option>
										</select>
										<br>
										<br>
										<label id="descformD" >Descripción</label>
										<textarea rows= "6" cols="40" id="desctxtform" name="descripcionDemanda">
										</textarea>
										<br>
										<br>
										<a href="/index.php"><input type="submit" id="pubformD" name="Publicar" value="Publicar" onclick="irInicio()"/></a>
										<a href="/index.php"><input type="button" id="cancformd" name="Cancelar" value="Cancelar" /></a>
									</form>

									<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';
									document.getElementById('fade').style.display='none'">Close</a>
								</div>
								<div id="fade" class="black_overlay"></div>
							</ul -->
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
			</div>
			<div id="principal">			
				<div id="loginbox">
				<div id="logincontent">	
					<div id="registerform">
							
						<h5>Si todavía no tienes una cuenta</h5>

						<form Name="form1" Method="POST" Action="registro.php">
						
						<p>Nombre completo</p>
						<input type="Text" Name="FullNameText" placeholder="Nombre Apellidos">
						
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
			
						<h5>Si ya eres cliente</h5>
							
						<form name="form1" method="POST" action="signup.php">
						<?php if ($_POST){
							$style="";
							if(correctLogin($_POST)){
								echo "<script>window.location = 'http://theabilitybank.dyndns.org/'</script>";
							} else {
								$style='style="border: 2px solid red"';
								echo '<div class="wrongdata">Datos incorrectos</div>';
							}
						}
						?>						
						<p>Nombre completo</p>
						<input type="Text" name="FullNameText" placeholder="Nombre Apellidos" <?php echo $style?>>
						
						<p>Contraseña</p>
						<input type="password" name="PasswdText" placeholder="Contraseña" autocomplete="off" <?php echo $style?>>
						
						<p> <input type="Submit" name="RegisterButton" value="Entrar"> </p>
						
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
