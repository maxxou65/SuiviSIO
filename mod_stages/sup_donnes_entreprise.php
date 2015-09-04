<?php
/**
 * @see http://www.phpdoc.org/
 * ---------------------------
 *
 * Page de suppression des entreprises
 * Permet à l’utilisateur de supprimer données relatives aux entreprises en cas d’erreur par exemple
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
 * @var string $mod Définit le module pour les inclusions (en-tête et menu vertical)
 */
include_once('../connexion/session.php');
$_SESSION['MOD'] = "_"."stages";
$mod = $_SESSION['MOD'];


/**
 * Description
 * @param object $connexion 
 * @return string
 */
function afficher_entreprise($connexion) { // $classe = 'SIO1' || $classe = 'SIO2'
	$sql = "SELECT `ID_ENTREPRISE`, `NOM_ENTREPRISE`, `TYPE_ENTREPRISE`, `ADRESSE_ENTREPRISE`, `CPOSTAL_ENTREPRISE`, `VILLE_ENTREPRISE`, `TEL_ENTREPRISE`, `EMAIL_ENTREPRISE`, `ID_TUTEUR`\n"
		 . "FROM `ENTREPRISE`;";
	$res_sio = $connexion->query($sql);  
	$table = $res_sio->fetchAll(PDO::FETCH_ASSOC);
	$table_entreprise = '<table class="def sup">'
					  . '<thead>'.'<tr>'
					  . '<th>'."NOM".'</th><th>'."TYPE".'</th><th>'."ADRESSE".'</th>'
					  . '</tr>'.'</thead>'
					  . '<tbody>';

	foreach ($table as $table_row) {

		$id_entreprise = $table_row['ID_ENTREPRISE'];
		$nom_entreprise = $table_row['NOM_ENTREPRISE'];
		$type_entreprise = $table_row['TYPE_ENTREPRISE'];
		$adresse_entreprise = $table_row['ADRESSE_ENTREPRISE'];

		$table_entreprise .= '<tr>'
					  	   . '<td>'.'<input type="checkbox" name="stage[SUP]" value="'.$id_entreprise.'">'.'</td>'
						   . '<td>'.$nom_entreprise.'</td>'
						   . '<td>'.$type_entreprise.'</td>'
						   // . '<td>'.$adresse_entreprise.'</td>'
						   . '</tr>';
	}

	$table_entreprise .= '</tbody>'.'</table>';
	return $table_entreprise;
}

$tab = afficher_entreprise($connexion);

// ================================
// 	DOCUMENT HTML
// ================================

?>
<!DOCTYPE html>
<html>
<head>
	<?php

	// ================================
	// 	paramètres du <head>
	// 	commun aux pages (inclusion de fichiers CSS, JS; balise meta; ...) 
	// ================================

	include("../struct/param_head.php");
	echo '<title>'."Module de gestion des stages et des entreprises".$title.'</title>';

	?>
	<link rel="stylesheet" type="text/css" href="../css/stage.css">
</head>
<body><!--	entête (header)
--><?php include("../struct/entete".$mod.".php"); ?><!--	menu horizontal
--><?php include("../struct/menu_horizontal.php"); ?><!--	menu vertical
--><?php include("../struct/menu_vertical".$mod.".php"); ?><!--
	contenu de la page
	appliquez un ID sur votre section pour y appliquer un style particulier en CSS
--><section id="" class="document">
		<div class="placer">
		<?php 
			echo $tab;
		?>
		</div>
</section><!--
	Pied de page (footer)
--><?php include("../struct/pieddepage.php"); ?>
</body>
</html>