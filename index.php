<?php
	require 'backend/config.php';
?>
<?php

function printService($class, $service, $categoriaServicio){
	$html = '<div class="servicio '.$class.'" data_category="'.$service->getCategory()->getName().'">
             <a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria='.$categoriaServicio.'">
			 <h4>'.$service->getCategory()->getName().'</h4>
			 <p>'.substr($service->getName(),0,20).'</p>
			 <u>Ver</u>
			</a></div>';
	return $html;
}

if(isset($_GET['logout'])) {
	setcookie("usuariotab","",time()-3600);
	header('Location: /');
	exit;
}
?>

<html>
	<head>
        
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
                            $user=User::withName($_COOKIE['usuariotab']);
                            $i = 0;
                            foreach(Message::getMessagesByUserName($user->getName()) as $message){
                                $receiverID = $message->getReceiver();
                                $receiver = User::withID($receiverID);
                                $read = $message->getRead();
                                if($receiver == $user)
                                    if($read==0)
                                        $i++;
                            }

                            echo '<li><a href="/perfil_mensajes.php">'.ucfirst($_COOKIE['usuariotab']).' '."<u>$i</u>".'</a></li>';

                        } else {
                            echo '<li><a href="/signup.php">Log in</a></li>';
                        } ?>
						<!--<li><a href="/perfil.php">Perfil</a></li>-->
						<li><a href="#">Noticias</a></li>
						<li><a href="#">Contacto</a></li>
						<li><form id="formBus" name="formBus" method="get" action="" >
                                <input id="buscar" name="buscar" type="text" placeholder="BuscarServicio" size="15" >

                            </form></li>
					</ul>
                    <script>
                        document.formBus.submit();
                        function Buscar(){
                            self.open("/index.php","_self");
                            window.location= "?buscar="document.formBus['buscar'];

                        }
                    </script>
				</div>
				<div id="menusecundario">
					<ul>
						<li><a href="index.php">Todo</a></li>
					<?php	
						foreach(Category::getAll() as $category) {
							
							echo '<li><a href="index.php?categoria='.$category->getName().'">'.$category->getName().'</a></li>';
						}
					?>
						
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

						if ($service->getServiceType() == Service::TYPE_OFFER){
							$class = "ofertas";
						} else {
							$class = "demandas";
						}


						if ($categoriaServicio != "vacio") {
							if ($categoriaServicio == $service->getCategory()->getName()) {
								echo printService($class, $service, $categoriaServicio);
							}
						}
						else if ($buscarServicio != "vacio" && $buscarServicio != null) {
							if (strstr($service->getDescription(), $buscarServicio)) {
								echo printService($class, $service, $categoriaServicio);
							}
						}
						else {
								echo printService($class, $service, $categoriaServicio);
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
