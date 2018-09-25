<?php
/**
 * Class Vue
 * Modèle de classe Vue. Dupliquer et modifier pour votre usage.
 * 
 * @author Bélanda
 * @version 1.1
 * @update 2013-12-11
 * @update 2016-01-22 : Adaptation du code aux standards de codage du département de TIM
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 * 
 */


class Vue {
	private $_bConnecter = false;
	function __construct($bConnecter = false){
		$this->_bConnecter = $bConnecter;
	}
	/**
	 * Produit l'entête html
	 * @access public
	 * @return void
	 */
	public function afficheEntete() {
		?>
		<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Biero</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width">
		
		<link rel="stylesheet" href="./css/normalize.css" type="text/css" media="screen">
		<link rel="stylesheet" href="./css/base_h5bp.css" type="text/css" media="screen">
		<link rel="stylesheet" href="./css/main.css" type="text/css" media="screen">
		
		<script src="./js/plugins.js"></script>
		<script src="./js/main.js"></script>
	</head>

	<body>
 		<header class="monEntete">
	        <li><a href="?requete=acceuil"><h1>Bièro : Administration</h1></a>
	 
    	</header>
    	<main>
    	<nav class="panneauNavigation">
    		<ul>
    			<?php
					if($this->_bConnecter){
				?>
    			<li><a href="?requete=liste">Liste des bières</a>
    				<ul><li><a href="?requete=ajouter">Ajouter une bière</a></li></ul>
    			</li>
    			<?php
					}
				?>
    		</ul>
    		<section class="login">
					<?php
					if($this->_bConnecter){
						echo '<a href="?requete=deconnecter">Se deconnecter</a>';
					}
					else {
					?>
						<form method="post" action="?requete=connecter">
							<h3>Nom:</h1><input type="text" name="nom">
							<h3>Mot de passe:</h1><input type="password" name="motpasse">
							<button type="submit">Se connecter</button>
						</form>	
					<?php
					}
					
					?>
			</section>
    	</nav>
		
		<?php
	}
	
