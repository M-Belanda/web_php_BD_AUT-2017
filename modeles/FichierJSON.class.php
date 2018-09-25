<?php
/**
 * Class FichierJSON
 * Classe de manipulation des fichiers JSON
 * 
 * @version 1.0
 * @update 2017-08-18 : Création de la classe
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 * 
 */
class FichierJSON {
	
    
	function __construct ()
	{
		
	}
	
	function __destruct ()
	{
		
	}

	
		
	/**
	 * @access public
	 * @return Array
	 */
	public function LireFichier($sNomFichier="donnees") 
	{
		$aDonnees = "";
		//var_dump($sNomFichier.".json");
		$sDonnees = file_get_contents($sNomFichier.".json"); 
		//var_dump($sDonnees);
		$aDonnees = json_decode($sDonnees, true);
		return $aDonnees;
	}

	/**
	 * @access public
	 * @return Array
	 */
	 public function EcrireFichier($sNomFichier="donnees", $aData=array()) 
	 {
		 $aDonnees = "";
		 //$resFichier = $this->ouvrirFichier($sNomFichier.".json");
		 $jsonDonnees = json_encode($aData);
		 //ftruncate($resFichier, 0);
		 //fwrite($resFichier, $jsonDonnees);
		 $bytes= file_put_contents($sNomFichier.".json", $jsonDonnees);
		 //var_dump($bytes);
		 return $aDonnees;
	 }
}




?>