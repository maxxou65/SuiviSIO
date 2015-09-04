<?php
/*
 * /!\ NE PAS UTILISER CE FICHIER /!\
 */
session_start();
if(!isset($_SESSION['CONNEXION'])){
	echo "<script>alert('Vous ne devriez pas utiliser ce fichier session.php, lisez la note \"important\" dans la racine à la date du 10/12');</script>"
	header('Location: ../utilisateur_inconnu.php');
	exit;
} else {
	// création de la connexion vers la base
	// n'hésitez pas à améliorer le fichier connexion.php si besoin est
	// mais faites une copie avec un nom différent
	if (!(isset($connexion))) {
		include_once("../connexion/connexion_by_id.php");
		$identifiant = strtolower($_SESSION['CONNEXION']['ID_CONNEXION']);
		$mdp = strtolower($_SESSION['CONNEXION']['MDP_CONNEXION']);
		$connexion = getConnexion($identifiant, $mdp);
	}
}
function newLineMsg($message) {
	$message = '<li>'.$message.'</li>';
	return $message;
}
?>