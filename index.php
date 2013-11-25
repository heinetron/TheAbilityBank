<?php
include 'backend/config.php';
?>

<html>
<?php  

function delete($get){
	if(isset($get['deleteOffer'])){
		echo "Delete offer with id" . $get['deleteOffer'];
		//Offer::withID($get['deleteOffer'])->delete();
	}
	else if(isset($get['deleteDemand'])){
		echo "Delete demand with id" . $get['deleteDemand'];
		//Offer::withID($get['deleteDemand'])->delete();
	}
}

if ($_GET){
	delete($_GET);
}
 ?>
	<head>
        <meta charset="utf-8" />
		<title>The Ability Bank</title>
		<link rel="stylesheet" href="estilo_bueno.css" type="text/css">
        <script type="text/javascript" src="jQuery/jquery-2.0.3.min.js"></script>

	</head>

    <body>
        <div id="total">

            <table id="cabecera">
                <tr>
                    <td id="logo"></td>
                    <td id="b_todo" onclick="Todo()">TODO</td>
                    <td id="b_ofer" onclick="Offer()">OFERTAS</td>
                    <td id="b_deman" onclick="Demand()">DEMANDAS</td>
                </tr>
            </table>
            <div id="border_top"></div>
            <div id="principal">

                <?php
                    foreach(Offer::getAll() as $offer){
                        $name = $offer->getName();
                        $category = $offer->getCategory()->getName();
                        $description = $offer->getDescription();
                        echo '<div class="ofertas">'.$category.'<p>'.$description.'</p>
						            <a href="index_borrar.php?deleteOffer='.$offer->getID().'">Delete</a></div>';
                    }
                    foreach(Demand::getAll() as $demand){
                        $name = $demand->getName();
                        $category = $demand->getCategory()->getName();
                        $description = $demand->getDescription();
                        echo '<div class="demandas">'.$category.'<p>'.$description.'</p>
                        <a href="index_borrar.php?deleteDemand='.$demand->getID().'">Delete</a></div>';
                    }
                ?>

            </div>
            <div id="border_botton"></div>

            <div class="secundario">
                <ul>
                    <li><a href="#">Todo</a></li>
                    <li><a href="#">Jardinería</a></li>
                    <li><a href="#">Fontanería </a></li>
                    <li><a href="#">Electricidad</a></li>
                    <li><a href="#">Cuidado de Personas</a></li>
                    <li><a href="#">Cuidado de Personas</a></li>
                    <li><a href="#">Idiomas</a></li>
                    <li><a href="#">Otros</a></li>
                </ul>
                <br>
                <ul>
                    <li><a href="/crear_oferta.html">Crear servico</a></li>
                    <br>
                    <li><a href="/crear_demanda.html">Petición de servicio</a></li>
                </ul>
            </div>

        </div>
        <script>
            function Todo(){
                $(".ofertas").show();
                $(".demandas").show();
            }

            function Offer(){
                $(".ofertas").show();
                $(".demandas").hide();
            }

            function Demand(){
                $(".ofertas").hide();
                $(".demandas").show();
            }
        </script>
    </body>

</html>