	/**
	 * Contenu de la page d'accueil
	 * @access public
	 * @return void
	 */
	public function afficheAccueil() {
		
		?>
		<article>
			<h1>Bienvenue sur Simple MVC Structure </h1>
			<p>Simple MVC Structure n'est pas un framework, mais seulement une structure de base qui permet de monter un MVC rapidement en php. 
				Il suffit de forker le <a href="https://github.com/JonathanMartel/simpleMVCStructure">dépot Github</a> et de dupliquer les classes vues et modele afin d'en disposer à votre convenance.</p>
		</article>
		<?php
		
	}
	
	
	/**
	 * Contenu de la page d'accueil
	 * @access public
	 * @return void
	 */
	public function afficheListe($aBieres, $nPage, $nPageActive) {
		
		?>
		<section class="liste">
			<article class='titre'>
			<span class='nom'>Nom</span>
			<span class='brasserie'>Brasserie</span>
			<span class='description'>Description</span>
			<span class='public'>Public?</span>
			<span class='flex_filler'></span>
			<span class='action'>Action</span>
			</article>
			<?php
				if(!empty($aBieres))
				{
					foreach ($aBieres as $cle => $aUneBiere) {
						$index = ($nPageActive-1)*10+$cle;
						echo "<article class='biere'>";
						echo "<span class='nom'><a href='?requete=biere&id_biere=".$index."'>". $aUneBiere['nom'] . "</a></span>";
						echo "<span class='brasserie'>".$aUneBiere['brasserie']."</span>";
						echo "<span class='description'>". $aUneBiere['description']."</span>";
						echo "<span class='public'>". $aUneBiere['public']."</span>";
						echo "<span class='flex_filler'></span>";
						echo "<span class='action'><a href='?requete=modifier&id_biere=".$index."'>[Modif]</a><a href='?requete=effacer&id_biere=".$index."'>[Effacer]</a></span>";
						echo "</article>";
					}
				}
				else {
					echo "<article class='biere'>Aucun produit trouvé</article>";
					
				}
			?>
		
			<section class="pager">
				<ul>
				<?php
					for($i=0;$i<$nPage;$i++)
					{
						echo "<li><a href='?requete=liste&page=". ($i+1) ."'>". ($i+1) ."</a></li>";
					}
				?>
				</ul>
			</section>
		</section>
		<?php
		
	}
	
	
	/**
	 * Contenu de la page d'accueil
	 * @access public
	 * @return void
	 */
	public function afficheBiere($aBiere) {
		?>
		<section >
			<p>Nom : <input disabled type='text' name='nom' value='<?php echo $aBiere['nom']?>' >
			<p>Brasserie : <input disabled type='text' name='brasserie' value='<?php echo $aBiere['brasserie']?>'>
			<p>Description : <textarea disabled name='description'><?php echo $aBiere['description']?></textarea>
			<p>Type : <select disabled name='type'>
				<option value="ipa" <?php echo ($aBiere['type'] == 'ipa' ? 'selected':'')?> >IPA</option>
				<option value="brune" <?php echo ($aBiere['type'] == 'brune' ? 'selected' :'') ?>>Brune</option>
				<option value="blonde" <?php echo ($aBiere['type'] == 'blonde' ? 'selected' :'') ?>>Blonde</option>
				<option value="rousse" <?php echo ($aBiere['type'] == 'rousse' ? 'selected' :'') ?>>Rousse</option>
				<option value="lager" <?php echo ($aBiere['type'] == 'lager' ? 'selected' :'') ?>>Lager</option>
				<option value="stout" <?php echo ($aBiere['type'] == 'stout' ? 'selected' :'') ?>>Stout</option>
			 </select>
			<p>Formats disponibles : 
				<p>350ml : <input disabled type='checkbox' <?php echo (in_array('350ml', $aBiere['format']) ? 'checked':'')?>  name='format[]' value='350ml'></p>
				<p>500ml : <input disabled type='checkbox' <?php echo (in_array('500ml', $aBiere['format']) ? 'checked':'')?> name='format[]' value='500ml'></p>
				<p>750ml : <input disabled type='checkbox' <?php echo (in_array('750ml', $aBiere['format']) ? 'checked':'')?> name='format[]' value='750ml'></p>
				<p>1.8l : <input disabled type='checkbox' <?php echo (in_array('1.8l', $aBiere['format']) ? 'checked':'')?> name='format[]' value='1.8l'></p>
				<p>Public : Oui : <input disabled type='radio' name='public' value='oui' <?php echo ($aBiere['public'] == 'oui' ? 'checked':'')?> > Non : <input disabled type='radio' name='public' value='non' <?php echo ($aBiere['public'] == 'non' ? 'checked':'')?> >
			
			<p><a class='button' href='?requete=modifier&id_biere=<?php echo $aBiere['id']?>'>Modif</a><a class='button' href='?requete=effacer&id_biere=<?php echo $aBiere['id']?>'>Effacer</a>
		</form>
		
	</section>
		<?php
		
	}

