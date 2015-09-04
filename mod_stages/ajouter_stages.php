<?php

	//---------------------------------------------------------------------------------------------------------
	// Attention : pour savoir ce qu'il reste à faire pour l'ajout du stage, rendez-vous au bas de cette page.
	//---------------------------------------------------------------------------------------------------------
	
// <!--
// ================================
// 	Création de la session
// 	Redirection des utilisateurs non identifié
// ================================
// -->

include("../connexion/session.php");
$_SESSION['MOD']="_"."stages";
$mod=$_SESSION['MOD'];

/**
 * Permet l'affichage de la liste des raisons sociales contenu dans la base de données dans le champs 'NOM' (ou raison sociale) du formulaire
 *
 * @param object $connexion Instance de l'objet PDO permettant la connexion et le dialogue avec la base 
 * 
 * @return string $liste contient les éléments HTML (<datalist>) permettant d'afficher la liste des raisons sociales d'entreprises sur le champ 'raison sociale'
 */
function listNom($connexion){
	$sql ="SELECT `NOM_ENTREPRISE` FROM `entreprise`;";
	try {
		$res = $connexion->query($sql); 
		$table = $res->fetchAll(PDO::FETCH_ASSOC);		
	} catch(PDOException $e){
		$message = newLineMsg($e->getMessage());
	}
	$liste = '<datalist id="raisons_sociales"';
	foreach ($table as $row) {
		$liste .= '<option value="'.$row['NOM_ENTREPRISE'].'">';
	}
	$liste .= '</datalist>';

	echo $liste;
}

//fonction pour afficher les noms des entreprises dans l'ordre alphabétique

function listNomEnt($connexion){
	$sql="SELECT `ID_ENTREPRISE`,`NOM_ENTREPRISE` FROM `entreprise` ORDER BY NOM_ENTREPRISE;";
	try {
		$res = $connexion->query($sql); 
		$table = $res->fetchAll(PDO::FETCH_ASSOC);		
	} catch(PDOException $e){
		$message = newLineMsg($e->getMessage());
	}
	$nomEnt = '<select name="NOM_ENTREPRISE" list="entreprise" id="nomEnt" class="defaut" tabindex="2" required>';
	foreach ($table as $row) {
		$nomEnt .= '<option value="'.$row['ID_ENTREPRISE'].'">'.$row['NOM_ENTREPRISE'];
	}
	$nomEnt .= '</select>';

	echo $nomEnt;
}

//fonction pour afficher les noms et prénoms des tuteurs
//Dans la liste les noms sont mis en majuscules suivis des prénoms en minuscules

function listNomTuteur($connexion, $id_tuteur){
	$sql="SELECT `ID_TUTEUR`,`NOM_TUTEUR`,`PRENOM_TUTEUR`  FROM `tuteur` order by NOM_TUTEUR";
	try {
		$res = $connexion->query($sql); 
		$table = $res->fetchAll(PDO::FETCH_ASSOC);		
	} catch(PDOException $e){
		$message = newLineMsg($e->getMessage());
	}
	$nomTuteur = '<select name="ID_TUTEUR" list="tuteur" id="nomTuteur" class="defaut" tabindex="2">';
	foreach ($table as $row) {
		$nomTuteur =$nomTuteur.'<option value="'.$row['ID_TUTEUR'].'">'.strtoupper($row['NOM_TUTEUR'])." ".$row['PRENOM_TUTEUR']."</option> \n";
	}
	$nomTuteur .= '</select>';

	echo $nomTuteur;
}
// <!--
// ================================
// 	Inclusion des fichiers permettant l'affichage des listes déroulantes
// ================================
// -->


// Inclusion de tous les fichiers comportant une ou des fonctions de listes déroulantes
// On met tout les suffixes des fichiers dans un tableau
$tables=array("prof","date","etudiant");
// On compte le nombre de suffixes présents dans le tableau, et on inclue les fichiers comportant le suffixe demandé.
for($i=0;$i<count($tables);$i++)
{
	include_once("../fonctions/liste_deroulante_".$tables[$i].".php");
}
include_once("../fonctions/radio_bouton_classe.php");

