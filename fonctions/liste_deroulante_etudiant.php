<?php
	/*
		Cette fonction liste les étudiants à qui un stage n'a pas encore été attribué
		pour l'année en cours.
		En paramètre d'entrée, il y a la connexion  qui permet d'accéder la base de données 
		et l'id_etu afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante d'étudiants
	*/
	function lister_etudiant_sans_stage($connexion,$id_etu,$classe)
	{	
		// Ce qui est modifié entre les deux lignes ------- 
		// doit l'être aussi dans le fichier fonctions/recharger_liste_etudiant.php !
		// ---------------------------------------------------------------------- D'ICI
		//charger la liste des étudiants avec le sélectionné dans la liste
		$requete="select ID_ETU, PRENOM_ETU, NOM_ETU from etudiant
				where CODE_CLASSE='$classe' and ID_ETU not in(
												select stage.ID_ETU from stage
												inner join etudiant on etudiant.ID_ETU=stage.ID_ETU
												where stage.CLASSE_STAGE=etudiant.CODE_CLASSE);";
		// ---------------------------------------------------------------------- JUSQU'A ICI

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
		// Renvoyer la liste des étudiants
		return $liste_etudiant;
	}
	/*
		Cette fonction liste les étudiants.
		En paramètre d'entrée : 
		 - il y a la connexion  qui permet d'accéder la base de données 
		 - l'id_etu afin de vérifier la condition de test pour la selection
		 - la classe afin de retourner les étudiants correspondants
		Cette fonction retourne le code généré pour avoir une liste déroulante d'étudiants
	*/
	function lister_etudiant($connexion,$id_etu)
	{
		// on remplit la liste des fonctions
		$requete="select ID_ETU, PRENOM_ETU, NOM_ETU from etudiant 
				  where CODE_CLASSE like 'SIO%' or CODE_CLASSE like 'sio%'
				  order by NOM_ETU, PRENOM_ETU;";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations des étudiants<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_etudiant="\n<select name='ID_ETUDIANT' id='ID_ETUDIANT'>\n";
		foreach($tableau as $ligne)
		{
			$selected="";
			if($ligne['ID_ETU']==$id_etu)
			{
				$selected=" selected='selected'";
			}
			$liste_etudiant=$liste_etudiant."<option value='".$ligne['ID_ETU']."' $selected>".strtoupper($ligne['NOM_ETU'])." ".$ligne['PRENOM_ETU']."</option>\n";
		}
		$liste_etudiant=$liste_etudiant."</select>";
		return $liste_etudiant;
	}
	/*
		Cette fonction permet de faire une recherche des étudiants.
		En paramètre d'entrée, il y a la connexion  qui permet d'accéder la base de données 
		et l'id_etu afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante d'étudiants
	*/
	function rechercher_etudiant($connexion,$id_etu)
	{
		// on remplit la liste des fonctions
		$requete="select ID_ETU, PRENOM_ETU, NOM_ETU from etudiant order by NOM_ETU, PRENOM_ETU;";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations des étudiants<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_etudiant="\n<input list='ID_ETUDIANT' name='ID_ETUDIANT'>\n";
		$liste_etudiant=$liste_etudiant."\n<datalist id='ID_ETUDIANT'>\n";
		foreach($tableau as $ligne)
		{
			$liste_etudiant=$liste_etudiant."<option value='".$ligne['ID_ETU']."'>".$ligne['NOM_ETU']." ".$ligne['PRENOM_ETU']."</option>\n";
		}
		$liste_etudiant=$liste_etudiant."</datalist>";
		return $liste_etudiant;
	}
?>