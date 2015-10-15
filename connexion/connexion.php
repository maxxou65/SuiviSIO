<?php

function getConnexion() {
    $connexion = "";
    $PARAM_nom_bd = 'suivisio'; // le nom de votre base de données
    $PARAM_utilisateur = 'root'; // nom d'utilisateur pour se connecter
    $PARAM_mot_passe = 'ppe3suivisio2014'; // mot de passe de l'utilisateur pour se connecter
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $PARAM_mot_passe = '';
    }
    $PARAM_hote = 'localhost'; // le chemin vers le serveur

    $connexion = ConnexionPDO::getInstance($PARAM_hote, $PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
   
  
    return $connexion;
}

class ConnexionPDO {
    private static $instance;
    
    private function __construct($hote, $bd, $usr, $pwd) {
        try {
            $con = new PDO("mysql:host=$hote;dbname=$bd", $usr, $pwd);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance = $con;
        } catch (PDOException $e) {
            echo "<br/>Problème  ";
            $erreur = $e->getCode();
            $message = $e->getMessage();
            echo "erreur $erreur $message\n";
        };
    }
    
    static public function getInstance($hote, $bd, $usr, $pwd) {
        if (!self::$instance) {
            new ConnexionPDO($hote, $bd, $usr, $pwd);
        }
        return self::$instance;
    }
}
?>