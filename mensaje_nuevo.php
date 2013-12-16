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
    </div>
    <div id="perfil">
        <div id="label_edit">
            <p>Destinatario </p>
            <p>Asunto </p>
            <br>
            <p>Cuerpo </p>

        </div>
        <form name="form1" method="POST" action="mensaje_enviado.php">
            <div id="input_editar">


                <?php
                $user = User::withName($_COOKIE['usuariotab']);

                ?>

                <p></p>

                <input type=text name="receiver">
                <p></p>
                <input type=text name="subject">
                <p></p>
                <textarea rows="4" cols="30" type=text name="body"></textarea>
                <p></p>
                <br><br><br>
                <input type="Submit" name="button" value="Enviar mensaje">



            </div>

        </form>
    </div>

</div>
</body>
</html>
