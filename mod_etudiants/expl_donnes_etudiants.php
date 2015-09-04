<!--
================================
	Création de la session
	Redirection des utilisateurs non identifié
================================
-->
<?php
	include_once("../connexion/session.php");
	$_SESSION['MOD'] = "_"."etudiants"; // définition du module
	$mod = $_SESSION['MOD'];
?>
<!--
================================
	
================================
-->
<?php
// Requete pour selectionner les etudiants
function afficher_etu_sio($classe, $connexion) { // $classe = 'SIO1' || $classe = 'SIO2'
	$sql = "SELECT ID_ETU, NOM_ETU, PRENOM_ETU, DNAISSANCE_ETU, BAC_ORIGINE, CLASSE.CODE_CLASSE, CODE_SPECIALITE, REGIME, ANNEE, DOUBLANT1_ETU, DOUBLANT2_ETU FROM ETUDIANT INNER JOIN ORIGINE on ETUDIANT.ID_ORIGINE=ORIGINE.ID_ORIGINE inner join PROMOTION on ETUDIANT.ID_PROMOTION=PROMOTION.ID_PROMOTION inner join CLASSE on ETUDIANT.CODE_CLASSE=CLASSE.CODE_CLASSE WHERE CLASSE.CODE_CLASSE='$classe' ORDER BY NOM_ETU ASC;";
	$res_sio = $connexion->query($sql);  
	$table_etu_sio = $res_sio->fetchAll(PDO::FETCH_ASSOC);
	$table_etu = '<div>'.'<span class="classe">'.$classe.'</span>'
				 . '<table class="def">'
				 . '<thead>'.'<tr>'
				 . '<th colspan="9">Etudiants</th>'.'<th colspan="2">Redoublement</th>'
				 . '</tr>'.'<tr>'
				 . '<th>ID</th>'.'<th>Nom</th>'.'<th>Prenom</th>'.'<th>Date de naissance</th>'.'<th>Bac</th> '.'<th>Classe</th>'.'<th>Spécialité</th>'.'<th>Regime</th>'.'<th>Promotion</th>'.'<th>1e année</th>'.'<th>2e année</th>'
				 . '</tr>'.'</thead>'
				 . '<tbody>';

	foreach ($table_etu_sio as $table_row) {

		$id_etu =  $table_row['ID_ETU'];
		$nom_etu =  $table_row['NOM_ETU'];
		$prenom_etu =  $table_row['PRENOM_ETU'];
		$dnaissance_etu =  $table_row['DNAISSANCE_ETU'];
		$bac_origine =  $table_row['BAC_ORIGINE'];
		$code_classe =  $table_row['CODE_CLASSE'];
		$code_specialite =  $table_row['CODE_SPECIALITE'];
		$regime =  $table_row['REGIME'];
		$annee =  $table_row['ANNEE'];
		$doublant1_etu =  $table_row['DOUBLANT1_ETU'];
        if($doublant1_etu==1){
            $doublant1_etu="oui";
        }
        else{
            $doublant1_etu="non";
        }
        $doublant2_etu =  $table_row['DOUBLANT2_ETU'];
        if($doublant2_etu==1){
            $doublant2_etu="oui";
        }
        else{
            $doublant2_etu="non";
        }
		$table_etu.= '<tr>'
            . '<td>'.$id_etu.'</td>'
            . '<td>'.$nom_etu.'</td>'
			. '<td>'.$prenom_etu.'</td>'
			. '<td>'.$dnaissance_etu.'</td>'
			. '<td>'.$bac_origine.'</td>'
            . '<td>'.$code_classe.'</td>'
			. '<td>'.$code_specialite.'</td>'
			. '<td>'.$regime.'</td>'
            . '<td>'.$annee.'</td>'
            . '<td>'.$doublant1_etu.'</td>'
            . '<td>'.$doublant2_etu.'</td>'
			. '</tr>';
	}

	$table_etu .= '</tbody>'.'</table>'.'</div>';
	return $table_etu;
}
?>
<!DOCTYPE html>
<html>
<head>
	<!--
		paramètres du <head>
		commun aux pages (inclusion de fichiers CSS, JS; balise meta; ...) 
	-->
	<?php include("../struct/param_head.php");
	echo '<title>'."Module étudiants".$title.'</title>';
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
--><section id="consult" class="document">
<?php
    echo "<h1>Cliquez sur une classe pour afficher les élèves</h1>";
    echo (afficher_etu_sio('SIO1', $connexion));
    echo (afficher_etu_sio('SIO2', $connexion));
?>
</section><!--	Pied de page (footer)
--><?php include("../struct/pieddepage.php"); ?>
    <script src="../js/toggle_etudiants.js"></script>
</body>
</html>