<?php
// Inclure les fonctions (fct.inc.php) et les classes (class.pdogsb.inc.php)
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
//require_once ("include/class.rangeoption.php");


// Inclure la vue "v_entete.php"
include("vues/v_entete.php") ;

session_start();//cr�e une session ou restaure celle trouv�e sur le serveur.

$pdo = PdoGsb::getPdoGsb();//fonction dans class.pdogsb.Connexion � la base de donn�es GSB.
$estConnecte = estConnecte();//Teste si un quelconque visiteur est connect�. retourne V ou F.
$estConnecte_comptable = estConnecte_comptable();//Teste si un quelconque comptable est connect�.

/*isset � D�termine si une variable est d�finie et est diff�rente de NULL.
$_REQUEST fait partie des variables superglobales de PHP. 
Elle permet de r�cup�rer des variables fournies au script par n'importe quel m�canisme d'entr�e.*/

/* si rien n'est renseign� uc = connexion */
if(!isset($_REQUEST['uc']) && !$estConnecte && !$estConnecte_comptable){
     $_REQUEST['uc'] = 'connexion';
}
/*sinon si uc non null et action = valide connexion, uc = connexion */	 
else if (isset($_REQUEST['uc']) && $_REQUEST['action'] = "valideConnexion"){
	$_REQUEST['uc'] = 'connexion';
}
/*sinon si idVisiteur, uc = etatFrais et gererFrais
 *  $_SESSION : Variables de session*/
else if (isset($_SESSION['idVisiteur'])) {
	$_REQUEST['uc'] = 'etatFrais';
	$_REQUEST['uc'] = 'gererFrais';
}
else if (isset($_SESSION['idComptable'])) {
	$_REQUEST['uc'] = 'validFrais';
	$_RESQUEST['uc'] = 'suivreFiche';
}
/*sinon uc = null*/
else {
	$_REQUEST['uc'] = NULL;
}
// Stockage dans la variable "uc"
$uc = $_REQUEST['uc'];

switch($uc){
	case 'connexion':{
		// Inclure le contr�leur "c_connexion.php"
		include("controleurs/c_connexion.php");break;
	}
	case 'gererFrais' :{
		// Inclure le contr�leur "c_gererFrais.php"
		include("controleurs/c_gererFrais.php");break;
	}
	case 'etatFrais' :{
		// Inclure le contr�leur "c_etatFrais.php"
		include("controleurs/c_etatFrais.php");break;
	}
	case 'validFrais': {
	    //inclure le contr�leur "c_validFrais.php"
		include("controleurs/c_validFrais.php");break;
	}
	case 'suivreFiche' :{
		
		include("controleurs_test/c_suivreFiche.php");
		break;
	}
}
// Inclure la vue "v_pied.php"
include("vues/v_pied.php") ;
?>

