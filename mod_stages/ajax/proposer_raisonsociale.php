<?php

include_once('../../connexion/session.php');

if (isset($_GET['NOM'])) {
	$nom = $_GET['NOM'];
	$sql ="SELECT `NOM_ENTREPRISE` FROM `entreprise` WHERE `NOM_ENTREPRISE` LIKE '%$nom%';";
	try {
		$res = $connexion->query($sql); 
		$table = $res->fetchAll(PDO::FETCH_ASSOC);		
	} catch(PDOException $e){
		echo $e->getMessage();
	}

	$nom = "";

	foreach ($table as $row) {
		$nom .= $row['NOM_ENTREPRISE'].'<br>';
	}

	echo $nom;
}

?>