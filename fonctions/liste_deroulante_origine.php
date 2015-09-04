<?php
	/*
		Cette fonction liste les promotions.
		En paramètre d'entrée, il y a la variable connexion pour intéragir avec la base de données
		et le code_date afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante de dates
	*/
	function lister_origine($connexion,$code_origine)
	{
		// on remplit la liste des fonctions
		$requete="SELECT ID_ORIGINE, BAC_ORIGINE FROM origine;";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations sur les diplomes acquis.<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_origine="\n<select name='BAC_ORIGINE'>\n";
		$i=0;
		foreach($tableau as $ligne)
		{
			$selected="";
			if($ligne['ID_ORIGINE']==$code_origine)
			{
				$selected=" selected='selected'";
			}
			$liste_origine=$liste_origine."<option value='".$ligne['ID_ORIGINE']."' $selected>".$ligne['BAC_ORIGINE']."</option>";
		}
		$liste_origine=$liste_origine."</select>";
		return $liste_origine;
	}
?>