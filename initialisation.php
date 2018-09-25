<?php

/**
 * Fichier d'initialisation des variables GET et POST.
 * @version 1.1
 * @update 2016-01-22
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 * 
 */
 
 /**
 * Faire l'assignation des variables ici avec les isset() ou !empty()
 */
  
   
if(empty($_GET['requete']))
{
	$_GET['requete'] = '';
}
    
if(!isset($_SESSION['login'])){
		$_SESSION['login'] = false;
	}
	   
if(empty($_GET['page']))
{
	$_GET['page'] = '1';
}

if(empty($_GET['id_biere']))
{
	$_GET['id_biere'] = '0';
}
    
	
   
   
?>