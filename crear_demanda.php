<?php
include 'backend/config.php';

if(isset($_REQUEST["tituloDemanda"])){
    $valorNombre = $_REQUEST["tituloDemanda"];
    //echo($valorNombre . "<br>");


    $valorCategoria = $_REQUEST["CategoriaDemanda"];
    //echo($valorCategoria . "<br>");



    $valorDescripcion = $_REQUEST["descripcionDemanda"];
    //echo($valorDescripcion . "<br>");

$demand = new Service(Service::TYPE_DEMAND);
$demand->setName($valorNombre);
$demand->setDescription($valorDescripcion);
$category = Category::withName($valorCategoria);
$demand->setCategory($category);
$user = User::withName("usuario");//Usuario de login? Recoger algo de sesion?
$demand->setUser($user);
echo($demand);
$demand->save();
}
?>