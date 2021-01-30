<?php
session_start(); 
include_once'../accesDB/connex.php';
$con=new connexion();
$db=$con->connect();
    $log=$_SESSION['log'];
    $pwd=$_SESSION['pwd'];
    $_SESSION['log']=$log;
    $_SESSION['pwd']=$pwd;
    $res=$db->query("select * from admin where login='$log' and psw='$pwd'");
    $don=$res->fetch();
    $username=$don["login"];
?>


<!doctype html>
<html lang="en">


  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
   
    <!--Ajax-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Sunshine</title>

    <!--Style CSS-->
    <link rel="stylesheet" type="text/css" href="../style.css">
  </head>



  <body id="bd" class="bg" style="background:rgba(167, 34, 67, 0.849);" >
  
  
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
              
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>


              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="admin.php">
                      <img src="../imgs/sun1.png" width="40"> Sunshine
                    </a>
                  </li>
                </ul>
                <!--Right Navbar-->
                <ul class="navbar-nav navbar-right mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#" style= "pointer-events: none;"><img src="../imgs/user2.png"  width="25"/><?php echo $username; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="searchcity.php">Cities</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="searchuser.php">Users

                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a class="nav-link" href="../accesDB/deconnectionadmin.php">Logout</a>
                  </li>
                  
                  
                </ul>
                
              </div>
            </div>
          </nav>
    </div>

<div class="container" id="cont1">
 
    
<!--Search Box-->
  <div class="div_search">
    <h3>Search city by its ID</h3>

    <div class="col-md-6 col-lg-6 col-l1 mx-auto my-auto search-box">

            <form name="search-form" action= "cityinf.php" method="POST">
            <div class="input-group form-container">
              <input type="text" name="id" id="id" class="search-input "required  placeholder="  Tap a valid ID ..." autofocus="autofocus" autocomplete="off" >
            
              <span class="input-group-btn">
              <button type ="submit" class="btn btn-search" name="search">
                <img src="../imgs/search2.png" width="20">
              </button>
            </span>
            </div>
            </form>
    </div>
    <br>
    <a href="newcity.php" >Would you like to add a new city ?</a>

  </div>
</div>
    
</body>
<script type="text/javascript">
    function initialize() {
        var map = L.map('map').setView([<?php echo $lat.",".$long ?>], 8); 

        var osmLayer = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', { 
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        });
    
        map.addLayer(osmLayer);
        L.marker([<?php echo $lat.",".$long ?>]).addTo(map)
    .bindPopup('<?php echo $city ?>');
    }
</script>
  
</html>
