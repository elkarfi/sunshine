<?php
session_start(); 
$log=$_SESSION['log'];
$pwd=$_SESSION['pwd'];
$_SESSION['log']=$log;
$_SESSION['pwd']=$pwd;

include_once'../accesDB/connex.php';
$con=new connexion();
$db=$con->connect();
 if(isset($_POST['id']) )
 {
  $id=$_POST['id'];
  $res=$db->query("select * from city where id='$id'");
  $don=$res->fetch();

  if(empty($don))
  {
    ?>
    <script>alert('Sorry we can\'t find this city. ');location='searchcity.php';</script>
    <?php
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
   
    <!--Ajax-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Sunshine</title>

    <!--Style CSS-->
<style>
@import url('https://fonts.googleapis.com/css?family=Poppins');

/* BASIC */

html {
  background-color: rgba(167, 34, 67, 0.849);
}

body {
  background-color: rgba(167, 34, 67, 0.849);
  font-family: "Poppins", sans-serif;
  height: 100%;
}

a {
  color: #92badd;
  display:inline-block;
  text-decoration: none;
  font-weight: 400;
}

h2 {
  text-align: center;
  font-size: 16px;
  font-weight: 600;
  text-transform: uppercase;
  display:inline-block;
  margin: 40px 8px 10px 8px; 
  color: #cccccc;
}



/* STRUCTURE */

.wrapper {
  display: flex;
  align-items: center;
  flex-direction: column; 
  justify-content: center;
  width: 100%;
  min-height: 100%;
  padding: 20px;
}

#formContent {
  -webkit-border-radius: 10px 10px 10px 10px;
  border-radius: 10px 10px 10px 10px;
  background: #fff;
  padding: 30px;
  width: 90%;
  max-width: 450px;
  position: relative;
  padding: 0px;
  -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
  box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
  text-align: center;
}

#formFooter {
  background-color: #f6f6f6;
  border-top: 1px solid #dce8f1;
  padding: 25px;
  text-align: center;
  -webkit-border-radius: 0 0 10px 10px;
  border-radius: 0 0 10px 10px;
}



/* TABS */

h2.inactive {
  color: #cccccc;
}

h2.active {
  color: #0d0d0d;
  border-bottom: 2px solid rgba(167, 34, 67, 0.849);
}



/* FORM TYPOGRAPHY*/

input[type=button], input[type=submit], input[type=reset]  {
  background-color: rgba(167, 34, 67, 0.849);
  border: none;
  color: white;
  padding: 15px 80px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  text-transform: uppercase;
  font-size: 13px;
  -webkit-box-shadow: 0 10px 30px 0 rgba(167, 34, 67, 0.849);
  box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
  -webkit-border-radius: 5px 5px 5px 5px;
  border-radius: 5px 5px 5px 5px;
  margin: 5px 20px 40px 20px;
  -webkit-transition: all 0.3s ease-in-out;
  -moz-transition: all 0.3s ease-in-out;
  -ms-transition: all 0.3s ease-in-out;
  -o-transition: all 0.3s ease-in-out;
  transition: all 0.3s ease-in-out;
}

input[type=button]:hover, input[type=submit]:hover, input[type=reset]:hover  {
  background-color: rgba(167, 34, 67, 0.849);
}

input[type=button]:active, input[type=submit]:active, input[type=reset]:active  {
  -moz-transform: scale(0.95);
  -webkit-transform: scale(0.95);
  -o-transform: scale(0.95);
  -ms-transform: scale(0.95);
  transform: scale(0.95);
}

input[type=text] ,input[type=password],input[type=date]{
  background-color: #f6f6f6;
  border: none;
  color: #0d0d0d;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 5px;
  width: 85%;
  border: 2px solid #f6f6f6;
  -webkit-transition: all 0.5s ease-in-out;
  -moz-transition: all 0.5s ease-in-out;
  -ms-transition: all 0.5s ease-in-out;
  -o-transition: all 0.5s ease-in-out;
  transition: all 0.5s ease-in-out;
  -webkit-border-radius: 5px 5px 5px 5px;
  border-radius: 5px 5px 5px 5px;
}

input[type=text]:focus {
  background-color: #fff;
  border-bottom: 2px solid rgba(167, 34, 67, 0.849);
}

input[type=text]:placeholder {
  color: #cccccc;
}



/* ANIMATIONS */

