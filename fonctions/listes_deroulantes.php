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
	/*
		Cette fonction liste les classes.
		En paramètre d'entrée, il y a la variable connexion pour intéragir avec la base de données
		et le code_classe afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante de classes
	*/
	function lister_classe($connexion,$code_classe,$i)
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
		$liste_classe="\n<select name='tab[".$i."][CODE_CLASSE]'>\n";
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

	/*
		Cette fonction liste les dates de stage.
		En paramètre d'entrée, il y a la variable connexion pour intéragir avec la base de données
		et le code_date afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante de dates
	*/
	function lister_date($connexion,$code_date)	{
		// on remplit la liste des fonctions
		$requete="SELECT ID_DPERIODE, DATE_DEBUT, DATE_FIN FROM dperiode ORDER BY DATE_DEBUT;";
		try {
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e) {
			$message="problème pour accéder aux informations sur les dates de stages<br>";
			$message.=$e->getMessage();
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

	/*
		Cette fonction liste les entreprises.
		En paramètre d'entrée, il y a la connexion  qui permet d'accéder la base de données 
		et l'id_etu afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante d'entreprise
	*/
	// PAS FINI D'ÊTRE MODIFIEE!
	function lister_entreprise($connexion,$id_entr)
	{
		// on remplit la liste des fonctions
		$requete="select ID_ENTREPRISE, NOM_ENTREPRISE from entreprise order by NOM_ENTREPRISE";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations des entreprises<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_entreprise="\n<select name='ID_ENTREPRISE'>\n";
		foreach($tableau as $ligne)
		{
			$selected="";
			if($ligne['ID_ENTREPRISE']==$id_entr)
			{
				$selected=" selected='selected'";
			}
			$liste_entreprise=$liste_entreprise."<option value='".$ligne['ID_ENTREPRISE']."' $selected>".$ligne['NOM_ENTREPRISE']."</option>\n";
		}
		$liste_entreprise=$liste_entreprise."</select>";
		return $liste_entreprise;
	}
	function rechercher_entreprise($connexion,$id_entr)
	{
		// on remplit la liste des fonctions
		$requete="select ID_ENTREPRISE, NOM_ENTREPRISE from ENTREPRISE order by NOM_ENTREPRISE;";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations des entreprises<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_entreprise="\n<input list='ID_ENTREPRISE' name='ID_ENTREPRISE'>\n";
		$liste_entreprise=$liste_entreprise."\n<datalist id='ID_ENTREPRISE'>\n";
		foreach($tableau as $ligne)
		{
			$liste_entreprise=$liste_entreprise."<option value='".$ligne['ID_ENTREPRISE']."'>".$ligne['NOM_ENTREPRISE'];
		}
		$liste_entreprise=$liste_entreprise."</datalist>";
		return $liste_entreprise;
	}

	/*
		Cette fonction liste les étudiants.
		En paramètre d'entrée, il y a la connexion  qui permet d'accéder la base de données 
		et l'id_etu afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante d'étudiants
	*/
	function lister_etudiant2($connexion,$id_etu,$classe)
	{
		//charger la liste des étudiants avec le sélectionné dans la liste
		$requete="select ID_ETU, PRENOM_ETU, NOM_ETU from etudiant 
			where CODE_CLASSE='$classe'";
			//order by NOM_ETU, PRENOM_ETU;";
		//$requete="select ID_ETU, PRENOM_ETU, NOM_ETU from ETUDIANT;";

		$resultats=$connexion->query($requete);
		$tab_E=$resultats->fetchALL(PDO::FETCH_ASSOC);
		try{
			$resultats=$connexion->query($requete);
		}
		catch(PDOException $e){
			$message="probleme pour acceder aux informations des employés<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_etudiant="<select name='ID_ETUDIANT' id='ID_ETUDIANT' >\n";
		foreach($tab_E as $ligne){
			$liste_etudiant=$liste_etudiant."<option value='".$ligne['ID_ETU']."'>".strtoupper($ligne['NOM_ETU'])." ".$ligne['PRENOM_ETU']."</option>\n";
		}
		$liste_etudiant=$liste_etudiant."</select>";
		// Renvoyer la liste des étudiants
		return $liste_etudiant;
	}
	/*
		Cette fonction liste les étudiants.
		En paramètre d'entrée : 
		 - il y a la connexion  qui permet d'accéder la base de données 
		 - l'id_etu afin de vérifier la condition de test pour la selection
		 - la classe afin de retourner les étudiants correspondants
		Cette fonction retourne le code généré pour avoir une liste déroulante d'étudiants
	*/
	function lister_etudiant($connexion,$id_etu)
	{
		// on remplit la liste des fonctions
		$requete="select ID_ETU, PRENOM_ETU, NOM_ETU from etudiant 
				  where CODE_CLASSE like 'SIO%'
				  order by NOM_ETU, PRENOM_ETU;";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations des étudiants<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_etudiant="\n<select name='ID_ETUDIANT' id='ID_ETUDIANT'>\n";
		foreach($tableau as $ligne)
		{
			$selected="";
			if($ligne['ID_ETU']==$id_etu)
			{
				$selected=" selected='selected'";
			}
			$liste_etudiant=$liste_etudiant."<option value='".$ligne['ID_ETU']."' $selected>".strtoupper($ligne['NOM_ETU'])." ".$ligne['PRENOM_ETU']."</option>\n";
		}
		$liste_etudiant=$liste_etudiant."</select>";
		return $liste_etudiant;
	}
	/*
		Cette fonction permet de faire une recherche des étudiants.
		En paramètre d'entrée, il y a la connexion  qui permet d'accéder la base de données 
		et l'id_etu afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante d'étudiants
	*/
	function rechercher_etudiant($connexion,$id_etu)
	{
		// on remplit la liste des fonctions
		$requete="select ID_ETU, PRENOM_ETU, NOM_ETU from etudiant order by NOM_ETU, PRENOM_ETU;";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations des étudiants<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_etudiant="\n<input list='ID_ETUDIANT' name='ID_ETUDIANT'>\n";
		$liste_etudiant=$liste_etudiant."\n<datalist id='ID_ETUDIANT'>\n";
		foreach($tableau as $ligne)
		{
			$liste_etudiant=$liste_etudiant."<option value='".$ligne['ID_ETU']."'>".$ligne['NOM_ETU']." ".$ligne['PRENOM_ETU']."</option>\n";
		}
		$liste_etudiant=$liste_etudiant."</datalist>";
		return $liste_etudiant;
	}

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
		$liste_origine="\n<input list='origine'><datalist id='origine'>\n";
		foreach($tableau as $ligne)
		{
			$liste_origine=$liste_origine."<option value='".$ligne['BAC_ORIGINE']."'>";
		}
		$liste_origine=$liste_origine."</datalist>";
		return $liste_origine;
	}
	/*
		Cette fonction liste les professeurs supervisant un stage.
		En paramètre d'entrée, il y a la variable connexion pour intéragir avec la base de données
		et l'id_prof afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante de professeurs
	*/
	function lister_superviseur($connexion,$id_prof)
	{
		// on remplit la liste des fonctions
		$requete="select ID_PROF, PRENOM_PROF, NOM_PROF from professeur order by NOM_PROF,PRENOM_PROF ;";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations des superviseurs<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_superviseur="\n<select name='ID_PROF_SUPERVISEUR'>\n";
		foreach($tableau as $ligne)
		{
			$selected="";
			if($ligne['ID_PROF']==$id_prof)
			{
				$selected=" selected='selected'";
			}
			$liste_superviseur=$liste_superviseur."<option value='".$ligne['ID_PROF']."' $selected>".strtoupper($ligne['NOM_PROF'])." ".$ligne['PRENOM_PROF']."</option>\n";
		}
		$liste_superviseur=$liste_superviseur."</select>";
		return $liste_superviseur;
	}
	/*
		Cette fonction liste les professeurs visitant une entreprise pendant un stage.
		En paramètre d'entrée, il y a l'id_prof afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante de professeurs
	*/
	function lister_visiteur($connexion,$id_prof)
	{
		// on remplit la liste des fonctions
		$requete="select ID_PROF, PRENOM_PROF, NOM_PROF from professeur order by NOM_PROF,PRENOM_PROF;";
		$tableau=array();
		try{
			$resultats=$connexion->query($requete);
			$tableau=$resultats->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$message="problème pour accéder aux informations des visiteurs<br/>";
			$message=$message.$e->getMessage();
		}
		$liste_visiteur="\n<select name='ID_PROF_VISITEUR'>\n";
		//$liste_visiteur=$liste_visiteur."<option></option>";
		foreach($tableau as $ligne)
		{
			$selected="";
			if($ligne['ID_PROF']==$id_prof)
			{
				$selected=" selected='selected'";
			}
			$liste_visiteur=$liste_visiteur."<option value='".$ligne['ID_PROF']."' $selected>".strtoupper($ligne['NOM_PROF'])." ".$ligne['PRENOM_PROF']."</option>\n";
		}
		$liste_visiteur=$liste_visiteur."</select>";
		return $liste_visiteur;
	}

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

	/*
		Cette fonction liste les promotions.
		En paramètre d'entrée, il y a la variable connexion pour intéragir avec la base de données
		et le code_date afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante de dates
	*/
	function lister_regime($connexion,$code_regime,$i)
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
		$liste_regime="\n<select name='tab[".$i."][REGIME]'>\n";
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

	/*
		Cette fonction liste les promotions.
		En paramètre d'entrée, il y a la variable connexion pour intéragir avec la base de données
		et le code_date afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante de dates
	*/
	function lister_specialite($connexion,$code_spe,$i)
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
		$liste_spe="\n<select name='tab[".$i."][CODE_SPECIALITE]'>\n";
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

	/*
		Cette fonction liste les étudiants.
		En paramètre d'entrée, il y a la variable connexion pour intéragir avec la base de données
		et l'id_etu afin de vérifier la condition de test pour la selection
		Cette fonction retourne le code généré pour avoir une liste déroulante d'étudiants
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
			$message="problème pour accéder aux informations des étudiants<br/>";
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