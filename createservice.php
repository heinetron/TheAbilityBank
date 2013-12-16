<?php
require 'backend/config.php';
?>
<?php

if(isset($_GET['logout'])) {
    setcookie("usuariotab","",time()-3600);
    header('Location: /');
    exit;
}

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
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
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
        <div id="menuperfil">
            <ul>
                <li><a href="/perfil.php">Publicaciones</a></li>
                <li><a href="/perfil_mensajes.php">Mensajes</a></li>
                <li><a href="/perfil_editar.php">Editar</a></li>
                <li><a href="/index.php?logout">Cerrar sesión</a></li>
            </ul>
        </div>

    </div>


    <div id="createService">
        <div id="label_service">
            <label id="servformO">Tipo Servicio</label>
            <br><br><br><br>
            <label id="titformO">Título</label>
            <br><br><br><br>
            <label id="catformO">Categoría</label>
            <br><br><br><br>
            <label id="descformO" >Descripción</label>
        </div>
        <div id="input_service" >
            <form name="form2" action="createservice.php" method="post">

                <select id="selTipoformO" name="TipoServicio">
                    <option value="Oferta">Oferta</option>
                    <option value="Demanda">Demanda</option>
                </select>
                <br><br><br>
                <input id="tittxtformO" type=text name="tituloOferta"  width="...">
                <br><br><br>
                <select id="selformO" name="CategoriaOferta">
					<?php	
						foreach(Category::getAll() as $category) {
							echo '<option value="' . $category->getName() . '">' . $category->getName() . '</option>';
						}
					?>
                </select>
                <br><br><br>
                <textarea rows= "6" cols="40" id="desctxtformO" name="DescripcionOferta">
                </textarea>
                 <br>
                <br>
        
			<input type="submit" id="pubformO" name="Publicar" value="Publicar" />
			<input type="submit" id="cancformO" name="Cancelar" value="Cancelar" />
				<?php
				
				if ($_POST){
					if($_POST['Cancelar'] == 'Cancelar'){
						echo "<script>window.location = 'http://theabilitybank.dyndns.org/index.php'</script>";
						}

                    if($_POST['Publicar'] == 'Publicar'){
                        Publicar();
                        echo "<script>window.location = 'http://theabilitybank.dyndns.org/index.php'</script>";
                    }
                }
				?>
			</form>
		</div>
    </div>
</body>

</html>
