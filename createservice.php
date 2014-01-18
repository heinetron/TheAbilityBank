<?php
require 'backend/config.php';
?>
<?php

if(isset($_GET['logout'])) {
    setcookie("usuariotab","",time()-3600);
    header('Location: /');
    exit;
}
// If the user is blocked, nothing to do here
$user = User::withName($_COOKIE['usuariotab']);
$banDate = $user->getBanDate();
if($banDate != 0 && time() < $banDate)
	header('Location: /youAreBlocked.php');
?>
<?php
function Publicar(){
    if($_REQUEST["tituloOferta"]){
        $valorNombre= $_REQUEST["tituloOferta"];
        //echo($valorNombre . "<br>");


        $valorCategoria= $_REQUEST["CategoriaOferta"];
        //echo($valorCategoria . "<br>");


        $valorDescripcion= $_REQUEST["DescripcionOferta"];
        //echo($valorDescripcion . "<br>");
        $valorTipo=$_REQUEST["TipoServicio"];
        //echo($valorTipo . "<br>");
        if($valorTipo=="Oferta"){
            $service = new Service(Service::TYPE_OFFER);
        }else{
            $service= new Service(Service::TYPE_DEMAND);
        }
        $service->setName($valorNombre);
        $service->setDescription($valorDescripcion);
        $category = Category::withName($valorCategoria);
        $service->setCategory($category);
        $user = User::withName($_COOKIE['usuariotab']);//Usuario de login? Recoger algo de sesion?
        $service->setUser($user);
//echo($offer);
        $service->save();
    }
    header('Location: /perfil.php');

}
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
                <!--<li><a href="/perfil.php">Perfil</a></li>-->
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

    </div>


    <div id="createService">
        <div id="label_service">
            <label id="servformO">Tipo Servicio</label>
            <br><br><br><br>
            <label id="titformO">T&iacute;tulo</label>
            <br><br><br><br>
            <label id="catformO">Categor&iacute;a</label>
            <br><br><br><br>
            <label id="descformO" >Descripci&oacute;n</label>
        </div>
        <div id="input_service" >
            <form name="form2" action="createservice.php" method="post">

                <select id="selectstyle" name="TipoServicio">
                    <option value="Oferta">Oferta</option>
                    <option value="Demanda">Demanda</option>
                </select>
                <br><br><br>
                <input id="inputstyle" type=text name="tituloOferta"  width="...">
                <br><br><br>
                <select id="selectstyle" name="CategoriaOferta">
					<?php	
						foreach(Category::getAll() as $category) {
							echo '<option value="' . $category->getName() . '">' . $category->getName() . '</option>';
						}
					?>
                </select>
                <br><br><br>
                <textarea name="DescripcionOferta" id="textareastyle" onfocus="this.value=''; setbg('#e5fff3');" onblur="setbg('white')"></textarea>
                 <br>
                <br>
        
			<input type="submit" id="button" name="Publicar" value="Publicar" />
			<input type="submit" id="button" name="Cancelar" value="Cancelar" />
				<?php
				
				if ($_POST){
					if($_POST['Cancelar'] == 'Cancelar'){
						echo "<script>window.location = 'http://theabilitybank.dyndns.org/perfil.php'</script>";
						}

                    if($_POST['Publicar'] == 'Publicar'){
                        Publicar();
                        echo "<script>window.location = 'http://theabilitybank.dyndns.org/perfil.php'</script>";
                    }
                }
				?>
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

<script>
    function setbg(color)
    {
        document.getElementById("styled").style.background=color
    }
</script>

</html>
