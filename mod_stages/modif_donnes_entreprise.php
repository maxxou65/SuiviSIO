<?php

// ================================
// 	Création de la session
// 	Redirection des utilisateurs non identifié
// ================================


include_once('../connexion/session.php');
$_SESSION['MOD'] = "_"."stages"; // définition du module
$mod = $_SESSION['MOD'];


/**
* Permet l'affichage de la liste des types  contenu dans la base de donnèes dans le champs 'Type' (ou type entreprise) du formulaire
*
* @param object $connexion Instance de l'objet PDO permettant la connexion et le dialogue avec la base 
* 
* @return string $type contient les éléments HTML (<datalist>) permettant d'afficher la liste des types  d'entreprises sur le champ 'type'
*/

function listType($connexion,$type_ent,$libelle){
	$sql="SELECT `TYPE`,`ID_TYPE_ENTREPRISE` FROM `type_entreprise`;";
	try {
		$res = $connexion->query($sql); 
		$table = $res->fetchAll(PDO::FETCH_ASSOC);		
	} catch(PDOException $e){
		$message = newLineMsg($e->getMessage());
	}
	$type = '<select name="TYPE" list="type_entreprise" id="type" class="defaut">';
	foreach ($table as $row) {
		$type .= '<option value="'.$row['ID_TYPE_ENTREPRISE'].'">'.$row['TYPE'];
	}
	$type .= '<option value="'.$type_ent.'" selected>'.$libelle;

	$type .= '</select>';

	return $type;
}

// ================================
// Récupération du choix
// ================================

$sql = "SELECT `ID_ENTREPRISE`,`NOM_ENTREPRISE` FROM `entreprise` ORDER BY `NOM_ENTREPRISE`;";
$res = $connexion->query($sql);  
$info_ent = $res->fetchAll(PDO::FETCH_ASSOC);


