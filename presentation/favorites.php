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


$res=$db->query("select * from appuser where email= '$log'");
$don=$res->fetch();
$username=$don["fname"];
if(empty($don))
  {
$boolfv=0;
  }
else {
  $boolfv=1;
  
    }




    function weatherstatuticon($statut) {
      switch($statut){
        case"Clear":
          return <<<HTML
          <html>
          <body><img src="../imgs/clear.png" width=55 style="filter: invert(100%);"></body>
          </html> 
        HTML;
      break;
          case "Drizzle":
            return <<<HTML
          <html>
          <body><img src="../imgs/drizzle.png" width=55 style="filter: invert(100%);"></body>
          </html> 
        HTML;
        
      break;
          case "Rain":
        
        return <<<HTML
          <html>
          <body><img src="../imgs/rain.png" width=55 style="filter: invert(100%);"></body>
          </html> 
        HTML;
      break;
          case "Clouds":
        
        return <<<HTML
          <html>
          <body><img src="../imgs/cloudy.png" width=55 style="filter: invert(100%);"></body>
          </html> 
        HTML;
    
      break;
          case "Thunderstorm":
        
        return <<<HTML
          <html>
          <body><img src="../imgs/thunder.png"width=55 style="filter: invert(100%);"></body>
          </html> 
        HTML;
      break;
          case "Snow":
        
        return <<<HTML
          <html>
          <body><img src="../imgs/snow.png" width=55 style="filter: invert(100%);"></body>
          </html> 
        HTML;
      break;
      case "Mist":
        
        return <<<HTML
          <html>
          <body><img src="../imgs/fog.png"width=55 style="filter: invert(100%);"></body>
          </html> 
        HTML;
      break;
      case "Haze":
        
        return <<<HTML
          <html>
          <body><img src="../imgs/fog.png"width=55 style="filter: invert(100%);"></body>
          </html> 
        HTML;
      break;
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
<br>
<br>

     <?php
      $res1=$db->query("select * from favs where useremail='$log'");
      
      if($res1->rowCount() > 0)
      {          
        while($don1=$res1->fetch()){
        $cityid=$don1["cityid"];

        $res2=$db->query("select * from city where id='$cityid'");
        $don2=$res2->fetch();
        $cityname=$don2["city_ascii"];
        $country=$don2["country"];

        // Url de l'API
        $url = "http://api.openweathermap.org/data/2.5/weather?q=".$cityname."&units=metric&appid=fffa02115ff24eecf97a1cbdf3e6e77c";
        // On obtient les resultat
        $raw = file_get_contents($url);
        // Décode la chaine JSON
        $data = json_decode($raw);


        // Météo
        $weather = $data->weather[0]->main;
        $desc = $data->weather[0]->description;

        //humidity 
        $humid = $data->main->humidity;
        //visibility
        $visib= $data->visibility/1000;

        // Températures
        $temp = round($data->main->temp);
        $temp_min = round($data->main->temp_min);
        $temp_max = round($data->main->temp_max);

        //Time
        $timestamp=$data->dt+$data->timezone;

              ?>



  <div class="card">
      <div class="card-header">
        <?php echo "<h3> $cityname, $country</h3>"; ?>
      </div>

      <div class="card-body">
        <div class="weather-box22">
            <div class="weather-box221">
              <h3><img src="../imgs/wind2.png" width="25" style="filter: invert(100%);">&nbsp;&nbsp;&nbsp;Wind &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $data->wind->speed."km/h"?> </h3>
              <h3><img src="../imgs/pressure2.png" width="25" style="filter: invert(100%);">&nbsp;&nbsp;&nbsp;Pressure &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $data->main->pressure."mb"?> </h3>
              <h3><img src="../imgs/visibility2.png" width="25" style="filter: invert(100%);">&nbsp;&nbsp;&nbsp;Visibility &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $visib."km"?> </h3>
              <h3><img src="../imgs/humid2.png" width="20" style="filter: invert(100%);">&nbsp;&nbsp;&nbsp;Humidity &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $humid."%"?> </h3>
            </div>
            
            <div class="weather-box222">
                <div class="weather-box-minifv">
                  <?php echo weatherstatuticon($weather);?>
                  <h5 ><?php echo $weather?></h5>
                </div>
                <div class="weather-box-mini33">
                  <h1><?php echo $temp."°"?></h1>
                  <h5 ><?php echo $temp_min."°/".$temp_max."°" ?></h5>
                </div> 
            </div>

        </div>

            <a href="<?php echo 'suppfav.php?id='.$don1['idfav'];?>" class="btn btn-danger" OnClick="return confirm('Are you sure to remove this city ?');" >Remove from favorites</a>        
        </div>
    </div>
    <br>
            <?php
            }}
            
        else{
          ?> 
          
          <div class="alert alert-danger" role="alert"> No favorite cities in your list.  </div>
        
        <?php
        }
    ?>
</div>


  </body>

</html>
