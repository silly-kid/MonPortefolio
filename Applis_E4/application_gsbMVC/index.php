<?php
// Inclure les fonctions (fct.inc.php) et les classes (class.pdogsb.inc.php)
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
//require_once ("include/class.rangeoption.php");


// Inclure la vue "v_entete.php"
include("vues/v_entete.php") ;

session_start();//crée une session ou restaure celle trouvée sur le serveur.

$pdo = PdoGsb::getPdoGsb();//fonction dans class.pdogsb.Connexion à la base de données GSB.
$estConnecte = estConnecte();//Teste si un quelconque visiteur est connecté. retourne V ou F.
$estConnecte_comptable = estConnecte_comptable();//Teste si un quelconque comptable est connecté.

/*isset — Détermine si une variable est définie et est différente de NULL.
$_REQUEST fait partie des variables superglobales de PHP. 
Elle permet de récupérer des variables fournies au script par n'importe quel mécanisme d'entrée.*/

/* si rien n'est renseigné uc = connexion */
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
		// Inclure le contrôleur "c_connexion.php"
		include("controleurs/c_connexion.php");break;
	}
	case 'gererFrais' :{
		// Inclure le contrôleur "c_gererFrais.php"
		include("controleurs/c_gererFrais.php");break;
	}
	case 'etatFrais' :{
		// Inclure le contrôleur "c_etatFrais.php"
		include("controleurs/c_etatFrais.php");break;
	}
	case 'validFrais': {
	    //inclure le contrôleur "c_validFrais.php"
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

