<?php
	/*
		Cette fonction liste les promotions.
		En paramètre d'entrée, il y a la variable connexion pour intéragir avec la base de données
		et le code_date afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante de dates
	*/
	function lister_specialite($connexion,$code_spe)
	{
		// on remplit la liste des fonctions
		$requete="SELECT CODE_SPECIALITE FROM specialite;";
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
		$liste_spe="\n<select name='CODE_SPECIALITE'>\n";
		foreach($tableau as $ligne)
		{
			$selected="";
			if($ligne['CODE_SPECIALITE']==$code_spe)
			{
				$selected=" selected='selected'";
			}
			$liste_spe=$liste_spe."<option value='".$ligne['CODE_SPECIALITE']."' $selected>".$ligne['CODE_SPECIALITE']."</option>\n";
		}
		$liste_spe=$liste_spe."</select>";
		return $liste_spe;
	}
?>