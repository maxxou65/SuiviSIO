<?php

/**
 * Description
 * @param type $data 
 * @return type
 */
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// ================================
// 	Init
// ================================

	$id = $mdp = "";
	$idErr = $mdpErr = "";

	$formValid = TRUE;


/*
 * Si formulaire soumis
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Test des entrées (inputs)
	// -----------

	if (empty($_POST['ID_CONNEXION'])) {
		$idErr = "Identifiant est obligatoire ... et oui ...";
		$formValid = FALSE;
	} else {
		$id = test_input($_POST['ID_CONNEXION']);
	}

	if (empty($_POST['MDP_CONNEXION'])) {
		$mdpErr = "Mot de passe est obligatoire ... Sérieusement ...";
	} else {
		$mdp = test_input($_POST['MDP_CONNEXION']);
	}

	if ($formValid) {

		include_once("./connexion/connexion.php");
		$connexion = getConnexion();

		$req = "SELECT `ID_CONNEXION`, `MDP_CONNEXION` FROM `connexion`;";
		$res = $connexion->query($req);
		$table_connexion = $res->fetchAll(PDO::FETCH_ASSOC);

		foreach ($table_connexion as $table) {
			if ($table == $_POST) {
				session_start();
				$_SESSION['CONNEXION']['ID'] = $id;
				$_SESSION['CONNEXION']['MDP'] = $mdp;
				header('Location: ./accueil.php');
				exit;
			} else {
				$message = "Identifiant ou mot de passe incorrect.";
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php

	/** Inclusion des différents paramètres présent dans l'élément head commum aux pages */
	include("struct/param_headAccueil.php");

	?>
	<link rel="stylesheet" type="text/css" href="css/connexion.css">
	<title>Suivi des SIO</title>
</head>
<body><!--
--><?php

/** Inclusion de l'élément header (en-tête) */
//Pour permettre de faire un retour en arrière
include("struct/enteteAccueil.php");

?><!--
--><section id="conn_app" class="document">
	<h4>Bienvenue sur l'application de Suivi des SIO</h4>
	<span>Identifiez-vous pour y accéder</span>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"><!--
	 --><div>
		 	<label for="ID_CONNEXION">Identifiant</label>
		 	<input id="ID_CONNEXION" class="transition" type="text" name="ID_CONNEXION" value="<?php echo $id; ?>" tabindex="1">
		 	<span class="hint"><?php echo $idErr; ?></span>
		</div><!--
	 --><div>
		 	<label for="MDP_CONNEXION">Mot de passe</label>
		  	<input id="MDP_CONNEXION" type="password" name="MDP_CONNEXION" tabindex="2">
		  	<span class="hint"><?php echo $mdpErr; ?></span>
		</div>
	<input class="submit transition" type="submit" value="Connexion" tabindex="3">
	</form>
        
        <div>
            <input class="submit transition" type="submit" value="Inscription">
        </div>
	
	<?php
		if (isset($message)) {
			echo '<span class="message">';
			echo $message;
			echo '</span>';
		}
	?>
</section><!-- 
--><?php
/** Inclusion de l'éléménet footer (pied de page) */
include("struct/pieddepageAccueil.php");

?>
</body>
</html>
