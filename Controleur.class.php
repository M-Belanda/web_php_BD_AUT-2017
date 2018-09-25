<?php
/**
 * Class Controleur
 * Gère les requêtes HTTP
 * 
 * @author Bélanda
 * @version 1.0
 * @update 2013-12-10
 * @update 2016-01-22 : Adaptation du code aux standards de codage du département de TIM
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 * 
 */

class Controleur 
{
	
		/**
		 * Traite la requête
		 * @return void
		 */
		public function gerer()
		{
			
			switch ($_GET['requete']) {
				case 'acceuil':
					$this->accueil();
					break;
				case 'liste':
					$this->listeProduit();
					break;
				case 'biere':
					$this->biere();
					break;
				case 'modifier':
					$this->modifierBiere();
					break;
				case 'soumettremodif':
					$this->soumettreModif();
					break;
				case 'ajouter':
					$this->ajouterBiere();
					break;
				case 'soumettreajouter':
					$this->ajouterBiere($_POST);
					break;
				case 'effacer':
					$this->effacerBiere();
					break;
				case 'effacerConf':
					$this->effacerConfBiere();
					break;
				case 'connecter' :
					$this -> connecter();
					break;
				case 'deconnecter' :
					$this -> deconnecter();
					break;
				default:
					$this->accueil();
					break;
			}
		}
		private function accueil()
		{
			$oVue = new Vue($_SESSION['login']);
			$oVue->afficheEntete();
			$oVue->afficheAccueil();
			$oVue->affichePied();
		}
		// Placer les méthodes du controleur.
		private function deconnecter() {
			$_SESSION['login'] = false;
			$this->accueil();
		}
	
		private function connecter() {
			$oBiere = new Biere();
			if(isset($_POST['nom']) && isset($_POST['motpasse'])){
				$bLogin = $oBiere -> verifLogin($_POST['nom'], $_POST['motpasse']);
				$_SESSION['login'] = $bLogin;
			}
			
			
			$this->accueil();
		}
		private function listeProduit(){
			
			$oVue = new Vue($_SESSION['login']);
			$oVue->afficheEntete();
			if ($_SESSION['login']) {
				$oBiere = new Biere();
				$nBiere = $oBiere->getNombrePages();
				
				$aBieres = $oBiere->getBieres($_GET['page']);
				
				$oVue->afficheListe($aBieres, $nBiere, $_GET['page']);
			} else {
				$oVue->AfficheErreurAccess();
			}
			$oVue->affichePied();
		}
		
		private function biere(){
			
			$oVue = new Vue($_SESSION['login']);
			$oVue->afficheEntete();
			if ($_SESSION['login']) {
				$oBiere = new Biere();
				$aBiere = $oBiere->getBiere($_GET['id_biere']);
				
				
				
				$oVue->afficheBiere($aBiere);
			}else {
				$oVue->AfficheErreurAccess();
			}
			
			$oVue->affichePied();
		}
		private function modifierBiere(){
			
			$oVue = new Vue($_SESSION['login']);
			$oVue->afficheEntete();
			
			$oBiere = new Biere();
			$aBiere = $oBiere->getBiere($_GET['id_biere']);
			//var_dump("ici");
			if ($_SESSION['login']) {	
				$oVue->afficheModifBiere($aBiere);
			} else {
				$oVue->AfficheErreurAccess();
			}
			
			$oVue->affichePied();
		}

		private function soumettreModif()
		{
			
			$oVue = new Vue($_SESSION['login']);
			$oVue->afficheEntete();
			//var_dump($_POST);
			if ($_SESSION['login']) {
				$oBiere = new Biere();
				$aBiere = $oBiere->modifBiere($_GET['id_biere'], $_POST);
				
				
				$oVue->afficheBiere($aBiere);
			} else {
				$oVue->AfficheErreurAccess();
			}
			
			$oVue->affichePied();
		}
		
		private function ajouterBiere($aBiere = array())
		{
			
			if ($_SESSION['login']) {
				if(!empty($aBiere))
				{
					$oBiere = new Biere();
					$res = $oBiere->ajouterBiere($aBiere);
					//var_dump($res);
					//var_dump($aBiere);
					if(!empty($res))
					{
						header("Location: ?requete=liste");
						//var_dump($aBiere);
					}
					else {
						$oVue = new Vue($_SESSION['login']);
						$oVue->afficheEntete();
						$oVue->afficheAjoutBiere($aBiere, "Tous les champs sont requis");
					}
				}
				else
				{
					$oVue = new Vue($_SESSION['login']);
					$oVue->afficheEntete();
					$oVue->afficheAjoutBiere();
				
				
				
				}
			} else {
				$oVue->AfficheErreurAccess();
			}
			$oVue->affichePied();
		}
		
		private function effacerBiere()
		{
			$oBiere = new Biere();
			$oVue = new Vue($_SESSION['login']);
			$oVue->afficheEntete();
			if ($_SESSION['login']) {
				$aBiere = $oBiere->getBiere($_GET['id_biere']);
				
				
				
				
				$oVue->afficheConfEffacerBiere($aBiere);
			
			} else {
				$oVue->AfficheErreurAccess();
			}
			$oVue->affichePied();
		}
		
		private function effacerConfBiere()
		{
			$oBiere = new Biere();
			if ($_SESSION['login']) {
				$aBiere = $oBiere->effacerBiere($_GET['id_biere']);
				//var_dump($aBiere);
				$this->listeProduit();
			} else {
				$oVue->AfficheErreurAccess();
			}
		}
		
		private function test(){
			$oBiere = new Biere();
			$aBieres = $oBiere->getBieres($_GET['page']);
			$aBieres[] = $aBieres[0];
			$oFichier = new FichierJSON();
			$oFichier->ecrireFichier("donnees",$aBieres );
		}
}
?>















