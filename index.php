<?php

/**
 * Fichier de lancement du MVC, Il appel le fichier de configuration.php et le fichier d'initialisation des GET/POST initialisation.php 
 * @version 1.1
 * @update 2016-01-22 : Adaptation du code aux standards de codage du département de TIM
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 * 
 */
	 /***************************************************/
    /** Fichier de configuration, contient l'autoloader **/
    /***************************************************/
	require_once("./configuration.php");
	
	/***************************************************/
    /** Les classes modeles **/
    /***************************************************/   
	require_once("./modeles/Biere.class.php");
	
   /***************************************************/
    /** Les classes vues **/
    /***************************************************/	
	require_once("./vues/Vue.class.php");
	
	
	/***************************************************/
    /** Les classes controleurs **/
    /***************************************************/
   require_once("./Controleur.class.php");
   
	/***************************************************/
    /** ouverture session **/
    /***************************************************/
	 session_start();
   
   /***************************************************/
    /** Initialisation des variables **/
    /***************************************************/
	require_once("./initialisation.php");
	
   
   /***************************************************/
    /** Démarrage du controleur **/
    /***************************************************/
	$oCtl = new Controleur();
	$oCtl->gerer();
    
?>
