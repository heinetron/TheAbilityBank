<?php
include 'backend/config.php';

// If the user is blocked, nothing to do here
$user = User::withName($_COOKIE['usuariotab']);
$banDate = $user->getBanDate();
if($banDate != 0 && time() < $banDate)
	header('Location: /youAreBlocked.php');
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
                <li><input id="buscar" type="text" placeholder="Buscar servicio" size="15"></li>
            </ul>
        </div>
        <div id="menuperfil">
            <ul>
                <li><a href="/perfil.php">Publicaciones</a></li>
                <li><a href="/perfil_mensajes.php">Mensajes</a></li>
                <li><a href="/perfil_editar.php">Editar</a></li>
                <li><a href="/index.php?logout">Cerrar sesión</a></li>
                <li><a href="/perfil_fichas.php">Comprar monedas</a></li>
            </ul>
        </div>
    </div>
    <div id="perfil">
        <div id="label_edit">
            <p>Destinatario </p>
            <br>
            <p>Asunto </p>
            <br>
            <p>Cuerpo </p>

        </div>
        <form name="form1" method="POST" action="mensaje_nuevo.php">
            <div id="input_editar">


                <?php
                $user = User::withName($_COOKIE['usuariotab']);

                ?>

                <p></p>

                <input id="inputstyle" type=text name="receiver">
                <p></p>
                <br>
                <input id="inputstyle" type=text name="subject">
                <p></p>
                <br>
                <textarea name="body" id="textareastyle" onfocus="this.value=''; setbg('#e5fff3');" onblur="setbg('white')"></textarea>
                <p></p>
                <br>
                <input id="button" type="Submit" name="button" value="Enviar mensaje">
				<?php
				if(isset($_POST['button'])) {
				 if($_POST['button'] == 'Enviar mensaje'){
						$date_array = getdate();
						$user = User::withName($_COOKIE['usuariotab']);
						$receiver = User::withName($_POST['receiver']);
						
						if($user->getID() != $receiver->getID() and $receiver != null) {
							$message = new Message();
							$message->setSubject($_POST['subject']);
							$message->setBody($_POST['body']);
							$message->setRead(0);
							$message->setDate(time());
							$message->setSender($user->getID());
							$message->setReceiver($receiver->getID());
                            $message->setNotification(0);
							$message->save();
                            echo "<script>window.location = '/perfil_mensajes.php'</script>";
						}
						
						else {
							echo "Error al enviar el mensaje. Comprueba el destinatario";
						}
					}
				}
				?>


            </div>


        </form>
		
    </div>

</div>

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
