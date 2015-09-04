	<form action="ajouter_stages.php" method="post"><!--
	--><?php 
		//-------------------------
		// AVIS AUX DEVELOPPEURS !
		//-------------------------
		// Pour faciliter le fait de devoir débogguer le formulaire, on peut choisir entre afficher un formulaire vide ou un formulaire déjà complété,
		// après avoir soumis le formulaire. Si l'auto-maintien est à vrai, les données seront réaffichés, sinon un nouveau formulaire vierge apparaîtra.
		$auto_maintien = false;
		// Et pensez à le remettre à false quand vous avez terminé de modifier.
		//-------------------------
		?><!--
		----------------------------------------
			Champ de formulaire pour les 
			informations concernant la date du 
			stage, l'étudiant concerné, le ou 
			les professeurs qui s'occupent de 
			l'élève		
		----------------------------------------
	 --><div class="header">
			<h2>Ajout d'un stage</h2>
		</div><!--
			Classe choisie pour aller chercher ensuite un étudiant
	 --><div class="radio">
			<label for="CODE_CLASSE">Classe</label>
			<?php echo donner_radio_bouton_classe($connexion,$code_classe); ?>
			<span class="hint"></span>
		</div><!--
			Etudiant à qui l'on souhaite ajouter un stage
	 --><div>
			<label for="ID_ETUDIANT">Etudiant</label>
			<?php echo lister_etudiant_sans_stage($connexion,$id_etudiant,$code_classe); ?>
			<span class="hint"></span>
		</div><!--	
			Date du stage
	 --><div>
			<label for="CODE_STAGE">Date de stage</label>
			<?php echo lister_date($connexion,$id_periode); ?>
			<span class="hint"></span>
		</div><!--
			Professeur qui s'occupe du stage de l'élève
	 --><div>
			<label for="ID_PROF_SUPERVISER">Superviseur</label>
			<?php echo lister_superviseur($connexion,$id_prof_superviseur); ?>
			<span class="hint"></span>
		</div><!--
			Professeur qui va visiter l'étudiant pendant le stage
	 --><div>
			<label for="ID_PROF">Visiteur</label>
			<?php echo lister_visiteur($connexion,$id_prof_visiteur); ?>
			<span class="hint"></span>
		</div><!--
		----------------------------------------
			Champ de formulaire à rentrer pour
			savoir les informations concernant
			l'entreprise où est réalisé le stage
		----------------------------------------
	 --><div class="header">
			<h2>Entreprise</h2>
		</div><!--
			Nom de l'entreprise
	 --><div>
			<label for="ID_ENTREPRISE">Raison sociale *</label>
			<?php echo listNomEnt($connexion); ?>
			<span class="hint"></span>
		</div><!--
<!-- Pour une zone de texte-->
			<!--<input name="NOM_ENTREPRISE" list="raisons_sociales" value="<?php if($auto_maintien) echo $nom_entreprise?>" type="text" id="nom" class="defaut" tabindex="1">-->


