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
//-----------------------------------------------------------------
// Ajout des listes déroulantes nécessaires au formulaire
//-----------------------------------------------------------------

include_once("../fonctions/liste_deroulante_classe.php");
include_once("../fonctions/liste_deroulante_promotion.php");
include_once("../fonctions/liste_deroulante_origine.php");
include_once("../fonctions/liste_deroulante_regime.php");
include_once("../fonctions/liste_deroulante_specialite.php");

$code_classe=0;
$code_promotion=0;
$code_origine=0;
$code_regime='';
$code_spe=0;
$message="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$erreur=false;
	//-----------------------------------------------------------------
	// Validation des champs du formulaire étudiant
	//-----------------------------------------------------------------
	// On récupère chaques champs du formulaire, et pour ceux 
	// qui sont obligatoires vérifie qu'il n'y ait pas d'erreur.
	//-----------------------------------------------------------------
	if(!empty($_POST['NOM_ETU'])){
		$nom = test_input($_POST['NOM_ETU']);
	}
	else{
		$erreur=true;
	}
	if(!empty($_POST['PRENOM_ETU'])){
		$prenom = test_input($_POST['PRENOM_ETU']);
	}
	else{
		$erreur=true;
	}
	if(!empty($_POST['DNAISSANCE_ETU'])){
		$dnaissance = test_input($_POST['DNAISSANCE_ETU']);
                // TODO : vérifier que c'est une vraie date
                
                // TODO si ok convertir la date pour le SQL : YYYY-MM-DD
                
	}
	else{
		$erreur=true;
	}
	//-----------------------------------------------------------------
	// On récupère les données non obligatoires du formulaire
	//-----------------------------------------------------------------
	$nom = $_POST["NOM_ETU"];
	$prenom = $_POST["PRENOM_ETU"];
	$dnaissance = $_POST["DNAISSANCE_ETU"];
	$origine=$_POST["BAC_ORIGINE"];
	$promotion=$_POST["ID_PROMOTION"];
	$specialite=$_POST["CODE_SPECIALITE"];
	$classe=$_POST["CODE_CLASSE"];
	$regime=$_POST["REGIME"];
        $login=$_POST["LOGIN"];
        $password=$_POST["PASSWORD"];

	if(!$erreur){
		//-----------------------------------------------------------------
		//Formulaire soumis -> recuperation des données
		//-----------------------------------------------------------------
		$requete2="SELECT MAX(ID_ETU) as idetu_max FROM etudiant;";
		$resultat=$connexion->query($requete2);
		$tab=$resultat->fetchAll(PDO::FETCH_ASSOC);
		$idetu=$tab[0]['idetu_max'];
		$idetu=$idetu+1;

		//-----------------------------------------------------------------
		// Ajout de l'étudiant dans la table ETUDIANT_TEMP
		//-----------------------------------------------------------------
		try 
		{
			$requete="INSERT INTO etudiant (ID_ORIGINE, ID_PROMOTION, CODE_SPECIALITE, CODE_CLASSE, NOM_ETU,
                            PRENOM_ETU, DNAISSANCE_ETU, DOUBLANT1_ETU, DOUBLANT2_ETU, DIPLOME_ETU, REGIME, LOGIN, PASSWORD) VALUES 
			($origine, $promotion,'$specialite', '$classe', '$nom', '$prenom', '$dnaissance', 0, 0, 0, '$regime', '$login', '$password')";
			$connexion->exec($requete);
		}
		catch (PDOException $e) 
		{
			$message="<li>Problème pour insérer les informations de l'étudiant.</li>".'<li>'.$e->getMessage().'</li>'.'<li>'.$requete.'</li>';
		}
	}

	//-----------------------------------------------------------------
	// Message d'information sur l'état de validation du formulaire
	//-----------------------------------------------------------------
	if($message=="" && $erreur==false){
	$message="<li>Etudiant ajouté</li>";
	}
	else{
		echo $message;
		$message="<li>Le formulaire n'est pas complet. Vérifier que les champs soient bien remplis, ils sont tous obligatoires !</li>";
	}
}
else {
	//-------------------------------
	// INITIALISATION DES DONNEES
	//-------------------------------

	$idetu="";
	$origine="";
	$promotion="";
	$specialite="";
	$classe="";
	$nom="";
	$prenom="";
	$dnaissance="";
	$regime="";
        $login="";
        $email="";
        $password="";
}
//------------------------------------------------------------------------------------------
// Fonction permettant le traitement des champs du formulaire afin de retirer des erreurs.
//------------------------------------------------------------------------------------------
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>
<!DOCTYPE html>
<html>
	<head>
		<!--
		========================================================================
			paramètres du <head>
			commun aux pages (inclusion de fichiers CSS, JS; balise meta; ...) 
		========================================================================
		-->
		<?php include("../struct/param_head.php");
		//-------------------
		// Nom de votre page
		//-------------------
		echo '<title>'."Module étudiants".$title.'</title>';?>
		<link rel="stylesheet" type="text/css" href="../css/etudiants.css">
                <link href="../js/jquery-ui-1.11.4.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
                <script src="../js/jquery-ui-1.11.4.custom/jquery-ui.min.js" type="text/javascript"></script>
                <script src="../js/jquery-ui-1.11.4.custom/datepicker-fr.js" type="text/javascript"></script>
	</head>
	<body>	
		<?php
			//-------------------------------
			// Header
			//-------------------------------
			include("../struct/entete".$mod.".php");
			//-------------------------------
			// Menu horizontal
			//-------------------------------
			include("../struct/menu_horizontal.php");
			//-------------------------------
			// Menu vertical
			//-------------------------------
			include("../struct/menu_vertical".$mod.".php"); 
		?>
		<section id="ajouter" class="document">
		<!--
		========================================================================
		 Formulaire d'ajout d'étudiant
		========================================================================
		-->
			<form action="ajout_etudiants.php" method="post">
				<div class="header">
					<h2>Ajout d'un étudiant</h2>
				</div>
				<div>
					<label for="nom_etu">Nom</label>
					<input id="nom_etu" type="text" name="NOM_ETU" value="<?php echo $nom ;?>"/>
				</div>
				<div>
					<label for="prenom_etu">Prénom</label>
					<input id="prenom_etu" type="text" name="PRENOM_ETU" value="<?php echo $prenom ;?>"/>
				</div>
                            	<div>
					<label for="login">Login</label>
					<input id="login" type="text" name="LOGIN" value="<?php echo $login ;?>"/>
				</div>
                            	<div>
					<label for="password">Mot de passe</label>
                                        <input id="password" type="password" name="PASSWORD" value=""/>
				</div>
				<div>
					<label for="dnaissance_etu">Date de naissance</label>
                                        <input id="dnaissance_etu" type="date" name="DNAISSANCE_ETU" autocomplete="off" value="<?php echo $dnaissance ;?>"/>
				</div>
				<div>
					<label>Classe</label><?php echo lister_classe($connexion,"SIO1"); ?><br/>
				</div>
				<div>
					<label>Promotion</label><?php echo lister_promotion($connexion,$code_promotion); ?><br/>
				</div>
				<div>
					<label>Origine</label><?php echo lister_origine($connexion,$code_origine); ?><br/>
				</div>
				<div>
					<label>Régime</label><?php echo lister_regime($connexion,$code_regime); ?><br/>
				</div>
				<div>
					<label>Spécialité envisagée</label><?php echo lister_specialite($connexion,$code_spe); ?><br/>
				</div>
				<input id="valider" class="submit" type="submit" value="Valider">
			</form>
		</section>
		<?php
			//-------------------------------
			// Message d'information
			//-------------------------------
			include("../struct/message.php");
			//-------------------------------
			// Footer
			//-------------------------------
			include("../struct/pieddepage.php");
		?>
            <script type="text/javascript">
                if (navigator.userAgent.match(/Firefox/i)) {
                    $.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );
                    $( "#dnaissance_etu" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeYear: true,
                        changeMonth: true,
                        yearRange: "1950:2012",
                        defaultDate: "1996-08-08"
                    });
                }
            </script>
	</body>
</html>
