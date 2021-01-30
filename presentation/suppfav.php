<?php
    include_once'../metier/classfav.php';
    include'../accesDB/connex.php';
    $con= new connexion();
    $db=$con->connect();
    
    $s=new favorite($_GET['id']);
    $s->Supprimer($db);

 ?>  