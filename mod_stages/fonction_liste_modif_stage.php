<?php

//<!--
//================================
//	Création d'une liste
//	Liste etudiant
//================================
//-->

function listerEtudiant($id_etu, $i, $connexion) {
	$select_etu = "SELECT ID_ETU, NOM_ETU, PRENOM_ETU FROM ETUDIANT ORDER BY NOM_ETU ASC;";
	$res = $connexion->query($select_etu);
	$table_etu = $res->fetchAll( PDO::FETCH_ASSOC);
	$liste_etu = '<select name="stage'.$i.'[ID_ETU]">'."\n";
	foreach ($table_etu as $table_row){
		$selected = "";
		if ($table_row['ID_ETU'] == $id_etu) {
			$selected = 'selected';
		}
		$liste_etu .= '<option value="'.$table_row['ID_ETU'].'" '.$selected.">".$table_row['PRENOM_ETU'].' '.$table_row['NOM_ETU'].'</option>'."\n";
	}
	$liste_etu .= '</select>';
	return $liste_etu;
}

// <!--
// ================================
// 	Création d'une liste
// 	Liste tuteur (entreprise)
// ================================
// -->

function listerTuteur($id_tuteur, $i, $connexion) {

	$select_tuteur = "SELECT ID_TUTEUR, NOM_TUTEUR, PRENOM_TUTEUR FROM TUTEUR;";
	$res = $connexion->query($select_tuteur);
	$table_tuteur = $res->fetchAll( PDO::FETCH_ASSOC);
	
	$select_tuteur = '<select name="stage'.$i.'[ID_TUTEUR]">'."\n";
	foreach ($table_tuteur as $table_row){
		$selected = "";
		if ($table_row['ID_TUTEUR'] == $id_tuteur) {
			$selected = 'selected';
		}
		$select_tuteur .= '<option value="'.$table_row['ID_TUTEUR'].'" '.$selected.">".$table_row['PRENOM_TUTEUR'].' '.$table_row['NOM_TUTEUR'].'</option>'."\n";
	}
	$select_tuteur .= '</select>';
	return $select_tuteur;
}

// <!--
// ================================
// 	Création d'une liste
// 	Liste superviseur (professeur)
// ================================
// -->

function listerProfSuperviseur($id_prof, $i, $connexion) {
	$sql = "SELECT `ID_PROF`, `MAT_PROF` FROM PROFESSEUR ORDER BY `MAT_PROF` ASC";
	$res = $connexion->query($sql);
	$table_tuteur = $res->fetchAll(PDO::FETCH_ASSOC);
	$select_mprof_tuteur = '<select name="stage'.$i.'[ID_PROF_TUTEUR]">'."\n";
	foreach ($table_tuteur as $table_row){
		$selected = "";
		if ($table_row['ID_PROF'] == $id_prof) {
			$selected = 'selected';
		}
		$select_mprof_tuteur .= '<option value="'.$table_row['ID_PROF'].'" '.$selected.">".$table_row['MAT_PROF'].'</option>'."\n";
	}
	$select_mprof_tuteur .= '</select>';
	return $select_mprof_tuteur;
}

// <!--
// ================================
// 	Création d'une liste
// 	Liste tuteur (professeur)
// ================================
// -->

function listerProf($id_prof, $i, $connexion) {
	$sql = "SELECT `ID_PROF`, `MAT_PROF` FROM PROFESSEUR ORDER BY `MAT_PROF` ASC";
	$res = $connexion->query($sql);
	$table_tuteur = $res->fetchAll(PDO::FETCH_ASSOC);
	$select_mprof_tuteur = '<select name="stage'.$i.'[ID_PROF_VISITER]">'."\n";
	foreach ($table_tuteur as $table_row){
		$selected = "";
		if ($table_row['ID_PROF'] == $id_prof) {
			$selected = 'selected';
		}
		$select_mprof_tuteur .= '<option value="'.$table_row['ID_PROF'].'" '.$selected.">".$table_row['MAT_PROF'].'</option>'."\n";
	}
	$select_mprof_tuteur .= '</select>';
	return $select_mprof_tuteur;
}

// <!--
// ================================
// 	Création d'une liste
// 	Liste (entreprise)
// ================================
// -->

function listerEntreprise($id_entreprise, $i, $connexion) {
	$sql = "SELECT `ID_ENTREPRISE`, `NOM_ENTREPRISE` FROM `ENTREPRISE` ORDER BY `NOM_ENTREPRISE` ASC;";
	$res = $connexion->query($sql);
	$table_periode = $res->fetchAll(PDO::FETCH_ASSOC);
	$select_periode = '<select name="stage'.$i.'[ID_ENTREPRISE]">'."\n";
	foreach ($table_periode as $table_row){
		$selected = "";
		if ($table_row['ID_ENTREPRISE'] == $id_entreprise) {
			$selected = 'selected';
		}
		$select_periode .= '<option value="'.$table_row['ID_ENTREPRISE'].'" '.$selected.">".$table_row['NOM_ENTREPRISE'].'</option>'."\n";
	}
	$select_periode .= '</select>';
	return $select_periode;
}

// <!--
// ================================
// 	Création d'une liste
// 	Liste (entreprise)
// ================================
// -->

function listerPeriode($id_periode, $i, $connexion) {
	$sql = "SELECT `ID_DPERIODE`, `DATE_DEBUT`, `DATE_FIN` FROM `DPERIODE` ORDER BY `DATE_DEBUT` ASC;";
	$res = $connexion->query($sql);
	$table_periode = $res->fetchAll(PDO::FETCH_ASSOC);


	$select_periode = '<select name="stage'.$i.'[ID_PERIODE]">'."\n";
	$opt_group = substr($table_periode[0]['DATE_DEBUT'],0,4);
	$select_periode .= '<optgroup label="'.$opt_group.'">';

	foreach ($table_periode as $table_row){
		$selected = "";
		if ($table_row['ID_DPERIODE'] == $id_periode)
			$selected = 'selected';
		if ($opt_group != substr($table_row['DATE_DEBUT'],0,4)) {
			$opt_group = substr($table_row['DATE_DEBUT'],0,4);
			$select_periode .= '</optgroup>'.'<optgroup label="'.$opt_group.'">';
		}
		$select_periode .= '<option value="'.$table_row['ID_DPERIODE'].'" '.$selected."><b>".$table_row['DATE_DEBUT']."</b> au <b>".$table_row['DATE_FIN'].'</b></option>'."\n";
	}
	$select_periode .= '</select>';
	return $select_periode;
}
?>