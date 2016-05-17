<?php
require_once("include/fct.inc.php"); // contient toutes les fonctions
require_once ("include/class.pdogsb.inc.php"); // contient les méthodes
include("vues/v_entete.php") ; // vues de l'entête

session_start();
$pdo = PdoGsb::getPdoGsb(); // base de donnèe
$estConnecte = estConnecte();

if(!isset($_REQUEST['uc']) || !$estConnecte){ // connexion
     $_REQUEST['uc'] = 'connexion';
}	

$uc = $_REQUEST['uc'];

switch($uc){
	case 'connexion':{
		include("controleurs/c_connexion.php");break; //contrôle la connexion, crypte de mdp
	}
	case 'gererFrais' :{
		include("controleurs/c_gererFrais.php");break; //Visiteur : ajouter des FF, ajouter et supprimer des FHF
	}
	case 'etatFrais' :{
		include("controleurs/c_etatFrais.php");break;  //Visiteur : voir l'ètat des F à une date
	}
	case 'validationFicheFrais': {
		include("controleurs/c_validerFrais.php");break; //Comptable : valider, refuser, modifier FF et FHF
	}
	case 'suiviPaiement' :{
		include("controleurs/c_suiviPaiement.php");break; //Comptable : Valider, Mettre en paiement fiche de F
	}
}
include("vues/v_pied.php") ; // vue du bas de page
?>

