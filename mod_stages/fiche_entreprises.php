<?php

// ================================
// 	Création de la session
// 	Redirection des utilisateurs non identifié
// ================================

include_once('../connexion/session.php');
$_SESSION['MOD'] = "_"."stages"; // définition du module
$mod = $_SESSION['MOD'];

// ================================
// Récupération du choix
// ================================

$sql = "SELECT `ID_ENTREPRISE`,`NOM_ENTREPRISE`,`TYPE_ENTREPRISE`,`ADRESSE_ENTREPRISE`,`CPOSTAL_ENTREPRISE`,`VILLE_ENTREPRISE`,`TEL_ENTREPRISE`,`EMAIL_ENTREPRISE`,`ID_TUTEUR` FROM `entreprise` ORDER BY `NOM_ENTREPRISE`;";
$res = $connexion->query($sql);  
$info_fiche = $res->fetchAll(PDO::FETCH_ASSOC);


if(isset($_GET['choix'])) {
	$id_entreprise_selected = $_GET['choix'];

	// ================================
	// Récupération des infos pour la fiche
	// ================================

	$sql = "SELECT etudiant.CODE_CLASSE, etudiant.NOM_ETU, etudiant.PRENOM_ETU, etudiant.CODE_SPECIALITE, dperiode.DATE_DEBUT, dperiode.DATE_FIN, tuteur.NOM_TUTEUR, professeur.NOM_PROF, etudiant.ID_ETU, entreprise.NOM_ENTREPRISE
			FROM etudiant
			INNER JOIN stage ON etudiant.ID_ETU = stage.ID_ETU
			INNER JOIN periode ON periode.ID_PERIODE = stage.ID_PERIODE
			INNER JOIN dperiode ON dperiode.ID_DPERIODE = periode.ID_DPERIODE
			INNER JOIN entreprise ON entreprise.ID_ENTREPRISE = stage.ID_ENTREPRISE 
			INNER JOIN tuteur ON tuteur.ID_TUTEUR = entreprise.ID_TUTEUR
			INNER JOIN professeur ON professeur.ID_PROF = stage.ID_PROF
			WHERE entreprise.ID_ENTREPRISE = '$id_entreprise_selected';";
	$res = $connexion->query($sql);  
	$info_stages = $res->fetchAll(PDO::FETCH_ASSOC);
		$enteteTableau = 
		'<table class="def">'
		. '<thead>'.'<tr>'
		. '<th colspan="4">'."Début du stage ".'</th>'
		. '<th colspan="4">'."Fin du stage ".'</th>'
		. '<th colspan="4">'."Nom".'</th>'
		. '<th colspan="4">'."	Prenom".'</th>'
		. '<th colspan="4">'."Parcours".'</th>'
		. '<th colspan="4">'."Classe".'</th>'
		. '<th colspan="4">Nom du tuteur</th>'
		. '<th colspan="4">'."Nom du professeur".'</th>'
		. '</tr>';

		$fiche_test = "";

	if ($info_stages == false) {

		$pasStage = '<li>'."Désolé, mais d'après la base de données il semble que cet étudiant n'a pas fait encore de stage..".'</li>';
		
	} else {
		
		foreach ($info_stages as $info_stage) {
		// Stage
		// ----------------
		$date_debut =  $info_stage['DATE_DEBUT'];
		$date_fin =  $info_stage['DATE_FIN'];

		//etudiant
		// ----------------
		$id_etu = $info_stage['ID_ETU']; 
		$nom_etu = $info_stage['NOM_ETU']; 
		$prenom_etu = $info_stage['PRENOM_ETU']; 
		$code_classe = $info_stage['CODE_CLASSE'];
		$code_specialite = $info_stage['CODE_SPECIALITE'];

		// Tuteurs
		// ----------------
		$nom_tuteur = $info_stage['NOM_TUTEUR'];

		// Professeur tuteur
		// ----------------
		$nom_prof = $info_stage['NOM_PROF'];

		// entreprise
		// ----------------
		$nom_entreprise = $info_stage['NOM_ENTREPRISE'];

		$fiche_test = $fiche_test.'<div>'

		.'<tr>'
		.'<td colspan="4">'.$date_debut.'</td>'
		.'<td colspan="4">'.$date_fin.'</td>'
		.'<td colspan="4">'.$nom_etu.'</td>'
		.'<td colspan="4">'.$prenom_etu.'</td>'
		.'<td colspan="4">'.$code_specialite.'</td>'
		.'<td colspan="4">'.$code_classe.'</td>'
		.'<td colspan="4">'.$nom_tuteur.'</td>'
		.'<td colspan="4">'.$nom_prof.'</td>'
		.'</tr>';

		}
		
		$fiche_test = $fiche_test. '</tbody>'.'</table>'.'</div>';

	}

} else {
	$id_entreprise_selected = "";
}

//
$opt_group = $info_fiche[0]['NOM_ENTREPRISE'];
$choix_fiche = '<select name="choix">'."\n"
			 . '<optgroup label="">'."\n";

foreach ($info_fiche as $row) {
	if ($opt_group != $row['NOM_ENTREPRISE']) {
		$opt_group = $row['NOM_ENTREPRISE'];
		//$choix_fiche .= '</optgroup>';//.'<optgroup label="'.$opt_group.'">'."\n";
	}
	if ($row['NOM_ENTREPRISE'] == $id_entreprise_selected)
		$selected = 'selected';
	else 
		$selected = "";
		$choix_fiche .= '<option value="'.$row['ID_ENTREPRISE'].'">'.$row['NOM_ENTREPRISE'].'</option>'."\n";
}
$choix_fiche .= '</select>';


// <!--
// ================================
// 	DOCUMENT HTML
// ================================
// -->

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
	echo '<title>'."Fiche de l'entreprise".$title.'</title>';
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
--><section id="fiche_entreprises" class="document">

<?php
	// include("../struct/breadcrumb.php");
	// breadcrumb();
?>
<form id="choix_classe" action="fiche_entreprises.php" method="get">
	<p>Choisissez la fiche d'une entreprise</p>
	<?php echo $choix_fiche ?>
	<input type="submit" class="submit transition" value="Valider">
	
</form>
<?php
if ($id_entreprise_selected != ""){

if ($fiche_test != "") {
	//afficher le tableau des stages
	echo $enteteTableau;
	echo $fiche_test;

}else{
	echo $pasStage;
}
}

?>
<?php include("../struct/message.php"); ?>
</section><!--
	Pied de page (footer)
--><?php include("../struct/pieddepage.php"); ?>
</body>
</html>