if(isset($_GET['choix'])) {
	$id_entreprise_selected = $_GET['choix'];

// ================================
// Récupération des infos pour l'entreprise
// ================================

	$sql ="SELECT `NOM_ENTREPRISE`,`TYPE_ENTREPRISE`,`ADRESSE_ENTREPRISE`,`CPOSTAL_ENTREPRISE`,`VILLE_ENTREPRISE`,`TEL_ENTREPRISE`,`EMAIL_ENTREPRISE`,`ID_TUTEUR`,entreprise.`ID_CONTACT`, `NOM_CONTACT`,`PRENOM_CONTACT`,`MAIL_CONTACT`,`NUM_TELEPHONE`, `TYPE`
	FROM entreprise INNER JOIN contact ON entreprise.ID_CONTACT=contact.ID_CONTACT
	INNER JOIN type_entreprise ON type_entreprise.ID_TYPE_ENTREPRISE=entreprise.TYPE_ENTREPRISE
	WHERE entreprise.ID_ENTREPRISE = '$id_entreprise_selected';";
	$res = $connexion->query($sql);  
	$info_ents = $res->fetchAll(PDO::FETCH_ASSOC);


/*
Informations concernant ENTREPRISE
*/

$nom_ent=$info_ents[0]['NOM_ENTREPRISE'];
$type_ent=$info_ents[0]['TYPE_ENTREPRISE'];
$libelle=$info_ents[0]['TYPE'];
$adresse_ent=$info_ents[0]['ADRESSE_ENTREPRISE'];
$cpostal_ent=$info_ents[0]['CPOSTAL_ENTREPRISE'];
$ville_ent=$info_ents[0]['VILLE_ENTREPRISE'];
$tel_ent=$info_ents[0]['TEL_ENTREPRISE'];
$mail_ent=$info_ents[0]['EMAIL_ENTREPRISE'];

/*
Information concernant le tuteur
*/

$id_tuteur=$info_ents[0]['ID_TUTEUR'];

/*
Informations concernant le CONTACT
*/

$id_contact=$info_ents[0]['ID_CONTACT'];
$nom_contact=$info_ents[0]['NOM_CONTACT'];
$prenom_contact=$info_ents[0]['PRENOM_CONTACT'];
$tel_contact=$info_ents[0]['NUM_TELEPHONE'];
$mail_contact=$info_ents[0]['MAIL_CONTACT'];


$type=listType($connexion,$type_ent,$libelle);


$ent_test='<form id="modif" action="modif_donnes_entreprise.php" method="POST">'
.'<div class="header">'
.'<h2>Formulaire de modification d une entreprise </h2>'
.'</div>'."\n"
.'<div>'
.'<input name="ENTREPRISE_SELECTED" value="'.$id_entreprise_selected.'" type="hidden" id="adresse" class="defaut"/>'
.'</div>'."\n"
.'<div>'
.'<label for="nom">Raison sociale </label>'
.'<input name="NOM" list="raisons_sociales" value="'.$nom_ent.'" type="text" id="nom" class="defaut" tabindex="1"/>'
.'</div>'."\n"
.'<div>'
.'<label for="type">Type </label>'
.$type
.'</div>'."\n"
.'<div>'
.'<label for="adresse">Ville </label>'
.'<input name="VILLE" value="'.$ville_ent.'" type="text" id="adresse" class="defaut" tabindex="2"/>'
.'</div>'."\n"
.'<div>'
.'<label for="mail">Mail </label>'
.'<input name="MAIL_ENT" value="'.$mail_ent.'" type="text" id="mail_ent" class="defaut" tabindex="3"/>'
.'</div>'."\n"
.'<div>'
.'<label for="tel_ent">Telephone</label>'
.'<input name="TEL_ENT" value="'.$tel_ent.'" type="text" id="adresse" class="defaut" tabindex="4"/>'
.'</div>'."\n"
.'<div>'
.'<label for="adresse">Adresse</label>'
.'<input name="ADRESSE" value="'.$adresse_ent.'" type="text" id="adresse" class="defaut" tabindex="5"/>'
.'</div>'."\n"
.'<div>'
.'<label for="cpost">Code postal</label>'
.'<input min="0" max="99999" name="CPOST" value="'.$cpostal_ent.'" type="number" id="cpost" class="defaut" tabindex="5"/>'
.'</div>'."\n"
.'<div class="header">'
.'<h3>Contact</h3>'
.'</div>'."\n"
.'<div>'
.'<input name="ID_CONTACT" value="'.$id_contact.'" type="hidden" id="adresse" class="defaut"/>'
.'</div>'."\n"
.'<div>'
.'<label for="nom_contact">Nom </label>'
.'<input name="NOM_CONTACT" value="'.$nom_contact.'" type="text" id="adresse" class="defaut"/>'
.'</div>'."\n"
.'<div>'
.'<label for="prenom_contact">PRENOM </label>'
.'<input name="PRENOM_CONTACT" value="'.$prenom_contact.'" type="text" id="adresse" class="defaut"/>'
.'</div>'."\n"
.'<div>'
.'<label for="tel_contact">Téléphone </label>'
.'<input name="TEL_CONTACT" value="'.$tel_contact.'" type="text" id="adresse" class="defaut"/>'
.'</div>'."\n"
.'<div>'
.'<label for="mail_contact">Email </label>'
.'<input name="MAIL_CONTACT" value="'.$mail_contact.'" type="text" id="adresse" class="defaut"/>'
.'</div>'."\n"
.'<input type="submit" class="submit long" value="Enregistrer les modifications">'
.'</form>';

}else {
	$id_entreprise_selected = "";
}

//liste deroulante pour le premier formulaire
$choix_ent = '<select name="choix">'."\n";

foreach ($info_ent as $row) {
	if ($row['NOM_ENTREPRISE'] == $id_entreprise_selected)
		$selected = 'selected';
	else 
		$selected = "";
	$choix_ent .= '<option value="'.$row['ID_ENTREPRISE'].'">'.$row['NOM_ENTREPRISE'].'</option>'."\n";
}

$choix_ent .= '</select>';


