<?php

echo "<meta charset=utf-8>";

class favorite  {

    private $id; 
    private $useremail; 
    private $cityid;
   

    


    public function __construct($id,$useremail="",$cityid="") 
    {   $this->id=$id;
        $this->useremail=$useremail;
        $this->cityid=$cityid;

    }

   

    
    public function __destruct() {
        
    }
    public function getid() {
        return $this->id;
    }

    public function setid($id) {
        $this->id = $id;
    }

    public function getuseremail() {
        return $this->useremail;
    }

    public function setuseremail($useremail) {
        $this->useremail = $useremail;
    }

    public function getcityid() {
        return $this->cityid;
    }

    public function setcityid($cityid) {
        $this->cityid = $cityid;
    }


    public static function Read($Base, $Table) {
        $result = $Base->query('SELECT useremail,cityid FROM ' . $Table . '');
        while ( $donnee = $result->fetch()){
        $this->useremail = htmlspecialchars($donnee['useremail']);
        $this->cityid = htmlspecialchars($donnee['cityid']);
        }
    }
    public function Write($Base) {
   if ($this->Existe($Base)) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('City already in favorite list.')
    window.location.href='citydetails.php';
    </SCRIPT>");
     
        } else 

        {
           $req=$Base->prepare('INSERT INTO favs (useremail,cityid)
              VALUES (?,?)');
          $req->execute(array($_POST['log'],$_POST['id']));
            

                echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('City has been added to favorites successfully.')
                window.location.href='citydetails.php';
                </SCRIPT>");
     }
}

       public function Existe($Base) {
        $requet = $Base->query('SELECT idfav FROM  favs');
        while ($donnee = $requet->fetch()) {
            if ($donnee['idfav'] == $this->id) {

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
            window.location.href='favorites.php';
            </SCRIPT>");
        }
        else
        {
         $requete="DELETE FROM favs  WHERE idfav='$this->id'";
        $Base->exec($requete);
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('City successfully removed from favorites list.')
            window.location.href='favorites.php';
            </SCRIPT>");
    }
    }




 



}
