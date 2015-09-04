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
//function afficher_entreprise($connexion) { // $classe = 'SIO1' || $classe = 'SIO2'
	$sql = "SELECT etudiant.CODE_CLASSE, etudiant.NOM_ETU, etudiant.PRENOM_ETU, etudiant.CODE_SPECIALITE, dperiode.DATE_DEBUT, dperiode.DATE_FIN, tuteur.NOM_TUTEUR, professeur.NOM_PROF, etudiant.ID_ETU
			FROM etudiant
			INNER JOIN stage ON etudiant.ID_ETU = stage.ID_ETU
			INNER JOIN periode ON periode.ID_PERIODE = stage.ID_PERIODE
			INNER JOIN dperiode ON dperiode.ID_DPERIODE = periode.ID_DPERIODE
			INNER JOIN entreprise ON entreprise.ID_ENTREPRISE = stage.ID_ENTREPRISE 
			INNER JOIN tuteur ON tuteur.ID_TUTEUR = entreprise.ID_TUTEUR
			INNER JOIN professeur ON professeur.ID_PROF = stage.ID_PROF;";
	$res = $connexion->query($sql);  
	$table = $res->fetch(PDO::FETCH_ASSOC);

	if ($table == "") {

		$message = '<li>'."Désolé, mais d'après la base de données il semble que cette entreprise n'a pas encore pris de stagiaire..".'</li>';

	} else {

	$table_entreprise = '<table class="def">'
					  . '<thead>'.'<tr>'
					  . '<th rowspan="2">'."Stage".'</th>'. '<th>'."Date de début".'</th><th>'."Date de fin".'</th><th>'."Nom du stagiaire".'</th><th>'."Prenom du stagiaire".'</th><th>'."Option".'</th><th>'."Nom du tuteur".'</th><th>'."Professeur".'</th><th>'."Fiche".'</th>'
					  . '</tr>'.'</thead>'
					  . '<tbody>';

	foreach ($table as $table_row) {
		$code_classe = $table_row['CODE_CLASSE'];
		$nom_etudiant = $table_row['NOM_ENTREPRISE'];
		$prenom_etudiant = $table_row['TYPE_ENTREPRISE'];
		$adresse_entreprise = $table_row['ADRESSE_ENTREPRISE'];
		$code_specialite = $table_row['CODE_SPECIALITE'];
		$nom_tuteur = $table_row['NOM_TUTEUR'];
		$nom_prof = $table_row['NOM_PROF'];
		$id_etu = $table_row['ID_ETU'];

		$table_entreprise .= '<tr>'
						  . '<td>'.$code_classe.'</td>'
						  . '<td>'.$nom_etudiant.'</td>'
						  . '<td>'.$prenom_etudiant.'</td>'
						  . '<td>'.$adresse_entreprise.'</td>'
						  . '<td>'.$code_specialite.'</td>'
						  . '<td>'.$nom_tuteur.'</td>'
						  . '<td>'.$nom_prof.'</td>'
						  . '<td>'.'<a href="fiche_etudiant.php?choix='.$id_etu.'" alt="Aller sur la fiche correspondante">'.'<img src="../img/fiche.png" width="22" height="30">'.'</a>'.'</td>'
						  . '</tr>';
	}

	$table_entreprise .= '</tbody>'.'</table>'.'</div>';
	return $table_entreprise;
}

//$tab = afficher_entreprise($connexion);

	//}	
	
} else {
	$id_etu_selected = "";
}


$liste_ent = $info_fiche[0]['NOM_ENTREPRISE'];
$choix_fiche = '<select name="choix">'."\n"
			 . '<liste_ent label="'.$liste_ent.'">'."\n";

foreach ($info_fiche as $row) {
	if ($liste_ent != $row['NOM_ENTREPRISE']) {
		$liste_ent = $row['NOM_ENTREPRISE'];
		$choix_fiche .= '</liste_ent>'.'<liste_ent label="'.$liste_ent.'">'."\n";
	}
	if ($row['ID_ENTREPRISE'] == $id_etu_selected)
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