	/**
	 * Contenu de la page d'accueil
	 * @access public
	 * @return void
	 */
	 public function afficheModifBiere($aBiere) {
		$aBiere['id']=$aBiere['id']-1;
		?>
		<section >
			<form method='post' action='?requete=soumettremodif&id_biere=<?php echo $aBiere['id']?>'>
				<p>Nom : <input type='text' name='nom' value='<?php echo $aBiere['nom']?>' >
				<p>Brasserie : <input type='text' name='brasserie' value='<?php echo $aBiere['brasserie']?>' >
				<p>Description : <textarea name='description'><?php echo $aBiere['description']?></textarea>
				<p>Type : <select name='type'>
					<option value="ipa" <?php echo (isset($aBiere['type']) && $aBiere['type'] == 'ipa' ? 'selected':'')?>>IPA</option>
					<option value="brune" <?php echo (isset($aBiere['type']) && $aBiere['type'] == 'brune' ? 'selected':'')?>>Brune</option>
					<option value="blonde" <?php echo (isset($aBiere['type']) && $aBiere['type'] == 'blonde' ? 'selected':'')?>>Blonde</option>
					<option value="rousse" <?php echo (isset($aBiere['type']) && $aBiere['type'] == 'rousse' ? 'selected':'')?>>Rousse</option>
					<option value="lager" <?php echo (isset($aBiere['type']) && $aBiere['type'] == 'lager' ? 'selected':'')?>>Lager</option>
					<option value="stout" <?php echo (isset($aBiere['type']) && $aBiere['type'] == 'stout' ? 'selected':'')?>>Stout</option>
	 			</select>
				<p>Formats disponibles : 
					<p>350ml : <input type='checkbox' <?php echo (isset($aBiere['format']) && in_array('350ml', $aBiere['format']) ? 'checked':'')?> name='format[]' value='350ml'></p>
					<p>500ml : <input type='checkbox' <?php echo (isset($aBiere['format']) && in_array('500ml', $aBiere['format']) ? 'checked':'')?> name='format[]' value='500ml'></p>
					<p>750ml : <input type='checkbox' <?php echo (isset($aBiere['format']) && in_array('750ml', $aBiere['format']) ? 'checked':'')?> name='format[]' value='750ml'></p>
					<p>1.8l : <input type='checkbox' <?php echo (isset($aBiere['format']) && in_array('1.8l', $aBiere['format']) ? 'checked':'')?> name='format[]' value='1.8l'></p>
				<p>Public : Oui : <input type='radio' name='public' value='oui' <?php echo ($aBiere['public'] == 'oui' ? 'checked':'')?> > Non : <input type='radio' name='public' value='non' <?php echo ($aBiere['public'] == 'non' ? 'checked':'')?> >
				<p><button type='submit'>Soumettre</button></p>
			</form>
			<p><a class="boutton" href="?requete=liste">Annuler</a></p>
		</section>
		<?php
		
	}
	
