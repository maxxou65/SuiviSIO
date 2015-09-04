<?php
	/*
		Cette fonction liste les promotions.
		En paramètre d'entrée, il y a la variable connexion pour intéragir avec la base de données
		et le code_date afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante de dates
	*/
	function lister_promotion($connexion,$code_promotion)
	{
		// on remplit la liste des fonctions
		$requete="select ID_PROMOTION, ANNEE from promotion;";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations sur les promotions.<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_promo="\n<select name='ID_PROMOTION'>\n";
		foreach($tableau as $ligne)
		{
			$selected="";
			if($ligne['ID_PROMOTION']==$code_promotion)
			{
				$selected=" selected='selected'";
			}
			$liste_promo=$liste_promo."<option value='".$ligne['ID_PROMOTION']."' $selected>".$ligne['ANNEE']."</option>\n";
		}
		$liste_promo=$liste_promo."</select>";
		return $liste_promo;
	}
?>