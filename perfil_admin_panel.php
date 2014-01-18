<?php
include 'backend/config.php';
?>
<html>
<head>
    <meta charset="utf-8">
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
                        <li><a href="/index.php?logout">Cerrar sesión</a></li>
                        <li><a href="/perfil_fichas.php">Comprar monedas</a></li>
						<?php
						$isAdmin = $user->getisAdmin();
						if($isAdmin)
							echo '<li><a href="/perfil_admin_panel.php">Panel administrador</a></li>';
						?>
                    </ul>
                </div>
            </div>
            <div id="panel_administrador">
               <h1>Bloquear usuarios<h1>
			   
			   <form name="blockUserForm" method="POST" action="perfil_admin_panel.php">
					<p> <input type="text" name="UserToBlock" placeholder="Usuario a bloquear"> </p>
					<p> <input type="text" name="BlockDuration" placeholder="Dias de bloqueo"> </p>
					<p> <input type="text" name="Reason" placeholder="Motivo del bloqueo"> </p>
					<p> <input type="text" name="Details" placeholder="Detalles"> </p>
					<input type="Submit" name="BlockUserButton" value="Bloquear usuario">
				</form>
            </div>

        </div>
		
		
		<?php
		if(isset($_POST["BlockUserButton"])) {
			if($_POST["BlockUserButton"] == "Bloquear usuario") {
				$userToBlock = User::withName($_POST["UserToBlock"]);
				$blockDuration = $_POST["BlockDuration"];
				$reason = $_POST["Reason"];
				$details = $_POST["Details"];
				
				// Sets the date when the block expires an updates the user
				$banDate = time() + ($blockDuration * 24 * 60 * 60);
				$userToBlock->setBanDate($banDate);
				$userToBlock->update();
				
				//Sends a message to the user
				$message = new Message();
				$message->setSubject("Tu cuenta ha sido bloqueada");
				$message->setBody("Nos hemos visto obligados a bloquear tu cuenta temporalmente. Motivo del bloqueo: " . $reason .
							"\nDurante los pr&oacute;ximos " . $blockDuration . " d&iacute;as, no podr&aacute;s efectuar la mayor&iacute;a de las operaciones propias de usuarios registrados.\n" . 
							"Detalles del bloqueo: " . $details . "\nEl bloqueo expira: " . date('d-m-Y H:i:s', $banDate));
				$message->setRead(0);
				$message->setDate(time());
				$message->setSender($user->getID());
				$message->setReceiver($userToBlock->getID());
				$message->setNotification(1);
				$message->save();
			}
		}
		?>

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
