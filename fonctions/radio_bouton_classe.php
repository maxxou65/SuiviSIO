<?php
	function donner_radio_bouton_classe($connexion,$code_classe){
	// on remplit la liste des fonctions
		$requete="select CODE_CLASSE from classe where CODE_CLASSE!='DIPLOME'";
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
		$radio_boutons="";
		$i=0;
		foreach($tableau as $ligne)
		{
			// On bloque le bouton sélectionné pour qu'il reste coché à l'endroit où il était
			// après la validation du formulaire grace au paramètre d'entrée $code_classe de la fonction
			$selected="";
			if($code_classe=="SIO1" && $i==0){
				$selected="checked";
			}
			if($code_classe=="SIO2" && $i==1){
				$selected="checked";
			}
			$i++;
			// On met en place la structure permettant de créer les boutons radios
			$radio_boutons=$radio_boutons."<input type='radio' 
												  name='CODE_CLASSE' 
												  id='".strtolower($ligne['CODE_CLASSE'])."'
												  value='".$ligne['CODE_CLASSE']."' $selected/>
			<label class='.classe' for=".$ligne['CODE_CLASSE']." ";
			$radio_boutons=$radio_boutons."> ".strtolower($ligne['CODE_CLASSE'])."</label>\n";
		}
		// On renvoie le code html correspondant aux données
		return $radio_boutons;
	}
	
?>