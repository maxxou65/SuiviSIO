<?php
	//inclusion de la connexion
	include("../connexion/session.php");
	$code_classe=$_GET['CODE_CLASSE'];
	//charger la liste des étudiants avec le sélectionné dans la liste
	$requete="select ID_ETU, PRENOM_ETU, NOM_ETU from etudiant 
				where CODE_CLASSE='$code_classe' and ID_ETU not in(
												select stage.ID_ETU from stage
												inner join etudiant on etudiant.ID_ETU=stage.ID_ETU
												where stage.CLASSE_STAGE=etudiant.CODE_CLASSE);";
		//order by NOM_ETU, PRENOM_ETU;";
	//$requete="select ID_ETU, PRENOM_ETU, NOM_ETU from ETUDIANT;";

	$resultats=$connexion->query($requete);
	$tab_E=$resultats->fetchALL(PDO::FETCH_ASSOC);
	try{
		$resultats=$connexion->query($requete);
	}
	catch(PDOException $e){
		$message="probleme pour acceder aux informations des employés<br/>";
		$message=$message.$e->getMessage();
	}
	$liste_etudiant="<select name='ID_ETUDIANT' id='ID_ETUDIANT' >\n";
	foreach($tab_E as $ligne){
		$liste_etudiant=$liste_etudiant."<option value='".$ligne['ID_ETU']."'>".strtoupper($ligne['NOM_ETU'])." ".$ligne['PRENOM_ETU']."</option>\n";
	}
	$liste_etudiant=$liste_etudiant."</select>";
	// Renvoyer la liste au client
	echo $liste_etudiant;
?>