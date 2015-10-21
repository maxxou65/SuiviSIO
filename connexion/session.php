<?php
session_start();

if(!isset($_SESSION['CONNEXION'])){

	header('Location: ../utilisateur_inconnu.php');
	exit;

} else {

	include_once('connexion.php');

	$id = $_SESSION['CONNEXION']['ID'];
	$mdp = $_SESSION['CONNEXION']['MDP'];

	$connexion = getConnexion();
	
}

function newLineMsg($message) {
	$message = '<li>'.$message.'</li>';
	return $message;
}

$path = $_SERVER['PHP_SELF']; 
$file = basename ($path); 

if ($_SESSION['CONNEXION']['ID'] != 'enseignant' && ($file == 'ajout_etudiants.php' || $file == 'expl_donnes_stages.php')) {

}
?>
