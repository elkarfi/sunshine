<?php
session_start(); 
include_once'../accesDB/connex.php';
$con=new connexion();
$db=$con->connect();


$city=$_SESSION['city'] ;
$log=$_SESSION['log'];
$pwd=$_SESSION['pwd'];

$_SESSION['log']=$log;
$_SESSION['pwd']=$pwd;


$res=$db->query("select * from city where city_ascii= '$city'");
$don=$res->fetch();
if(empty($don))
  {
    ?>
    <script>alert('City details are currently unavailable. Content will be available soon.');location='signin.php';</script>
    <?php
    echo "";
  }
else {

  $res3=$db->query("select * from appuser where email='$log'");
  $don3=$res3->fetch();
  $username=$don3["fname"];
  $country =  $don['country'];
  $popl =  $don['population'];
   // Url de l'API
   $url = "http://api.openweathermap.org/data/2.5/weather?q=".$city."&units=metric&appid=fffa02115ff24eecf97a1cbdf3e6e77c";
  
   // On obtient les resultat
   $raw = file_get_contents($url);
   // Décode la chaine JSON
   $data = json_decode($raw);
   
  $timeZ=$data->timezone/3600 ;
  $sign="+";
   if($timeZ<0)
   $sign="";
   //longitude and latitude
   $long=$data->coord->lon;
   $lat=$data->coord->lat;

   // city Id in table city 
   $id=$don['id'] ;

   //test if city already in favorites 
    $res2=$db->query("select * from favs where cityid= '$id' AND useremail = '$log'");
    $don2=$res2->fetch();
    if(empty($don2))
    
    $cityexist=0;
    else 
    $cityexist=1;


    if(isset($_POST['addfv'])) { 
      include_once'../metier/classfav.php';
      $fav=new favorite($id,$log);
      $fav->Write($db);
  }
}
?>


<!doctype html>
<html lang="en">


  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!--Style CSS-->
    <link rel="stylesheet" type="text/css" href="../style.css">
    <!--Ajax-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Sunshine</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>

   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
   
  </head>
  <body id="bd" class="bg" onload="initialize()">
  
  
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
              
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>


              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="signin.php">
                      <img src="../imgs/sun1.png" width="40"> Sunshine
                    </a>
                  </li>
                </ul>
                <!--Right Navbar-->
                <ul class="navbar-nav navbar-right mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="#" style= "pointer-events: none;"><img src="imgs/user2.png"  width="25"/><?php echo $username; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Edit profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="favorites.php">Favorites</a>
                  </li>
                  
                  <li class="nav-item">
                    <a class="nav-link" href="../accesDB/deconnection.php">Logout</a>
                  </li>
                  
                  
                </ul>
                
              </div>
            </div>
          </nav>
    </div>

<div class="container" id="cont1">
    

      <!--today weather-->
    <div  class="weather-box">
    <?php if($cityexist==0)
    {echo "<form method=\"post\"> ";
      echo "<input type=\"hidden\" name=\"id\" value=\"$id\"> "; 
      echo "<input type=\"hidden\" name=\"log\" value=\"$log\"> "; 
    echo "<button type=\"submit\" class=\"btnmd2\" name=\"addfv\" title=\"Add to favorites\" ><img src=\"imgs/fav.png\"  width=\"18\"/></button>";
    echo "</form> ";
    }
    else
    echo "<button class=\"btnmd2\" style= \"pointer-events: none;\"><img src=\"imgs/favcheck.png\" width=\"18\"/ ></button>";
    
    ?>
    
    <br>
      <h3 id="h3"><?php echo $city?> </h3><br>
      <h4>&nbsp;&nbsp;&nbsp;<?php echo "► Country : ".$country; ?></h4><br>
      <h4>&nbsp;&nbsp;&nbsp;<?php echo "► Timezone : (GMT".$sign.$timeZ.")";?></h4><br>
      
      <h4>&nbsp;&nbsp;&nbsp;<?php echo "► population : ".$popl; ?></h4><br>

    </div>

    <br>
    <div id="map" style="width:600px; height:200px; ">
    
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
