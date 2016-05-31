<?php

/**
 * Contrôleur Visiteur : pour validé, modifier, supprimer FF et FHF
 * @author Flora Carriere
 */

include("vues/v_sommaire.php"); //vue du sommaire
$idVisiteur = $_SESSION['idVisiteur']; //récupération infos idVisiteur
$mois = getMois(date("d/m/Y")); //récupère mois
$numAnnee =substr( $mois,0,4);
$numMois =substr( $mois,4,2);
$action = $_REQUEST['action']; //récupère action
echo $action;

switch($action){
	case 'saisirFrais':{ //saisie d'un frais F
		if($pdo->estPremierFraisMois($idVisiteur,$mois)){
			$pdo->creeNouvellesLignesFrais($idVisiteur,$mois);
		}
		break;
	}
	case 'validerMajFraisForfait':{ //enregistrement dans bdd frais F
		$lesFrais = $_REQUEST['lesFrais'];
			if(lesQteFraisValides($lesFrais)){ //si les frais sont vaides
	  	 		$pdo->majFraisForfait($idVisiteur,$mois,$lesFrais);
			}
			else{ //en cas d'erreur 
				ajouterErreur("Les valeurs des frais doivent être numériques");
				include("vues/v_erreurs.php");
			}
	  break;
	}
	case 'validerCreationFrais':{ //nouveaus frais H F 
		$dateFrais = $_REQUEST['dateFrais'];
		$libelle = $_REQUEST['libelle'];
		$montant = $_REQUEST['montant'];
		valideInfosFrais($dateFrais,$libelle,$montant);
		if (nbErreurs() != 0 ){ //si il y a des erreurs
			include("vues/v_erreurs.php");
		}
		else{ //sinon crèation nouveau FHF
			$pdo->creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$dateFrais,$montant);
			
		}
		break;
	}
	case 'supprimerFrais':{ //supprimer FHF
		$idFrais = $_REQUEST['idFrais'];
	    $pdo->supprimerFraisHorsForfait($idFrais);
		break;
	}
}

$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois); //les FHF
$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois); //les FF
$km = $pdo->getFraiskm($idVisiteur, $mois); //km
$vehicule = $pdo->getVehicule($idVisiteur, $mois); //type VEH
$vehicule1 = 0; //coef

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
		ajouterErreur("aucun type de vehicule choisi ou type non valide");
		include("vues/v_erreurs.php");
	}
$resultat = $km[0] * $vehicule1; //calcul des F km en fonction du VEH

include("vues/v_listeFraisForfait.php"); //vue FF
include("vues/v_listeFraisHorsForfait.php"); //vue FHF

?>