<?php
include 'backend/config.php';

if($_REQUEST["tituloOferta"]){
    $valorNombre= $_REQUEST["tituloOferta"];
    //echo($valorNombre . "<br>");


    $valorCategoria= $_REQUEST["CategoriaOferta"];
    //echo($valorCategoria . "<br>");


    $valorDescripcion= $_REQUEST["DescripcionOferta"];
    //echo($valorDescripcion . "<br>");


$offer = new Service(Service::TYPE_OFFER);
$offer->setName($valorNombre);
$offer->setDescription($valorDescripcion);
$category = Category::withName($valorCategoria);
$offer->setCategory($category);
$user = User::withName("usuario");//Usuario de login? Recoger algo de sesion?
$offer->setUser($user);
echo($offer);
$offer->save();
}
?>