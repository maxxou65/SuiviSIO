<?php
	/*
		Cette fonction liste les étudiants.
		En paramètre d'entrée, il y a la variable connexion pour intéragir avec la base de données
		et l'id_etu afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante d'étudiants
	*/
	function lister_tuteur($connexion,$id_tuteur)
	{
		// on remplit la liste des fonctions
		$requete="select ID_TUTEUR, PRENOM_TUTEUR, NOM_TUTEUR from tuteur order by NOM_TUTEUR, PRENOM_TUTEUR;";
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
		$liste_tuteur="\n<select name='ID_TUTEUR'>\n";
		foreach($tableau as $ligne)
		{
			$selected="";
			if($ligne['ID_TUTEUR']==$id_tuteur)
			{
				$selected=" selected='selected'";
			}
			$liste_tuteur=$liste_tuteur."<option value='".$ligne['ID_TUTEUR']."' $selected>".strtoupper($ligne['NOM_TUTEUR'])." ".$ligne['PRENOM_TUTEUR']."</option>\n";
		}
		$liste_tuteur=$liste_tuteur."</select>";
		return $liste_tuteur;
	}
?>