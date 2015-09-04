<nav class="menu_vertical_stages menu_vertical">
	<ul>
		<?php if($_SESSION['CONNEXION']['ID'] == 'enseignant') {?>
		<!-- Retour vers l'accueil -->
		<li id="home" class="menu_header"><a href="../mod_stages/index_stages.php"><img src="../img/home_16-16.png">Accueil</a></li>
		<!-- stages -->
		<li class="separateur"></li>
		<li class="menu_header">Stages</li>
		<li class="separateur"></li>
		<li class="menu_elt"><a href="../mod_stages/superviser_stages.php"><img src="../img/arrleft_16-16.png">Supervision</a></li>
		<li class="menu_elt"><a href="../mod_stages/ajouter_stages.php"><img src="../img/arrleft_16-16.png">Ajouter</a></li>
		<li class="menu_elt"><a href="../mod_stages/expl_donnes_stages.php"><img src="../img/arrleft_16-16.png">Consulter</a></li>
		<li class="menu_elt"><a href="../mod_stages/fiche_stages.php"><img src="../img/arrleft_16-16.png">Fiche</a></li>
		<li class="menu_elt"><a href="../mod_stages/modif_donnes_stages.php"><img src="../img/arrleft_16-16.png">Modifier</a></li>
		<li class="menu_elt"><a href="../mod_stages/sup_donnes_stages.php"><img src="../img/arrleft_16-16.png">Supprimer</a></li>
		<?php } ?>
		<!-- entreprises -->
		<li class="separateur"></li>
		<li class="menu_header">Entreprises</li>
		<li class="separateur"></li>
		<?php if($_SESSION['CONNEXION']['ID'] == 'enseignant') {?>
		<li class="menu_elt"><a href="../mod_stages/ajouter_entreprise.php"><img src="../img/arrleft_16-16.png">Ajouter</a></li>
		<?php } ?>
		<li class="menu_elt"><a href="../mod_stages/expl_donnes_entreprise.php"><img src="../img/arrleft_16-16.png">Consulter</a></li>
		<li class="menu_elt"><a href="../mod_stages/fiche_entreprises.php"><img src="../img/arrleft_16-16.png">Fiche</a></li>
		<?php if($_SESSION['CONNEXION']['ID'] == 'enseignant') {?>
		<li class="menu_elt"><a href="../mod_stages/modif_donnes_entreprise.php"><img src="../img/arrleft_16-16.png">Modifier</a></li>
		<li class="menu_elt"><a href="../mod_stages/sup_donnes_entreprise.php"><img src="../img/arrleft_16-16.png">Supprimer</a></li>

		<?php } ?>
		<!-- Tuteur -->
	<!--<li class="separateur"></li>
		<li class="menu_header">Tuteurs</li>
		<li class="separateur"></li>
		<li class="menu_elt"><a href="../mod_stages/ajouter_tuteur.php"><img src="../img/arrleft_16-16.png">Ajouter</a></li>
		<li class="menu_elt"><a href="../mod_stages/expl_donnes_tuteur.php"><img src="../img/arrleft_16-16.png">Consulter</a></li>
		<li class="menu_elt"><a href="../mod_stages/modif_donnes_tuteur.php"><img src="../img/arrleft_16-16.png">Modifier</a></li>
		<li class="menu_elt"><a href="../mod_stages/sup_donnes_tuteur.php"><img src="../img/arrleft_16-16.png">Supprimer</a></li> -->
	</ul>
</nav>