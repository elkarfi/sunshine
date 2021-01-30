
<?php

include_once'../metier/classuser.php';
include'../accesDB/connex.php';
$con= new connexion();
$db=$con->connect();
$user=new appuser($_GET['birthday'],$_GET['fname'],$_GET['email'],$_GET['pass'],$_GET['country']);
$user->Modifier($db);

?>