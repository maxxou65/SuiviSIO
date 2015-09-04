<?php
	/*
		Cette fonction liste les entreprises.
		En paramètre d'entrée, il y a la connexion  qui permet d'accéder la base de données 
		et l'id_etu afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante d'entreprise
	*/
	// PAS FINI D'ÊTRE MODIFIEE!
	function lister_entreprise($connexion,$id_entr)
	{
		// on remplit la liste des fonctions
		$requete="select ID_ENTREPRISE, NOM_ENTREPRISE from entreprise order by NOM_ENTREPRISE";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations des entreprises<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_entreprise="\n<select name='ID_ENTREPRISE'>\n";
		foreach($tableau as $ligne)
		{
			$selected="";
			if($ligne['ID_ENTREPRISE']==$id_entr)
			{
				$selected=" selected='selected'";
			}
			$liste_entreprise=$liste_entreprise."<option value='".$ligne['ID_ENTREPRISE']."' $selected>".$ligne['NOM_ENTREPRISE']."</option>\n";
		}
		$liste_entreprise=$liste_entreprise."</select>";
		return $liste_entreprise;
	}
	function rechercher_entreprise($connexion,$id_entr)
	{
		// on remplit la liste des fonctions
		$requete="select ID_ENTREPRISE, NOM_ENTREPRISE from entreprise order by NOM_ENTREPRISE;";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations des entreprises<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_entreprise="\n<input list='ID_ENTREPRISE' name='ID_ENTREPRISE'>\n";
		$liste_entreprise=$liste_entreprise."\n<datalist id='ID_ENTREPRISE'>\n";
		foreach($tableau as $ligne)
		{
			$liste_entreprise=$liste_entreprise."<option value='".$ligne['ID_ENTREPRISE']."'>".$ligne['NOM_ENTREPRISE'];
		}
		$liste_entreprise=$liste_entreprise."</datalist>";
		return $liste_entreprise;
	}
?>