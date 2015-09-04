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
if (isset($_POST['tab'])) {
    print_r($_POST);
    $tab_ETU=$_POST['tab'];
    $requete="";
    foreach ($tab_ETU as $ligne) {
        $id_etu=$ligne['ID_ETU'];
        $nom_etu=$ligne['NOM_ETU'];
        $prenom_etu=$ligne['PRENOM_ETU'];
        $dnaissance_etu=$ligne['DNAISSANCE_ETU'];
        $bac_origine=$ligne['ID_ORIGINE'];
        $message.=' '.$bac_origine;
        //$convertreq=$connexion->query("SELECT ID_ORIGINE FROM ORIGINE WHERE BAC_ORIGINE='$bac_origine'");
        //$convert=$convertreq->fetch();
        /*foreach($convert as $conversion){
            $id_origine=$conversion;    
        }*/
        $code_classe=$ligne['CODE_CLASSE'];
        $code_specialite=$ligne['CODE_SPECIALITE'];
        $regime=$ligne['REGIME'];
        $id_promotion=$ligne['ID_PROMOTION'];
        @$doublant1_etu=$ligne['DOUBLANT1_ETU'];
        if($doublant1_etu==1){
            $doublant1_etu=1;
        }
        else{
            $doublant1_etu=0;
        }
        @$doublant2_etu=$ligne['DOUBLANT2_ETU'];
        if($doublant2_etu==1){
            $doublant2_etu=1;
        }
        else{
            $doublant2_etu=0;
        }
        $requete.="UPDATE ETUDIANT SET 
        NOM_ETU='$nom_etu', 
        PRENOM_ETU='$prenom_etu', 
        DNAISSANCE_ETU='$dnaissance_etu', 
        ID_ORIGINE='$bac_origine', 
        CODE_CLASSE='$code_classe', 
        CODE_SPECIALITE='$code_specialite', 
        REGIME='$regime',
        ID_PROMOTION=$id_promotion, 
        DOUBLANT1_ETU=$doublant1_etu, 
        DOUBLANT2_ETU=$doublant2_etu
        WHERE ID_ETU=$id_etu;";
        $message="Modifications effectuées avec succès \n".$bac_origine;
    }
    if($requete!=""){
        try{
            $connexion->exec($requete);
        }
        catch(PDOException $e){
            $message="Probleme pour modifier la table etudiant";
            $message=$message.$e->getMessage();
        }
    }
}


