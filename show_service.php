<?php
include 'backend/config.php';

function printService($class, $service, $categoriaServicio){
	$html = '<div class="servicio '.$class.'" data_category="'.$service->getCategory()->getName().'">
             <a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria='.$categoriaServicio.'">
			 <h4>'.$service->getCategory()->getName().'</h4>
			 <p>'.substr($service->getName(),0,20).'</p>
			 <u>Ver</u>
			</a></div>';
	return $html;
}

session_start();

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
                <li><a href="/index.php">Home</a></li>
                <li id="logo"></li>
                <?php



                if(isset($_COOKIE['usuariotab']) && $_COOKIE['usuariotab'] != ""){

                    echo '<li><a href="/perfil.php">'.ucfirst($_COOKIE['usuariotab']).'</a></li>';
                } else {
                    echo '<li><a href="/signup.php">Log in</a></li>';
                } ?>

                <li><a href="#">Noticias</a></li>
                <li><a href="#">Contacto</a></li>

                <li><form id="formBus" name="formBus" method="get" action="" >
                        <input id="buscar" name="buscar" type="text" placeholder="BuscarServicio" size="15" >
                        <input id="Bbuscar" type="submit" VALUE="Buscar" onclick=href="index.php?buscar="document.formBus['buscar'] >
                    </form>
                </li>
            </ul>
        </div>
        <div id="menusecundario">
            <ul>
                <?php
				if(isset($_GET['service'])){
					$id2 = $_GET['service'];
					$_SESSION['service'] = $id2;
					$stype2 = $_GET['servicetype'];
					$_SESSION['servicetype'] = $stype2;
					$service = Service::withID($id2,$stype2);
					echo '<li><a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'">Todo</a></li>';
					
					foreach(Category::getAll() as $category) {	
						echo '<li><a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria='.$category->getName().'">'.$category->getName().'</a></li>';
					}
				}
				else if (isset($_SESSION['service'])){
					$id2 = $_SESSION['service'];
					$stype2 = $_SESSION['servicetype'];
					$service = Service::withID($id2,$stype2);
					echo '<li><a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'">Todo</a></li>';					
					
					foreach(Category::getAll() as $category) {	
						echo '<li><a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria='.$category->getName().'">'.$category->getName().'</a></li>';
					}

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

        </div>

       <hr>
    </div>

    <div id="principal">
            <?php
			if(isset($_GET['service'])){
				$id = $_GET['service'];
				$stype = $_GET['servicetype'];
				$serviceAuthor = $_GET['user'];

				$service = Service::withID($id,$stype);
				$name = $service->getName();
				$category = $service->getCategory()->getName();
				$description = $service->getDescription();
				$class = "ofertas";
				if ($service->getServiceType() == Service::TYPE_OFFER){
					$class = "ofertas_demandas";
					$type = "Oferta";
				} else {
					$class = "ofertas_demandas";
					$type = "Demanda";
				}
				//TODO link perfil publico  <input type="Submit" Name="ver_perfil" Value="Ver perfil de " $serviceAuthor>
				echo '<div class="servicio2 '.$class.'"><h4>'."Descripción de la ".$type." " .$name.'</h4><h5>'.$category.'</h5><p>'.$description.'</p>';
				echo '<form id="twoButtons" name="twoButtons" method="post" action="show_service.php" >
						<input type="Submit" Name="pedir_neg" Value="Solicitar negociación">
							  
							  </form>';
				echo '<h5>'.$type.' publicada por el usuario '.$serviceAuthor.'</h5></div>';
				$_SESSION['serviceAuthor'] = $serviceAuthor;
			}	
			
			if(isset($_POST['pedir_neg'])) {	
				if($_POST['pedir_neg'] == 'Solicitar negociación') {
					$serviceAuthor = User::withName($_SESSION['serviceAuthor']);
					$loggedUser = User::withName($_COOKIE['usuariotab']);
					if($loggedUser->getID() != $serviceAuthor->getID()){
						$message = new Message();
						$message->setSubject('Usuario interesado');
						$message->setBody('A un usuario le interesa tu oferta');
						$message->setRead(0);
						$message->setDate(time());
						$message->setSender($loggedUser->getID());
						$message->setReceiver($serviceAuthor->getID());
						$message->save();
						echo "Se le ha enviado un mensaje a " . $serviceAuthor->getName();
					} else {
						echo "¡No puedes negociar contigo mismo!";
					}
				}
			}
			
            ?>
        <hr>
        <div id="lista">
            <?php

                if (isset($_GET['categoria'])){

                    $categoriaServicio = $_GET['categoria'];
                }
			    else{
                    $categoriaServicio = "vacio";
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

                    if ($categoriaServicio != "vacio")  {
                        if ($categoriaServicio == $category) {
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
            $(".ofertas").show()
            $(".demandas").show();;
        }

        function Offer(){
            $(".ofertas").show();
            $(".demandas").hide();
        }

        function Demand(){
            $(".ofertas").hide();
            $(".demandas").show();
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
