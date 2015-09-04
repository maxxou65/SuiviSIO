<?php
	/*
		Cette fonction liste les promotions.
		En paramètre d'entrée, il y a la variable connexion pour intéragir avec la base de données
		et le code_date afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante de dates
	*/
	function lister_regime($connexion,$code_regime)
	{
		// on remplit la liste des fonctions
		$requete="select REGIME from regime;";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations sur les régimes.<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_regime="\n<select name='REGIME'>\n";
		foreach($tableau as $ligne)
		{
			$selected="";
			if($ligne['REGIME']==$code_regime)
			{
				$selected=" selected='selected'";
			}
			$liste_regime=$liste_regime."<option value='".$ligne['REGIME']."' $selected>".$ligne['REGIME']."</option>\n";
		}
		$liste_regime=$liste_regime."</select>";
		return $liste_regime;
	}
?>