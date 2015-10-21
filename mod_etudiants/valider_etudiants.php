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
//================================
//                  DEUXIEME PASSAGE
//                  Requete pour effectuer les traitements
//================================

if(isset($_POST['valid'])){
	$valid=$_POST['valid'];
	foreach($valid as $ID_ETU){
		$get = "SELECT `ID_ORIGINE`, `ID_PROMOTION`, `CODE_SPECIALITE`, `CODE_CLASSE`, `NOM_ETU`, `PRENOM_ETU`, `DNAISSANCE_ETU`, `DOUBLANT1_ETU`, `DOUBLANT2_ETU`, `DIPLOME_ETU`, `REGIME` FROM ETUDIANT WHERE ID_ETU=$ID_ETU";
        try {
            $infos = $connexion->query($get);  
        }
        catch(PDOException $e){
            $message = "Problème pour d'accès".'<br>'.$e->getMessage();
        }
// On cree la requete d'ajout de l'etudiant dans la table devinitive
        $insert = "INSERT INTO `suivisio`.`ETUDIANT` (`ID_ORIGINE`, `ID_PROMOTION`, `CODE_SPECIALITE`, `CODE_CLASSE`, `NOM_ETU`, `PRENOM_ETU`, `DNAISSANCE_ETU`, `DOUBLANT1_ETU`, `DOUBLANT2_ETU`, `DIPLOME_ETU`, `REGIME`) VALUES ( ";
        $tab_infos = $infos->fetch(PDO::FETCH_ASSOC);
        // foreach info qui constitue la table etudiant, et on finit la requete
        $i=0;
        foreach ($tab_infos as $tab) {
            $insert .= "'".$tab."',";
        }
        $long=strlen($insert)-1;
        $insert=substr($insert, 0, $long);
        $insert .= ");";
        //on execute la requete d'insertion
        try {
            $connexion->exec($insert);
        }
        catch(PDOException $e){
            $message = "Problème pour ajouter l'étudiant".'<br>'.$e->getMessage();
        }
        //on execute la requete de suppression de la table temporaire
        if(!isset($message)){
            try {
                $connexion->exec("DELETE FROM ETUDIANT WHERE ID_ETU=$ID_ETU");
            }
            catch(PDOException $e){
                $message = "Problème pour supprimer l'étudiant de la table temporaire".'<br>'.$e->getMessage();
            }
        }
	}
}
//================================
//                  PREMIER PASSAGE
//                  Requete pour selectionner les etudiants
//================================

$select_stage = "SELECT ID_ETU, NOM_ETU, PRENOM_ETU, DNAISSANCE_ETU, BAC_ORIGINE, CLASSE.CODE_CLASSE, CODE_SPECIALITE, REGIME, ANNEE, DOUBLANT1_ETU, DOUBLANT2_ETU FROM ETUDIANT INNER JOIN ORIGINE on ETUDIANT.ID_ORIGINE=ORIGINE.ID_ORIGINE inner join PROMOTION on ETUDIANT.ID_PROMOTION=PROMOTION.ID_PROMOTION inner join CLASSE on ETUDIANT.CODE_CLASSE=CLASSE.CODE_CLASSE;";
try {  
	$res = $connexion->query($select_stage);  
}
catch(PDOException $e){
	$message = "Problème pour d'accès".'<br>'.$e->getMessage();
}
    
// table pour <table>
// remplissage du resultat de la requete dans $table_etudiant
$table_etudiant = $res->fetchAll(PDO::FETCH_ASSOC);
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
--><section id="" class="document">
    <form name='valider' action="" method='post'>
        <table class="def">
            <thead>
                <tr>
                    <th colspan="10">Etudiants</th>
                    <th colspan="2">Redoublement</th>
                    <th colspan="1">Supprimer</th>
                </tr>
                <tr>
                    <th>Valider</th>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Date de naissance</th>
                    <th>Bac</th> 
                    <th>Classe</th>
                    <th>Spécialité</th>
                    <th>Regime</th> 
                    <th>Promotion</th>
                    <th>1ere année</th> 
                    <th>2eme année</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // table_row pour <tr> et table_data pour <td> 
                    foreach ($table_etudiant as $table_row) {
                        $ID_ETU=$table_row['ID_ETU'];
                        echo '<tr>';
                        echo "<td><input type='checkbox' name ='valid[$ID_ETU]' value='$ID_ETU' checked /></td>";
                        foreach ($table_row as $table_data) {
                            echo '<td>'.$table_data.'</td>';
                        }
                        echo "<td><img class='poubelle' src='../img/delete.png'></td>";
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
        <input class="submit" type='submit' value='Valider' onclick="return confirm('Etes vous sûr ?')"/>
    </form>
    <span><?php if (isset($message)) {echo $message;} ?></span>
</section><!--	Pied de page (footer)-->
<?php include("../struct/pieddepage.php"); ?>
</body>
</html>