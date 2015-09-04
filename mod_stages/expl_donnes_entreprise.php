<?php

/** 
 * Inclusion de la session
 * Définition du module. A améliorer
 * @var string $mod Définit le module pour les inclusions (en-tête, menu vertical)
 */
include_once('../connexion/session.php');
$_SESSION['MOD'] = "_"."stages"; // définition du module
$mod = $_SESSION['MOD'];


/**
 * Permet l'affiche d'un tableau avec
 * @param type $connexion 
 * @return type
 */
function afficher_entreprise($connexion) { // $classe = 'SIO1' || $classe = 'SIO2'
	$sql = "SELECT `ID_ENTREPRISE`, `NOM_ENTREPRISE`, `TYPE_ENTREPRISE`, `ADRESSE_ENTREPRISE`, `CPOSTAL_ENTREPRISE`, `VILLE_ENTREPRISE`, `TEL_ENTREPRISE`, `EMAIL_ENTREPRISE`, `ID_TUTEUR` FROM `entreprise` ORDER BY `NOM_ENTREPRISE`;";
	$res_sio = $connexion->query($sql);  
	$table = $res_sio->fetchAll(PDO::FETCH_ASSOC);
	$table_entreprise = '<table class="def">'
					  . '<thead>'.'<tr>'
					  . '<th rowspan="2">'."Fiche".'</th>'. '<th>'."NOM".'</th><th>'."TYPE".'</th><th>'."ADRESSE".'</th><th>'."CODE POSTAL".'</th><th>'."VILLE".'</th><th>'."TELEPHONE".'</th><th>'."EMAIL".'</th>'
					  . '</tr>'.'</thead>'
					  . '<tbody>';

	foreach ($table as $table_row) {
		$id_entreprise = $table_row['ID_ENTREPRISE'];
		$nom_entreprise = $table_row['NOM_ENTREPRISE'];
		$type_entreprise = $table_row['TYPE_ENTREPRISE'];
		$adresse_entreprise = $table_row['ADRESSE_ENTREPRISE'];
		$cpostal_entreprise = $table_row['CPOSTAL_ENTREPRISE'];
		$ville_entreprise = $table_row['VILLE_ENTREPRISE'];
		$tel_entreprise = $table_row['TEL_ENTREPRISE'];
		$email_entreprise = $table_row['EMAIL_ENTREPRISE'];

		$table_entreprise .= '<tr>'
						  . '<td>'.'<a href="fiche_entreprises.php?choix='.$id_entreprise.'" alt="Aller sur la fiche correspondante">'.'<img src="../img/fiche.png" width="22" height="30">'.'</a>'.'</td>'
						  . '<td>'.$nom_entreprise.'</td>'
						  . '<td>'.$type_entreprise.'</td>'
						  . '<td>'.$adresse_entreprise.'</td>'
						  . '<td>'.$cpostal_entreprise.'</td>'
						  . '<td>'.$ville_entreprise.'</td>'
						  . '<td>'.$tel_entreprise.'</td>'
						  . '<td>'.$email_entreprise.'</td>'
						  . '</tr>';
	}

	$table_entreprise .= '</tbody>'.'</table>'.'</div>';
	return $table_entreprise;
}

$tab = afficher_entreprise($connexion);

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
echo '<title>'."Consulter les entreprises".$title.'</title>';

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
--><section id="consult" class="document">
	<div id="tableaux">
		<?php echo $tab; ?>
	</div>
</section><!--
--><?php

/** Inclusion de l'éléménet footer (pied de page) */
include("../struct/pieddepage.php");

?>
</body>
</html>