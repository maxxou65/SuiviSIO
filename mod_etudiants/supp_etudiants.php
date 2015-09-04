<?php
	include_once("../connexion/session.php");
	$_SESSION['MOD'] = "_"."etudiants"; // définition du module
	$mod = $_SESSION['MOD'];

// Si formulaire soumis
// -----------

if (isset($_POST))
{
	// $tab=$_POST['table_etu_sio'];
	foreach($_POST as $ligne)
	{
		if (isset($ligne['sup'])) 
		{
			$id_etu=$ligne['ID_ETU'];
			
			$requete="DELETE FROM ETUDIANT WHERE ID_ETU=$id_etu;";
			$message = '<li>'.$requete.'</li>'
					 . '<li>'."Suppression effectives".'</li>';
			try {
				$connexion->query($requete);
			} catch (PDOException $e) {
				$message="<li> Problème pour supprimer l'étudiant n°$id_etu </li>".
					'<li>'.$e->getMessage().'</li>';
			}
		}
	}
}
include_once('../struct/session.php');

function afficher_etudiant_sio($classe, $connexion) { // $classe = 'SIO1' || $classe = 'SIO2'
	$sql = "SELECT ID_ETU, NOM_ETU, PRENOM_ETU, CODE_SPECIALITE FROM ETUDIANT WHERE CODE_CLASSE='$classe'";
	$res_sio = $connexion->query($sql);
	$table_etu_sio = $res_sio->fetchAll(PDO::FETCH_ASSOC);
	$table_etu = '<div>'.'<span class="classe">'.$classe.'</span>'
				 . '<table class="def">'
				 . '<thead>'.'<tr>'
				 . '<th colspan="3">Etudiant</th>'
				 . '</tr>'.'<tr>'
				 . '<th>Nom Prénom</th>'.'<th>Spécialité</th><th>Supprimer</th>'
				 . '</tr>'.'</thead>'
				 . '<tbody>';
	$i = 0;
	foreach ($table_etu_sio as $table_row) {

		$id_etu =  $table_row['ID_ETU'];
		$prenom_etu =  $table_row['PRENOM_ETU'];
		$nom_etu =  $table_row['NOM_ETU'];
		$spe_etu = $table_row['CODE_SPECIALITE'];

		$table_etu .= '<tr>'
					. '<td>'.'<input name="table_etu_sio'.$i.'[ID_ETU]" value="'.$id_etu.'" type="text" readonly>'.'</td>'.'<td>'.$prenom_etu." ".$nom_etu.'</td>'.'<td>'.$spe_etu.'</td>'.'<td><input type="checkbox" name="table_etu_sio'.$i.'[sup]" value="'.$id_etu.'"></td>'
					. '</tr>';
		$i++;
	}

	$table_etu .= '</tbody>'.'</table>'.'</div>';
	return $table_etu;
}

$tab = "";

if (isset($_GET["sio1"]) && !isset($_GET["sio2"])) {

	$classe = 'SIO1';
	$tab = afficher_etudiant_sio($classe, $connexion);

} elseif (!isset($_GET["sio1"]) && isset($_GET["sio2"])) {

	$classe = 'SIO2';
	$tab = afficher_etudiant_sio($classe, $connexion);

} elseif (isset($_GET["sio1"]) && isset($_GET["sio2"])) {

	$classe = 'SIO1';
	$tab = afficher_etudiant_sio($classe, $connexion);
	$classe = 'SIO2';
	$tab .= afficher_etudiant_sio($classe, $connexion);

} else {

	$classe = 'SIO1';
	$tab = afficher_etudiant_sio($classe, $connexion);
	$classe = 'SIO2';
	$tab .= afficher_etudiant_sio($classe, $connexion);
}
?>



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
echo '<title>'."Suppression étudiants".$title.'</title>';
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
--><section id="supp_etu" class="document">
<form id="choix_classe" action="supp_etudiants.php" method="get">
	<p>Choissiez la classe à consulter</p>
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
<?php include("../struct/message.php"); ?>
<form id="supp_etu_classe" action="supp_etudiants.php" method="post">
<div id="tableaux">
	<?php echo $tab; ?>
</div>
<input id="Supp_Etu" type="submit" class="submit suppression" value="Supprimer">
</form>
</section><!--	Pied de page (footer)
--><?php include("../struct/pieddepage.php"); ?>
<script src="../js/consult_classe_etu_jq.js" type="text/javascript"></script>
</body>
</html>