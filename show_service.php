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
                <li><a href="/index.php">Home</a></li>
                <li id="logo"></li>
                <?php



                if(isset($_COOKIE['usuariotab']) && $_COOKIE['usuariotab'] != ""){

                    echo '<li><a href="/perfil.php">'.ucfirst($_COOKIE['usuariotab']).'</a></li>';
                } else {
                    echo '<li><a href="/signup.php">Log in</a></li>';
                } ?>

                <li><a href="#">Noticias</a></li>
                <li><a href="#">Contacto</a></li>

                <li><form id="formBus" name="formBus" method="get" action="" >
                        <input id="buscar" name="buscar" type="text" placeholder="BuscarServicio" size="15" >
                        <input id="Bbuscar" type="submit" VALUE="Buscar" onclick=href="index.php?buscar="document.formBus['buscar'] >
                    </form>
                </li>
            </ul>
        </div>
        <div id="menusecundario">
            <ul>
                <?php
                $id2 = $_GET['service'];
                $stype2 = $_GET['servicetype'];
                $service = Service::withID($id2,$stype2);
                echo '<li><a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'">Todo</a></li>';
                echo '<li><a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria=Jardinería">Jardinería</a></li>';
                echo '<li><a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria=Fontanería">Fontanería </a></li>';
                echo '<li><a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria=Electricidad">Electricidad</a></li>';
                echo '<li><a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria=Cuidado de Personas">Cuidado de Personas</a></li>';
                echo '<li><a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria=Música">Música</a></li>';
                echo '<li><a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria=Idiomas">Idiomas</a></li>';
                echo '<li><a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria=Otros">Otros</a></li>';

                ?>

            </ul>
        </div>
        <div id="seleccion">
            <table>
                <tr>
                    <td id="b_todo" onclick="Todo()">TODO</td>
                    <td id="b_ofer" onclick="Offer()">OFERTAS</td>
                    <td id="b_deman" onclick="Demand()">DEMANDAS</td>
                    <?php
                    if(isset($_COOKIE['usuariotab']) && $_COOKIE['usuariotab'] != ""){
                        echo '<td id="b_todo" onclick=ToMyPosts()>MIS PUBLICACIONES</td>';
                    }
                    else{
                        echo '<td id="b_todo" onclick=ToSignUp()>MIS PUBLICACIONES</td>';
                    }
                    if(isset($_COOKIE['usuariotab']) && $_COOKIE['usuariotab'] != ""){
                        echo '<td id="b_todo" onclick=ToCreateService()>CREAR OFERTA/DEMANDA</td>';
                    }
                    else{
                        echo '<td id="b_todo" onclick=ToSignUp()>CREAR OFERTA/DEMANDA</td>';
                    }
                    ?>
                </tr>
            </table>

        </div>

       <hr>
    </div>

    <div id="principal">
            <?php
            $id = $_GET['service'];
            $stype = $_GET['servicetype'];
            $user = $_GET['user'];

            $service = Service::withID($id,$stype);
            $name = $service->getName();
            $category = $service->getCategory()->getName();
            $description = $service->getDescription();
            $class = "ofertas";
            if ($service->getServiceType() == Service::TYPE_OFFER){
                $class = "ofertas_demandas";
                $type = "Oferta";
            } else {
                $class = "ofertas_demandas";
                $type = "Demanda";
            }
            if(isset($_COOKIE['usuariotab']) && $_COOKIE['usuariotab'] != ""){
                echo '<div class="servicio2 '.$class.'"><h4>'."Descripción de la ".$type." " .$name.'</h4><h5>'.$category.'</h5><p>'.$description.'</p>
                    <a href="/index.php"><input type="button" id="negotiation_button" name="negotiation_button" value="Pedir negociacion" /></a>
                    <a href="/index.php"><input type="button" id="user_button" name="user_button" value="Ver perfil de '.$user.'" /></a>
                    <h5>'.$type.' posteada por el usuario '.$user.'</h5></div>';
            }
            else{
                echo '<div class="servicio2 '.$class.'"><h4>'."Descripción de la ".$type." " .$name.'</h4><h5>'.$category.'</h5><p>'.$description.'</p>
                    <a href="/signup.php"><input type="button" id="negotiation_button" name="negotiation_button" value="Pedir negociacion" /></a>
                    <a href="/signup.php"><input type="button" id="user_button" name="user_button" value="Ver perfil de '.$user.'" /></a>
                    <h5>'.$type.' posteada por el usuario '.$user.'</h5></div>';
            }

            ?>
        <hr>
        <div id="lista">
            <?php

                if (isset($_GET['categoria'])){

                    $categoriaServicio = $_GET['categoria'];
                }
			    else{
                    $categoriaServicio = "vacio";
                }


                foreach(Service::getAll() as $service){
                    $name = $service->getName();
                    $category = $service->getCategory()->getName();
                    $description = $service->getDescription();
                    $class = "ofertas";
                    if ($service->getServiceType() == Service::TYPE_OFFER){
                        $class = "ofertas";
                    } else {
                        $class = "demandas";
                    }

                    if ($categoriaServicio != "vacio")  {
                        if ($categoriaServicio == $category) {
                            echo '<div class="servicio '.$class.'" data_category="'.$category.'"><h4>'.$category.'</h4><p>'.$name.'</p>
                             		<a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria='.$service= $categoriaServicio.'"><u>Ver</u></a></div>';
                        }
                    }
                    else {
                        echo '<div class="servicio '.$class.'" data_category="'.$category.'"><h4>'.$category.'</h4><p>'.$name.'</p>
                            		<a href="show_service.php?service='.$service->getID().'&servicetype='.$service->getServiceType().'&user='.$service->getUser()->getName().'&categoria='.$service= $categoriaServicio.'"><u>Ver</u></a></div>';
                    }
                }
            ?>
        </div>
    </div>
    <script>
        function Todo(){
            $(".ofertas").show()
            $(".demandas").show();;
        }

        function Offer(){
            $(".ofertas").show();
            $(".demandas").hide();
        }

        function Demand(){
            $(".ofertas").hide();
            $(".demandas").show();
        }

        function ToSignUp(){
            self.open("/signup.php", "_self");
        }

        function ToCreateService(){
            self.open("/createservice.php", "_self")
        }

    </script>



</body>


</html>