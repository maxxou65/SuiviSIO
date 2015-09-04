<?php
	function ajouter_stage_bdd($connexion,$id_tuteur,$id_prof,$id_etu,$id_entr,$id_periode,$id_prof_visiter,$code_classe)
	{
		//faire la requete pour inserer avec le try et le catch
		try{
			$requete="insert into STAGE(ID_TUTEUR,ID_PROF,ID_ETU,ID_ENTREPRISE,ID_PERIODE,ID_PROF_VISITER,CLASSE_STAGE) 
					  values($id_tuteur,$id_prof,$id_etu,$id_entr,$id_periode,$id_prof_visiter,'$code_classe');";
			$matricule=$connexion->exec($requete);	
		}
		catch(PDOExeption $e)
		{
			$message="probleme pour insérer les informations de l'employe";
			$message=$message.$e->getMessage();
		}
	}
?>