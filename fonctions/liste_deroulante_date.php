<?php
	/*
		Cette fonction liste les dates de stage.
		En paramètre d'entrée, il y a la variable connexion pour intéragir avec la base de données
		et le code_date afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante de dates
	*/
	function lister_date($connexion,$code_date)	{
		// on remplit la liste des fonctions
		$requete="SELECT ID_DPERIODE, DATE_DEBUT, DATE_FIN 
				  FROM dperiode 
				  WHERE YEAR(DATE_DEBUT) in(
					 SELECT YEAR(MAX(DATE_DEBUT))
					 FROM dperiode
				  )
				  ORDER BY DATE_DEBUT;";
		
		try {
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e) {
			$message="problème pour accéder aux informations sur les dates de stages".'<br>'.$e->getMessage();
		}

		$liste_date="\n<select name='ID_DPERIODE'>\n";

		foreach($tableau as $ligne) {
			$selected="";
			if($ligne['ID_DPERIODE']==$code_date)
				$selected=" selected";
			$liste_date.="<option value='".$ligne['ID_DPERIODE']."' $selected>".$ligne['DATE_DEBUT']." au ".$ligne['DATE_FIN']."</option>\n";
		}

		$liste_date.="</select>";
		return $liste_date;
	}
?>