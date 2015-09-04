<?php
// ================================
// 	Création de la session
// 	Redirection des utilisateurs non identifié
// ================================


include_once('../struct/session.php');
$_SESSION['MOD'] = "_"."stages"; // définition du module
$mod = $_SESSION['MOD'];

// ================================
// 	Si formulaire soumis
// ================================

if (isset($_POST['NOM_TUTEUR'])) {

	$nom_tuteur = $_POST['NOM_TUTEUR'];
	$prenom_tuteur = $_POST['PRENOM_TUTEUR'];
	$service_tuteur = $_POST['SERVICE_TUTEUR'];
	$statut_tuteur = $_POST['STATUT_TUTEUR'];
	$tel_tuteur = $_POST['TEL_TUTEUR'];
	$mail_tuteur = $_POST['MAIL_TUTEUR'];

	$sql = "INSERT INTO `TUTEUR` (`NOM_TUTEUR`, `PRENOM_TUTEUR`, `SERVICE_TUTEUR`, `STATUT_TUTEUR`, `TEL_TUTEUR`, `MAIL_TUTEUR`)	
			VALUES (\"$nom_tuteur\", \"$prenom_tuteur\", \"$service_tuteur\", \"$statut_tuteur\", $tel_tuteur, \"$mail_tuteur\");";
	try {
		$res = $connexion->query($sql);  
		$message = '<li>'."Tuteur \"".$nom_tuteur." ".$prenom_tuteur."\" à bien été ajoutée.".'</li>'
				 . '<li>'.'<a href="'.$_SERVER['PHP_SELF'].'">'."Cliquez ici pour faire un nouvel ajout.".'</a>'.'</li>';
				 // '<li>'..'</li>'
	} catch(PDOException $e){
		$message = '<li>'."Problème pour ajouter l'entreprises, vérifier vos données.".'</li>';
		$message .= $e->getMessage();
	}
	
} else {

	$nom_tuteur = "";
	$prenom_tuteur = "";
	$service_tuteur = "";
	$statut_tuteur = "";
	$tel_tuteur = "";
	$mail_tuteur = "";

}

// ================================
// 	DOCUMENT HTML
// ================================

?>
<!DOCTYPE html>
<html>
<head>
	<?php
	// <!--
	// ================================
	// 	paramètres du <head>
	// 	commun aux pages (inclusion de fichiers CSS, JS; balise meta; ...) 
	// ================================
	// -->
	include("../struct/param_head.php");
	echo '<title>'."Ajout d'un tuteur".$title.'</title>';
	// nom de votre page
	?>
	<link rel="stylesheet" type="text/css" href="../css/stage.css">
</head>
<body><!--	entête (header)
--><?php include("../struct/entete".$mod.".php"); ?><!--	menu horizontal
--><?php include("../struct/menu_horizontal.php"); ?><!--	menu vertical
--><?php include("../struct/menu_vertical".$mod.".php"); ?><!--
	contenu de la page
	appliquez un ID sur votre section pour y appliquer un style particulier en CSS
--><section id="ajouter" class="document">
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"><!--
	 --><div>
			<h2>Formulaire d'ajout d'un tuteur (entreprise)</h2>
		</div><!--
	 --><div>
			<label for="nom_tuteur">Nom</label>
			<input name="NOM_TUTEUR" value="<?php echo $nom_tuteur; ?>" type="text" id="nom_tuteur">
			<span class="hint"></span>
		</div><!--
	 --><div>
			<label for="prenom_tuteur">Prénom</label>
			<input name="PRENOM_TUTEUR" value="<?php echo $prenom_tuteur; ?>" type="text" id="prenom_tuteur">
			<span class="hint"></span>
		</div><!--
	 --><div>
			<label for="service_tuteur">Service</label>
			<input name="SERVICE_TUTEUR" value="<?php echo $service_tuteur; ?>" type="text" id="service_tuteur">
			<span class="hint"></span>
		</div><!--
	 --><div>
			<label for="statut_tuteur">Statut</label>
			<input name="STATUT_TUTEUR" value="<?php echo $statut_tuteur; ?>" type="text" id="statut_tuteur">
			<span class="hint"></span>
		</div><!--
	 --><div>
			<label for="tel_tuteur">Téléphone</label>
			<input name="TEL_TUTEUR" value="<?php echo $tel_tuteur; ?>" type="tel" id="tel_tuteur">
			<span class="hint"></span>
		</div><!--
	 --><div>
			<label for="mail_tuteur">Mail</label>
			<input name="MAIL_TUTEUR" value="<?php echo $mail_tuteur; ?>" type="email" id="mail_tuteur">
			<span class="hint"></span>
		</div><!--
	 --><div>
	 		<input class="submit transition" type="submit" value="Soumettre">
	 	</div>
	</form>
<?php include("../struct/message.php"); ?>
</section><!-- Pied de page (footer)
--><?php include("../struct/pieddepage.php"); ?>
</body>
</html>