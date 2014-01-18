<?php
include 'backend/config.php';



function delete($get){
    if(isset($get['deleteService'])){
		// TODO pop up "do you really want to delete it?"
        //echo "Delete service with id" . $get['deleteService'];
        Service::withID($get['deleteService'],$get['serviceType'])->delete();
    }
}

if ($_GET){
    delete($_GET);
}

// If the user is blocked, nothing to do here
$user = User::withName($_COOKIE['usuariotab']);
$banDate = $user->getBanDate();
if($banDate != 0 && time() < $banDate)
	header('Location: /youAreBlocked.php');

?>

<html>
<head>

    <title>The Ability Bank</title>
    <link rel="shortcut icon" href="/icon.png">
    <link rel="stylesheet" href="estilos_heine.css">
    <link rel="stylesheet" href="reveal.css">
    <link href=' http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script>
    <script type="text/javascript" src="jQuery/jquery.reveal.js"></script>

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
                <li><a href="#" data-reveal-id="myModal">Notificaciones</a></li>
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
        <div id="menuperfil">
            <ul>
                <li><a href="/perfil.php">Publicaciones</a></li>
                <li><a href="/perfil_mensajes.php">Mensajes</a></li>
                <li><a href="/perfil_editar.php">Editar</a></li>
                <li><a href="/index.php?logout">Cerrar sesi&oacute;n</a></li>
                <li><a href="/perfil_fichas.php">Comprar monedas</a></li>
            </ul>
        </div>
        <div id="seleccion">
            <table>
                <tr>
                    <td id="b_todo" onclick="NewService()">CREAR OFERTA/DEMANDA</td>
                </tr>
            </table>
            <hr>
        </div>


        <div id="principal">

            <table id="publicaciones">
                <?php
				
                $username=$_COOKIE['usuariotab'];
				$user = User::withName($username);
				$services=Service::getAllByUserName($user->getID());
				foreach(Service::getAllByUserID($user->getID()) as $service){
                    $type = $service->getServiceType();
					$name = $service->getName();
					$category = $service->getCategory()->getName();
					$description = $service->getDescription();
                    if($type == "Offer")
                        echo '<tr> <td>Oferta</td> <td>'.$category.'</td> <td> '.$name.'</td> <td> '.$description.'</td>

                                 <td id="modificar"><a href ="modify_service.php?modifiyService='.$service->getID().'&serviceType='.$service->getServiceType().'&serviceName='.$service->getName().' &serviceDescription='.$service->getDescription().' &serviceCategory=' .$service->getCategory().'">Modificar</a></td>
                                 <td id="borrar"><a href="perfil.php?deleteService='.$service->getID().'&serviceType='.$service->getServiceType().'">Borrar</a></td></tr>';
				    else
                        echo '<tr> <td>Demanda</td> <td>'.$category.'</td> <td> '.$name.'</td> <td> '.$description.'</td>
                                 <td id="modificar">Modificar</td>
                                 <td id="borrar"><a href="perfil.php?deleteService='.$service->getID().'&serviceType='.$service->getServiceType().'">Borrar</a></td></tr>';
                }
				
                ?>


            </table>


        </div>

        <script>

            function NewService(){
                self.open("/createservice.php", "_self");
            }

        </script>


        <div id="myModal" class="reveal-modal">
            <?php
            if(isset($_COOKIE['usuariotab']) && $_COOKIE['usuariotab'] != ""){
                $user=User::withName($_COOKIE['usuariotab']);
                $i = 0;
                foreach(Message::getMessagesByUserName($user->getName()) as $message){
                    $receiverID = $message->getReceiver();
                    $receiver = User::withID($receiverID);
                    $read = $message->getRead();
                    $notification = $message ->getNotification();
                    if($receiver == $user && $notification == 1 && $read==0){
                        $i++;
                        $subject = $message->getSubject();
                        $body = $message->getBody();
                        echo '<h1>'.$subject.'</h1>';
                        echo '<p>'.$body.'</p>';
                        echo '<a class="close-reveal-modal">&#215;</a>
                                <hr>';
                    }
                }
                if($i == 0){
                    echo '<h1>No hay notificaciones</h1>';
                    echo '<a class="close-reveal-modal">&#215;</a>
                                <hr>';
                }
            }
            ?>
        </div>

</body>
</html>
