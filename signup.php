<?php
include 'backend/config.php';
?>
<?php

function delete($get){
    if(isset($get['deleteService'])){
		// TODO pop up "do you really want to delete it?"
        //echo "Delete service with id" . $get['deleteService'];
        Service::withID($get['deleteService'])->delete();
    }
}

if ($_GET){
    delete($_GET);
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
			
			<!--
            <div id="principal">
				<fieldset>
            <label for="user_email">With your email</label>
            <input class="required email" id="user_email" name="user[email]" placeholder="e.g. me@domain.com" size="30" type="email">
            <label for="user_full_name">Full Name</label>
            <input class="required" id="user_full_name" maxlength="80" name="user[full_name]" placeholder="First Last" size="80" type="text" value="">
            <div class="form-nested">
              <label for="user_password">Password</label>
              <input autocomplete="off" class="required form-small" id="user_password" minlength="4" name="user[password]" size="30" type="password">
            </div>
            <div class="form-nested second-to-last">
              <label for="user_password_confirmation">Confirm Password</label>
              <input autocomplete="off" class="required form-small" equalto="#user_password" id="user_password_confirmation" minlength="4" name="user[password_confirmation]" size="30" type="password">
            </div>
          
            <input id="sign_up_code" name="sign_up_code" title="Promo code" type="hidden">
            <button type="submit" class="btn btn-small btn-submit ralign" id="registration-submit" tabindex="">Sign up</button>
          </fieldset>
            </div>
			-->
			
			<div id="principal">
			
			<Form Name="form1" Method="POST" Action="variables.php">
			
			<p>Nombre completo:</p>
			<input type="Text" Name="FullNameText" Value="Nombre Apellidos">
			
			<p>Email:</p>
			<input type="Text" Name="EmailText" Value="Email">
			
			<p>Contraseña</p>
			<input type="Text" Name="PasswdText" Value="Contraseña">
			
			<p>Confirma la contraseña:</p>
			<input type="Text" Name="ConfirmedPasswdText" Value="Contraseña (otra vez)">
			
			<p> <input type="Submit" Name="RegisterButton" Value="Registrarse"> </p>
			
			</Form>
			
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