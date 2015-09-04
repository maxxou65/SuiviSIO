<?php
/**
 * @see http://www.phpdoc.org/
 * ---------------------------
 *
 * Index du module devenirs
 *
 * @package mod_devenirs
 *
 * @version 1.0
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
$_SESSION['MOD'] = "_"."devenirs";
$mod = $_SESSION['MOD'];



?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
	<?php

	// Inclusion des différents paramètres présent dans l'élément head commum aux pages
	include_once("../struct/param_head.php");
	echo '<title>'."Ajout d'une entreprises".$title.'</title>';

	?>
	<link rel="stylesheet" type="text/css" href="../css/devenirs.css">
</head>
<body class="mod_stages"><!--
--><?php

// Inclusion de l'élément header (en-tête), dépend du module
include_once("../struct/entete".$mod.".php");

// Inclusion de l'élément nav, correspondant au menu horizontal (liens vers les modules)
include_once("../struct/menu_horizontal.php");

// Inclusion de l'élément nav, correspondant au menu vertical, dépend du module
include_once("../struct/menu_vertical".$mod.".php");

?><!--
--><section id="" class="document">
		<div class="placer">
			<h1>Bienvenue sur le module de gestion des étudiants actuellement dans la section</h1>
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