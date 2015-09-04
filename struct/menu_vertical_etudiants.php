<nav class="menu_vertical_stages menu_vertical">
	<ul>
		<?php if($_SESSION['CONNEXION']['ID'] == 'enseignant') {?>
		<!-- Retour vers l'accueil -->
		<li id="home" class="menu_header"><a href="../mod_etudiants/index_etudiants.php"><img src="../img/home_16-16.png">Accueil</a></li>
		<?php } ?>
		<!-- Etudiants -->
		<li class="separateur"></li>
		<li class="menu_header">Etudiants</li>
		<li class="separateur"></li>
		<li class="menu_elt"><a href="../mod_etudiants/ajout_etudiants.php"><img src="../img/arrleft_16-16.png">Ajouter</a></li>
		<?php if($_SESSION['CONNEXION']['ID'] == 'enseignant') {?>
		<li class="menu_elt"><a href="../mod_etudiants/modifier_etudiants.php"><img src="../img/arrleft_16-16.png">Modifier</a></li>
		<li class="menu_elt"><a href="../mod_etudiants/valider_etudiants.php"><img src="../img/arrleft_16-16.png">Valider</a></li>
		<li class="menu_elt"><a href="../mod_etudiants/expl_donnes_etudiants.php"><img src="../img/arrleft_16-16.png">Consulter</a></li>
		<?php } ?>
	</ul>
</nav>