<?php
require 'backend/config.php';
?>
<?php

if(isset($_GET['logout'])) {
	setcookie("usuariotab","",time()-3600);
	header('Location: /');
	exit;
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
                        <?php
                        if(isset($_COOKIE['usuariotab']) && $_COOKIE['usuariotab'] != ""){
                            echo '<li><a href="/perfil.php">'.$_COOKIE['usuariotab'].'</a></li>';
                        } else {
                            echo '<li><a href="/signup.php">Log in</a></li>';
                        } ?>
						<!--<li><a href="/perfil.php">Perfil</a></li>-->
						<li><a href="#">Noticias</a></li>
						<li><a href="#">Contacto</a></li>
						<li><input id="buscar" type="text" placeholder="Buscar servicio" size="15"></li>
					</ul>
				</div>
				<div id="menusecundario">
					<ul>
						<li><a href="index.php">Todo</a></li>
						<li><a href="index.php?categoria=Jardinería">Jardinería</a></li>
						<li><a href="index.php?categoria=Fontanería">Fontanería </a></li>
						<li><a href="index.php?categoria=Electricidad">Electricidad</a></li>
						<li><a href="index.php?categoria=Cuidado de Personas">Cuidado de Personas</a></li>
						<li><a href="index.php?categoria=Música">Música</a></li>
						<li><a href="index.php?categoria=Idiomas">Idiomas</a></li>
						<li><a href="index.php?categoria=Otros">Otros</a></li>
						
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
						$categoriaServicio = $_GET['categoria'];

					
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

							
							if ($categoriaServicio != null) {
								if ($categoriaServicio == $category) {
									echo '<div class="servicio '.$class.'" data_category="'.$category.'"><h4>'.$category.'</h4><p>'.$name.'</p>
                             		<a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser().'"><u>Ver</u></a></div>';
								}
							}
							else {
									echo '<div class="servicio '.$class.'" data_category="'.$category.'"><h4>'.$category.'</h4><p>'.$name.'</p>
                            		<a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser().'"><u>Ver</u></a></div>';
							 }
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