<?php
function breadcrumb() {
	$breadcrumb = '<div id="breadcrumb">';

	$fichier_courant = explode("/", $_SERVER['PHP_SELF']);
	$fichier_courant = $fichier_courant[count($fichier_courant)-1];
	// $fichier_courant = substr($fichier_courant, start);

	$breadcrumb .= '<span>'.'<a href="/accueil.php" alt="Accueil de l\'application">'."SuiviSIO".'</a>'.'</span>'
				 . " > "
				 . '<span>'.'<a href="/mod_stages/index_stages.php" alt="Accueil du module stage">'."Module Stage".'</a>'.'</span>'
				 . " > "
				 . '<span>'.'<a href="'.$_SERVER['PHP_SELF'].'">'."Cette page".'</a>'.'</span>';

	$breadcrumb .= '</div>';

	echo $breadcrumb;
}
?>

