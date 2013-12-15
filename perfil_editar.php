<?php
include 'backend/config.php';
?>

<?php
function change_profile(){
    $user = User::withName($_COOKIE['usuariotab']);
    $mail = $_POST["emailUser"];
    $user->setEmail($mail);
    $user->update();

}

function change_pass(){
    $user = User::withName($_COOKIE['usuariotab']);
    $actualpass = $_POST["actualpassUser"];
    if($user->checkPassword($actualpass)){
        $newpass = $_POST["newpassUser"];
        $repass = $_POST["confirmpassUser"];
        if($newpass == $repass){
            $user->setPassword($newpass);
            $user->update();
        }
    }
}

function delete_user(){
    $user = User::withName($_COOKIE['usuariotab']);
    $user->delete();
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
            </div>
            <div id="perfil">
                <div id="label_edit">
                    <p>Email </p>
                    <br><br><br><br><br>
                    <p>Contraseña actual </p>
                    <p>Contraseña nueva </p>
                    <p>Confirmar contraseña </p>

                </div>
                <form name="form1" method="POST" action="perfil_editar.php">
                    <div id="input_editar">

                        <p></p>
                        <?php
                            $user = User::withName($_COOKIE['usuariotab']);
                            echo '<input id="input" type=text Name="emailUser" placeholder="'.$user->getEmail().'">';
                        ?>



                        <p></p>
                        <input type="Submit" name="button" value="Actualizar perfil">

                        <p></p>
                        <br><br>
                        <input id="actualpass" type=password name="actualpassUser">
                        <p></p>
                        <input id="newpass" type=password name="newpassUser">
                        <p></p>
                        <input id="confirmpass" type=password name="confirmpassUser">
                        <p></p>
                        <input type="Submit" name="button" value="Actualizar contraseña">
                        <br><br><br><br>


                    </div>

                    <hr>
                    <br><br>
                    <input id="delete_button" type="Submit" name="button" value="Borrar cuenta">
                    <?php
                        if ($_POST){
                            if($_POST['button'] == 'Actualizar perfil'){
                                change_profile();
                                echo "<script>window.location = 'http://theabilitybank.dyndns.org/perfil_editar.php'</script>";
                            }
                            elseif($_POST['button'] == 'Actualizar contraseña'){
                                change_pass();
                                echo "<script>window.location = 'http://theabilitybank.dyndns.org/perfil_editar.php'</script>";
                            }
                            elseif($_POST['button'] == 'Borrar cuenta'){
                                delete_user();
                                echo "<script>window.location = 'http://theabilitybank.dyndns.org/index.php?logout'</script>";
                            }
                        }

                    ?>
                </form>
            </div>

        </div>
    </body>
</html>
