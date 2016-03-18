<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
echo $action;
$lesFichesFrais = $pdo->getFichesFraisValidees();
include("vues/v_lstFicheFrais.php");

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
		if ((empty($lesFraisForfait)) && (empty($lesFraisHorsForfait))) {
			include("vues/v_pasDeFicheFrais.php");
		} else {
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