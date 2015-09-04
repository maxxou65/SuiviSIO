<nav class="menu_horizontal">
	<ul>
	<?php

		$menu_horizontal = '<li><a href="../mod_etudiants/index_etudiants.php">MODULE ETUDIANTS</a></li>';
		$menu_horizontal .= '<li><a href="../mod_stages/index_stages.php">MODULE STAGES &amp; ENTREPRISES</a></li>';

		if ($_SESSION['CONNEXION']['ID'] == 'enseignant') {
			$menu_horizontal .= '<li><a href="../mod_devenirs/index_devenirs.php">MODULE DEVENIRS &amp; DIPLOMES</a></li>';
		}
		
		echo $menu_horizontal;
	?>
	</ul>
</nav>