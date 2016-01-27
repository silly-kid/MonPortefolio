<?php
/**
 * Inclus "vues/v_sommaire.php"
 *
 * Affichage de vue du sommaire :
 * - Visiteur 'nom' 'prenom'
 * - Saisie fiche de frais
 * - Mes fiches de frais
 * - D�connexion
 */
include("vues/v_sommaire.php");
// R�cup�ration des informations n�cessaires
$action = $_REQUEST['action'];
$jourActuel = date('d');
$moisActuel = date('m');
$anneeActuelle = date('Y');
$mois = $_SESSION['mois'];
switch ($action){
	// Permet de choisir le visiteur et le mois
	case 'choisirVisiteurMois' :
		$lesVisiteurs = $pdo->getLesVisiteurs();
		$VisiteurSelectionne = $lesVisiteurs[0];
		// Si on est le 20 ou avant le 20 du mois en cours on affiche le mois
		// pr�c�dent sinon on affiche le mois en cours
		if ($jourActuel <= 20){
			$moisAAfficher = Fonction::moisPrecedent($moisActuel, $anneeActuelle);
		}
		else{
			$moisAAfficher = $moisActuel."/".$anneeActuelle;
		}
		/**
		 * Inclus "vues/v_choixVisiteur.php"
		 *
		 * Affiche le formulaires permettant de saisir :
		 * - le visiteur
		 * - le mois
		 */
		include("vues/v_choixVisiteur.php");
		break;
		// Permet d'afficher la fiche de frais
	case 'voirFicheFrais' :
		if (isset($_REQUEST['lstVisiteurs'])){
			// R�cup�ration du visiteur concern�
			$leVisiteur = $_REQUEST['lstVisiteurs'];
			$_SESSION['leVisiteur'] = $leVisiteur;

			// R�cup�ration du mois concern�
			$leMois = $_REQUEST['mois'];
			$_SESSION['leMois'] = $leMois;
		}else{
			// R�cup�ration du visiteur concern�
			$leVisiteur = $_GET['nom']." ".$_GET['prenom'];
			$idVisiteur = $_GET['idVisiteur'];
			$_SESSION['leVisiteur'] = $leVisiteur;
			$_SESSION['idVisiteur'] = $idVisiteur;

			// R�cup�ration du mois concern�
			$mois = $_GET['mois'];
			$leMois = substr($mois, 4, 2)."/".  substr($mois, 0, 4);
			$_SESSION['leMois'] = $leMois;
		}

		// Affichage de la fiche de frais
		voirFiche($leVisiteur, $leMois);
		break;
	case 'supprimerFraisHF' :
		// Variables utiles
		$idVisiteur = $_SESSION['idVisiteur'];
		$leVisiteur = $_SESSION['leVisiteur'];
		$leMois = $_SESSION['leMois'];
		$idFrais = $_REQUEST['idFrais'];

		$pdo->refuserFraisHorsForfait($idFrais);
		voirFiche($leVisiteur, $leMois);
		break;
	case 'reporterFraisHF':
		// Variables utiles
		$idVisiteur = $_SESSION['idVisiteur'];
		$leVisiteur = $_SESSION['leVisiteur'];
		$leMois = $_SESSION['leMois'];
		$idFrais = $_REQUEST['idFrais'];

		// Test si le mois suivant existe
		$moisSuivant = Fonction::moisSuivant($leMois);
		// Report du frais hors forfait
		$pdo->reporterFraisHorsForfait($idVisiteur, $moisSuivant, $idFrais);
		voirFiche($leVisiteur, $leMois);
		break;
	case 'actualiserFraisForfait' :
		// Variables utiles
		$idVisiteur = $_SESSION['idVisiteur'];
		$leVisiteur = $_SESSION['leVisiteur'];
		$leMois = $_SESSION['leMois'];
		$lesFrais = $_REQUEST['lesFrais'];

		$nbJustif = $_REQUEST['nbJustif'];

		// Si il n'y a pas de caract�re interdit on actualise les frais sinon on
		// on affiche un message d'erreur
		if (Fonction::lesQteFraisValides($lesFrais)){
			$pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
			$pdo->majFicheFrais($idVisiteur, $mois, $nbJustif);
			include("vues/v_confirmation.php");
		}else{
			Fonction::ajouterErreur("Les valeurs des frais doivent �tre num�riques");
			/**
			 * Inclus "vues/v_erreurs.php"
			 *
			 * Affiche la liste des erreurs rencontr�es
			 */
			include("vues/v_erreurs.php");
		}
		voirFiche($leVisiteur, $leMois);
		break;
	case 'validerFrais':
		// Variables utiles
		$idVisiteur = $_SESSION['idVisiteur'];
		$leVisiteur = $_SESSION['leVisiteur'];
		$leMois = $_SESSION['leMois'];

		$mois = Fonction::getMois($jourActuel.'/'.$leMois);
		$montantValide = $pdo->calculerMontantValide($idVisiteur, $mois);
		$pdo->majEtatFicheFrais($idVisiteur, $mois, 'VA',$montantValide);
		voirFiche($leVisiteur, $leMois);
		break;
		// Modifie l'�tat de la fiche de frais de Valid�e � Rembourss�e
	case 'reglerFrais':
		// R�cup�ration des variables n�cessaires
		$idVisiteur = $_SESSION['idVisiteur'];
		$leVisiteur = $_SESSION['leVisiteur'];
		$leMois = $_SESSION['leMois'];

		$idVisiteur = $_GET['idVisiteur'];
		$mois = $_GET['mois'];
		$montantValide = $_GET['montantValide'];

		// Mise � jour de fiche de frais
		$pdo->majEtatFicheFrais($idVisiteur, $mois, 'RB', $montantValide);

		voirFiche($leVisiteur, $leMois);
		break;
	default :
		break;
}
/**
 *
 * Affiche la fiche de frais du visiteur et le mois pass� en param�tre
 *
 * @param String $leVisiteur
 * @param String $leMois
 * @retunr void
 */
