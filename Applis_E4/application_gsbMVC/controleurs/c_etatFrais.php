<?php
include("vues/v_sommaire.php");

// Récupération de l'idVisiteur et de l'action à réaliser
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
		/**
		 * Inclus "vues/v_listeMois.php"
		 *
		 * Affiche la vue de sélection des mois disponibles pour l'affichage de la
		 * fiche de frais correspondante
		 */
		include("vues/v_listeMois.php");
		break;
	}
	// Affichage de la fiche de frais
	case 'voirEtatFrais':{
		$leMois = $_REQUEST['lstMois']; 
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		$moisASelectionner = $leMois;
		/**
		 * Inclus "vues/v_listeMois.php"
		 *
		 * Affiche la vue de sélection des mois disponibles pour l'affichage de la
		 * fiche de frais correspondante
		 */
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

		/**
		 * Inclus "vues/v_etatFrais.php"
		 *
		 * Affiche la vue de la fiche de frais de l'utilisateur concernant le mois
		 * précédement sélectionné
		 */
		include("vues/v_etatFrais.php");
		break;
		}
}
?>