
<?php

include_once'../metier/classcity.php';
include'../accesDB/connex.php';
$con= new connexion();
$db=$con->connect();
$cit=new city($_GET['id'],$_GET['city_name'],$_GET['city_ascii'],$_GET['lat'],$_GET['lng'],$_GET['country'],$_GET['iso2'],$_GET['iso3'],$_GET['admin_name'],$_GET['capital'],$_GET['population']);
$cit->Write($db);
 
?>