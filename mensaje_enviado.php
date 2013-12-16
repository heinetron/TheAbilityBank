<?php
include 'backend/config.php';

function delete($get){
    if(isset($get['deleteMessage'])){
        // TODO pop up "do you really want to delete it?"
        //echo "Delete service with id" . $get['deleteService'];
        Message::withID($get['deleteMessage'])->delete();
    }
}

function noreadMessage($get){
    if(isset($get['noreadMessage'])){
        // TODO pop up "do you really want to delete it?"
        //echo "Delete service with id" . $get['deleteService'];
        $message = Message::withID($get['noreadMessage']);
        $message->setRead(0);
        $message->update();
    }
}

function readMessage($get){
    if(isset($get['readMessage'])){
        // TODO pop up "do you really want to delete it?"
        //echo "Delete service with id" . $get['deleteService'];
        $message = Message::withID($get['readMessage']);
        $message->setRead(1);
        $message->update();
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
                <li><a href="/index.php">Home</a></li>
                <?php
                if(isset($_COOKIE['usuariotab']) && $_COOKIE['usuariotab'] != ""){
                    echo '<li><a href="/perfil.php">'.ucfirst($_COOKIE['usuariotab']).'</a></li>';
                } else {
                    echo '<li><a href="/signup.php">Log in</a></li>';
                    echo "<script>window.location = 'http://theabilitybank.dyndns.org/'</script>";
                } ?>
                <li><a href="#">Noticias</a></li>
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
            </ul>
        </div>
        <div id="seleccion">
            <table>
                <tr>
                    <td id="b_todo" onclick="Recived()">MENSAJES RECIBIDOS</td>
                    <td id="b_todo" onclick="Sended()">MENSAJES ENVIADOS</td>
                    <td id="b_todo"><a href="/mensaje_nuevo.php">ENVIAR</td>


                </tr>
            </table>
            <hr>
        </div>

        <div id="principal">
			<?php
			 if($_POST['button'] == 'Enviar mensaje'){
                    // send_message();
					
					$user = User::withName($_COOKIE['usuariotab']);
					$receiver = User::withName($_POST['receiver']);
					
					$message = new Message();
					$message->setSubject($_POST['subject']);
					$message->setBody($_POST['body']);
					$message->setRead(0);
					$message->setDate(1111111);
					$message->setSender($user->getID());
					$message->setReceiver($receiver->getID());
					if($message->save()) {
						echo "<h1>Mensaje enviado</h1>";
					}
					else {
						echo "<h1>Error al enviar el mensaje</h1>";
					}
					echo '<form name="form1" method="POST" action="perfil_mensajes.php">
						<input type="Submit" name="back_button" value="Ver mis mensajes">
						</form>';
                }
			?>
        </div>
        <script>
            function Recived(){
                $(".recive").show();
                $(".send").hide();

            }

            function Sended(){
                $(".recive").hide();
                $(".send").show();

            }
        </script>


         </body>
</html>
