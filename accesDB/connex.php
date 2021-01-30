<?php

class connexion {

    var $bdd;
    var $pseudo;
    var $password;

    public function __construct($bdd = null, $pseudo = null, $password = null) {
        if ($bdd != null && $pseudo != null && $password != null) {
            $this->bdd = $bdd;
            $this->pseudo = $pseudo;
            $this->password = $password;
        } else {
            $this->bdd = 'mysql:dbname=weatherapp;host=localhost';
            $this->pseudo = 'root';
            $this->password = '';
        }
    }

    public function connect() {
        try {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $db = new PDO($this->bdd, $this->pseudo, $this->password, $pdo_options);
        } catch (PDOException $e) {
            die('ERREUR DE CONNECTION' . $e->getMessage());
        }
        return $db;
    }
}
?>