	<?php
	/**
	 * @see http://www.phpdoc.org/
	 * ---------------------------
	 *
	 * Formulaire d'ajout d'une entreprise
	 * 
	 * Permet à l'utilisateur d'ajouter une entreprise avec son contact
	 * 
	 *
	 * Vérification des données requises avant l'envoie de la requête pour remplir la base de données
	 * 
	 *
	 *
	 * @package mod_stages
	 *
	 * @version 1.0.0
	 *
	 * @author Anthony Lozano
	 */



	/** 
	 * Inclusion de la session
	 * Définition du module. A améliorer
	 *
	 * @var string $mod Définit le module pour les inclusions (en-tête, menu vertical)
	 */
	include_once('../connexion/session.php');
	$_SESSION['MOD'] = "_"."stages";
	$mod = $_SESSION['MOD'];



	/**
	 * Permet l'affichage de la liste des raisons sociales contenu dans la base de donnèes dans le champs 'NOM' (ou raison sociale) du formulaire
	 *
	 * @param object $connexion Instance de l'objet PDO permettant la connexion et le dialogue avec la base 
	 * 
	 * @return string $liste contient les éléments HTML (<datalist>) permettant d'afficher la liste des raisons sociales d'entreprises sur le champ 'raison sociale'
	 */

	function listNom($connexion)
    {
		$sql ="SELECT `NOM_ENTREPRISE` FROM `entreprise`;";
		try 
        {
			$res = $connexion->query($sql); 
			$table = $res->fetchAll(PDO::FETCH_ASSOC);		
		} catch(PDOException $e){
			$message = newLineMsg($e->getMessage());
		}
		$liste = '<datalist id="raisons_sociales"';
		foreach ($table as $row) 
        {
			$liste .= '<option value="'.$row['NOM_ENTREPRISE'].'">';
		}
		$liste .= '</datalist>';

		echo $liste;
	}

	/**
	 * Permet l'affichage de la liste des types  contenu dans la base de donnèes dans le champs 'Type' (ou type entreprise) du formulaire
	 *
	 * @param object $connexion Instance de l'objet PDO permettant la connexion et le dialogue avec la base 
	 * 
	 * @return string $type contient les éléments HTML (<datalist>) permettant d'afficher la liste des types  d'entreprises sur le champ 'type'
	 */

	function listType($connexion)
    {
		$sql="SELECT `TYPE`,`ID_TYPE_ENTREPRISE` FROM `type_entreprise`;";
		try 
        {
			$res = $connexion->query($sql); 
			$table = $res->fetchAll(PDO::FETCH_ASSOC);		
		} 
        catch(PDOException $e)
        {
			$message = newLineMsg($e->getMessage());
		}
		$type = '<select name="TYPE" list="type_entreprise" id="type" class="defaut" tabindex="2" required>';
		foreach ($table as $row) 
        {
			$type .= '<option value="'.$row['ID_TYPE_ENTREPRISE'].'">'.$row['TYPE'];
		}
		$type .= '</select>';

		echo $type;
	}


	/**
	 * Formate les entrées du formulaire, afin d'éviter toute faile de sécurité (injections sql et failles XSS notament)
	 *
	 * @param mixed $data Données à formater (chaîne, nombre, date, ...)
	 * 
	 * @return mixed Données passer en paramètre formaté
	 */
	function test_input($data) 
    {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}






	/**
	 * Déclaration et initialisation des couples de variables utilisée dans le formulaire
	 * - Valeurs des données rentré par l'utilisateur, pour garder les entrées en cas d'erreur, où les envoyés dans la base
	 * - Erreurs à afficher dans le cas où le formulaire est incorrect 
	 */

	// Champs correspondant à l'entreprise
	$nom = 	$type = $adresse = 	$cpost = $ville = $mail_ent =$tel_ent = "";

	// Erreurs des champs
	$nomErr = $typeErr = $adresseErr = $cpostErr = $villeErr = $mail_entErr= $tel_entErr= "";

	// Champs correspondant au contact
	$nom_contact = $prenom_contact = $tel_contact = $mail_contact = "";

	// Erreurs des champs
	$nom_contactErr = $prenom_contactErr  = $tel_contactErr = $mail_contactErr = "";



	if ($_SERVER["REQUEST_METHOD"] == "POST") 
    { // Si le formulaire est envoyé

		/** @var boolean détermine si le formulaire est correct ou pas */
		$formulaireCorrect = TRUE;
		$message='';


		// récupération des entrées pour l'entreprise du formulaire dans des variables intermédiaires
		
		$type=$_POST['TYPE'];
		$adresse = $_POST['ADRESSE'];
		$cpost = $_POST['CPOST'];
		$ville = $_POST['VILLE'];
		$nom = $_POST['NOM'];
		$mail_ent=$_POST['MAIL_ENT'];
		$tel_ent=$_POST['TEL_ENT'];



		/**
		 * Vérification de la raison sociale (nom) 
		 * - Requis
		 * - Pas de condition de validation particulière 
		 */
		if (empty($nom)) 
        {
			$nomErr = "Nom obligatoire";
			$formulaireCorrect = FALSE;
		} 
        else 
        {
			$nom = test_input($nom);
		}



		/**
		 * Vérification du type
		 * - Requis
		 * - Pas de condition de validation particulière 
		 */
		if (empty($type)) 
        {
			$typeErr = "Type d'entreprise obligatoire";
			$formulaireCorrect = FALSE;
		} 
        else 
        {
			$type = test_input($type);
		}



		/**
		 * Vérification de l'adresse
		 * - Optionnel
		 * - Pas de condition de validation particulière 
		 */
		$adresse = test_input($adresse);



		/**
		 * Vérification du code postal 
		 * - Optionnel
		 * - 5 chiffres maximum
		 */
		if (empty($cpost))
        {
			$cpost = "NULL";
		} 
        else 
        {
			$cpost = test_input($cpost);
			if(strlen($cpost) < 5) 
            {
				$cpostErr = "Seulement 5 chiffres sont acceptés"; 
				$formulaireCorrect = FALSE;
			}
		}



		/**
		 * Vérification de la ville
		 * - Optionnel
		 * - Pas de condition de validation particulière 
		 */
		if (empty($ville)) 
        {
			$villeErr = "Ville obligatoire";
			$formulaireCorrect = FALSE;
		} 
        else 
        {
			$ville = test_input($ville);
		}

		/*
		 * Vérification du mail de l'entreprise
		 * - Requis
		 * - Vérification de la syntaxe avec un filtre
		 */
		if (empty($mail_ent)) 
        {
			$mail_entErr = "E-mail de l'entreprise obligatoire";
			$formulaireCorrect = FALSE;
		} 
        else 
        {
			$mail_ent = test_input($mail_ent);
			if (!filter_var($mail_ent, FILTER_VALIDATE_EMAIL)) 
            {
				$mail_entErr = "Adresse mail invalide"; 
				$formulaireCorrect = FALSE;
			}
		}



		/** récupération des entrées pour le contact de l'entreprise du formulaire dans des variables temporaires */
		$nom_contact = $_POST['NOM_CONTACT'];
		$prenom_contact = $_POST['PRENOM_CONTACT'];
		$tel_contact = $_POST['TEL_CONTACT'];
		$mail_contact = $_POST['MAIL_CONTACT'];




		// Si le formulaire à été soumis, on inserre les données dans la base, sinon on affiche les erreurs
		if ($formulaireCorrect == TRUE) 
        {
			
			// Initialisation du message à afficher pour l'utilisateur 
			$message = "";

			if ($nom_contact!="" OR $prenom_contact!="" OR $tel_contact!="" OR $mail_contact!="")
            {
			/*
			 * Phase 1
			 * -------
				 * Insertion du contact dans la base si au minimun un seul champs est rempli
			 */
			

			$sql = "INSERT INTO `contact`(`NOM_CONTACT`, `PRENOM_CONTACT`, `MAIL_CONTACT`, `NUM_TELEPHONE`)
			VALUES ('$nom_contact', '$prenom_contact', '$mail_contact',  '$tel_contact');";

			try 
            {
				$connexion->query($sql);  
			} 
            catch(PDOException $e)
            {
				$message .= newLineMsg("Problème pour ajouter le contact, vérifiez vos données.")
				.  newLineMsg($e->getMessage())
				.  newLineMsg($sql);
			}

			/*
			 * Phase 2
			 * -------
			 * Selection du contact fraîchement ajouté
			 */

			
			try 
            {
				$tab = $connexion->query('SELECT LAST_INSERT_ID() as last_id');
				$tab1=$tab->fetchALL(PDO::FETCH_ASSOC);
			}
            catch(PDOException $e)
            {
				$message .= newLineMsg("Problème pour recupere le numéro du contact, vérifier vos données.")
				.  newLineMsg($e->getMessage());
			}
			$id_contact = $tab1[0]['last_id'];
			
		}
            else
            {
			$id_contact="1";
		}


			/*
			 * phase 3 - Finale
			 * -------
			 * Insertion de l'entreprise avec son contact dans la base si il en possede un
			 */

			$sql = "INSERT INTO `entreprise`(`NOM_ENTREPRISE`, `TYPE_ENTREPRISE`, `ADRESSE_ENTREPRISE`, `CPOSTAL_ENTREPRISE`, `VILLE_ENTREPRISE`, `TEL_ENTREPRISE`, `ID_CONTACT`,`EMAIL_ENTREPRISE`)
			VALUES ( \"$nom\", \"$type\", \"$adresse\", $cpost, \"$ville\", \"$tel_ent\", \"$id_contact\", \"$mail_ent\");";

			$message .= newLineMsg("Entreprise \"".$nom."\" à bien été ajoutée.")
			. newLineMsg('<a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'">'."Cliquez ici pour faire un nouvel ajout.".'</a>');

			try {
				$connexion->query($sql);  
			} catch(PDOException $e){
				$message .= newLineMsg("Problème pour ajouter l'entreprises, vérifier vos données.").newLineMsg($e->getMessage()).newLineMsg($sql);
			}

		} else {
			$message .= newLineMsg("Certain(s) champ(s) obligatoire(s) sont incomplet(s), veuillez vérifié vos données");
		}
	}
	?>
	<!DOCTYPE html>
	<html lang="fr-FR">
	<head>
		<?php
		// Inclusion des différents paramètres présent dans l'élément head commum aux pages
		include("../struct/param_head.php");
		echo '<title>'."Ajout d'une entreprises".$title.'</title>';
		?>
		<link rel="stylesheet" type="text/css" href="../css/stage.css">
	</head>
	<body><!--
		--><?php
	// Inclusion de l'élément header (en-tête), dépend du module
		include("../struct/entete".$mod.".php");

	// Inclusion de l'élément nav, correspondant au menu horizontal (liens vers les modules)
		include("../struct/menu_horizontal.php");

	// Inclusion de l'élément nav, correspondant au menu vertical, dépend du module
		include("../struct/menu_vertical".$mod.".php");
	?><!--
--><section id="ajouter" class="document">

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"><!--
		--><div class="header">
		<h2>Formulaire d'ajout d'une entreprise</h2>
		<small>Les champs muni d'un caractère * sont obligatoires</small>
			</div><!--
		--><div>
		<label for="nom">Raison sociale *</label>
		<input name="NOM" list="raisons_sociales" value="<?php echo $nom; ?>" type="text" id="nom" class="defaut" tabindex="1" required>
		<span class="hint"><?php echo $nomErr; ?></span>
		<?php listNom($connexion); ?>
			</div><!--
		--><div>
		<label for="type">Type *</label>
		<?php listType($connexion); ?>
		<span class="hint"><?php echo $typeErr; ?></span>
			</div><!--
		--><div>
		<label for="adresse">Ville *</label>
		<input name="VILLE" value="<?php echo $ville; ?>" type="text" id="adresse" class="defaut" tabindex="2" required>
		<span class="hint"><?php echo $villeErr; ?></span>
		</div><!--
	--><div>
	<label for="mail">Mail *</label>
	<input name="MAIL_ENT" value="<?php echo $mail_ent; ?>" type="email" id="mail_ent" class="defaut" tabindex="3" required>
	<span class="hint"><?php echo $mail_entErr; ?></span>
			</div><!--
		--><div>
		<label for="tel_ent">Telephone</label>
		<input name="TEL_ENT" value="<?php echo $tel_ent; ?>" type="text" id="adresse" class="defaut" tabindex="3">
		<span class="hint"><?php echo $tel_entErr; ?></span>
			</div><!--
		
		--><div>
		<label for="adresse">Adresse</label>
		<input name="ADRESSE" value="<?php echo $adresse; ?>" type="text" id="adresse" class="defaut" tabindex="4">
		<span class="hint"><?php echo $adresseErr; ?></span>
			</div><!--
		--><div>
		<label for="cpost">Code postal</label>
		<input min="0" max="99999" name="CPOST" value="<?php echo $cpost; ?>" type="number" id="cpost" class="defaut" tabindex="5">
		<span class="hint"><?php echo $cpostErr; ?></span>
			</div><!--
		--><div class="header">
		<h3>Contact</h3>
		 	</div><!--
		 --><div>
		 <label for="nom_contact">Nom </label>
		 <input name="NOM_CONTACT" value="<?php echo $nom_contact; ?>" type="text" id="nom_contact" class="defaut" tabindex="6">
		 <span class="hint"><?php echo $nom_contactErr; ?></span>
			</div><!--
		--><div>
		<label for="prenom_contact">Prénom</label>
		<input name="PRENOM_CONTACT" value="<?php echo $prenom_contact; ?>" type="text" id="prenom_contact" class="defaut" tabindex="7">
		<span class="hint"><?php echo $prenom_contactErr; ?></span>
			</div><!--
		--><div>
		<label for="tel_contact">Téléphone </label>
		<input name="TEL_CONTACT" value="<?php echo $tel_contact; ?>" type="tel" id="tel_contact" class="defaut" tabindex="8">
		<span class="hint"><?php echo $tel_contactErr; ?></span>
			</div><!--
		--><div>
		<label for="mail_contact">Mail </label>
		<input name="MAIL_CONTACT" value="<?php echo $mail_contact; ?>" type="email" id="mail_contact" class="defaut" tabindex="9">
		<span class="hint"><?php echo $mail_contactErr; ?></span>
			</div><!--
		--><div>
		<input class="submit transition" type="submit" value="Soumettre">
		<!-- <input class="submit transition" type="reset" value="Réinitialiser"> -->
	</div>
</form>
<?php include("../struct/message.php"); ?>
	</section><!-- 
	--><?php
	// Inclusion de l'éléménet footer (pied de page)
	include("../struct/pieddepage.php");
	?>
	<script src="../js/validForm_entreprise.jq.js" type="text/javascript"></script>
</body>
</html>