function voirFiche($leVisiteur, $leMois){
	$lesVisiteurs = PdoGsb::getLesVisiteurs();
	$VisiteurSelectionne = $leVisiteur;
	$moisAAfficher = $leMois;

	include("vues/v_choixVisiteur.php");
	$idVisiteur = $_SESSION['idVisiteur'];
	if(PdoGsb::estFicheExistante($leMois)){
		$mois = substr($leMois, 3,4).substr($leMois,0,2);
		$numAnnee = substr($leMois, 0 ,4);
		$numMois = substr($leMois ,4, 2);
		$_SESSION['mois'] = $mois;
		$lesFraisForfait = PdoGsb::getLesFraisForfait($idVisiteur, $mois);
		$lesFraisHorsForfait = PdoGsb::getLesFraisHorsForfait($idVisiteur, $mois);
		$lesInfosFicheFrais = PdoGsb::getInfosFicheFrais($idVisiteur, $mois);
		$idEtat = $lesInfosFicheFrais['idEtat'];
		$libEtat = $lesInfosFicheFrais['libelle'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif = $lesInfosFicheFrais['dateModif'];
		$dateModif = Fonction::dateAnglaisVersFrancais($dateModif);
		// V�rification de l'etat de la fiche (si l'etat n'est pas 'CR' on affiche
		// uniquemenet la fiche sans possiblit� de la modifier
		if ($idEtat == 'CL'){
			/**
			 * Inclus "vues/v_validerFraisForfait.php"
			 *
			 * Affiche la fiche de frais du visiteur pour le mois en cours
			 */
			include("vues/v_validerFrais.php");
		}else{
			/**
			 * Inclus "vues/v_etatFrais.php"
			 *
			 * Affiche la vue de la fiche de frais de l'utilisateur concernant le mois
			 * pr�c�dement s�lectionn�
			 */
			include("vues/v_etatFrais.php");
		}
	}else{
		/**
		 * Inclus "vues/v_ficheInexistante.php"
		 *
		 * Affiche un message pour informer que la fiche de frais voulue
		 * n'existe pas
		 */
		include("vues/v_ficheInexistante.php");
	}
}
?>