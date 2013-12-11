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
                if(isset($_COOKIE['usuariotab'])){
                    echo '<li><a href="/perfil.php">'.$_COOKIE['usuariotab'].'</a></li>';
                } else {
                    echo '<li><a href="/signup.php">Log in</a></li>';
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
                <li><a href="/index.php?logout">Salir</a></li>
            </ul>
        </div>


        <div id="principal">

            <table id="publicaciones">
                <?php
                foreach(Service::getAll() as $service){
                    $name = $service->getName();
                    $category = $service->getCategory()->getName();
                    $description = $service->getDescription();

                    echo '<tr><td>'.$category.'</td> <td> '.$name.'</td> <td> '.$description.'</td>
                             <td id="modificar">Modificar</td>
                             <td id="borrar"><a href="perfil.php?deleteService='.$service->getID().'&serviceType='.$service->getServiceType().'">Borrar</a></td></tr>';
                }
                ?>


            </table>


        </div>


</body>
</html>