if($_SERVER["REQUEST_METHOD"] == "POST") {// Si le formulaire est envoyé

	$message='';

/*
Recuperation des valeur entreprise
*/

$nom=$_POST['NOM'];
$type=$_POST['TYPE'];
$ville=$_POST['VILLE'];
$mail_ent=$_POST['MAIL_ENT'];
$tel_ent=$_POST['TEL_ENT'];
$cpt=$_POST['CPOST'];
$adresse_ent=$_POST['ADRESSE'];
$id_entreprise_selected=$_POST['ENTREPRISE_SELECTED'];
/*
Recuperation des valeur contact
*/
$id_contact=$_POST['ID_CONTACT'];
$nom_contact=$_POST['NOM_CONTACT'];
$prenom_contact=$_POST['PRENOM_CONTACT'];
$tel_contact=$_POST['TEL_CONTACT'];
$mail_contact=$_POST['MAIL_CONTACT'];



/*
Creation du contact si il y a modification d'un des champs du contact
*/

if ($id_contact=="1" AND ($nom_contact!="NR" OR $prenom_contact!="NR" OR $tel_contact!="0" OR $mail_contact!="NR")){
/*
* Phase 1
* -------
* Insertion du contact dans la base si au minimun un seul champs est rempli
*/


$sql = "INSERT INTO `contact`(`NOM_CONTACT`, `PRENOM_CONTACT`, `MAIL_CONTACT`, `NUM_TELEPHONE`)
VALUES ('$nom_contact', '$prenom_contact', '$mail_contact',  '$tel_contact');";

try {
	$connexion->query($sql);  
} catch(PDOException $e){
	$message .= newLineMsg("Problème pour ajouter le contact, vérifiez vos données.")
	.  newLineMsg($e->getMessage())
	.  newLineMsg($sql);
}

/*
* Phase 2
* -------
* Selection du contact fraîchement ajouté
*/


try {
	$tab = $connexion->query('SELECT LAST_INSERT_ID() as last_id');
	$tab1=$tab->fetchALL(PDO::FETCH_ASSOC);
}catch(PDOException $e){
	$message .= newLineMsg("Problème pour recupere le numéro du contact, vérifier vos données.")
	.  newLineMsg($e->getMessage());
}
$id_contact = $tab1[0]['last_id'];

}else{
	$sql = "UPDATE `contact`
	SET `NOM_CONTACT`='$nom_contact', `PRENOM_CONTACT`='$prenom_contact', `MAIL_CONTACT`='$mail_contact', `NUM_TELEPHONE`='$tel_contact'
	WHERE contact.ID_CONTACT = '$id_contact';";

	$message .= newLineMsg("Le contact \"".$nom_contact."\" à bien été modifiée.")
	. newLineMsg('<a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'">'."Cliquez ici pour faire une nouvelle modification.".'</a>');

	try {
		$connexion->query($sql);  
	} catch(PDOException $e){
		$message .= newLineMsg("Problème pour ajouter l'entreprises, vérifier vos données.").newLineMsg($e->getMessage()).newLineMsg($sql);
	}
};



/*
* -------
* Modification de l'entreprise
*/

$sql = "UPDATE `entreprise`
SET `NOM_ENTREPRISE`='$nom', `TYPE_ENTREPRISE`='$type', `ADRESSE_ENTREPRISE`='$adresse_ent',`CPOSTAL_ENTREPRISE`='$cpt',`VILLE_ENTREPRISE`='$ville', `TEL_ENTREPRISE`='$tel_ent', `EMAIL_ENTREPRISE`='$mail_ent', `ID_CONTACT`='$id_contact'
WHERE ID_ENTREPRISE = '$id_entreprise_selected';";

$message .= newLineMsg("Entreprise \"".$nom."\" à bien été modifiée.")
. newLineMsg('<a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'">'."Cliquez ici pour faire une nouvelle modification.".'</a>');

try {
	$connexion->query($sql);  
} catch(PDOException $e){
	$message .= newLineMsg("Problème pour ajouter l'entreprises, vérifier vos données.").newLineMsg($e->getMessage()).newLineMsg($sql);
}
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

	?>
	<link rel="stylesheet" type="text/css" href="../css/stage.css">
</head>
<body><!--	entête (header)
--><?php include("../struct/entete".$mod.".php"); ?><!--	menu horizontal
--><?php include("../struct/menu_horizontal.php"); ?><!--	menu vertical
--><?php include("../struct/menu_vertical".$mod.".php"); ?><!--
contenu de la page
appliquez un ID sur votre section pour y appliquer un style particulier en CSS
--><section id="ajouter" class="document">
<div>
	<form id="choix_classe" action="modif_donnes_entreprise.php" method="get">
		<p>Choissiez l'entreprise à modifier : </p>
		<div>
			<?php echo $choix_ent;?>

		</div>
		<input type="submit" class="submit transition" value="Valider">
	</form>

	<?php include("../struct/message.php") ?>
	
		<div>
			<?php if (isset($ent_test)) {
				echo $ent_test;}
				?>
			</div>
		

</section><!--
Pied de page (footer)
--><?php include("../struct/pieddepage.php"); ?>
</body>
</html>