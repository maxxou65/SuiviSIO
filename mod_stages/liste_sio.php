<?php
include_once('../connexion/session.php');

if (isset($_GET["sio1"]) && !isset($_GET["sio2"])) {
	
	$classe = 'SIO1';
	afficher_stage_sio($classe, $connexion);

} elseif (!isset($_GET["sio1"]) && isset($_GET["sio2"])) {

	$classe = 'SIO2';
	afficher_stage_sio($classe, $connexion);

} elseif (isset($_GET["sio1"]) && isset($_GET["sio2"])) {

	$classe = 'SIO1';
	afficher_stage_sio($classe, $connexion);

	$classe = 'SIO2';
	afficher_stage_sio($classe, $connexion);


} else {

	$classe = 'SIO1';
	afficher_stage_sio($classe, $connexion);

	$classe = 'SIO2';
	afficher_stage_sio($classe, $connexion);

}


function afficher_stage_sio($classe, $connexion) { // $classe = 'SIO1' || $classe = 'SIO2'
	$sql = "SELECT PRENOM_ETU, NOM_ETU, NOM_ENTREPRISE, TYPE_ENTREPRISE, PRENOM_TUTEUR, NOM_TUTEUR, TEL_TUTEUR, MAIL_TUTEUR, PROF_TUTEUR.MAT_PROF MAT_PROF_TUTEUR, PROF_VISITEUR.MAT_PROF MAT_PROF_VISITEUR FROM STAGE INNER JOIN ETUDIANT ON STAGE.ID_ETU = ETUDIANT.ID_ETU INNER JOIN ENTREPRISE ON STAGE.ID_ENTREPRISE= ENTREPRISE.ID_ENTREPRISE INNER JOIN TUTEUR ON STAGE.ID_TUTEUR = TUTEUR.ID_TUTEUR INNER JOIN PROFESSEUR PROF_TUTEUR ON STAGE.ID_PROF = PROF_TUTEUR.ID_PROF INNER JOIN PROFESSEUR PROF_VISITEUR ON STAGE.ID_PROF_VISITER = PROF_VISITEUR.ID_PROF WHERE CLASSE_STAGE = '$classe';";
	$res_sio = $connexion->query($sql);  
	$table_stage_sio = $res_sio->fetchAll(PDO::FETCH_ASSOC);
	$table_stage = '<div>'.'<span class="classe">'.$classe.'</span>'
				 . '<table class="def">'
				 . '<thead>'.'<tr>'
				 . '<th rowspan="2">Etudiant</th>'.'<th colspan="2">Entreprise</th>'.'<th colspan="3">Tuteur</th>'.'<th colspan="2">Professeur</th>'
				 . '</tr>'.'<tr>'
				 . '<th>Nom</th>'.'<th>Adresse</th>'.'<th>Nom</th>'.'<th>Téléphone</th>'.'<th>Mail</th>'.'<th>Tuteur</th>'.'<th>Visiteur</th>'
				 . '</tr>'.'</thead>'
				 . '<tbody>';

	foreach ($table_stage_sio as $table_row) {

		$prenom_etu =  $table_row['PRENOM_ETU'];
		$nom_etu =  $table_row['NOM_ETU'];
		$nom_entreprise =  $table_row['NOM_ENTREPRISE'];
		$type_entreprise =  $table_row['TYPE_ENTREPRISE'];
		$prenom_tuteur =  $table_row['PRENOM_TUTEUR'];
		$nom_tuteur =  $table_row['NOM_TUTEUR'];
		$tel_tuteur =  $table_row['TEL_TUTEUR'];
		$mail_tuteur =  $table_row['MAIL_TUTEUR'];
		$mat_prof_tuteur =  $table_row['MAT_PROF_TUTEUR'];
		$mat_prof_visiteur =  $table_row['MAT_PROF_VISITEUR'];

		$table_stage .= '<tr>'
					  . '<td>'.$prenom_etu." ".$nom_etu.'</td>'
					  . '<td>'.$nom_entreprise.'</td>'
					  . '<td>'.$type_entreprise.'</td>'
					  . '<td>'.$prenom_tuteur." ".$nom_tuteur.'</td>'
					  . '<td>'.$tel_tuteur.'</td>'
					  . '<td>'.$mail_tuteur.'</td>'
					  . '<td>'.$mat_prof_tuteur.'</td>'
					  . '<td>'.$mat_prof_visiteur.'</td>'
					  . '</tr>';
	}

	$table_stage .= '</tbody>'.'</table>'.'</div>';
	echo $table_stage;
}
?>