<?php
    include_once'../metier/classuser.php';
    include'../accesDB/connex.php';
    $con= new connexion();
    $db=$con->connect();
    
    $usr=new appuser($_GET['birthday'],$_GET['fname'],$_GET['email'],$_GET['pass'],$_GET['country']);
    $usr->Supprimer($db);

 ?>  