<?php

echo "<meta charset=utf-8>";

class city  {

    private $id; 
    private $city_name;
    private $city_ascii;
    private $lat;
    private $lng;
    private $country;
    private $iso2;
    private $iso3;
    private $admin_name;
    private $capital;
    private $population;

    


    public function __construct($id="",$city_name="",$city_ascii="",$lat="",$lng="",$country="",$iso2="",$iso3="",$admin_name="",$capital="",$population="") 
    {
        $this->id=$id;
        $this->city_name=$city_name;
        $this->city_ascii=$city_ascii;
        $this->lat=$lat;
        $this->lng=$lng;
        $this->country=$country;
        $this->iso2=$iso2;
        $this->iso3=$iso3;
        $this->admin_name=$admin_name;
        $this->capital=$capital;
        $this->population=$population;


    }
    
    public function __destruct() {
        
    }
    public function getid() {
        return $this->id;
    }

    public function setid($id) {
        $this->id = $id;
    }

    public function getcity_name() {
        return $this->city_name;
    }

    public function setcity_name($city_name) {
        $this->city_name = $city_name;
    }


    public function getcity_ascii() {
        return $this->city_ascii;
    }

    public function setcity_ascii($city_ascii) {
        $this->city_ascii = $city_ascii;
    }

   
 public function getlat() {
        return $this->lat;
    }

    public function setlat($lat) {
        $this->lat = $lat;
    }
    
    
     
    public function getlng() {
        return $this->lng;
    }

    public function setlng($lng) {
        $this->lng = $lng;
    }

    public function getcountry() {
        return $this->country;
    }

    public function setcountry($country) {
        $this->country = $country;
    }

    public function getiso2() {
        return $this->iso2;
    }

    public function setiso2($iso2) {
        $this->iso2 = $iso2;
    }
    public function getiso3() {
        return $this->iso3;
    }

    public function setiso3($iso3) {
        $this->iso3 = $iso3;
    }
    
    public function getadmin_name() {
        return $this->admin_name;
    }

    public function setadmin_name($admin_name) {
        $this->admin_name = $admin_name;
    }

    public function getcapital() {
        return $this->capital;
    }

    public function setcapital($capital) {
        $this->capital = $capital;
    }

    public function getpopulation() {
        return $this->population;
    }

    public function setpopulation($population) {
        $this->population = $population;
    }
    

    public static function Read($Base, $Table) {
        $result = $Base->query('SELECT id,city_name,city_ascii,lat,lng,country,iso2,iso3,admin_name,capital,population FROM ' . $Table . '');
        while ( $donnee = $result->fetch()){
        $this->id = htmlspecialchars($donnee['id']);
        $this->city_name = htmlspecialchars($donnee['city_name']);
        $this->city_ascii = htmlspecialchars($donnee['city_ascii']);
        $this->lat = htmlspecialchars($donnee['lat']);
        $this->lng = htmlspecialchars($donnee['lng']);        
        $this->country = htmlspecialchars($donnee['country']);
        $this->country = htmlspecialchars($donnee['iso2']);
        $this->country = htmlspecialchars($donnee['iso3']);
        $this->country = htmlspecialchars($donnee['admin_name']);
        $this->country = htmlspecialchars($donnee['capital']);
        $this->country = htmlspecialchars($donnee['population']);

        }
    }
    public function Write($Base) {
   if ($this->Existe($Base)) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('City already exist, try another ID.')
    window.location.href='searchcity.php';
    </SCRIPT>");
     
        } else 

        {
           $req=$Base->prepare('INSERT INTO city (id,city_name,city_ascii,lat,lng,country,iso2,iso3,admin_name,capital,population)
              VALUES (?,?,?,?,?,?,?,?,?,?,?)');
          $req->execute(array($_GET['id'],$_GET['city_name'],$_GET['city_ascii'],$_GET['lat'],$_GET['lng'],$_GET['country'],$_GET['iso2'],$_GET['iso3'],$_GET['admin_name'],$_GET['capital'],$_GET['population']));
            

                echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('City has been successfully registered.')
                window.location.href='searchcity.php';
                </SCRIPT>");
     }
}


       public function Existe($Base) {
        $requet = $Base->query('SELECT id FROM  city');
        while ($donnee = $requet->fetch()) {
            if ($donnee['id'] == $this->id) {
                return TRUE;
            }
        }
        $requet->closeCursor();
        return FALSE;
    }




   
    public function Supprimer($Base) {
    	if (!$this->Existe($Base))
         {
            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('City not exist.')
            window.location.href='searchcity.php';
            </SCRIPT>");
        }
        else
        {
         $requete="DELETE FROM city  WHERE id='$this->id'";
        $Base->exec($requete);
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('City successfully deleted.')
            window.location.href='searchcity.php';
            </SCRIPT>");
    }
    }





 public function Modifier($Base) {
 	if (!$this->Existe($Base))
         {
            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('City not exist.')
            window.location.href='searchcity.php';
            </SCRIPT>");
        }
        else
        { 
        $requete="UPDATE city SET city_name='$this->city_name',lat='$this->lat',lng='$this->lng',country='$this->country',iso2='$this->iso2',iso3='$this->iso3',admin_name='$this->admin_name',capital='$this->capital',population='$this->population' where id='$this->id'";
        $Base->exec($requete); 
        
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('City informations have been successfully updated.')
            window.location.href='searchcity.php';
            </SCRIPT>");
    
    }
    }


}
