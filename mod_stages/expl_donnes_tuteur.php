<?php

// ================================
// 	Création de la session
// 	Redirection des utilisateurs non identifié
// ================================

include_once('../struct/session.php');
$_SESSION['MOD'] = "_"."stages"; // définition du module
$mod = $_SESSION['MOD'];

// ================================
// 	CREATION DE LA VUE
// ================================

function afficher_entreprise($connexion) { // $classe = 'SIO1' || $classe = 'SIO2'
	$sql = "SELECT CONCAT(UPPER(`NOM_TUTEUR`), ' ', `PRENOM_TUTEUR`) AS NOM_TUTEUR, `SERVICE_TUTEUR`, `STATUT_TUTEUR`, `TEL_TUTEUR`, `MAIL_TUTEUR` FROM `TUTEUR`";
	$res_sio = $connexion->query($sql);  
	$table = $res_sio->fetchAll(PDO::FETCH_ASSOC);
	$table_entreprise = '<table class="def">'
					  . '<thead>'.'<tr>'
					  . '<th>'."NOM".'</th><th>'."SERVICE".'</th><th>'."STATUT".'</th><th>'."TELEPHONE".'</th><th>'."EMAIL".'</th>'
					  . '</tr>'.'</thead>'
					  . '<tbody>';

	foreach ($table as $table_row) {

		$nom_tuteur = $table_row['NOM_TUTEUR'];
		$service_tuteur = $table_row['SERVICE_TUTEUR'];
		$statut_tuteur = $table_row['STATUT_TUTEUR'];
		$tel_tuteur = $table_row['TEL_TUTEUR'];
		$mail_tuteur = $table_row['MAIL_TUTEUR'];

		$table_entreprise .= '<tr>'
						  . '<td>'.$nom_tuteur.'</td>'
						  . '<td>'.$service_tuteur.'</td>'
						  . '<td>'.$statut_tuteur.'</td>'
						  . '<td>'.$tel_tuteur.'</td>'
						  . '<td>'.$mail_tuteur.'</td>'
						  . '</tr>';
	}

	$table_entreprise .= '</tbody>'.'</table>'.'</div>';
	return $table_entreprise;
}

$tab = afficher_entreprise($connexion);

// ================================
// 	CREATION DES LISTES DES STAGES
// ================================

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
<body><!--	entête (header)
--><?php include("../struct/entete".$mod.".php"); ?><!--	menu horizontal
--><?php include("../struct/menu_horizontal.php"); ?><!--	menu vertical
--><?php include("../struct/menu_vertical".$mod.".php"); ?><!--
	contenu de la page
	appliquez un ID sur votre section pour y appliquer un style particulier en CSS
--><section id="consult" class="document">
<div id="tableaux">
<?php echo $tab; ?>
</div>
</section><!--	Pied de page (footer)
--><?php include("../struct/pieddepage.php"); ?>
<script src="../js/consult_stage_jq.js" type="text/javascript"></script>
</body>
</html>