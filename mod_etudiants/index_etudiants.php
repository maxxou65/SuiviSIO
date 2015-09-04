<!--
================================
	Création de la session
	Redirection des utilisateurs non identifié
================================
-->
<?php
	include_once("../connexion/session.php");
	$_SESSION['MOD'] = "_"."etudiants"; // définition du module
	$mod = $_SESSION['MOD'];
?>
<!--
================================
	
================================
-->
<?php
	// ici, vos scripts ...
	// of course
?>
<!--
================================
	DOCUMENT HTML
================================
-->
<!DOCTYPE html>
<html>
<head>
	<!--
	================================
		paramètres du <head>
		commun aux pages (inclusion de fichiers CSS, JS; balise meta; ...) 
	================================
	-->
	<?php include("../struct/param_head.php");
	echo '<title>'."Module étudiants".$title.'</title>';
	// nom de votre page
	?>
	<link rel="stylesheet" type="text/css" href="../css/etudiants.css">
</head>
<body><!--
	entête (header)
--><?php include("../struct/entete".$mod.".php"); ?><!--
	menu horizontal
--><?php include("../struct/menu_horizontal.php"); ?><!--
	menu vertical
--><?php include("../struct/menu_vertical".$mod.".php"); ?><!--
	contenu de la page
	appliquez un ID sur votre section pour y appliquer un style particulier en CSS
--><section id="" class="document">
		<div class="placer">
			<h1>Bienvenue sur le module de gestion des étudiants actuellement dans la section</h1>
			<hr>
			<ul>
				<li>Choisissez une action du module dans le menu à gauche</li>
				<li>Sinon changez de module dans le menu ci-dessus</li>
				<li>Le menu "Accueil"  vous ramenera sur cette page</li>
				<li>Enfin, vous pouvez revenir sur l'accueil de l'application grâce à l'icone dans le coin supérieur gauche</li>	
			</ul>
		</div>
</section><!--
	Pied de page (footer)
--><?php include("../struct/pieddepage.php"); ?>
</body>
</html>