// <!--
// ================================
// 	Initialisation des variables
// ================================
// -->

//-----------------------
// Du stage
$id_tuteur = $id_etudiant = $id_entreprise = $id_prof_superviseur = $id_prof_visiteur = $id_periode = "";
$code_classe="SIO1";
//-----------------------
// De l'entreprise
$nom_entreprise = "";
//-----------------------
// Du tuteur
$nom_tuteur = $prenom_tuteur = $tel_tuteur = $mail_tuteur = $statut_tuteur = $service_tuteur = "";
//-----------------------
// Du contenu
$contenu = $contenu_stage = "";
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
	echo '<title>'."Ajout d'un stage".$title.'</title>';
	// nom de votre page
	?>
	<link rel="stylesheet" type="text/css" href="../css/stage.css">
</head>
<?php

// Récupération des données du formulaire
$confirmation="";
$message="";

// Fonction permettant le traitement des champs du formulaire afin de retirer des erreurs.
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
// Dans le cas où le formulaire est saisi
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$creation=false;


		$id_etudiant = test_input($_POST['ID_ETUDIANT']);

		$id_periode=$_POST['ID_DPERIODE'];

		$id_prof_superviseur=$_POST['ID_PROF_VISITEUR'];
	
		$id_prof_visiteur=$_POST['ID_PROF_VISITEUR'];

		$code_classe=$_POST['CODE_CLASSE'];

		$id_entreprise=$_POST['NOM_ENTREPRISE'];


	//-----------------------------------------------------------------
	// Validation des champs du formulaire tuteur
	//-----------------------------------------------------------------
	// On récupère chaques champs du formulaire, et pour ceux 
	// qui sont obligatoires, vérifie qu'il n'y ait pas d'erreur.
	//-----------------------------------------------------------------
	if(!empty($_POST['NOM_TUTEUR'])){
		$nom_tuteur = test_input($_POST['NOM_TUTEUR']);
		$creation = true;
	}

	if(!empty($_POST['PRENOM_TUTEUR'])){
		$prenom_tuteur = test_input($_POST['PRENOM_TUTEUR']);
	}

	if(!empty($_POST['TEL_TUTEUR'])){
		$tel_tuteur = test_input($_POST['TEL_TUTEUR']);
	}

	if(!empty($_POST['MAIL_TUTEUR'])){
		$mail_tuteur = test_input($_POST['MAIL_TUTEUR']);
	}
	if(!empty($_POST['STATUT_TUTEUR'])){
		$statut_tuteur = test_input($_POST['STATUT_TUTEUR']);
	}

	if(!empty($_POST['SERVICE_TUTEUR'])){
		$service_tuteur = test_input($_POST['SERVICE_TUTEUR']);
	}
	
	if($creation){
		
		//-----------------------------------------------------------------
		// Ajout du tuteur dans la table TUTEUR
		//-----------------------------------------------------------------
		//Choix pour selectionner un tuteur dans la liste déroulante soit le créer via les zones de textes.
		//-----------------------------------------------------------------

	

		try{
		$requete="insert into tuteur(NOM_TUTEUR,PRENOM_TUTEUR,SERVICE_TUTEUR,STATUT_TUTEUR,TEL_TUTEUR,MAIL_TUTEUR, ID_ENTREPRISE)
		values('$nom_tuteur','$prenom_tuteur','$service_tuteur','$statut_tuteur','$tel_tuteur','$mail_tuteur', '$id_entreprise');";
		$connexion->exec($requete);

		
		}

		catch(PDOException $e)
		{
			$message.="\nLe tuteur n'a pas pu être ajouté dans la base de données";
			$message.=$e->getMessage();
		}

		//Pour prendre la dernière valeur ajouté
				try {
			$tab = $connexion->query('SELECT LAST_INSERT_ID() as last_id');
			$tab1=$tab->fetchALL(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			$message .= newLineMsg("Problème pour recupere le numéro du contact, vérifier vos données.")
			.  newLineMsg($e->getMessage());
		}
		$id_tuteur = $tab1[0]['last_id'];
			
	}else{
		$id_tuteur= $_POST['ID_TUTEUR'];
		var_dump($id_tuteur);
	}

		

	
	//-----------------------------------------------------------------
	// Validation des champs du formulaire de l'entreprise
	//-----------------------------------------------------------------
	// On récupère chaques champs du formulaire, et pour ceux 
	// qui sont obligatoires, vérifier qu'il n'y ait pas d'erreur.
	//-----------------------------------------------------------------
		$erreur = false;
		$nom_entreprise = test_input($_POST['NOM_ENTREPRISE']);
	
	//-----------------------------------------------------------------
	// Validation des champs du contenu
	//-----------------------------------------------------------------
	// On récupère chaques champs du formulaire, et pour ceux 
	// qui sont obligatoires, vérifier qu'il n'y ait pas d'erreur.
	//-----------------------------------------------------------------

		$contenu = test_input($_POST['CONTENU']);

	//-----------------------------------------------------------------
	// Si tous les champs obligatoires du formulaire sont remplis
	//-----------------------------------------------------------------
	if(!$erreur){
	
	//-----------------------------------------------------------------
	// Validation des champs du formulaire du stage
	// et insertion dans la base de données
	//-----------------------------------------------------------------
	// On récupère chaques champs du formulaire, et pour ceux 
	// qui sont obligatoires, vérifier qu'il n'y ait pas d'erreur.
	//-----------------------------------------------------------------
		
	
		//-----------------------------------------------------------------
		// Ajout du stage dans la table STAGE
		//-----------------------------------------------------------------		
		try{
			$requete="insert into stage(ID_PROF,ID_ETU,ID_ENTREPRISE,ID_PERIODE,ID_PROF_VISITER,CLASSE_STAGE, CONTENU, ID_TUTEUR)
			values($id_prof_superviseur,$id_etudiant,$id_entreprise,$id_periode,$id_prof_visiteur,'$code_classe', '$contenu', '$id_tuteur');";
			$connexion->exec($requete);
			echo $requete;
		}
		catch(PDOException $e)
		{
			$message.="\nLe stage n'a pas pu être ajouté dans la base de données ";
			$message.="";
			$message.=$message.$e->getMessage();
			echo $requete;
		}
	}
	
	//-----------------------------------------------------------------
	// Message d'information sur l'état de validation du formulaire
	//-----------------------------------------------------------------
	if($message=="" && $erreur==false){
		$confirmation="Stage ajouté";
	}
	else{
		echo $message;
		$confirmation="Le formulaire n'est pas complet. Vérifier que les champs (*) soient bien remplis";
	}
}
?>
<body><!-- entête (header) 
--><?php include("../struct/entete".$mod.".php"); ?><!-- menu horizontal 
--><?php include("../struct/menu_horizontal.php"); ?><!-- menu vertical 
--><?php include("../struct/menu_vertical".$mod.".php"); ?><!--
	contenu de la page
	appliquez un ID sur votre section pour y appliquer un style particulier en CSS
--><section id="ajouter" class="document">
																		<!-- Endroit où il faut modifier -->

		<!-- 
			Formulaire d'ajout de stage aux étudiants 
		-->
		<?php include("../mod_stages/formulaire_ajout_stage.php"); ?>
		<!--
			Message donnant l'état de validation du formulaire.
			Stage ajouté ou Message disant qu'il y a une erreur au moins
		-->
		<?php 
			$message=newLineMsg($confirmation); 
			include("../struct/message.php");
		?>
	</div>
</section>
<script src="../js/jquery.js"></script>
<!-- 
	Modification de la liste déroulante d'étudiant en fonction de la classe choisie (sio1 ou sio2) 
-->
<script src="../js/modifier_liste_etudiant_stage.js" type="text/javascript"></script>
<!--<script src="../js/valider_recherche_entreprise_stage.js" type="text/javascript"></script>-->
<!--
	Pied de page (footer)
--><?php include("../struct/pieddepage.php"); ?>
</body>
</html>