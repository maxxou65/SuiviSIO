<?php 

    function getConnexion($identifiant, $mdp) 
    {
        $PARAM_nom_bd = 'suivisio'; // le nom de votre base de données
        $PARAM_utilisateur = 'root'; // nom d'utilisateur pour se connecter
        $PARAM_mot_passe = ''; // mot de passe de l'utilisateur pour se connecter
        $PARAM_hote = 'localhost'; // le chemin vers le serveur
        $pdo_option[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES\'UTF8\'';
        $connexion="";
        try 
        {
            $connexion = new PDO("mysql:host=$PARAM_hote;dbname=$PARAM_nom_bd", $PARAM_utilisateur,                                     
            $PARAM_mot_passe, $pdo_option);
        } 
        catch (PDOException $e) 
        {
            echo "<br/>Problème  ";
            $erreur = $e->getCode();
            $message = $e->getMessage();
            echo "erreur $erreur $message\n";
        }

        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connexion;
    

    }
?>