	/**
	 * Contenu de la page d'accueil
	 * @access public
	 * @return void
	 */
	 public function afficheAjoutBiere($aBiere = array(), $sMsg="") {
		?>
		<section >
			<?php echo ($sMsg == "" ? "" : "<p class='erreur'>".$sMsg. "</p>") ?>
			<form method='post' action='?requete=soumettreajouter'>
				<p>Nom : <input type='text' name='nom' value='<?php echo (isset($aBiere['nom']) ? $aBiere['nom'] : '') ?>' >
				<p>Brasserie : <input type='text' name='brasserie' value='<?php echo (isset($aBiere['brasserie']) ? $aBiere['brasserie'] : '') ?>' >
				<p>Description : <textarea name='description'><?php echo (isset($aBiere['description']) ? $aBiere['description'] : '') ?></textarea>
				<p>Type : <select name='type'>
					<option value="ipa" <?php echo (isset($aBiere['type']) && $aBiere['type'] == "ipa" ? 'selected':'') ?>>IPA</option>
					<option value="brune" <?php echo (isset($aBiere['type']) && $aBiere['type'] == "brune" ? 'selected':'') ?>>Brune</option>
					<option value="blonde" <?php echo (isset($aBiere['type']) && $aBiere['type'] == "blonde" ? 'selected':'') ?>>Blonde</option>
					<option value="rousse" <?php echo (isset($aBiere['type']) && $aBiere['type'] == "rousse" ? 'selected':'') ?>>Rousse</option>
					<option value="lager" <?php echo (isset($aBiere['type']) && $aBiere['type'] == "lager" ? 'selected':'') ?>>Lager</option>
					<option value="stout" <?php echo (isset($aBiere['type']) && $aBiere['type'] == "stout" ? 'selected':'') ?>>Stout</option>
	 			</select>
				<p>Formats disponibles : 
					<p>350ml : <input type='checkbox' <?php echo (isset($aBiere['format']) && in_array('350ml', $aBiere['format']) ? 'checked':'')?> name='format[]' value='350ml'></p>
					<p>500ml : <input type='checkbox' <?php echo (isset($aBiere['format']) && in_array('500ml', $aBiere['format']) ? 'checked':'')?> name='format[]' value='500ml'></p>
					<p>750ml : <input type='checkbox' <?php echo (isset($aBiere['format']) && in_array('750ml', $aBiere['format']) ? 'checked':'')?> name='format[]' value='750ml'></p>
					<p>1.8l : <input type='checkbox' <?php echo (isset($aBiere['format']) && in_array('1.8l', $aBiere['format']) ? 'checked':'')?> name='format[]' value='1.8l'></p>
				<p>Public : Oui : <input type='radio' name='public' value='oui' <?php echo (isset($aBiere['public']) && $aBiere['public'] == 'oui' ? 'checked':'')?> > Non : <input type='radio' name='public' value='non' <?php echo (isset($aBiere['public']) && $aBiere['public'] == 'non' ? 'checked':'')?> >
				<p><button type='submit'>Soumettre</button> </p>
			</form>
			<p><a class="boutton" href="?requete=liste">Annuler</a></p>
		</section>
		<?php
		
	}
	
	
	/**
	 * Contenu de la page d'accueil
	 * @access public
	 * @return void
	 */
	public function afficheConfEffacerBiere($aBiere) {
		$aBiere['id']=$aBiere['id']-1;
		?>
		<section >
			<p>Êtes-vous certain de vouloir effacer cette bière ? </p>
			<p>Nom : <input disabled type='text' name='nom' value='<?php echo $aBiere['nom']?>' >
			<p>Brasserie : <input disabled type='text' name='brasserie' value='<?php echo $aBiere['brasserie']?>' >
			<p>Description : <textarea disabled name='description'><?php echo $aBiere['description']?></textarea>
			<p>Type : <select disabled name='type'>
				<option value="ipa" <?php echo ($aBiere['type'] == 'ipa' ? 'selected':'')?> >IPA</option>
				<option value="brune" <?php echo ($aBiere['type'] == 'brune' ? 'selected' :'') ?>>Brune</option>
				<option value="blonde" <?php echo ($aBiere['type'] == 'blonde' ? 'selected' :'') ?>>Blonde</option>
				<option value="rousse" <?php echo ($aBiere['type'] == 'rousse' ? 'selected' :'') ?>>Rousse</option>
				<option value="lager" <?php echo ($aBiere['type'] == 'lager' ? 'selected' :'') ?>>Lager</option>
				<option value="stout" <?php echo ($aBiere['type'] == 'stout' ? 'selected' :'') ?>>Stout</option>
			 </select>
			<p>Formats disponibles : 
				<p>350ml : <input disabled type='checkbox' <?php echo (in_array('350ml', $aBiere['format']) ? 'checked':'')?>  name='format[]' value='350ml'></p>
				<p>500ml : <input disabled type='checkbox' <?php echo (in_array('500ml', $aBiere['format']) ? 'checked':'')?> name='format[]' value='500ml'></p>
				<p>750ml : <input disabled type='checkbox' <?php echo (in_array('750ml', $aBiere['format']) ? 'checked':'')?> name='format[]' value='750ml'></p>
				<p>1.8l : <input disabled type='checkbox' <?php echo (in_array('1.8l', $aBiere['format']) ? 'checked':'')?> name='format[]' value='1.8l'></p>
				<p>Public : Oui : <input disabled type='radio' name='public' value='oui' <?php echo ($aBiere['public'] == 'oui' ? 'checked':'')?> > Non : <input disabled type='radio' name='public' value='non' <?php echo ($aBiere['public'] == 'non' ? 'checked':'')?> >
			
			<p><a class='button' href='?requete=effacerConf&id_biere=<?php echo $aBiere['id']?>'>Confirmer la supression</a><a class='button' href='?requete=liste'>Annuler et retourner à la liste</a>
		</form>
		
	</section>
		<?php
		
	}
	public function AfficheErreurAccess() {
		echo "<div class='accueil'>";
		echo "<p>Vous n'êtes pas autorisés à accéder à cette page</p>";
		echo "</div>";
	}
	/**
	 * Produit le html du pied de page
	 * @access public
	 * @return void
	 */
	public function affichePied()
	{
		?>
		</main>
		<div id="footer">
				</div>
			</div>	
		</body>
	</html>
	<?php
	}
	
	
	
}
?>