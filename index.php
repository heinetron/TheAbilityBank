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
                        <li><a href="/index.php">Home</a></li>
                        <?php



                        if(isset($_COOKIE['usuariotab']) && $_COOKIE['usuariotab'] != ""){
                            echo '<li><a href="/perfil.php">'.ucfirst($_COOKIE['usuariotab']).'</a></li>';
                        } else {
                            echo '<li><a href="/signup.php">Log in</a></li>';
                        } ?>
						<!--<li><a href="/perfil.php">Perfil</a></li>-->
						<li><a href="#">Noticias</a></li>
						<li><a href="#">Contacto</a></li>
						<li><form id="formBus" name="formBus" method="get" action="" >
                                <input id="buscar" name="buscar" type="text" placeholder="BuscarServicio" size="15" >
                                <input id="Bbuscar" type="submit" VALUE="Buscar" onclick="Buscar()" >
                            </form></li>
					</ul>
                    <script>
                        function Buscar(){
                            window.location= "?buscar="document.formBus['buscar'];

                        }
                    </script>
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
                            <?php
                            if(isset($_COOKIE['usuariotab']) && $_COOKIE['usuariotab'] != ""){
                                echo '<td id="b_todo" onclick=ToMyPosts()>MIS PUBLICACIONES</td>';
                            }
                            else{
                                echo '<td id="b_todo" onclick=ToSignUp()>MIS PUBLICACIONES</td>';
                            }
                            if(isset($_COOKIE['usuariotab']) && $_COOKIE['usuariotab'] != ""){
                                echo '<td id="b_todo" onclick=ToCreateService()>CREAR OFERTA/DEMANDA</td>';
                            }
                            else{
                                echo '<td id="b_todo" onclick=ToSignUp()>CREAR OFERTA/DEMANDA</td>';
                            }
                            ?>

						</tr>
					</table>
                    <hr>
				</div>

			</div>


            <div id="principal">
                <div id="lista">
                    <?php
                    if (isset($_GET['categoria'])){
                        $categoriaServicio = $_GET['categoria'];
                    }
                    else {
                        $categoriaServicio = "vacio";
                    }

                    if (isset($_GET['buscar'])){
                        $buscarServicio = $_GET['buscar'];
                    }
                    else {
                        $buscarServicio = "vacio";
                    }

					
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


                            if ($categoriaServicio != "vacio") {
                                if ($categoriaServicio == $category) {
                                    echo '<div class="servicio '.$class.'" data_category="'.$category.'"><h4>'.$category.'</h4><p>'.$name.'</p>
                             		<a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria= '.$categoriaServicio.'"><u>Ver</u></a></div>';
                                }
                            }
                            else if ($buscarServicio != "vacio" && $buscarServicio != null) {
                                if (strstr($description, $buscarServicio)) {
                                    echo '<div class="servicio '.$class.'" data_category="'.$category.'"><h4>'.$category.'</h4><p>'.$name.'</p>
                            		<a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria='.$categoriaServicio.'"><u>Ver</u></a></div>';
                                }
                            }
                            else {
                                echo '<div class="servicio '.$class.'" data_category="'.$category.'"><h4>'.$category.'</h4><p>'.$name.'</p>
                            	<a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria='.$categoriaServicio.'"><u>Ver</u></a></div>';
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

            function ToMyPosts(){
                self.open("/perfil.php", "_self");

            }

            function ToSignUp(){
                self.open("/signup.php", "_self");
            }

            function ToCreateService(){
                self.open("/createservice.php", "_self")
            }


        </script>
    </body>

</html>