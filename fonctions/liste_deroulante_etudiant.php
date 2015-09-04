<?php
	/*
		Cette fonction liste les �tudiants � qui un stage n'a pas encore �t� attribu�
		pour l'ann�e en cours.
		En param�tre d'entr�e, il y a la connexion  qui permet d'acc�der la base de donn�es 
		et l'id_etu afin de v�rifier la condition de test pour la selection
		Cette fonction retourne le code g�n�r� pour avoir une liste d�roulante d'�tudiants
	*/
	function lister_etudiant_sans_stage($connexion,$id_etu,$classe)
	{	
		// Ce qui est modifi� entre les deux lignes ------- 
		// doit l'�tre aussi dans le fichier fonctions/recharger_liste_etudiant.php !
		// ---------------------------------------------------------------------- D'ICI
		//charger la liste des �tudiants avec le s�lectionn� dans la liste
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
			$message="probleme pour acceder aux informations des employ�s<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_etudiant="<select name='ID_ETUDIANT' id='ID_ETUDIANT' >\n";
		foreach($tab_E as $ligne){
			$liste_etudiant=$liste_etudiant."<option value='".$ligne['ID_ETU']."'>".strtoupper($ligne['NOM_ETU'])." ".$ligne['PRENOM_ETU']."</option>\n";
		}
		$liste_etudiant=$liste_etudiant."</select>";
		// Renvoyer la liste des �tudiants
		return $liste_etudiant;
	}
	/*
		Cette fonction liste les �tudiants.
		En param�tre d'entr�e : 
		 - il y a la connexion  qui permet d'acc�der la base de donn�es 
		 - l'id_etu afin de v�rifier la condition de test pour la selection
		 - la classe afin de retourner les �tudiants correspondants
		Cette fonction retourne le code g�n�r� pour avoir une liste d�roulante d'�tudiants
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
			$message="probl�me pour acc�der aux informations des �tudiants<br/>";
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
		Cette fonction permet de faire une recherche des �tudiants.
		En param�tre d'entr�e, il y a la connexion  qui permet d'acc�der la base de donn�es 
		et l'id_etu afin de v�rifier la condition de test pour la selection
		Cette fonction retourne le code g�n�r� pour avoir une liste d�roulante d'�tudiants
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
			$message="probl�me pour acc�der aux informations des �tudiants<br/>";
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