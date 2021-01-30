<?php
session_start(); 





include_once'../accesDB/connex.php';
$con=new connexion();
$db=$con->connect();
 if(isset($_POST['login']) and isset($_POST['password'])  )

 {
  $log=$_POST['login'];
  $pwd=$_POST['password'];
  $res=$db->query("select * from admin where login='$log' and psw='$pwd'");
  $don=$res->fetch();

  if(empty($don))
  {
    ?>
    <script>alert('Sorry we can\'t find this account. ');location='index.html';</script>
    <?php
    echo "";
  }

  else
    { 
    $_SESSION['log']=$log;
    $_SESSION['pwd']=$pwd;
    $username=$don["login"];
   }

  }

  else{
    $log=$_SESSION['log'];
    $pwd=$_SESSION['pwd'];
    $res=$db->query("select * from admin where login='$log' and psw='$pwd'");
    $don=$res->fetch();
    $username=$don["login"];
  }



function weatherstatuticon($statut) {
  switch($statut){
    case"Clear":
      return <<<HTML
      <html>
      <body><img src="../imgs/clear.png"></body>
      </html> 
    HTML;
  break;
      case "Drizzle":
        return <<<HTML
      <html>
      <body><img src="../imgs/drizzle.png"></body>
      </html> 
    HTML;
    
  break;
      case "Rain":
    
    return <<<HTML
      <html>
      <body><img src="../imgs/rain.png" ></body>
      </html> 
    HTML;
  break;
      case "Clouds":
    
    return <<<HTML
      <html>
      <body><img src="../imgs/cloudy.png" ></body>
      </html> 
    HTML;

  break;
      case "Thunderstorm":
    
    return <<<HTML
      <html>
      <body><img src="../imgs/thunder.png" ></body>
      </html> 
    HTML;
  break;
      case "Snow":
    
    return <<<HTML
      <html>
      <body><img src="../imgs/snow.png" ></body>
      </html> 
    HTML;
  break;
  case "Mist":
    
    return <<<HTML
      <html>
      <body><img src="../imgs/fog.png" ></body>
      </html> 
    HTML;
  break;
  case "Haze":
    
    return <<<HTML
      <html>
      <body><img src="../imgs/fog.png" ></body>
      </html> 
    HTML;
  break;
      }
}


if(isset($_POST["city_id"])){
  $city = $_POST["city_id"];  
}


  else{
  //Ip Address infos
  
        /*
  function getIp(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }
  $ip=getIp();*/
  //$ip='196.120.46.207';  tit mellil example not in database
  $ip='196.65.128.253';
  $ip_info='http://api.ipinfodb.com/v3/ip-city/?key=b5ca945c8fc2030c6380f46aa8a407f06374ab49eaf2e1f86f2263a3b8cd31e7&ip='.$ip.'&format=json';
  // On get les resultat
  $inf = file_get_contents($ip_info);
  // Décode la chaine JSON
  $dataip = json_decode($inf);

  $city = $dataip->cityName;
 //echo 'La ville de l IP de l utilisateur est : '.$city;
  }
  $_SESSION['city'] = $city;

// Url de l'API
$url = "http://api.openweathermap.org/data/2.5/weather?q=".$city."&units=metric&appid=fffa02115ff24eecf97a1cbdf3e6e77c";

// On obtient les resultat
$raw = file_get_contents($url);
// Décode la chaine JSON
$data = json_decode($raw);
 // Nom de la ville
 $city = $data->name;
 // nom du pays
$country =  $data->sys->country;

//longitude and latitude
$long=$data->coord->lon;
$lat=$data->coord->lat;


// Météo
$weather = $data->weather[0]->main;
$desc = $data->weather[0]->description;

// Températures
$temp = round($data->main->temp);
$feel_like = round($data->main->feels_like);
$temp_min = round($data->main->temp_min);
$temp_max = round($data->main->temp_max);

// Vent
$speed = $data->wind->speed;
$deg = $data->wind->deg;
$timestamp=$data->dt+$data->timezone;

//humidity 
$humid = $data->main->humidity;
//visibility
$visib= $data->visibility/1000;

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

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>

   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
   
  </head>



  <body id="bd" class="bg" style="background:rgba(167, 34, 67, 0.849);" onload="initialize()">
  
  
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
  <div class="select-div">
 
      <!--today weather-->
    <div  class="weather-box">


      <h3 id="h3"><?php echo $city.", ".$country ?> </h3>
      <h4><?php echo date("F j, Y", $timestamp); ?></h4>
      <h4><?php echo date("l g:i a", $timestamp); ?></h4>





        <div class="weather-box-mini2">
        <?php echo weatherstatuticon($weather);?>
          <h5 ><?php echo $weather?></h5>
        </div>

        <div class="weather-box-mini3">
          <h1><?php echo $temp."°"?></h1>
          <h5 ><?php echo $temp_min."°/".$temp_max."°" ?></h5>
        </div>

        


      <!-- more details -->
      <div class="weather-box2">
        <h3><img src="../imgs/wind2.png" width="25">&nbsp;&nbsp;&nbsp;Wind &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $data->wind->speed."km/h"?> </h3>
        <h3><img src="../imgs/pressure2.png" width="25">&nbsp;&nbsp;&nbsp;Pressure &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $data->main->pressure."mb"?> </h3>
        <h3><img src="../imgs/visibility2.png" width="25">&nbsp;&nbsp;&nbsp;Visibility &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $visib."km"?> </h3>
        <h3><img src="../imgs/humid2.png" width="20">&nbsp;&nbsp;&nbsp;Humidity &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $humid."%"?> </h3>
        <h3><img src="../imgs/dawn2.png" width="25">&nbsp;&nbsp;&nbsp;Sunrise &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("g:i a", $data->sys->sunrise);?> </h3>
        <h3><img src="../imgs/sunset2.png" width="25">&nbsp;&nbsp;&nbsp;Sunset &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("g:i a", $data->sys->sunset);?> </h3>
      </div>
      

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
