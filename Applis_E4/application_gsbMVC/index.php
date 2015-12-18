<?php
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
include("vues/v_entete.php") ;
session_start();//cr�e une session ou restaure celle trouv�e sur le serveur.
$pdo = PdoGsb::getPdoGsb();//fonction dans class.pdogsb.
$estConnecte = estConnecte();//Teste si un quelconque visiteur est connect�. retourne V ou F.
$estConnecte_comptable = estConnecte_comptable();//Teste si un quelconque comptable est connect�.
/*isset � D�termine si une variable est d�finie et est diff�rente de NULL.
$_REQUEST fait partie des variables superglobales de PHP. 
Elle permet de r�cup�rer des variables fournies au script par n'importe quel m�canisme d'entr�e.*/
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
		include("controleurs/c_gererFrais.php");
		//include("controleurs/c_etatFrais.php");break;
	}
	case 'etatFrais' :{
		include("controleurs/c_etatFrais.php");break; 
	}
}
include("vues/v_pied.php") ;
?>

