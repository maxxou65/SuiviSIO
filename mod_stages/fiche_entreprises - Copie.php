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

// $sql = "SELECT `ID_ETU`, `NOM_ETU`, `PRENOM_ETU`, `CODE_CLASSE` FROM `ETUDIANT` ORDER BY `CODE_CLASSE`, `NOM_ETU` ASC;";
// $res = $connexion->query($sql);  
// $info_fiche = $res->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT `ID_ENTREPRISE`,`NOM_ENTREPRISE`,`TYPE_ENTREPRISE`,`ADRESSE_ENTREPRISE`,`CPOSTAL_ENTREPRISE`,`VILLE_ENTREPRISE`,`TEL_ENTREPRISE`,`EMAIL_ENTREPRISE`,`ID_TUTEUR` FROM `entreprise` ORDER BY `NOM_ENTREPRISE`;";
$res = $connexion->query($sql);  
$info_fiche = $res->fetchAll(PDO::FETCH_ASSOC);


if(isset($_GET['choix'])) {
	$id_entreprise_selected = $_GET['choix'];

	// ================================
	// Récupération des infos pour la fiche
	// ================================

	$sql = "SELECT 	ID_STAGE, CLASSE_STAGE, STAGE.ID_PERIODE, PERIODE.ID_DPERIODE, CONCAT('du ', DATE_DEBUT, ' au ', DATE_FIN) AS `DATES`,
					ENTREPRISE.ID_TUTEUR, CONCAT(UPPER(NOM_TUTEUR), ' ', PRENOM_TUTEUR) AS NOM_TUTEUR, SERVICE_TUTEUR, STATUT_TUTEUR, TEL_TUTEUR, MAIL_TUTEUR,
					STAGE.ID_PROF, PROF_TUTEUR.MAT_PROF AS MAT_PROF_TUTEUR, CONCAT(UPPER(PROF_TUTEUR.NOM_PROF), ' ', PROF_TUTEUR.PRENOM_PROF) AS NOM_PROF_TUTEUR,
					STAGE.ID_PROF_VISITER, PROF_VISITEUR.MAT_PROF AS MAT_PROF_VISITEUR, CONCAT(UPPER(PROF_VISITEUR.NOM_PROF), ' ', PROF_VISITEUR.PRENOM_PROF) AS NOM_PROF_VISITEUR,
					STAGE.ID_ETU, CONCAT(UPPER(NOM_ETU), ' ', PRENOM_ETU) AS NOM_ETU, CODE_CLASSE, CODE_SPECIALITE,
					STAGE.ID_ENTREPRISE, NOM_ENTREPRISE, TYPE_ENTREPRISE, ADRESSE_ENTREPRISE, CPOSTAL_ENTREPRISE, VILLE_ENTREPRISE
					FROM STAGE
					INNER JOIN ENTREPRISE ON STAGE.ID_ENTREPRISE = ENTREPRISE.ID_ENTREPRISE
					INNER JOIN TUTEUR ON ENTREPRISE.ID_TUTEUR = TUTEUR.ID_TUTEUR
					INNER JOIN PROFESSEUR AS PROF_TUTEUR ON STAGE.ID_PROF = PROF_TUTEUR.ID_PROF
					INNER JOIN PROFESSEUR AS PROF_VISITEUR ON STAGE.ID_PROF_VISITER = PROF_VISITEUR.ID_PROF
					INNER JOIN ETUDIANT ON STAGE.ID_ETU = ETUDIANT.ID_ETU
					INNER JOIN PERIODE ON STAGE.ID_PERIODE = PERIODE.ID_DPERIODE
					INNER JOIN DPERIODE ON PERIODE.ID_DPERIODE = DPERIODE.ID_DPERIODE
					WHERE STAGE.ID_ETU = '$id_entreprise_selected';";
	$res = $connexion->query($sql);  
	$info_stage = $res->fetch(PDO::FETCH_ASSOC);

	if ($info_stage == "") {

		$message = '<li>'."Désolé, mais d'après la base de données il semble que cette entreprise n'a pas encore pris de stagiaire..".'</li>';

	} else {

		// Stage
		// ----------------
		$dates =  $info_stage['DATES'];
		$classe_stage =  $info_stage['CLASSE_STAGE'];

		// Tuteurs
		// ----------------
		$id_tuteur = $info_stage['ID_TUTEUR'];
		$nom_tuteur = $info_stage['NOM_TUTEUR'];
		$service_tuteur = $info_stage['SERVICE_TUTEUR'];
		$statut_tuteur = $info_stage['STATUT_TUTEUR'];
		$tel_tuteur = $info_stage['TEL_TUTEUR'];
		$mail_tuteur = $info_stage['MAIL_TUTEUR'];


		// Etudiant
		// ----------------
		$id_etu = $info_stage['ID_ETU']; 
		$nom_etu = $info_stage['NOM_ETU']; 
		$code_classe = $info_stage['CODE_CLASSE'];
		$code_specialite = $info_stage['CODE_SPECIALITE'];


		// Entreprise
		// ----------------
		$id_entreprise = $info_stage['ID_ENTREPRISE']; 
		$nom_entreprise = $info_stage['NOM_ENTREPRISE']; 
		$type_entreprise = $info_stage['TYPE_ENTREPRISE']; 
		$adresse_entreprise = $info_stage['ADRESSE_ENTREPRISE']; 
		$cpostal_entreprise = $info_stage['CPOSTAL_ENTREPRISE']; 
		$ville_entreprise = $info_stage['VILLE_ENTREPRISE'];

		// Professeur tuteur
		// ----------------
		$mat_prof_tuteur = $info_stage['MAT_PROF_TUTEUR'];
		$nom_prof_tuteur = $info_stage['NOM_PROF_TUTEUR'];

		// Professeur visiteur
		// ----------------
		$mat_prof_visiteur = $info_stage['MAT_PROF_VISITEUR'];
		$nom_prof_visiteur = $info_stage['NOM_PROF_VISITEUR'];

		$fiche_test = '<div>'
		. '<table class="fiche">'
		. '<thead>'.'<tr>'
		. '<th colspan="4">'."Stage de ".$classe_stage.'</th>'
		. '</tr>'.'<tr>'
		. '<th colspan="4">Effectué '.$dates.'</th>'
		. '</tr>'.'</thead>'.'<thead>'.'<tr>'
		. '<th colspan="4">'."Stagiaire".'</th>'
		. '</tr>'
		. '</thead>'
		. '<tbody>'.'<tr>'
		. '<th>'."Nom".'</th><td colspan="3">'.$nom_etu.'</td>'
		. '</tr>'.'<tr>'
		. '<th>'."Parcours".'</th>'.'<td>'.$code_specialite.'</td>'.'<th>'."Classe".'</th><td>'.$code_classe.'</td>'
		. '</tr>'.'</tbody>'.'<thead>'
		. '<tr>'.'<th colspan="4">'."Entreprise".'</th>'
		. '</tr>'.'</thead>'
		. '<tbody>'.'<tr>'
		. '<th>'."Nom".'</th><td colspan="3">'.$nom_entreprise.'</td>'
		. '</tr>'.'<tr>'
		. '<th>'."Type".'</th><td colspan="3">'.$type_entreprise.'</td>'
		. '</tr><tr>'
		. '<th>'."Ville".'</th><td>'.$ville_entreprise.'</td><th>'."Code Postal".'</th><td>'.$cpostal_entreprise.'</td>'
		. '</tr>'.'<tr>'
		. '<th>'."Adresse".'</th><td colspan="3">'.$adresse_entreprise.'</td>'
		. '</tr>'.'</tbody>'.'<thead>'.'<tr>'
		. '<th colspan="4">'."Tuteur".'</th>'
		. '</tr>'.'</thead>'.'<tbody>'.'<tr>'
		. '<th>Nom</th><td colspan="3">'.$nom_tuteur.'</td>'
		. '</tr>'.'<tr>'
		. '<th>Service</th><td>'.$service_tuteur.'</td><th>Statut</th><td>'.$statut_tuteur.'</td>'
		. '</tr>'.'<tr>'
		. '<th>Mail</th><td>'.$mail_tuteur.'</td><th>Telephone</th><td>'.$tel_tuteur.'</td>'
		. '</tr>'.'</tbody>'.'<thead>'.'<tr>'
		. '<th colspan="2">Professeur superviseur</th><th colspan="2">Professeur visiteur</th>'
		. '</tr>'.'</thead>'.'<tbody>'.'<tr>'
		. '<th>'."Nom".'</th><td>'.$nom_prof_tuteur.'</td><th>'."Nom".'</th><td>'.$nom_prof_tuteur.'</td>'
		. '</tr>'.'<tr>'
		. '<th>'."Matricule".'</th><td>'.$mat_prof_tuteur.'</td><th>'."Matricule".'</th><td>'.$mat_prof_tuteur.'</td>'
		. '</tr>'.'</tbody>'.'</table>'.'</div>';

	}
} else {
	$id_entreprise_selected = "";
}


