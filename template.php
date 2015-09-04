<?php
/**
 * Accueil de l'application
 *
 * @todo Redirigé l'utilisateur pour restreindre l'accès à certaine fonctionnalité de l'appli
 * @todo Personnalisé le message d'accueil
 * 
 * @version 1.0.0
 * @see http://frenchcoding.com/2013/05/15/versionnage-semantique/
 *
 * @author Anthony Lozano
 */
?>
<!DOCTYPE html>
<html>
<head>
	<?php

	/** Inclusion des différents paramètres présent dans l'élément head commum aux pages */
	include("struct/param_head.php");
	echo '<title>'."Template".$title.'</title';
	?>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body><!--
--><?php

/** Inclusion de l'élément header (en-tête) */
include("struct/entete.php");

?><!--
--><section id="" class="document">
	<div class="placer">
		<p>- Dis camion ...?</p>
		<p>- ... Camion ?</p>
		<p>- Pouet pouet !</p>
		<h1>Vous êtes perdu ?<br><sub>ceci est une page de modèle (template)</sub></h1>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	</div>
</section><!--
--><?php

/** Inclusion de l'élément footer (pied de page) */
include("struct/pieddepage.php");

?>
</body>
</html>