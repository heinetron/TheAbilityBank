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
						<li><a href="#">Mi sesión</a>
							<!--ul class="dropdown">
								<li><a href="#">Correo interno</a></li>
								<li><a href="#">Editar perfil</a></li>
								<li><a href="#">Salir</a></li>
							</ul-->
						</li>
						<li><a href="#">Crear servicio</a>
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

				<div id="seleccion">
					<table>
						<tr>
							<td id="b_todo" onclick="Todo()">TODO</td>
							<td id="b_ofer" onclick="Offer()">OFERTAS</td>
							<td id="b_deman" onclick="Demand()">DEMANDAS</td>
						</tr>
					</table>
				</div>
				<hr>
			</div>

            <div id="principal">
                <div id="lista">
                    <?php
						foreach(Service::getAll() as $service){
							$name = $service->getName();
                            $category = $service->getCategory()->getName();
                            $description = $service->getDescription();
							$class = "ofertas";
							if ($service->getServiceType() == Service::TYPE_OFFER){
								$class = "ofertas";
							} else {
								$class = "demandas";
							}
                            echo '<div class="servicio '.$class.'"><h4>'.$category.'</h4><p>'.$name.'</p>
                             <a href="index.php?deleteService='.$service->getID().'">Delete</a></div>';
						}
                    ?>
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