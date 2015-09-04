<?php
/**
 * Accueil de l'application
 *
 * @todo Personnalisé le message d'accueil
 * 
 * @version 1.0.3
 *
 * @author Anthony Lozano
 Modifié le 4/09/2015
 Modifié une deuxième fois
 */


	
/** Inclusion de la session */
include('connexion/session.php');

if (!($_SESSION['CONNEXION']['ID'] == 'enseignant')) {
	header('Location: mod_stages/expl_donnes_entreprise.php');
	exit;
}

?>
<!DOCTYPE html>
<html>
<head>
	<?php

	/** Inclusion des différents paramètres présent dans l'élément head commum aux pages */
	include_once("struct/param_headAccueil.php");

	?>
	<link rel="stylesheet" type="text/css" href="./css/accueil.css">
	<title>Suivi des SIO</title>
</head>
<body><!--
	entête (header)
--><?php include("./struct/enteteAccueil.php");
?>
<section id="accueil" class="">
	<div class="placer">
	<h2>Bienvenu sur l'application de Suivi des SIO <br><sub>qui que vous soyez</sub></h2>
		<p>Choisissez un module ci contre, bon dieu !</p>
		<div id="boutons_accueil">
			<a href="./mod_etudiants/index_etudiants.php">
				<span>Module étudiants</span>	
			</a><!--
		 --><a href="./mod_stages/index_stages.php">
		 		<span>Module stages</span>
		 	</a><!--
		 --><?php
		 	if($_SESSION['CONNEXION']['ID'] == 'enseignant') {
		 	?><!--
		 --><a href="./mod_devenirs/index_devenirs.php">
		 		<span>Module devenirs</span>
		 	</a>
			<?php
			}
		 	?>
	 	</div>
	</div>
</section><!-- 
--><?php

/** Inclusion de l'éléménet footer (pied de page) */
	include( 'struct/pieddepageAccueil.php' );

?>
</body>
</html>
