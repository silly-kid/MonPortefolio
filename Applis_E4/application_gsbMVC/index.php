<?php
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
include("vues/v_entete.php") ;
session_start();
$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();
$estConnecte_comptable = estConnecte_comptable();
if(!isset($_REQUEST['uc']) && !$estConnecte && !$estConnecte_comptable){
     $_REQUEST['uc'] = 'connexion';
}	 
else if (isset($_REQUEST['uc']) && $_REQUEST['action'] = "valideConnexion"){
	$_REQUEST['uc'] = 'connexion';
}
else if (isset($_SESSION['idVisiteur'])) {
	$_REQUEST['uc'] = 'etatFrais';
	$_REQUEST['uc'] = 'gererFrais';
}

else {
	$_REQUEST['uc'] = NULL;
}
$uc = $_REQUEST['uc'];
switch($uc){
	case 'connexion':{
		include("controleurs/c_connexion.php");break;
	}
	case 'gererFrais' :{
		include("controleurs/c_gererFrais.php");break;
	}
	case 'etatFrais' :{
		include("controleurs/c_etatFrais.php");break; 
	}
}
include("vues/v_pied.php") ;
?>

