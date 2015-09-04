<?php
// -------
// Création de la connexion
$tab = explode('/', $_SERVER ['SCRIPT_NAME']);
$max = count($tab);
$nomfic = $tab[$max-1];
//echo $nomfic;

if ($nomfic != "accueil.php" && $nomfic != "index.php"){
	include_once( '../connexion/connexion_by_id.php' ); 
}
//echo $_SERVER ['SCRIPT_NAME'];
//echo $_SERVER ['PHP_SELF'];
$connexion = getConnexion("etudiant", "azertyuiop");

// -------
// Accesseur pour l'adresse IP du client
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
$ipaddress = get_client_ip();

// -------
// ÉTAPE 1 : on vérifie si l'IP se trouve déjà dans la table.
// Pour faire ça, on n'a qu'à compter le nombre d'entrées dont le champ "ip" est l'adresse IP du visiteur.


$sql = "SELECT COUNT(*) AS nbre_entrees FROM connectes WHERE ip='".$ipaddress."';";

try {
	$res = $connexion->query($sql);  
} catch(PDOException $e){
	$message = "Probleme vérifier si l'ip est déjà dans la base".'<br>';
	$message .= $e->getMessage();
}
$donnees = $res->fetch(PDO::FETCH_ASSOC);

if ($donnees['nbre_entrees'] == 0) {
	// L'IP ne se trouve pas dans la table, on va l'ajouter.
    $sql = "INSERT INTO connectes VALUES('".$ipaddress."', ".time().");";
    try {
		$res = $connexion->query($sql);  
	} catch(PDOException $e){
		$message = "Probleme pour ajouter l'ip du visiteur à la base".'<br>';
		$message .= $e->getMessage();
	}
} else {
	// L'IP se trouve déjà dans la table, on met juste à jour le TIMESTAMP.
    $sql = "UPDATE connectes SET TIMESTAMP = ".time()." WHERE ip = '".$ipaddress."';";
    try {
		$res = $connexion->query($sql);  
	} catch(PDOException $e){
		$message = "Probleme pour mettre à jour le timestamp".'<br>';
		$message .= $e->getMessage();
	}
}

// -------
// ÉTAPE 2 : on supprime toutes les entrées dont le TIMESTAMP est plus vieux que 5 minutes.
// On stocke dans une variable le TIMESTAMP qu'il était il y a 5 minutes :
$timestamp_5min = time() - (60 * 5); // 60 * 5 = nombre de secondes écoulées en 5 minutes
$sql = "DELETE FROM connectes WHERE TIMESTAMP < ". $timestamp_5min;
try {
	$res = $connexion->query($sql);  
} catch(PDOException $e){
	$message = "Probleme supprimé les timestamps vieux de 5 minutes".'<br>';
	$message .= $e->getMessage();
}

// -------
// ÉTAPE 3 : on compte le nombre d'IP stockées dans la table. C'est le nombre de visiteurs connectés.
$sql = "SELECT COUNT(*) AS nbre_entrees FROM connectes";
try {
	$res = $connexion->query($sql);  
} catch(PDOException $e){
	$mnbc = "Problème compter les utilisateurs connectés".'<br>';
	$mnbc .= $e->getMessage();
	// mnbc = message nombre connecte
}
$donnees = $res->fetch(PDO::FETCH_ASSOC);


// Ouf ! On n'a plus qu'à afficher le nombre de connectés !
if (isset($mnbc)) {
	echo $mnbc;
} else {
	echo '<p>'."Il y a actuellement ".$donnees['nbre_entrees']." visiteurs connecté(s) !".'</p>';
}
?>