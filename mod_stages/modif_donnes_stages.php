<?php

// ================================
// 	Création de la session
// 	Redirection des utilisateurs non identifié
// ================================

include_once('../connexion/session.php');
$_SESSION['MOD'] = "_"."stages"; // définition du module
$mod = $_SESSION['MOD'];

// ================================
// 	Si formulaire soumis
// ================================


if (isset($_POST['stage0'])) {
	foreach ($_POST as $stage) {

		$id_tuteur = $stage['ID_TUTEUR'];
		$id_entreprise = $stage['ID_ENTREPRISE'];
		$id_stage = $stage['ID_STAGE'];
		$id_etu = $stage['ID_ETU'];
		$id_prof = $stage['ID_PROF_TUTEUR'];
		$id_prof_visiter = $stage['ID_PROF_VISITER'];

		$sql = "	UPDATE `stage`
					SET `ID_ETU` = $id_etu,
						`ID_TUTEUR` = $id_tuteur,
						`ID_ENTREPRISE` = $id_entreprise,
						`ID_PROF` = $id_prof,
						`ID_PROF_VISITER` = $id_prof_visiter
					WHERE `ID_STAGE` = $id_stage;";
		
		$message = "Modifications effectives.";

		try {
			$resultats=$connexion->query($sql);
		} catch(PDOException $e){
			$message = "Probleme pour mettre à jour les informations".'<br>';
			$message .= $e->getMessage();
		}


	}
}

// ================================
// 	INCLUSION DES LISTES
// ================================

include_once("fonction_liste_modif_stage.php");

// ================================
// 	TRAITEMENT DU CHOIX AVEC $_GET
// ================================

function afficher_modstage_sio($classe, $connexion) { // $classe = 'SIO1' || $classe = 'SIO2'
	$sql = "SELECT 	ID_STAGE, ID_PERIODE,\n\t"
		 . "entreprise.ID_TUTEUR, NOM_TUTEUR, PRENOM_TUTEUR,\n\t"
		 . "stage.ID_PROF, PROF_TUTEUR.MAT_PROF AS MAT_PROF_TUTEUR,\n\t"
		 . "stage.ID_PROF_VISITER, PROF_VISITEUR.MAT_PROF AS MAT_PROF_VISITEUR,\n\t"
		 . "stage.ID_ETU, NOM_ETU, PRENOM_ETU,\n\t"
		 . "stage.ID_ENTREPRISE, NOM_ENTREPRISE\n\t"
		 . "FROM stage\n"
		 . "INNER JOIN entreprise ON stage.ID_ENTREPRISE = entreprise.ID_ENTREPRISE\n"
		 . "INNER JOIN tuteur ON entreprise.ID_TUTEUR = tuteur.ID_TUTEUR\n"
		 . "INNER JOIN professeur PROF_TUTEUR ON stage.ID_PROF = PROF_TUTEUR.ID_PROF\n"
		 . "INNER JOIN professeur PROF_VISITEUR ON stage.ID_PROF_VISITER = PROF_VISITEUR.ID_PROF\n"
		 . "INNER JOIN etudiant ON stage.ID_ETU = etudiant.ID_ETU\n"
		 . "WHERE CLASSE_STAGE = '$classe';";

	$res_sio = $connexion->query($sql);  
	$tablesql_modstage_sio = $res_sio->fetchAll(PDO::FETCH_ASSOC);
	$table_modstage_sio = '<div>'.'<span class="classe">'.$classe.'</span>'
						. '<table class="def">'
						. '<thead>'.'<tr>'
						. '<th rowspan="2">Etudiant</th>'.'<th colspan="2">Entreprise</th>'.'<th colspan="2">Professeur</th>'.'<th rowspan="2">Période</th>'
						. '</tr>'.'<tr>'
						. '<th>Nom</th>'.'<th>Tuteur</th>'.'<th>Superviseur</th>'.'<th>Visiteur</th>'
						. '</tr>'.'</thead>'
						. '<tbody>';

	$i = 0;
	foreach ($tablesql_modstage_sio as $table_row) {

		$id_stage = $table_row['ID_STAGE'];
		$id_tuteur = $table_row['ID_TUTEUR'];
		$id_prof = $table_row['ID_PROF'];
		$id_prof_visiter = $table_row['ID_PROF_VISITER'];
		$id_etu = $table_row['ID_ETU'];
		$id_entreprise = $table_row['ID_ENTREPRISE'];
		$id_periode = $table_row['ID_PERIODE'];


		$table_modstage_sio .= '<tr>'
								. '<td class="id_stage">'.'<input name="stage'.$i.'[ID_STAGE]" type="num" value="'.$id_stage.'">'.'</td>'
								. '<td>'.listerEtudiant($id_etu, $i, $connexion).'</td>'
								. '<td>'.listerEntreprise($id_entreprise, $i, $connexion).'</td>'
								. '<td>'.listerTuteur($id_tuteur, $i, $connexion).'</td>'
								. '<td>'.listerProfSuperviseur($id_prof, $i, $connexion).'</td>'
								. '<td>'.listerProf($id_prof_visiter, $i, $connexion).'</td>'
								. '<td>'.listerPeriode($id_periode, $i, $connexion).'</td>'
							. '</tr>';

		$i ++;
	}

	$table_modstage_sio .= '</tbody>'.'</table>'.'</div>';
	return $table_modstage_sio;

}

