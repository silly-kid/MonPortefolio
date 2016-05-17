<?php

/**
 * Contrôleur Visiteur : pour validé, modifier, supprimer FF et FHF
 * @author Flora Carriere
 */

include("vues/v_sommaire.php");
$idVisiteur = $_SESSION['idVisiteur'];
$mois = getMois(date("d/m/Y"));
$numAnnee =substr( $mois,0,4);
$numMois =substr( $mois,4,2);
$action = $_REQUEST['action'];
echo $action;

switch($action){
	case 'saisirFrais':{
		if($pdo->estPremierFraisMois($idVisiteur,$mois)){
			$pdo->creeNouvellesLignesFrais($idVisiteur,$mois);
		}
		break;
	}
	case 'validerMajFraisForfait':{
		$lesFrais = $_REQUEST['lesFrais'];
			if(lesQteFraisValides($lesFrais)){
	  	 		$pdo->majFraisForfait($idVisiteur,$mois,$lesFrais);
			}
			else{
				ajouterErreur("Les valeurs des frais doivent être numériques");
				include("vues/v_erreurs.php");
			}
	  break;
	}
	case 'validerCreationFrais':{
		$dateFrais = $_REQUEST['dateFrais'];
		$libelle = $_REQUEST['libelle'];
		$montant = $_REQUEST['montant'];
		valideInfosFrais($dateFrais,$libelle,$montant);
		if (nbErreurs() != 0 ){
			include("vues/v_erreurs.php");
		}
		else{
			$pdo->creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$dateFrais,$montant);
			
		}
		break;
	}
	case 'supprimerFrais':{
		$idFrais = $_REQUEST['idFrais'];
	    $pdo->supprimerFraisHorsForfait($idFrais);
		break;
	}
}

$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
$km = $pdo->getFraiskm($idVisiteur, $mois);
$vehicule = $pdo->getVehicule($idVisiteur, $mois);
$vehicule1 = 0;

	if($vehicule[0] == 1){
		$vehicule1 = 0.52;
	}
	elseif($vehicule[0] == 2){
		$vehicule1 = 0.58;
	}
	elseif($vehicule[0] == 3){
		$vehicule1 = 0.62;
	}
	elseif($vehicule[0] == 4){
		$vehicule1 = 0.67;
	}
	else{
		echo "aucun vehicule type de vehicule choisi";
	}
$resultat = $km[0] * $vehicule1; 

include("vues/v_listeFraisForfait.php");
include("vues/v_listeFraisHorsForfait.php");

?>