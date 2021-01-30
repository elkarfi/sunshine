<?php
session_start(); 





include_once'../accesDB/connex.php';
$con=new connexion();
$db=$con->connect();
 if(isset($_POST['login']) and isset($_POST['password'])  )

 {
  $log=$_POST['login'];
  $pwd=$_POST['password'];
  $res=$db->query("select * from appuser where email='$log' and pass='$pwd'");
  $don=$res->fetch();

  if(empty($don))
  {
    ?>
    <script>alert('Sorry we can\'t find that account. ');location='signin.html';</script>
    <?php
    echo "";
  }

  else
    { 
    $_SESSION['log']=$log;
    $_SESSION['pwd']=$pwd;
    $username=$don["fname"];
   }

  }

  else{
    $log=$_SESSION['log'];
    $pwd=$_SESSION['pwd'];
    $res=$db->query("select * from appuser where email='$log' and pass='$pwd'");
    $don=$res->fetch();
    $username=$don["fname"];
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
// hourly and daily forecast
$url2= "http://api.openweathermap.org/data/2.5/onecall?lat=$lat&lon=$long&exclude=minutely&units=metric&appid=fffa02115ff24eecf97a1cbdf3e6e77c";
// On obtient les resultat
$raw2 = file_get_contents($url2);
// Décode la chaine JSON
$hourday = json_decode($raw2);

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



  <body id="bd" class="bg">
  
  
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
                    <a class="nav-link" href="#" style= "pointer-events: none;"><img src="../imgs/user2.png"  width="25"/><?php echo $username; ?></a>
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

  <div class="select-div">
  <form >
  <select id="country-dropdown" class="form-select" aria-label=".form-select-sm example">
  <option value="" disabled selected> Select a country </option>
    <?php
      $res=$db->query("SELECT DISTINCT country FROM city ORDER BY country");
      while($don=$res->fetch()){
      $cn=$don['country'];
      echo" <option value='$cn'> $cn</option>";
      }
    ?>
  </select>
 
  <select  id="city-dropdown" class="form-select">
  </select> 
  </form>
  </div>
  <script>
  $(document).ready(function() {
  $('#country-dropdown').on('change', function() {
  var country_id = this.value;
  $.ajax({
  url: "city_per_country.php",
  type: "POST",
  data: {
  country_id: country_id
  },
  cache: false,
  success: function(result){
  $("#city-dropdown").html(result);
  }
  });
  });    


  $('#city-dropdown').on('change', function() {
  var city_id = this.value;
  $.ajax({
  url: "signin.php",
  type: "POST",
  data: {
  city_id: city_id
  },
  cache: false,
  success: function(result){
  $("#bd").html(result);
  }
  });

  }); 
  });
  </script>
      <!--today weather-->
    <div  class="weather-box">


    <input type="submit" id="btnmd" value="More details" onclick="window.location='citydetails.php';" >
    <br>

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

    
    
    <div class="weather-box3">
    <h3 ><span>Day</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Min/Max</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Condition</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Pressure</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Humidity</span> </h3>
      <h3><?php echo date("D j", $hourday->daily[1]->dt); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo round($hourday->daily[1]->temp->min )."°/".round($hourday->daily[1]->temp->max )."°" ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo weatherstatuticon( $hourday->daily[1]->weather[0]->main); echo $hourday->daily[1]->weather[0]->main  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hourday->daily[1]->pressure."mb"  ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hourday->daily[1]->humidity."%"  ?> </h3>
      <h3><?php echo date("D j", $hourday->daily[2]->dt); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo round($hourday->daily[2]->temp->min )."°/".round($hourday->daily[2]->temp->max )."°" ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo weatherstatuticon($hourday->daily[2]->weather[0]->main); echo $hourday->daily[2]->weather[0]->main  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hourday->daily[2]->pressure."mb"  ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hourday->daily[2]->humidity."%"  ?> </h3>
      <h3><?php echo date("D j", $hourday->daily[3]->dt); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo round($hourday->daily[3]->temp->min )."°/".round($hourday->daily[3]->temp->max )."°" ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo weatherstatuticon($hourday->daily[3]->weather[0]->main); echo $hourday->daily[3]->weather[0]->main  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hourday->daily[3]->pressure."mb"  ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hourday->daily[3]->humidity."%"  ?> </h3>
      <h3><?php echo date("D j", $hourday->daily[4]->dt); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo round($hourday->daily[4]->temp->min )."°/".round($hourday->daily[4]->temp->max )."°" ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo weatherstatuticon($hourday->daily[4]->weather[0]->main); echo $hourday->daily[4]->weather[0]->main  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hourday->daily[4]->pressure."mb"  ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hourday->daily[4]->humidity."%"  ?> </h3>
      <h3><?php echo date("D j", $hourday->daily[5]->dt); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo round($hourday->daily[5]->temp->min )."°/".round($hourday->daily[5]->temp->max )."°" ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo weatherstatuticon($hourday->daily[5]->weather[0]->main); echo $hourday->daily[5]->weather[0]->main  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hourday->daily[5]->pressure."mb"  ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hourday->daily[5]->humidity."%"  ?> </h3>
      <h3><?php echo date("D j", $hourday->daily[6]->dt); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo round($hourday->daily[6]->temp->min )."°/".round($hourday->daily[6]->temp->max )."°" ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo weatherstatuticon($hourday->daily[6]->weather[0]->main); echo $hourday->daily[6]->weather[0]->main  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hourday->daily[6]->pressure."mb"  ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hourday->daily[6]->humidity."%"  ?> </h3>
      <h3><?php echo date("D j", $hourday->daily[7]->dt); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo round($hourday->daily[7]->temp->min )."°/".round($hourday->daily[7]->temp->max )."°" ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo weatherstatuticon($hourday->daily[7]->weather[0]->main); echo $hourday->daily[7]->weather[0]->main  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hourday->daily[7]->pressure."mb"  ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $hourday->daily[7]->humidity."%"  ?> </h3>
    </div>
   
</div>


  </body>
</html>
