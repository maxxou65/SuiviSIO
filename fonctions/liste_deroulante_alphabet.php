<?php
	// Cette fonction sert à avoir une liste déroulante de toutes les lettres de l'alphabet,
	// afin de faciliter la recherche d'une personne par sa lettre de nom de famille.
	// -------------------------------------------------------------------
	// Il y a deux paramètres d'entrée:
	// -------------------------------------------------------------------
	// $id qui récupère l'id de la liste déroulante de lettre d'alphabet
	// $lettre_alphabet qui permet de savoir la lettre sélectionnée
	// -------------------------------------------------------------------
	function lister_alphabet($id,$class,$lettre_alphabet){
		$alphabet=array();
		$liste_lettre="\n<select name='".$id."' class='".$class."'>\n";
		// Les lettres de l'alphabet en majuscule vont de 65 à 90 inclus.
		for($i=0;$i<=90-65;$i++){
			// On récupère les caractères avec la fonction chr() de php
			$alphabet[$i]=chr($i+65);
			$liste_lettre=$liste_lettre."<option value='".$alphabet[$i]."'>".$alphabet[$i]."</option>\n";
		}
		$liste_lettre=$liste_lettre."</select>";
		return $liste_lettre;
	}
?>