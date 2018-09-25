<?php
/**
 * Class Biere
 * 
 * 
 * @version 1.0
 * @update 2017-08-16
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 * 
 */
class Biere {
	const NOMBRE_PAR_PAGE =10;
	private $_db;
    
	function __construct ()
	{
		$this->_db = new mysqli("localhost", "root", "", "bieres");//aller chercher la base de donne
	}
	
	function __destruct ()
	{
		
	}
	 
	 /*
	 * @access public
	 * @return Array
	 */
	 
	 function verifLogin($nom, $motpasse){
		$login = false;
		$nom = $this->_db->real_escape_string($nom);
		
		$mySQLRes = $this->_db->query("select * from usager where nom='".$nom."'");
		if($mySQLRes){
			$res = $mySQLRes->fetch_assoc();
		}
		
		if(isset($res['nom']) && isset($res['motpasse'])){
			
			$hash = crypt($motpasse, $res['motpasse']);
			if($hash == $res['motpasse'])
			{
				$login = true;
				var_dump("entree");
			}
			//var_dump("motdepasse:".$hash);	
			//var_dump($res['motpasse']);	
		}
		
		return $login;
	}
	public function getDonnees() 
	{
		return $this->_db;
	}
	
	/**
	 * Retourne les produits d'une page
	 * @access public
	 * @param 
	 * @return Array
	 */
	public function getBieres($nPage=1) 
	{
		$res = array();
		if(count($this->_db))
		{
			$nMaxPage =ceil(count($this->_db)/self::NOMBRE_PAR_PAGE);
			 
			if($nPage>$nMaxPage)
			{
				$nPage = $nMaxPage;
			}
		$mSQLRes = $this->_db->query("select * from bieres");
		
		if($mSQLRes){
			$res = $mSQLRes->fetch_all(MYSQLI_ASSOC);
		}
			$aBiere = array_chunk($res, 10);
			if(isset($aBiere[$nPage-1]))
			{
				$res = $aBiere[$nPage-1];
			}
			
		}
		
		
		return $res;
	}
	
	/**
	 * Retourne les informations d'une bière
	 * @access public
	 * @param 
	 * @return Array
	 */
	public function getBiere($id_biere) 
	{
		$id_biere = $id_biere + 1;
		$res = array();
		
		$query = "SELECT * FROM bieres where id =" .$id_biere; //prendre l'informations d'une biere
		$result = $this->_db->query($query);
		$res = $result->fetch_array(MYSQLI_ASSOC);//https://stackoverflow.com/questions/16525413/fatal-error-cannot-use-object-of-type-mysqli-result
		$pieces = explode(",", $res['format']);
		
		$res['format']= array();
		$res['format'] = array_merge($res['format'], $pieces); //mettre le format en tableau
		//var_dump($res['format']);
		
		return $res;
	}
	
	/**
	 * 
	 * @access public
	 * @param 
	 * @return Array
	 */
	 public function modifBiere($id_biere,$aBiere) 
	 {
		
		$id_biere = $id_biere+1; //mettre le bon id pour la base de donnee
		
		$res = array();
		if(isset($aBiere)){
		//var_dump($id_biere);
		//var_dump($aBiere['format']);
		//$tableau=$aBiere['format'];
		//$vide= array();
		//$aBiere['format'] = array_merge($vide,$tableau);
		
		$aBiere['format'] = implode(",", $aBiere['format']);//mettre le format en string
		
		$mSQLRes = $this->_db->query("UPDATE bieres set nom = \"". $aBiere['nom'].'", brasserie = "'. $aBiere['brasserie'].'", description = "'. $aBiere['description']
		.'",format ="'.$aBiere['format'] .'", public = "'. $aBiere['public'].'", type = "'. $aBiere['type'].'" where id =' .$id_biere);//modifier la bonne biere
		}
		$id_biere = $id_biere-1; //mettre le bon id pour php
		$res = $this->getBiere($id_biere);// chercher la biere
		return $res;
		
	 }
	 /**
	 * Méthode d'ajout de bière
	 * @access public
	 * @param Array $aDonnees Contient les données envoyer par le formulaire d'ajout
	 * @return Array La bière qui a été ajouté
	 */
	 public function ajouterBiere($aBiere) 
	 {
		$id = 0;
		
		
		if(!empty($aBiere['nom']) && !empty($aBiere['brasserie']) && !empty($aBiere['description']) && !empty($aBiere['type']) && isset($aBiere['format']) && isset($aBiere['public']))
		{
			
			$aBiere['format'] = implode(',', $aBiere['format']);//mettre le format en string
			//var_dump($aBiere['format'] );
			//var_dump($aBiere['type'] );
		 $res = $this->_db->query("INSERT INTO bieres VALUES ('".$id."','". $aBiere['nom']."','". $aBiere['brasserie']."','". $aBiere['description']."','". $aBiere['format']."','". $aBiere['public'] ."','". $aBiere['type'] ."')");
			
				//var_dump("INSERT INTO bieres VALUES ('".$id."','". $aBiere['nom']."','". $aBiere['brasserie']."','". $aBiere['description']."','". $aBiere['type']."','". $aBiere['format'] ."','". $aBiere['public'] ."')");
				
		
			
		}
		if($this->_db->insert_id != 0){ //incrémenter l'id
			$id = $this->_db->insert_id;	
		}
		
		//var_dump("id:".$id);
		return $res;
	 }
	 
	
	public function effacerBiere($id_biere)
	{
		$id_biere = $id_biere+1;//mettre le bon id pour base de donnee
		$res = $this->_db->query("DELETE FROM bieres WHERE id =" .$id_biere);
		
		//var_dump($id_biere);
		return $res;
	}
	
	/**
	 * Retourne les produits d'une page
	 * @access public
	 * @param 
	 * @return Array
	 */
	public function getNombrePages() 
	{
		var_dump($this->_db);
		return ceil(count($this->_db)/self::NOMBRE_PAR_PAGE);
		
		//return $aBiere[$nPage-1];
	}
}




?>