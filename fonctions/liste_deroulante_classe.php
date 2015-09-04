<?php
	/*
		Cette fonction liste les classes.
		En paramètre d'entrée, il y a la variable connexion pour intéragir avec la base de données
		et le code_classe afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante de classes
	*/
	function lister_classe($connexion,$code_classe)
	{
		// on remplit la liste des fonctions
		$requete="SELECT CODE_CLASSE FROM classe ORDER BY CODE_CLASSE DESC;";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations des classes<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_classe="\n<select name='CODE_CLASSE' id='CODE_CLASSE'>\n";
		$i=0;
		foreach($tableau as $ligne)
		{
			//*
			$selected="";
			if($ligne['CODE_CLASSE']==$code_classe)
			{
				$selected=" selected='selected'";
			}//*/
			$liste_classe=$liste_classe."<option value='".$ligne['CODE_CLASSE']."' $selected>".$ligne['CODE_CLASSE']."</option>\n";
		}
		$liste_classe=$liste_classe."</select>";
		return $liste_classe;
	}
?>