// Requete pour selectionner les etudiants
function afficher_etu_sio($classe, $connexion) { // $classe = 'SIO1' || $classe = 'SIO2'
	$sql = "SELECT ID_ETU, NOM_ETU, PRENOM_ETU, DNAISSANCE_ETU, ETUDIANT.ID_ORIGINE, CLASSE.CODE_CLASSE, CODE_SPECIALITE, REGIME, ETUDIANT.ID_PROMOTION, DOUBLANT1_ETU, DOUBLANT2_ETU 
    FROM ETUDIANT 
    INNER JOIN ORIGINE on ETUDIANT.ID_ORIGINE=ORIGINE.ID_ORIGINE 
    INNER JOIN PROMOTION on ETUDIANT.ID_PROMOTION=PROMOTION.ID_PROMOTION 
    INNER JOIN CLASSE on ETUDIANT.CODE_CLASSE=CLASSE.CODE_CLASSE 
    WHERE CLASSE.CODE_CLASSE='$classe' 
    ORDER BY NOM_ETU ASC;";
	$res_sio = $connexion->query($sql);  
	$table_etu_sio = $res_sio->fetchAll(PDO::FETCH_ASSOC);
	$table_etu = '<div>'.'<span class="classe">'.$classe.'</span>'
				 . '<table class="def">'
				 . '<thead>'.'<tr>'
				 . '<th colspan="9">Etudiants</th>'.'<th colspan="2">Redoublement</th>'
				 . '</tr>'.'<tr>'
				 . '<th>ID</th>'
                    .'<th>Nom</th>'
                    .'<th>Prenom</th>'
                    .'<th>Date de naissance</th>'
                    .'<th>Bac</th> '
                    .'<th>Classe</th>'
                    .'<th>Spécialité</th>'
                    .'<th>Regime</th>'
                    .'<th>Promotion</th>'
                    .'<th>1e année</th>'
                    .'<th>2e année</th>'
				 . '</tr>'.'</thead>'
				 . '<tbody>';
    $i=0;
	foreach ($table_etu_sio as $table_row) {

		$id_etu =  $table_row['ID_ETU'];
		$nom_etu =  $table_row['NOM_ETU'];
		$prenom_etu =  $table_row['PRENOM_ETU'];
		$dnaissance_etu =  $table_row['DNAISSANCE_ETU'];
		$id_origine =  $table_row['ID_ORIGINE'];
        //echo "<script>alert(".$id_origine.")</script>";
		$code_classe =  $table_row['CODE_CLASSE'];
		$code_specialite =  $table_row['CODE_SPECIALITE'];
		$regime =  $table_row['REGIME'];
		$id_promotion =  $table_row['ID_PROMOTION'];
		$doublant1_etu =  $table_row['DOUBLANT1_ETU'];
        if($doublant1_etu==1){
            $doublant1='<input type="checkbox" name="tab['.$i.'][DOUBLANT1_ETU]" value="1" checked>';
        }
        else{
            $doublant1='<input type="checkbox" name="tab['.$i.'][DOUBLANT1_ETU]" value="0">';
        }
        $doublant2_etu =  $table_row['DOUBLANT2_ETU'];
        if($doublant2_etu==1){
            $doublant2='<input type="checkbox" name="tab['.$i.'][DOUBLANT2_ETU]" value="1" checked>';
        }
        else{
             $doublant2='<input type="checkbox" name="tab['.$i.'][DOUBLANT2_ETU]" value="0">';
        }
		$table_etu.= '<tr>'
            . '<td><input type="text" readonly size="2" name="tab['.$i.'][ID_ETU]" value=\''.$id_etu.'\'/></td>'
            . '<td><input type="text" name="tab['.$i.'][NOM_ETU]" value=\''.$nom_etu.'\'/></td>'
            . '<td><input type="text" name="tab['.$i.'][PRENOM_ETU]" value=\''.$prenom_etu.'\'/></td>'
            . '<td><input type="date" name="tab['.$i.'][DNAISSANCE_ETU]" value=\''.$dnaissance_etu.'\'/></td>'
            . '<td>'.lister_origine($connexion,$id_origine,$i).'</td>'
            . '<td>'.lister_classe($connexion,$code_classe,$i).'</td>'
            . '<td>'.lister_specialite($connexion,$code_specialite,$i).'</td>'
            . '<td>'.lister_regime($connexion,$regime,$i).'</td>'
            . '<td><input type="text" name="tab['.$i.'][ID_PROMOTION]" value=\''.$id_promotion.'\'/></td>'
            . '<td>'.$doublant1.'</td>'
            . '<td>'.$doublant2.'</td>'
			. '</tr>';
    $i++;
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
    <script src="../js/modifier_etu.js"></script>
</head>
<body><!--
	entête (header)
--><?php include("../struct/entete".$mod.".php"); ?><!--
	menu horizontal
--><?php include("../struct/menu_horizontal.php"); ?><!--
	menu vertical
--><?php include("../struct/menu_vertical".$mod.".php"); ?><!--
--><?php include("../fonctions/listes_deroulantes.php"); ?><!--
	contenu de la page
	appliquez un ID sur votre section pour y appliquer un style particulier en CSS -->
<section id="consult" class="document">
    <h1>Cliquez sur une classe pour modifier les élèves</h1>
    <form id='form' action='' method='post'>
        <?php
            echo (afficher_etu_sio('SIO1', $connexion));
            echo (afficher_etu_sio('SIO2', $connexion));
        ?>
        <input type='submit' class='submit' name='appliquer' value='Appliquer' onclick='return confirm("Etes vous sûr ?")'/>
    </form>
    <?php if(isset($message)){echo $message;} ?>
</section><!--	Pied de page (footer)
--><?php include("../struct/pieddepage.php"); ?>
    <script src="../js/toggle_etudiants.js"></script>
</body>
</html>