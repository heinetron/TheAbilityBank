<?php
require 'backend/config.php';
?>
<?php

/*function delete($get){
    if(isset($get['deleteService'])){
		// TODO pop up "do you really want to delete it?"
        //echo "Delete service with id" . $get['deleteService'];
        Service::withID($get['deleteService'])->delete();
    }
}

if ($_GET){
    delete($_GET);
}
*/
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
						<li><a href="/perfil.php">Perfil</a></li>
						<li><a href="#">Noticias</a></li>
						<li><a href="#">Contacto</a></li>
                        <?php 
						if(isset($_COOKIE['usuariotab'])){
							echo '<li><a href="#">Hola '.$_COOKIE['usuariotab'].'</a></li>';
						} else {
							echo '<li><a href="/signup.php">Log in</a></li>';
						} ?>
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
                    <hr>
				</div>

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
                            <a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser().'"><u>Ver</u></a></div>';

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
