<?php

/**
 * Contrôleur Comptable : pour validé, modifier, refuser FF et FHF
 * @author Flora Carriere
 */

include("vues/v_sommaire.php"); //vue du sommaire
$action = $_REQUEST['action']; //recupère action
echo $action;
$lesFichesFrais = $pdo->getFichesFraisValidees(); //récupèreFicheV
include("vues/v_lstFicheFrais.php"); //vue ListeFicheF

switch ($action) {
	case 'voirFicheFrais':
		$idEtMois = explode("/", $_POST['lstFicheFrais']);
		$idVisiteur = $idEtMois[0];
		$_SESSION['idVisiteur'] = $idVisiteur;
		echo "voir fiche :" . $idVisiteur;
		$leMois = $idEtMois[1];
		$_SESSION['leMois'] = $leMois;
		echo "voir fiche : " . $leMois;
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
		$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
		$numAnnee = substr($leMois, 0, 4);
		$numMois = substr($leMois, 4, 2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif = $lesInfosFicheFrais['dateModif'];
		$dateModif = dateAnglaisVersFrancais($dateModif);
		$readOnly = "readOnly='readOnly'";
		if ((empty($lesFraisForfait)) && (empty($lesFraisHorsForfait))) { //si pas de F de F 
			include("vues/v_pasDeFicheFrais.php");
		} else {
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
			$resultat = $km[0] * $vehicule1;
			include("vues/v_suiviePaiement_Comptable.php");
		}
		break;
		
	case 'remboursement':
		$idVisiteur = $_SESSION['idVisiteur'];
		$leMois = $_SESSION['leMois'];
		
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
		$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
		$numAnnee = substr($leMois, 0, 4);
		$numMois = substr($leMois, 4, 2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif = $lesInfosFicheFrais['dateModif'];
		$dateModif = dateAnglaisVersFrancais($dateModif);
		$readOnly = "readOnly='readOnly'";
		include("vues/v_suiviePaiement_Comptable.php");
		
		$pdo->majEtatFicheFrais($idVisiteur, $leMois, 'RB');
		include("vues/v_rembourse.php");
		break;
		
	case 'paiement' :
		$idVisiteur = $_SESSION['idVisiteur'];
		$leMois = $_SESSION['leMois'];
		
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
		$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
		$numAnnee = substr($leMois, 0, 4);
		$numMois = substr($leMois, 4, 2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif = $lesInfosFicheFrais['dateModif'];
		$dateModif = dateAnglaisVersFrancais($dateModif);
		$readOnly = "readOnly='readOnly'";
		include("vues/v_suiviePaiement_Comptable.php");
		
		$pdo->majEtatFicheFrais($idVisiteur, $leMois, 'VA');
		include("vues/v_valide.php");
		break;
		
}
include("vues/v_pied.php");
?>