<!-- Transformation du formulaire d'ajout de stage, onglet entreprise.
	------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	 	</div><!--
			Descriptif rapide de l'activité de l'entreprise en quelques mots
	 <div> 
			<label for="type">Type *</label>
			<input name="TYPE_ENTREPRISE" value="<?php if($auto_maintien) echo $type_entreprise?>" type="text" id="type" class="defaut" tabindex="2">
		</div>
			Adresse de l'entreprise
	 <div>
			<label for="adresse">Adresse *</label>
			<input name="ADRESSE_ENTREPRISE" value="<?php if($auto_maintien) echo $adresse_entreprise?>" type="text" id="adresse" class="defaut" tabindex="3">
		</div>
			Code postale de la ville où se situe l'entreprise
	 <div>
			<label for="cpost">Code postal</label>
			<input name="CPOSTAL_ENTREPRISE" value="<?php if($auto_maintien) echo $cpost_entreprise?>" type="number" id="cpost" class="defaut" tabindex="4">
		</div>
			Ville où se situe l'entreprise (le lieu où se fait le stage)
	 <div>
			<label for="ville_entr">Ville *</label>
			<input name="VILLE_ENTREPRISE" value="<?php if($auto_maintien) echo $ville_entreprise?>" type="text" id="ville_entr" class="defaut" tabindex="5">
		</div><!--
			Numéro de téléphone de l'entreprise
	 <div>
			<label for="tel_entreprise">Téléphone *</label>
			<input name="TEL_ENTREPRISE" value="<?php if($auto_maintien) echo $tel_entreprise ?>" type="text" id="tel_entreprise" class="defaut" tabindex="6">
		</div><!--
			Mail de l'entreprise
	 <div>
			<label for="mail_entr">Mail</label>
			<input name="EMAIL_ENTREPRISE" value="<?php if($auto_maintien) echo $email_entreprise ?>" type="text" id="mail_entr" class="defaut" tabindex="7">
		</div><!-- 

	------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	-->
	<!--
		----------------------------------------
			Champ de formulaire à rentrer pour
			savoir la description du stage
		----------------------------------------
	
	--><div class="header">
		<h2>Stage</h2>
	</div><!--
		Description du stage
	--><div>
			<label for="contenu">Description du stage</label>
			<textarea name="CONTENU" id="contenu" class="defaut" tabindex="8" rows ="4" >
				<?php if($auto_maintien) echo trim($description); ?>
			</textarea>
	</div>
		<!------------------------------------------
			Champs du formulaire pour avoir des
			informations sur le tuteur
		----------------------------------------
	 --><div class="header">
			<h2>Tuteur</h2>
		</div><!--
			Nom du tuteur
	  --><div>
	  		<h3> <center>Si vous connaissez le nom du tuteur</center></h3>
			<label for="ID_TUTEUR">Nom du tuteur</label>
			<?php echo listNomTuteur($connexion, $id_tuteur); ?>
			<span class="hint"></span>
		</div><!--

	 --><div>
	 	<h3><center> Sinon, vous devez créer le tuteur</center></h3>
			<label for="nom_tuteur">Nom </label>
			<input name="NOM_TUTEUR" value="<?php if($auto_maintien) echo $nom_tuteur ?>" type="text" id="nom_tuteur" class="defaut" tabindex="9">
		</div><!--
			Prénom du tuteur
	 --><div>
			<label for="prenom_tuteur">Prénom </label>
			<input name="PRENOM_TUTEUR" value="<?php if($auto_maintien) echo $prenom_tuteur ?>" type="text" id="prenom_tuteur" class="defaut" tabindex="10">
		</div><!--
			Téléphone du tuteur
	 --><div>
			<label for="tel_tuteur">Téléphone </label>
			<input name="TEL_TUTEUR" value="<?php if($auto_maintien) echo $tel_tuteur ?>" type="tel" id="tel_tuteur" class="defaut" tabindex="11">
		</div><!--
			Mail du tuteur
	 --><div>
			<label for="mail_tuteur">Mail</label>
			<input name="MAIL_TUTEUR" value="<?php if($auto_maintien) echo $mail_tuteur ?>" type="email" id="mail_tuteur" class="defaut" tabindex="12">
		</div><!--
			Statut du tuteur dans l'entreprise
	 --><div>
			<label for="statut_tuteur">Statut  </label>
			<input name="STATUT_TUTEUR" value="<?php if($auto_maintien) echo $statut_tuteur ?>" type="text" id="statut_tuteur" class="defaut" tabindex="13">
		</div><!--
			Service où travaille le tuteur
	 --><div>
			<label for="service_tuteur">Service </label>
			<input name="SERVICE_TUTEUR" value="<?php if($auto_maintien) echo $service_tuteur ?>" type="text" id="service_tuteur" class="defaut" tabindex="14">
		</div><!--
		----------------------------------------
			Bouton d'enregistrement du 
			formulaire
		----------------------------------------			
	 --><div>
	 		<input class="submit transition" type="submit" value="Soumettre">
	 	</div><!--
	 -->
	</form>