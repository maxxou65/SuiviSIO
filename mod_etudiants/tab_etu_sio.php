<?php
include_once('../connexion/session.php');

if (isset($_GET["sio1"]) && !isset($_GET["sio2"])) {
	
	$classe = 'SIO1';
	afficher_etudiant_sio($classe, $connexion);

} elseif (!isset($_GET["sio1"]) && isset($_GET["sio2"])) {

	$classe = 'SIO2';
	afficher_etudiant_sio($classe, $connexion);

} elseif (isset($_GET["sio1"]) && isset($_GET["sio2"])) {

	$classe = 'SIO1';
	afficher_etudiant_sio($classe, $connexion);

	$classe = 'SIO2';
	afficher_etudiant_sio($classe, $connexion);


} else {

	$classe = 'SIO1';
	afficher_etudiant_sio($classe, $connexion);

	$classe = 'SIO2';
	afficher_etudiant_sio($classe, $connexion);

}


function afficher_etudiant_sio($classe, $connexion) { // $classe = 'SIO1' || $classe = 'SIO2'
	$sql = "SELECT ID_ETU, NOM_ETU, PRENOM_ETU, CODE_SPECIALITE FROM ETUDIANT WHERE CODE_CLASSE='$classe' ORDER BY CODE_CLASSE, NOM_ETU, PRENOM_ETU";
	$res_sio = $connexion->query($sql);
	$table_etu_sio = $res_sio->fetchAll(PDO::FETCH_ASSOC);
	$table_etu = '<div>'.'<span class="classe">'.$classe.'</span>'
				 . '<table class="def">'
				 . '<thead>'.'<tr>'
				 . '<th colspan="3">Etudiant</th>'
				 . '</tr>'.'<tr>'
				 . '<th>ID</th><th>Nom Prénom</th>'.'<th>Spécialité</th>'
				 . '</tr>'.'</thead>'
				 . '<tbody>';
	$i = 0;
	foreach ($table_etu_sio as $table_row) {

		$id_etu =  $table_row['ID_ETU'];
		$prenom_etu =  $table_row['PRENOM_ETU'];
		$nom_etu =  $table_row['NOM_ETU'];
		$spe_etu = $table_row['CODE_SPECIALITE'];

		$table_etu .= '<tr>'
					. '<td>'.'<input name="table_etu_sio'.$i.'[ID_ETU]" value="'.$id_etu.'" type="text" readonly>'.'</td>'.'<td>'.$prenom_etu." ".$nom_etu.'</td>'.'<td>'.$spe_etu.'</td>'.'<td><input type="checkbox" name="table_etu_sio'.$i.'[sup]">Supprimer</td>'
					. '</tr>';
		$i++;
	}

	$table_etu .= '</tbody>'.'</table>'.'</div>';
	echo $table_etu;
}