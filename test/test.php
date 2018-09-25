<?php
	require("../modeles/Biere.class.php");
	require("../vues/Vue.class.php");
	
	?>
		<form method="post" action="?requete=connecter">
							<h3>Nom:</h3><input type="text" name="nom">
							<h3>Mot de passe:</h3><input type="password" name="motpasse">
							<button type="submit">Se connecter</button>
						</form>	
	<?php
		$oBiere = new Biere();
		$bLogin = $oBiere -> verifLogin($_POST['nom'], $_POST['motpasse']);
		$hash = crypt($motpasse, $res['motpasse']);
		var_dump("motdepasse:".$hash);	
			var_dump($res['motpasse']);	
		//	$1$V35.4G..$f8eL23zGR4gh/6giA8POy/
	?>