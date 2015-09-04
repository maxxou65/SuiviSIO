<?php
/**
 * @see http://www.phpdoc.org/
 * ---------------------------
 *
 * Page de consultation des stages
 *
 * Permet à l'utilisateur de consulter la liste des stages, en les filtrants par classe (SIO1 ou SIO2) et par période
 * 
 * @package mod_stages
 *
 * @version 1.1.2
 *
 * @todo Améliorer l'algorithme global
 * @todo Unifier les filtres SIO1/SIO2 et période
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
 * Permet d'afficher la liste des stages correspondants au choix fais par l'utilisateur 
 * 
 * @param string $classe Précise la classe du stage. Ne prend que 2 valeurs, "SIO1" ou "SIO2"
 * @param string $id_periode Précise l'identifiant de la période selectionnée
 * @param object $connexion Instance de l'objet PDO permettant la connexion et le dialogue avec la base 
 * 
 * @return string Contient les éléments HTML permettant de lister les stages dans un tableau
 */
function afficher_stage_sio($classe, $annee, $connexion) { // $classe = 'SIO1' || $classe = 'SIO2'

	/*
	 * Phase 1
	 * ------- 
	 * Requête pour le selectionné les stages suivants les paramètres
	 */

	$sql = "SELECT `stage`.`ID_ETU`,
					CONCAT(UPPER(`NOM_ETU`), \" \", `PRENOM_ETU`) AS `NOM_ETU`,
					`NOM_ENTREPRISE`, `TYPE_ENTREPRISE`,
					CONCAT(UPPER(`NOM_TUTEUR`), \" \", `PRENOM_TUTEUR`) AS `NOM_TUTEUR`, `TEL_TUTEUR`, `MAIL_TUTEUR`,
					`prof_tuteur`.`MAT_PROF` AS `MAT_PROF_TUTEUR`,
					`prof_visiteur`.`MAT_PROF` AS `MAT_PROF_VISITEUR`
			FROM `stage`
			INNER JOIN `etudiant`
					ON `stage`.`ID_ETU` = `etudiant`.`ID_ETU`
			INNER JOIN `entreprise`
					ON `stage`.`ID_ENTREPRISE` = `entreprise`.`ID_ENTREPRISE`
			INNER JOIN `tuteur`
					ON `entreprise`.`ID_TUTEUR` = `tuteur`.`ID_TUTEUR`
			INNER JOIN `professeur` AS `prof_tuteur`
					ON `stage`.`ID_PROF` = `prof_tuteur`.`ID_PROF`
			INNER JOIN `professeur` AS `prof_visiteur`
					ON `stage`.`ID_PROF_VISITER` = `prof_visiteur`.`ID_PROF`
			INNER JOIN `periode`
					ON `periode`.`ID_PERIODE` = `stage`.`ID_PERIODE`
			INNER JOIN `dperiode`
					ON `dperiode`.`ID_DPERIODE` = `periode`.`ID_DPERIODE`
			WHERE `CLASSE_STAGE` = '$classe'
			  AND DATE_FORMAT(`dperiode`.`DATE_DEBUT`, '%Y') = '$annee';";
		  
  	$res_sio = $connexion->query($sql); 
	$table_stage_sio = $res_sio->fetchAll(PDO::FETCH_ASSOC);

	/*
	 * Phase 2
	 * ------- 
	 * Si la requête est vide, on ne fait rien et on sort de la fonction
	 * Sinon 
	 *
	 * @var datatype description
	 */

	$nb_row = $res_sio->rowCount();

	if ($nb_row == 0) {

		return "";

	} else {

		$table_stage = '<div>'.'<span class="classe">'.$classe.'</span>'
					 . '<table class="def">'
					 . '<thead>'.'<tr>'
					 . '<th rowspan="2">'."Fiche".'</th>'.'<th rowspan="2">Etudiant</th>'.'<th colspan="2">Entreprise</th>'.'<th colspan="3">Tuteur</th>'.'<th colspan="2">Professeur</th>'
					 . '</tr>'.'<tr>'
					 . '<th>Nom</th>'.'<th>Type</th>'.'<th>Nom</th>'.'<th>Téléphone</th>'.'<th>Mail</th>'.'<th>Tuteur</th>'.'<th>Visiteur</th>'
					 . '</tr>'.'</thead>'
					 . '<tbody>';

		foreach ($table_stage_sio as $table_row) {

			$id_etu = $table_row['ID_ETU'];
			$nom_etu =  $table_row['NOM_ETU'];
			$nom_entreprise =  $table_row['NOM_ENTREPRISE'];
			$type_entreprise =  $table_row['TYPE_ENTREPRISE'];
			$nom_tuteur =  $table_row['NOM_TUTEUR'];
			$tel_tuteur =  $table_row['TEL_TUTEUR'];
			$mail_tuteur =  $table_row['MAIL_TUTEUR'];
			$mat_prof_tuteur =  $table_row['MAT_PROF_TUTEUR'];
			$mat_prof_visiteur =  $table_row['MAT_PROF_VISITEUR'];

			$table_stage .= '<tr>'
						  . '<td>'.'<a href="fiche_stages.php?choix='.$id_etu.'" alt="Aller sur la fiche correspondante">'.'<img src="../img/fiche.png" width="22" height="30">'.'</a>'.'</td>'
						  . '<td>'.$nom_etu.'</a>'.'</td>'
						  . '<td>'.$nom_entreprise.'</td>'
						  . '<td>'.$type_entreprise.'</td>'
						  . '<td>'.$nom_tuteur.'</td>'
						  . '<td>'.$tel_tuteur.'</td>'
						  . '<td>'.$mail_tuteur.'</td>'
						  . '<td>'.$mat_prof_tuteur.'</td>'
						  . '<td>'.$mat_prof_visiteur.'</td>'
						  . '</tr>';
		}

		$table_stage .= '</tbody>'.'</table>'.'</div>';
		return $table_stage;
	}
}



/**
 * Lister les périodes dans un éléments HTML <select>
 * 
 * @param object $connexion Instance de l'objet PDO permettant la connexion et le dialogue avec la base 
 * 
 * @return string Renvoie les éléments HTML nécéssaires 
 */
function listerAnnee($connexion, $annee_slctd) {
	// $sql = "SELECT DISTINCT `STAGE`.`ID_PERIODE` AS `ID_PERIODE`, `DATE_DEBUT`, `DATE_FIN`\n"
	// 	 . "FROM `STAGE`\n"
	// 	 . "INNER JOIN `PERIODE` ON `PERIODE`.`ID_PERIODE` = `STAGE`.`ID_PERIODE`\n"
	// 	 . "INNER JOIN `DPERIODE` ON `DPERIODE`.`ID_DPERIODE` = `PERIODE`.`ID_DPERIODE`\n"
	// 	 . "ORDER BY `DATE_DEBUT` DESC";

	$sql = "SELECT DISTINCT DATE_FORMAT(`DATE_DEBUT`, '%Y') AS `ANNEE`\n"
		 . "FROM `stage`\n"
		 . "INNER JOIN `periode` ON `periode`.`ID_PERIODE` = `stage`.`ID_PERIODE`\n"
		 . "INNER JOIN `dperiode` ON `dperiode`.`ID_DPERIODE` = `periode`.`ID_DPERIODE`\n"
		 . "ORDER BY `ANNEE` DESC;";

	$res = $connexion->query($sql);
	$t_annnee = $res->fetchAll(PDO::FETCH_ASSOC);

	// $select_periode = '<select name="periode">'."\n";
	// $opt_group = substr($table_periode[0]['DATE_DEBUT'],0,4);
	// $select_periode .= '<optgroup label="'.$opt_group.'">';

	$selected = "";
	$select_annee = '<select name="annee">'."\n";
	foreach ($t_annnee as $row){

		$annee = $row['ANNEE'];

		if ($annee == $annee_slctd)
			$selected = 'selected';

		$select_annee .= '<option value="'.$annee.'" '.$selected.'">'.$annee.'</option>'."\n";
	}
	$select_annee .= '</select>';
	return $select_annee;
}



/**
 * Permet d'obtenir l'identifiant de la période pour le premier chargement de la page
 * @param object $connexion Instance de l'objet PDO permettant la connexion et le dialogue avec la base 
 * @return string 
 */
function getAnnee($connexion){
	$sql = "SELECT DISTINCT DATE_FORMAT(`DATE_DEBUT`, '%Y') AS `ANNEE`\n"
		 . "FROM `stage`\n"
		 . "INNER JOIN `periode` ON `periode`.`ID_PERIODE` = `stage`.`ID_PERIODE`\n"
		 . "INNER JOIN `dperiode` ON `dperiode`.`ID_DPERIODE` = `periode`.`ID_DPERIODE`\n"
		 . "ORDER BY `ANNEE` DESC";
	try {
		$res = $connexion->query($sql); 
		$table = $res->fetch(PDO::FETCH_ASSOC);		
	} catch(PDOException $e){
		$message = newLineMsg($e->getMessage());
	}
	$annee = $table['ANNEE'];


	return $annee;
}


$annee = getAnnee($connexion);
if (isset($_GET['annee'])) {
	$annee = $_GET['annee'];
	$message = newLineMsg('BORDEEEEEEL');
}

/**
 * @var string $tab Contient tout le texte et éléments HTML à afficher dans la page en fonction des choix fais dans le premier formulaire (#choix_classe)
 * @var string $sio1_checked Permet de cocher la checkbox input#sio1 au (re-)chargement de la page
 * @var string $sio2_checked Permet de cocher la checkbox input#sio2 au (re-)chargement de la page
 */
$tab = "";
$sio1_checked = " checked";
$sio2_checked = " checked";


if (isset($_GET["sio1"]) && !isset($_GET["sio2"])) {

	$classe = 'SIO1';
	$tab = afficher_stage_sio($classe, $annee, $connexion);
	
	$sio1_checked = "checked";
	$sio2_checked = "";

} elseif (!isset($_GET["sio1"]) && isset($_GET["sio2"])) {

	$classe = 'SIO2';
	$tab = afficher_stage_sio($classe, $annee, $connexion);

	$sio1_checked = "";
	$sio2_checked = "checked";

} elseif (isset($_GET["sio1"]) && isset($_GET["sio2"])) {

	$classe = 'SIO1';
	$tab = afficher_stage_sio($classe, $annee, $connexion);
	$classe = 'SIO2';
	$tab .= afficher_stage_sio($classe, $annee, $connexion);

	$sio1_checked = "checked";
	$sio2_checked = "checked";

} else {

	$classe = 'SIO1';
	$tab = afficher_stage_sio($classe, $annee, $connexion);
	$classe = 'SIO2';
	$tab .= afficher_stage_sio($classe, $annee, $connexion);

	$sio1_checked = "checked";
	$sio2_checked = "checked";
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
--><section id="consult" class="document">
	<form id="choix_classe" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
		<p>Choissiez la classe des stages à consulter</p>
		<div>
			<input id="sio1" type="checkbox" name="sio1" <?php echo $sio1_checked ?>>
			<label for="sio1">SIO1</label>
		</div>
		<div>
			<input id="sio2" type="checkbox" name="sio2" <?php echo $sio2_checked ?>>
			<label for="sio2">SIO2</label>
		</div>
		<div>
			<label>Et selectionnez l'année du stage</label>
			<?php echo listerAnnee($connexion, $annee) ?>
		</div>
		<input type="submit" class="submit transition" value="Valider">
	</form>
	<div id="tableaux">
		<?php echo $tab; ?>
	</div>
</section><!-- 
--><?php

/** Inclusion de l'éléménet footer (pied de page) */
include("../struct/pieddepage.php");

?>
<!-- <script src="../js/consult_stage_jq.js" type="text/javascript"></script> -->
</body>
</html>