$liste_ent = $info_fiche[0]['NOM_ENTREPRISE'];
$choix_fiche = '<select name="choix">'."\n"
			 . '<liste_ent label="'.$liste_ent.'">'."\n";

foreach ($info_fiche as $row) {
	if ($liste_ent != $row['NOM_ENTREPRISE']) {
		$liste_ent = $row['NOM_ENTREPRISE'];
		$choix_fiche .= '</liste_ent>'.'<liste_ent label="'.$liste_ent.'">'."\n";
	}
	if ($row['ID_ENTREPRISE'] == $id_entreprise_selected)
		$selected = 'selected';
	else 
		$selected = "";
		$choix_fiche .= '<option value="'.$row['ID_ENTREPRISE'].'" '.$selected.'>'.$row['NOM_ENTREPRISE'].'</option>'."\n";
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
	echo '<title>'."Fiche de stage".$title.'</title>';
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
--><section id="fiche_stage" class="document">
<?php
	// include("../struct/breadcrumb.php");
	// breadcrumb();
?>
<form id="choix_classe" action="fiche_entreprises.php" method="get">
	<p>Choisissez la fiche de l'entreprise</p>
	<?php echo $choix_fiche ?>
	<input type="submit" class="submit transition" value="Valider">
</form>
<?php
if (isset($fiche_test)) {
	echo $fiche_test;
}
?>
<?php include("../struct/message.php"); ?>
</section><!--
	Pied de page (footer)
--><?php include("../struct/pieddepage.php"); ?>
</body>
</html>