<?php
    include_once'../metier/classcity.php';
    include'../accesDB/connex.php';
    $con= new connexion();
    $db=$con->connect();
    
    $cit=new city($_GET['id']);
    $cit->Supprimer($db);

 ?>  