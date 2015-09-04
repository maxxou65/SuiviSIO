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
	$sql = "SELECT etudiant.CODE_CLASSE, etudiant.NOM_ETU, etudiant.PRENOM_ETU, etudiant.CODE_SPECIALITE, dperiode.DATE_DEBUT, dperiode.DATE_FIN, tuteur.NOM_TUTEUR, professeur.NOM_PROF
			FROM etudiant
			INNER JOIN stage ON etudiant.ID_ETU = stage.ID_ETU
			INNER JOIN periode ON periode.ID_PERIODE = stage.ID_PERIODE
			INNER JOIN dperiode ON dperiode.ID_DPERIODE = periode.ID_DPERIODE
			INNER JOIN entreprise ON entreprise.ID_ENTREPRISE = stage.ID_ENTREPRISE 
			INNER JOIN tuteur ON tuteur.ID_TUTEUR = entreprise.ID_TUTEUR
			INNER JOIN professeur ON professeur.ID_PROF = stage.ID_PROF;";
	$res_sio = $connexion->query($sql);  
	$table = $res_sio->fetchAll(PDO::FETCH_ASSOC);
	$table_entreprise = '<table class="def">'
					  . '<thead>'.'<tr>'
					  . '<th rowspan="2">'."Stage".'</th>'. '<th>'."Date de début".'</th><th>'."Date de fin".'</th><th>'."Nom du stagiaire".'</th><th>'."Prenom du stagiaire".'</th><th>'."Option".'</th><th>'."Nom du tuteur".'</th><th>'."Professeur".'</th><th>'."Fiche".'</th>'
					  . '</tr>'.'</thead>'
					  . '<tbody>';

	foreach ($table as $table_row) {
		$code_classe = $table_row['CODE_CLASSE'];
		$nom_etudiant = $table_row['NOM_ENTREPRISE'];
		$prenom_etudiant = $table_row['TYPE_ENTREPRISE'];
		$adresse_entreprise = $table_row['ADRESSE_ENTREPRISE'];
		$code_specialite = $table_row['CODE_SPECIALITE'];
		$nom_tuteur = $table_row['NOM_TUTEUR'];
		$nom_prof = $table_row['NOM_PROF'];
		//$fiche_etu = $table_row['EMAIL_ENTREPRISE'];

		$table_entreprise .= '<tr>'
						  . '<td>'.'<a href="fiche_entreprises.php?choix='.$id_entreprise.'" alt="Aller sur la fiche correspondante">'.'<img src="../img/fiche.png" width="22" height="30">'.'</a>'.'</td>'
						  . '<td>'.$code_classe.'</td>'
						  . '<td>'.$nom_etudiant.'</td>'
						  . '<td>'.$prenom_etudiant.'</td>'
						  . '<td>'.$adresse_entreprise.'</td>'
						  . '<td>'.$code_specialite.'</td>'
						  . '<td>'.$nom_tuteur.'</td>'
						  . '<td>'.$nom_prof.'</td>'
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