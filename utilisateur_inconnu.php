<?php
/**
 * @see http://www.phpdoc.org/
 * ---------------------------
 *
 * Page de redirection pour un utilisateur inconnu ou non-authentifié
 * 
 * @todo Améliorer l'intégration de la re-direction
 *
 * @version 1.0.1
 *
 * @author Anthony Lozano
 */

// Redirige l'utilisateur sur la page index.php au bout de 5 secondes
header ("Refresh: 5;URL=index.php");

?>
<!DOCTYPE html>
<html>
<head>
	<?php

	// Inclusion des différents paramètres présent dans l'élément head commum aux pages
	include("./struct/param_head.php");
	echo '<title>'."Erreur d'authentification".$title.'</title>';

	?>
</head>
<body><!--
--><?php 

	// Inclusion de l'élément header (en-tête) 
	include("./struct/entete.php"); ?><!--

--><section id="" class="document">
	<div class="placer">
		<h3>Vous n'êtes pas authentifié ou votre session à expiré<br><sub>(brigand !)</sub></h3>
		<p>Vous allez être redirigé sur la page de connexion dans quelque secondes ...</p><img src="img/ajax-loader.gif" alt="">
		<p><a href="./index.php">Page de connexion</a></p>
	</div>
</section><!--
--><?php

// Inclusion de l'éléménet footer (pied de page)
include("./struct/pieddepage.php");

?>
</body>
</html>