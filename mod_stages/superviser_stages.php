<?php
/**
 * @see http://www.phpdoc.org/
 * ---------------------------
 *
 * Supervisation des stages
 * 
 * Affiche sous forme de graphiques (tartes) le pourcentage d’étudiant ayant trouvé un stage
 * et permet l’affichage des noms de ceux qui n’en ont pas trouvé.
 * 
 * @package mod_stages
 * @version 1.0.0
 *
 * @author Anthony Lozano
 */



/** 
 * Inclusion de la session
 * Définition du module. A améliorer
 * @var string $mod Définit le module pour les inclusions (en-tête, menu vertical)
 */
include_once('../connexion/session.php');
$_SESSION['MOD'] = "_"."stages";
$mod = $_SESSION['MOD'];



/**
 * Permet d'afficher les éléments HTML pour superviser les stages, avec une liste des étudiants qui n'ont pas trouvé de stage et
 * un graphique en "tarte" pour indiquer un pourcentage d'étudiant qui ont trouvé leurs stage.
 * @param type $classe 
 * @param type $connexion 
 * @return type
 */
function progressionStage($classe, $connexion){

	/**
	 * Phase 1
	 * -------
	 * Selection du nombre d'étudiant
	 * @var $nb_etu integer Nombre d'étudiant
	 */
	$sql = "SELECT DISTINCT COUNT(`ID_ETU`) AS `NB_ETU`\n"
		 . "FROM `ETUDIANT`\n"
		 . "WHERE `CODE_CLASSE` = '$classe'\n";
	$res = $connexion->query($sql); 
	$res = $res->fetch(PDO::FETCH_ASSOC);

	$nb_etu = $res['NB_ETU'];


	/**
	 * Phase 2
	 * -------
	 * Selection du nombre d'étudiant ayant un stage
	 */
	$sql = "SELECT DISTINCT COUNT(DISTINCT `STAGE`.`ID_ETU`) AS `NB_STAGES`\n"
		 . "FROM `STAGE`\n"
		 . "INNER JOIN `ETUDIANT`\n"
		 . "        ON `ETUDIANT`.`ID_ETU` = `STAGE`.`ID_ETU`\n"
		 . "INNER JOIN `PERIODE`\n"
		 . "        ON `PERIODE`.`ID_PERIODE` = `STAGE`.`ID_PERIODE`\n"
		 . "INNER JOIN `DPERIODE`\n"
		 . "        ON `DPERIODE`.`ID_DPERIODE` = `PERIODE`.`ID_DPERIODE`\n"
		 . "WHERE DATE_FORMAT(`DPERIODE`.`DATE_DEBUT`, '%Y') >= \n"
		 . "	(\n"
		 . "		SELECT MAX(DATE_FORMAT(`DPERIODE`.`DATE_DEBUT`, '%Y')) AS `ANNEE`\n"
		 . "		FROM `STAGE`\n"
		 . "		INNER JOIN `PERIODE`\n"
		 . "		        ON `PERIODE`.`ID_PERIODE` = `STAGE`.`ID_PERIODE`\n"
		 . "		INNER JOIN `DPERIODE`\n"
		 . "		        ON `DPERIODE`.`ID_DPERIODE` = `PERIODE`.`ID_DPERIODE`\n"
		 . "	)\n"
		 . "AND `ETUDIANT`.`CODE_CLASSE` = '$classe';";

	$res = $connexion->query($sql);
	$res = $res->fetch(PDO::FETCH_ASSOC);

	$nb_stages = $res['NB_STAGES'];

	/**
	 * Phase 3
	 * -------
	 * Liste (nom, prénom) des étudiants qui n'ont pas trouvé de stage
	 */
	$sql = "SELECT DISTINCT CONCAT(UPPER(`ETUDIANT`.`NOM_ETU`), \" \", `ETUDIANT`.`PRENOM_ETU`) AS `NOMS_ETU`\n"
		 . "FROM `STAGE`\n"
		 . "INNER JOIN `ETUDIANT`\n"
		 . "        ON `ETUDIANT`.`ID_ETU` != `STAGE`.`ID_ETU`\n"
		 . "INNER JOIN `PERIODE`\n"
		 . "        ON `PERIODE`.`ID_PERIODE` = `STAGE`.`ID_PERIODE`\n"
		 . "INNER JOIN `DPERIODE`\n"
		 . "        ON `DPERIODE`.`ID_DPERIODE` = `PERIODE`.`ID_DPERIODE`\n"
		 . "WHERE DATE_FORMAT(`DPERIODE`.`DATE_DEBUT`, '%Y') >=\n"
		 . "	(\n"
		 . "		SELECT MAX(DATE_FORMAT(`DPERIODE`.`DATE_DEBUT`, '%Y')) AS `ANNEE`\n"
		 . "		FROM `STAGE`\n"
		 . "		INNER JOIN `PERIODE`\n"
		 . "		        ON `PERIODE`.`ID_PERIODE` = `STAGE`.`ID_PERIODE`\n"
		 . "		INNER JOIN `DPERIODE`\n"
		 . "		        ON `DPERIODE`.`ID_DPERIODE` = `PERIODE`.`ID_DPERIODE`\n"
		 . "	)\n"
		 . "AND `ETUDIANT`.`CODE_CLASSE` = '$classe';";

	$res = $connexion->query($sql);
	$qui = $res->fetchAll(PDO::FETCH_ASSOC);

	/**
	 * @var string $progression Contient les éléments HTML pour afficher les informations de supervisation
	 * -------
	 * En-tête
	 */
	$progression = '<div>'."\n"
				 . '<h4>'.$classe.'</h4>'."\n"
				 . '<p>'.'<b>'.$nb_stages.'</b>'." étudiant(s) sur ".'<b>'.$nb_etu.'</b>'." ont trouvé un stage".'</p>'."\n";

	// Canvas
	$progression .= '<canvas id="canvas'.$classe.'" width="200" height="200"></canvas>'."\n"
				 . '<script>'."\n"
				 . "\t".'var canvas = document.getElementById(\'canvas'.$classe.'\')'."\n"
				 . "\t".'pie(canvas.getContext(\'2d\'), canvas.width, canvas.height, ['.$nb_stages.', '.$nb_etu.']);'."\n"
				 . '</script>'."\n";

	// Détails
	$progression .= '<details>'
				 . '<summary>'."Qui n'a pas trouvé ?".'</summary>'."\n"
				 . '<ul>'."\n";
	foreach ($qui as $row) {
		$progression .= "\t".'<li>'.$row['NOMS_ETU'].'</li>'."\n";
	}
	$progression .= '<ul>'."\n".'</details>'."\n"
				 . '</div>'."\n";



	return $progression;
}

?>
<!DOCTYPE html>
<html>
<head>
	<?php

	// Inclusion des différents paramètres présent dans l'élément head commum aux pages
	include("../struct/param_head.php");
	echo '<title>'."Ajout d'une entreprises".$title.'</title>';

	?>
	<link rel="stylesheet" type="text/css" href="../css/stage.css">
	<script src="../js/graphique.js" type="text/javascript"></script>
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
--><section id="supervisation" class="document">
		<div class="placer">
			<h1>Etats des stages<h1>
			<hr>
			<?php echo progressionStage('SIO1', $connexion) ?>
			<?php echo progressionStage('SIO2', $connexion) ?>
		</div>
</section><!-- 
--><?php

// Inclusion de l'éléménet footer (pied de page)
include("../struct/pieddepage.php");

?>
</body>
</html>