$tab = "";

if (isset($_GET["sio1"]) && !isset($_GET["sio2"])) {

	$classe = 'SIO1';
	$tab = afficher_modstage_sio($classe, $connexion);

} elseif (!isset($_GET["sio1"]) && isset($_GET["sio2"])) {

	$classe = 'SIO2';
	$tab = afficher_modstage_sio($classe, $connexion);

} elseif (isset($_GET["sio1"]) && isset($_GET["sio2"])) {

	$classe = 'SIO1';
	$tab = afficher_modstage_sio($classe, $connexion);
	$classe = 'SIO2';
	$tab .= afficher_modstage_sio($classe, $connexion);

} else {

	$classe = 'SIO1';
	$tab = afficher_modstage_sio($classe, $connexion);
	$classe = 'SIO2';
	$tab .= afficher_modstage_sio($classe, $connexion);
}

// ================================
// 	DOCUMENT HTML
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
echo '<title>'."Module de gestion des stages et des entreprises".$title.'</title>';
	// nom de votre page
?>
<link rel="stylesheet" type="text/css" href="../css/stage.css">
</head>
<body><!--	entête (header)
--><?php include("../struct/entete".$mod.".php"); ?><!--	menu horizontal
--><?php include("../struct/menu_horizontal.php"); ?><!--	menu vertical
--><?php include("../struct/menu_vertical".$mod.".php"); ?><!--	contenu de la page
--><section id="gerer_stage" class="document">
<form id="choix_classe" action="modif_donnes_stages.php" method="get">
	<p>Choissiez la classe des stages à modifier</p>
	<div>
		<input id="sio1" type="checkbox" name="sio1" <?php if (isset($_GET['sio1'])) echo "checked";?>>
		<label for="sio1">SIO1</label>
	</div>
	<div>
		<input id="sio2" type="checkbox" name="sio2" <?php if (isset($_GET['sio2'])) echo "checked";?>>
		<label for="sio2">SIO2</label>
	</div>
	<input type="submit" class="submit transition" value="Valider">
</form>
<form id="tableaux" action="modif_donnes_stages.php" method="post">
	<?php
	echo $tab;
	?>
	<input type="submit" class="submit long" value="Enregistrer les modifications">
</form>
<?php include("../struct/message.php") ?>
</section><!--
	Pied de page (footer)
--><?php include("../struct/pieddepage.php"); ?>
</body>
</html>