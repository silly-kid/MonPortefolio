<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];

switch($action){
	case 'selectionnerMois':{
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = $lesCles[0];
		include("vues/v_listeMois.php");
		break;
	}
	case 'voirEtatFrais':{
		
		$leMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		$moisASelectionner = $leMois;
		include("vues/v_listeMois.php");
		
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois);
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
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
		include("vues/v_etatFrais.php");
		
	}
}
?>