<?php
include 'backend/config.php';
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
                    <td id="b_todo" onclick="Intereses()">INTERESES EN MIS POSTS</td>
                    <td id="b_todo" onclick="Mensajes()">MENSAJES PRIVADOS</td>
                    <td id="b_todo" onclick="Notificaciones()">NOTIFICACIONES</td>


                </tr>
            </table>
            <hr>
        </div>

        <div id="principal">

            <table id="publicaciones">
                <?php
                $username= $_COOKIE['usuariotab'];
				
				$messages = Message::getMessagesByUserName($username);
                if($messages != null){
					foreach($messages as $message){
						$senderID = $message->getSender();
						$sender = User::withID($senderID);
						$date = $message->getDate();
						$subject = $message->getSubject();
						$body = $message->getBody();
						$read = $message->getRead();

						echo '<tr><td>'.$sender->getName().'</td> <td> '.$date.'</td> <td> '.$subject.'</td> <td> '.$body.'</td>
										<td id="leido">Leído</td>
										<td id="borrar">Borrar</td>';
					}
				}
                ?>


            </table>


        </div>
        <script>
            function Intereses(){
                $(".interests").show();
                $(".msg").hide();
                $(".notices").hide();
            }

            function Mensajes(){
                $(".interests").hide();
                $(".msg").show();
                $(".notices").hide();
            }

            function Notificaciones(){
                $(".interests").hide();
                $(".msg").hide();
                $(".notices").show();
            }
            </script>


         </body>
</html>