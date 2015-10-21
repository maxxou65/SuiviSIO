<!--
	/!\ WIP /!\ Work In Progress /!\ WIP /!\   
<<<<<<< HEAD
-->

<?php
// Connexion à MySQL
if (!(isset($connexion))) {
	include_once("../connexion/connexion.php");
	$connexion = getConnexion();
}
// -------
// ÉTAPE 1 : on vérifie si l'IP se trouve déjà dans la table.
// Pour faire ça, on n'a qu'à compter le nombre d'entrées dont le champ "ip" est l'adresse IP du visiteur.
$req = "SELECT COUNT(*) AS nbre_entrees FROM CONNECTES WHERE ip = '".$_SERVER['REMOTE_ADDR']."';";
try {  
	$res = $connexion->query($req);  
}
catch(PDOException $e){
	$message = "Problème pour d'accès".'<br>'.$e->getMessage();
	echo $message;
}

$donnees = $res->fetch(PDO::FETCH_ASSOC);

// L'IP ne se trouve pas dans la table, on va l'ajouter.
if ($donnees['nbre_entrees'] == 0) {
	$req = "INSERT INTO CONNECTES VALUES ip = '".$_SERVER['REMOTE_ADDR']."', timestamp = '".time()."';";
	$res = $connexion->query($req);  

}
// L'IP se trouve déjà dans la table, on met juste à jour le timestamp.
else {
	$req = "UPDATE CONNECTES SET timestamp = ".time()." WHERE ip = '". $_SERVER['REMOTE_ADDR']."';";
	try {  
		$res = $connexion->query($req);  
	}
	catch(PDOException $e){
		$message = "Problème d'accès aux ip";
	}
}

// -------
// ÉTAPE 2 : on supprime toutes les entrées dont le timestamp est plus vieux que 5 minutes.

// On stocke dans une variable le timestamp qu'il était il y a 5 minutes :
$timestamp_5min = time() - (60 * 5); // 60 * 5 = nombre de secondes écoulées en 5 minutes
$req = "DELETE FROM CONNECTES WHERE timestamp < ".$timestamp_5min.";";
try {  
	$res = $connexion->query($req);  
}
catch(PDOException $e){
	$message = "Problème pour d'accès".'<br>'.$e->getMessage();
	echo $message;
}

// -------
// ÉTAPE 3 : on compte le nombre d'IP stockées dans la table. C'est le nombre de visiteurs connectés.
$req = "SELECT COUNT(*) AS nbre_entrees FROM CONNECTES;";
try {  
	$res = $connexion->query($req);  
}
catch(PDOException $e){
	$message = "Problème pour d'accès".'<br>'.$e->getMessage();
	echo $message;
}