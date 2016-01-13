<?php
/**
 * Inclus "vues/v_sommaire.php"
 *
 * Affichage de vue du sommaire :
 * - Visiteur 'nom' 'prenom'
 * - Saisie fiche de frais
 * - Mes fiches de frais
 * - Déconnexion
 */
include("vues/v_sommaire.php");

// Récupération des informations nécessaires
$idVisiteur = $_SESSION['idVisiteur'];
$mois = getMois(date("d/m/Y"));
$numAnnee =substr( $mois,0,4);
$numMois =substr( $mois,4,2);
$action = $_REQUEST['action'];
switch($action){
	// Création de la nouvelle fiche de frais si premier frais du mois en cours
	case 'saisirFrais':{
		if($pdo->estPremierFraisMois($idVisiteur,$mois)){
			$pdo->creeNouvellesLignesFrais($idVisiteur,$mois);
		}
		break;
	}
	// Mise à jour de la fiche de frais
	case 'validerMajFraisForfait':{
		$lesFrais = $_REQUEST['lesFrais'];
		if(lesQteFraisValides($lesFrais)){
	  	 	$pdo->majFraisForfait($idVisiteur,$mois,$lesFrais);
		}
		else{
			ajouterErreur("Les valeurs des frais doivent Ãªtre numÃ©riques");
			include("vues/v_erreurs.php");
		}
	  break;
	}
	// Validation de la ligne de frais hors forfait après contrôle des erreurs
	case 'validerCreationFrais':{
		$dateFrais = $_REQUEST['dateFrais'];
		$dateFrais = dateAnglaisVersFrancais($dateFrais);
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
	// Suppression du frais sélectionné
	case 'supprimerFrais':{
		$idFrais = $_REQUEST['idFrais'];
	    $pdo->supprimerFraisHorsForfait($idFrais);
		break;
	}
}
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
/**
 * Inclus "vues/v_listeFraisForfait.php"
 *
 * Affiche la vue concernant la liste des frais forfaitisés de la fiche de frais du
 * mois en cours
 */
include("vues/v_listeFraisForfait.php");
/**
 * Inclus "vues/v_listeFraisHorsForfait.php"
 *
 * Affiche la vue concernant la liste des frais hors forfaits de la fiche de frais du
 * mois en cours
 */
include("vues/v_listeFraisHorsForfait.php");

?>