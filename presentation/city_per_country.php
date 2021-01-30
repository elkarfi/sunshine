<?php
include_once'../accesDB/connex.php';
$con=new connexion();
$db=$con->connect();

if(isset($_POST["country_id"])){
$country_id = $_POST["country_id"];
echo "<option value=''disabled selected>Select a city</option>";
$result=$db->query("SELECT * FROM city where country = '$country_id'  ORDER BY city_ascii");
while($row =$result->fetch()) {
$name=$row['city_ascii'];
echo "<option value='$name'>$name</option>";
}
}
?>