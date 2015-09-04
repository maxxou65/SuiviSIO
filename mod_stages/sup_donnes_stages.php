<?php

// ================================
// 	Création de la session
// 	Redirection des utilisateurs non identifié
// ================================

include_once('../connexion/session.php');
$_SESSION['MOD'] = "_"."stages"; // définition du module
$mod = $_SESSION['MOD'];

// ================================
// 	SI FORMULAIRE ENVOYER
// ================================

if (isset($_POST['sup'])) {
	$sql = "";
	foreach ($_POST['sup'] as $id_stage) {
		if ($sql != "")
			$sql .= " OR ";
		$sql .= " `ID_STAGE` = ".$id_stage;
	}

	$sql = "DELETE FROM `STAGE` WHERE ".$sql;
	$message = newLineMsg("Stage(s) supprimé(s) avec succès");

	try {
		$res = $connexion->query($sql);
	} catch(PDOException $e){
		$message = newLineMsg("Probleme pour supprimer le(s) stage(s)");
		$message .= newLineMsg($e->getMessage());
	}

}


// ================================
// 	FONCTION POUR AFFICHER LES DONNEES
// ================================

function afficher_stage_sio($classe, $connexion) { // $classe = 'SIO1' || $classe = 'SIO2'
	$sql = "SELECT ID_STAGE, PRENOM_ETU, NOM_ETU, NOM_ENTREPRISE, TYPE_ENTREPRISE, PRENOM_TUTEUR, NOM_TUTEUR, TEL_TUTEUR, MAIL_TUTEUR, PROF_TUTEUR.MAT_PROF MAT_PROF_TUTEUR, PROF_VISITEUR.MAT_PROF MAT_PROF_VISITEUR\n"
		 . "FROM STAGE\n"
		 . "INNER JOIN ETUDIANT ON STAGE.ID_ETU = ETUDIANT.ID_ETU\n"
		 . "INNER JOIN ENTREPRISE ON STAGE.ID_ENTREPRISE= ENTREPRISE.ID_ENTREPRISE\n"
		 . "INNER JOIN TUTEUR ON ENTREPRISE.ID_TUTEUR = TUTEUR.ID_TUTEUR\n"
		 . "INNER JOIN PROFESSEUR PROF_TUTEUR ON STAGE.ID_PROF = PROF_TUTEUR.ID_PROF\n"
		 . "INNER JOIN PROFESSEUR PROF_VISITEUR ON STAGE.ID_PROF_VISITER = PROF_VISITEUR.ID_PROF WHERE CLASSE_STAGE = '$classe';";
	$res_sio = $connexion->query($sql);  
	$table_stage_sio = $res_sio->fetchAll(PDO::FETCH_ASSOC);
	$table_stage = '<div>'.'<span class="classe">'.$classe.'</span>'
				 . '<table class="def sup">'
				 . '<thead>'.'<tr>'
				 . '<th rowspan="2" colspan="1">Supprimer ?</th>'.'<th rowspan="2">Etudiant</th>'.'<th colspan="2">Entreprise</th>'
				 . '</tr>'.'<tr>'
				 . '<th>Nom</th>'.'<th>Type</th>'
				 . '</tr>'.'</thead>'
				 . '<tbody>';

	foreach ($table_stage_sio as $table_row) {

		$id_stage = $table_row['ID_STAGE'];
		$prenom_etu =  $table_row['PRENOM_ETU'];
		$nom_etu =  $table_row['NOM_ETU'];
		$nom_entreprise =  $table_row['NOM_ENTREPRISE'];
		$type_entreprise =  $table_row['TYPE_ENTREPRISE'];

					 // . '<td>'.'<input type="number" name="sup[ID_STAGE]" value="'.$id_stage.'" readonly>'.'</td>'

		$table_stage .= '<tr>'
					  . '<td>'.'<input type="checkbox" name="sup['.$id_stage.']" value="'.$id_stage.'">'.'</td>'
					  . '<td>'.$prenom_etu." ".$nom_etu.'</td>'
					  . '<td>'.$nom_entreprise.'</td>'
					  . '<td>'.$type_entreprise.'</td>'
					  . '</tr>';
	}

	$table_stage .= '</tbody>'.'</table>'.'</div>';
	return $table_stage;
}

// ================================
// TRAITEMENT DU CHOIX AVEC $_GET
// ================================

$tab = "";

if (isset($_GET["sio1"]) && !isset($_GET["sio2"])) {

	$classe = 'SIO1';
	$tab = afficher_stage_sio($classe, $connexion);

} elseif (!isset($_GET["sio1"]) && isset($_GET["sio2"])) {

	$classe = 'SIO2';
	$tab = afficher_stage_sio($classe, $connexion);

} elseif (isset($_GET["sio1"]) && isset($_GET["sio2"])) {

	$classe = 'SIO1';
	$tab = afficher_stage_sio($classe, $connexion);
	$classe = 'SIO2';
	$tab .= afficher_stage_sio($classe, $connexion);

} else {

	$classe = 'SIO1';
	$tab = afficher_stage_sio($classe, $connexion);
	$classe = 'SIO2';
	$tab .= afficher_stage_sio($classe, $connexion);
}

// ================================
// 	DOCUMENT HTML
// ================================

?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
	<?php

	// ================================
	// 	paramètres du <head>
	// 	commun aux pages (inclusion de fichiers CSS, JS; balise meta; ...) 
	// ================================

	include("../struct/param_head.php");
	echo '<title>'."Suppression d'un stage".$title.'</title>';

	?>
	<link rel="stylesheet" type="text/css" href="../css/stage.css">
</head>
<body class="mod_stages"><!-- entête (header)
--><?php include("../struct/entete".$mod.".php"); ?><!--	menu horizontal
--><?php include("../struct/menu_horizontal.php"); ?><!--	menu vertical
--><?php include("../struct/menu_vertical".$mod.".php"); ?><!--	contenu de la page
--><section id="sup_stage" class="document">
<form id="choix_classe" action="sup_donnes_stages.php" method="get">
	<p>Choissiez la classe des stages à consulter</p>
	<div>
		<input id="sio1" type="checkbox" name="sio1">
		<label for="sio1">SIO1</label>
	</div>
	<div>
		<input id="sio2" type="checkbox" name="sio2">
		<label for="sio2">SIO2</label>
	</div>
	<input type="submit" class="submit transition" value="Valider">
</form>
<form id="tableaux" action="sup_donnes_stages.php" method="post">
<?php
echo $tab;
?>
<input type="submit" class="submit transition" value="Supprimer">
</form>
<?php include("../struct/message.php"); ?>
</section><!--	Pied de page (footer)
--><?php include("../struct/pieddepage.php"); ?>
</body>
</html>