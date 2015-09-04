<?php
	/*
		Cette fonction liste les professeurs supervisant un stage.
		En paramètre d'entrée, il y a la variable connexion pour intéragir avec la base de données
		et l'id_prof afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante de professeurs
	*/
	function lister_superviseur($connexion,$id_prof)
	{
		// on remplit la liste des fonctions
		$requete="select ID_PROF, PRENOM_PROF, NOM_PROF from professeur order by NOM_PROF,PRENOM_PROF ;";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations des superviseurs<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_superviseur="\n<select name='ID_PROF_SUPERVISEUR'>\n";
		foreach($tableau as $ligne)
		{
			$selected="";
			if($ligne['ID_PROF']==$id_prof)
			{
				$selected=" selected='selected'";
			}
			$liste_superviseur=$liste_superviseur."<option value='".$ligne['ID_PROF']."' $selected>".strtoupper($ligne['NOM_PROF'])." ".$ligne['PRENOM_PROF']."</option>\n";
		}
		$liste_superviseur=$liste_superviseur."</select>";
		return $liste_superviseur;
	}
	/*
		Cette fonction liste les professeurs visitant une entreprise pendant un stage.
		En paramètre d'entrée, il y a l'id_prof afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante de professeurs
	*/
	function lister_visiteur($connexion,$id_prof)
	{
		// on remplit la liste des fonctions
		$requete="select ID_PROF, PRENOM_PROF, NOM_PROF from professeur order by NOM_PROF,PRENOM_PROF;";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations des visiteurs<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_visiteur="\n<select name='ID_PROF_VISITEUR'>\n";
		//$liste_visiteur=$liste_visiteur."<option></option>";
		foreach($tableau as $ligne)
		{
			$selected="";
			if($ligne['ID_PROF']==$id_prof)
			{
				$selected=" selected='selected'";
			}
			$liste_visiteur=$liste_visiteur."<option value='".$ligne['ID_PROF']."' $selected>".strtoupper($ligne['NOM_PROF'])." ".$ligne['PRENOM_PROF']."</option>\n";
		}
		$liste_visiteur=$liste_visiteur."</select>";
		return $liste_visiteur;
	}
?>