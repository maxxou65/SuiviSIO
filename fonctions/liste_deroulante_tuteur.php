<?php
	/*
		Cette fonction liste les �tudiants.
		En param�tre d'entr�e, il y a la variable connexion pour int�ragir avec la base de donn�es
		et l'id_etu afin de v�rifier la condition de test pour la selection
		Cette fonction retourne le code g�n�r� pour avoir une liste d�roulante d'�tudiants
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
			$message="probl�me pour acc�der aux informations des �tudiants<br/>";
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