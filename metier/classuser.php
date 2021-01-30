<?php

echo "<meta charset=utf-8>";

class appuser  {

    private $birthday; 
    private $fname;
    private $email;
    private $pass;
    private $country;
    private $gender;

    


    public function __construct($birthday="",$fname="",$email="",$pass="",$country="",$gender="") 
    {
        $this->birthday=$birthday;
        $this->fname=$fname;
        $this->email=$email;
        $this->pass=$pass;
        $this->country=$country;
        $this->gender=$gender;

    }
    
    public function __destruct() {
        
    }
    public function getbirthday() {
        return $this->birthday;
    }

    public function setbirthday($birthday) {
        $this->birthday = $birthday;
    }

    public function getfname() {
        return $this->fname;
    }

    public function setfname($fname) {
        $this->fname = $fname;
    }


    public function getemail() {
        return $this->email;
    }

    public function setemail($email) {
        $this->email = $email;
    }

   
 public function getpass() {
        return $this->pass;
    }

    public function setpass($pass) {
        $this->pass = $pass;
    }
    
    
     
    public function getcountry() {
        return $this->country;
    }

    public function setcountry($country) {
        $this->country = $country;
    }

    public function getgender() {
        return $this->gender;
    }

    public function setgender($gender) {
        $this->gender = $gender;
    }
    
    

    public static function Read($Base, $Table) {
        $result = $Base->query('SELECT birthday,fname,email,pass,country,gender FROM ' . $Table . '');
        while ( $donnee = $result->fetch()){
        $this->birthday = htmlspecialchars($donnee['birthday']);
        $this->fname = htmlspecialchars($donnee['fname']);
        $this->email = htmlspecialchars($donnee['email']);
        $this->pass = htmlspecialchars($donnee['pass']);
        $this->country = htmlspecialchars($donnee['country']);        
        $this->gender = htmlspecialchars($donnee['gender']);

        }
    }
    public function Write($Base) {
   if ($this->Existe($Base)) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Email already exist, try another email.')
    window.location.href='signup.php';
    </SCRIPT>");
     
        } else 

        {
           $req=$Base->prepare('INSERT INTO appuser (birthday,fname,email,pass,country,gender)
              VALUES (?,?,?,?,?,?)');
          $req->execute(array($_GET['birthday'],$_GET['fname'],$_GET['email'],$_GET['pass'],$_GET['country'],$_GET['gender']));
            

                echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('Your account has been successfully registered.')
                window.location.href='signin.html';
                </SCRIPT>");
     }
}













       public function Existe($Base) {
        $requet = $Base->query('SELECT email FROM  appuser');
        while ($donnee = $requet->fetch()) {
            if ($donnee['email'] == $this->email) {

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
            window.alert('User not exist.')
            window.location.href='searchuser.php';
            </SCRIPT>");
        }
        else
        {
         $requete="DELETE FROM appuser  WHERE email='$this->email'";
        $Base->exec($requete);
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('User successfully deleted.')
            window.location.href='searchuser.php';
            </SCRIPT>");
    }
    }





 public function Modifier($Base) {
 	if (!$this->Existe($Base))
         {
            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('User not exist.')zz
            window.location.href='signin.php';
            </SCRIPT>");
        }
        else
        { 
        $requete="UPDATE appuser SET birthday='$this->birthday',fname='$this->fname',pass='$this->pass',country='$this->country' where email='$this->email'";
        $Base->exec($requete); 
        
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Your informations have been successfully updated.')
            window.location.href='signin.php';
            </SCRIPT>");
    
    }
    }

    public function ModifierAdmin($Base) {
        if (!$this->Existe($Base))
            {
               echo ("<SCRIPT LANGUAGE='JavaScript'>
               window.alert('User not exist.')
               window.location.href='searchuser.php';
               </SCRIPT>");
           }
           else
           { 
           $requete="UPDATE appuser SET birthday='$this->birthday',fname='$this->fname',pass='$this->pass',country='$this->country' where email='$this->email'";
           $Base->exec($requete); 
           
           echo ("<SCRIPT LANGUAGE='JavaScript'>
               window.alert('User informations have been successfully updated.')
               window.location.href='searchuser.php';
               </SCRIPT>");
       
       }
       }


}