/* Simple CSS3 Fade-in-down Animation */
.fadeInDown {
  -webkit-animation-name: fadeInDown;
  animation-name: fadeInDown;
  -webkit-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}

@-webkit-keyframes fadeInDown {
  0% {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
  }
  100% {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
  }
}

@keyframes fadeInDown {
  0% {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
  }
  100% {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
  }
}

/* Simple CSS3 Fade-in Animation */
@-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

.fadeIn {
  opacity:0;
  -webkit-animation:fadeIn ease-in 1;
  -moz-animation:fadeIn ease-in 1;
  animation:fadeIn ease-in 1;

  -webkit-animation-fill-mode:forwards;
  -moz-animation-fill-mode:forwards;
  animation-fill-mode:forwards;

  -webkit-animation-duration:1s;
  -moz-animation-duration:1s;
  animation-duration:1s;
}

.fadeIn.first {
  -webkit-animation-delay: 0.4s;
  -moz-animation-delay: 0.4s;
  animation-delay: 0.4s;
}

.fadeIn.second {
  -webkit-animation-delay: 0.6s;
  -moz-animation-delay: 0.6s;
  animation-delay: 0.6s;
}

.fadeIn.third {
  -webkit-animation-delay: 0.8s;
  -moz-animation-delay: 0.8s;
  animation-delay: 0.8s;
}

.fadeIn.fourth {
  -webkit-animation-delay: 1s;
  -moz-animation-delay: 1s;
  animation-delay: 1s;
}

/* Simple CSS3 Fade-in Animation */
.underlineHover:after {
  display: block;
  left: 0;
  bottom: -10px;
  width: 0;
  height: 2px;
  background-color: rgba(167, 34, 67, 0.849);
  content: "";
  transition: width 0.2s;
}

.underlineHover:hover {
  color: #0d0d0d;
}

.underlineHover:hover:after{
  width: 100%;
}



/* OTHERS */

*:focus {
    outline: none;
} 

#icon {
  width:60%;
}

* {
  box-sizing: border-box;
}

</style>
  </head>



  <body id="bd" class="bg">
  <div class="wrapper fadeInDown">
    <div id="formContent">
    <h2 class="active"> Edit City</h2>
  
      <!-- Login Form -->
      <form action="editcity.php" method="GET" id="userForm" >
      <br>
        <input type="text" id="id" class="fadeIn second" name="id"  value ="<?php echo (int)$don['id'];?>" onfocus="this.blur();" placeholder="ID" Required>
        <input type="text" id="city_name" class="fadeIn second" name="city_name" value ="<?php echo $don['city_name'];?>"placeholder="City Name"  Required>
        <input type="text" id="city_ascii" class="fadeIn second" name="city_ascii" value ="<?php echo $don['city_ascii'];?>" placeholder="City ASCII" Required>
        <input type="text" id="lat" class="fadeIn second" name="lat" value ="<?php echo $don['lat'];?>" placeholder="Latitude" Required>
        <input type="text" id="lng" class="fadeIn second" name="lng" value ="<?php echo $don['lng'];?>" placeholder="Longitude" Required><br>
        <input type="text" id="country" class="fadeIn second" name="country" value ="<?php echo $don['country'];?>" placeholder="Country" Required><br>
        <input type="text" id="iso2" class="fadeIn second" name="iso2" value ="<?php echo $don['iso2'];?>" placeholder="ISO2" Required><br>
        <input type="text" id="iso3" class="fadeIn second" name="iso3" value ="<?php echo $don['iso3'];?>" placeholder="ISO3" Required><br>
        <input type="text" id="admin_name" class="fadeIn second" name="admin_name" value ="<?php echo $don['admin_name'];?>" placeholder="Administrative Name" Required><br>
        <input type="text" id="capital" class="fadeIn second" name="capital" value ="<?php echo $don['capital'];?>" placeholder="Capital" Required><br>
        <input type="text" id="population" class="fadeIn second" name="population" value ="<?php echo (int)$don['population'];?>" placeholder="Population" Required><br>
        
        <input type="submit" class="fadeIn fourth" value="Save"> 
        <a href="<?php echo 'delcity.php?id='.$don['id'];?>" class="btn btn-danger" style="padding: 12px 20px;height:50px;width:150px; font-size: 13px; "OnClick="return confirm('Are you sure to delete  this city permanently?');" >DELETE CITY</a>
        <br>  <br>      
      </form>
  
      
  
    </div>
  </div>
  
  </body>
</html>
