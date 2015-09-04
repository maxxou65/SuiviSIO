<?php
/**
 * Accueil du module des stages
 * 
 * @package mod_stages
 *
 * @version 1.0.0
 * @see http://frenchcoding.com/2013/05/15/versionnage-semantique/
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
 * Description
 * @param string $classe 
 * @param object $connexion 
 * @return type
 */
function stageTrouver($classe, $connexion){

	$sql = "SELECT COUNT(DISTINCT `STAGE`.`ID_ETU`)\n"
		 . "FROM `STAGE`\n"
		 . "INNER JOIN `ETUDIANT`\n"
		 . "		ON `ETUDIANT`.`ID_ETU` != `STAGE`.`ID_ETU`\n"
		 . "INNER JOIN `PERIODE`\n"
		 . "		ON `PERIODE`.`ID_PERIODE` = `STAGE`.`ID_PERIODE`\n"
		 . "INNER JOIN `DPERIODE`\n"
		 . "		ON `DPERIODE`.`ID_DPERIODE` = `PERIODE`.`ID_DPERIODE`\n"
		 . "WHERE `DPERIODE`.`DATE_DEBUT` >= (\n"
		 . "								SELECT MAX(DATE_FORMAT(`DATE_DEBUT`, '%Y')) AS `ANNEE`\n"
		 . "								FROM `STAGE`\n"
		 . "								INNER JOIN `PERIODE`\n"
		 . "										ON `PERIODE`.`ID_PERIODE` = `STAGE`.`ID_PERIODE`\n"
		 . "								INNER JOIN `DPERIODE`\n"
		 . "										ON `DPERIODE`.`ID_DPERIODE` = `PERIODE`.`ID_DPERIODE`\n"
		 . "								 )\n"
		 . "AND `CLASSE_STAGE` = 'SIO2';";
  	$res = $connexion->query($sql); 
	$table = $res->fetchAll(PDO::FETCH_ASSOC);



}

?>
<!DOCTYPE html>
<html>
<head>
	<?php

	/** Inclusion des différents paramètres présent dans l'élément head commum aux pages */
	include("../struct/param_head.php");
	echo '<title>'."Accueil du module stages".$title.'</title>';

	?>
	<link rel="stylesheet" type="text/css" href="../css/stage.css">
</head>
<body><!--
--><?php

/** Inclusion de l'élément header (en-tête), dépend du module */
include("../struct/entete".$mod.".php");

/** Inclusion de l'élément nav, correspondant au menu horizontal (liens vers les modules) */
include("../struct/menu_horizontal.php");

/** Inclusion de l'élément nav, correspondant au menu vertical, dépend du module */
include("../struct/menu_vertical".$mod.".php");

?><!--
--><section id="" class="document">
		<div class="placer">
			<h1>Bienvenue sur le module de gestion des stages et des entreprises</h1>
			<hr>
			<ul>
				<li>Choisissez une action du module dans le menu à gauche</li>
				<li>Sinon changez de module dans la barre de menu ci-dessus</li>
				<li>Le menu "Accueil"  vous ramenera sur cette page</li>
				<li>Enfin, vous pouvez revenir sur l'accueil de l'application grâce à l'icone dans le coin supérieur gauche</li>	
			</ul>
		</div>
</section><!-- 
--><?php

// Inclusion de l'éléménet footer (pied de page)
include("../struct/pieddepage.php");

?>
</body>
</html>