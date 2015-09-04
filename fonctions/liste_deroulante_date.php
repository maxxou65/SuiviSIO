<?php
	/*
		Cette fonction liste les dates de stage.
		En param�tre d'entr�e, il y a la variable connexion pour int�ragir avec la base de donn�es
		et le code_date afin de v�rifier la condition de test pour la selection
		Cette fonction retourne le code g�n�r� pour avoir une liste d�roulante de dates
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
			$message="probl�me pour acc�der aux informations sur les dates de stages".'<br>'.$e->getMessage();
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