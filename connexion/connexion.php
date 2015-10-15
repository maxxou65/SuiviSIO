<?php 
function getConnexion() {
	$PARAM_nom_bd = 'suivisio'; // le nom de votre base de données
	$PARAM_utilisateur = 'root'; // nom d'utilisateur pour se connecter
	//$PARAM_mot_passe = 'ppe3suivisio2014'; // mot de passe de l'utilisateur pour se connecter
	$PARAM_mot_passe = ''; // mot de passe de l'utilisateur pour se connecter
	$PARAM_hote = 'localhost'; // le chemin vers le serveur


    
	try 
    {
	    $connexion = new PDO("mysql:host=$PARAM_hote;dbname=$PARAM_nom_bd", $PARAM_utilisateur,$PARAM_mot_passe);
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