<?php

/**
 * Contrôleur : Visiteur : voir état FF et FHF à une date : Fiche de Frais
 * @author Flora Carriere
 */

include("vues/v_sommaire.php"); //vue du sommaire
$action = $_REQUEST['action']; //recupère action
$idVisiteur = $_SESSION['idVisiteur']; //recupère idVisiteur

switch($action){
	case 'selectionnerMois':{ //selection du mois
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur); //recupère lesMoisDispo
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = $lesCles[0];//premiere clés
		include("vues/v_listeMois.php"); //vue de la liste des mois
		break;
	}
	case 'voirEtatFrais':{ //voir etat frais
		
		$leMois = $_REQUEST['lstMois']; //recupère mois
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur); //recupère lesMoisDispo
		$moisASelectionner = $leMois;
		include("vues/v_listeMois.php"); //vue des mois 
		
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois); //frais Hf
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$leMois); //frais F
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois); //ficheFrais
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat']; //infoFicheFrais
		$montantValide = $lesInfosFicheFrais['montantValide']; //montantvalidé
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs']; //nmb de justificatif
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois); //frais Hf
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois); //frais F
		$km = $pdo->getFraiskm($idVisiteur, $mois); //km
		$vehicule = $pdo->getVehicule($idVisiteur, $mois); //type de veh
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
		$resultat = $km[0] * $vehicule1;
		include("vues/v_etatFrais.php");
		
	}
}
?>