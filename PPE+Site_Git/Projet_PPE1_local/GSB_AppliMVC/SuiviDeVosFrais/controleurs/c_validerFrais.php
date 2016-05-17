<?php
include('vues/v_sommaire.php');
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
$tabVisiteurs = $pdo->getLesVisiteurs();

switch ($action) {
	case "selectionnerMois":
		$lesMois = [];
		$tabVisiteurs = $pdo->getLesVisiteurs();
		$idVisiteurChoisi = "";
		if(isset($_POST['idVisiteurChoisi'])){
			$idVisiteurChoisi = $_POST['idVisiteurChoisi'];
			$lesMois = $pdo->getLesMoisCloture($idVisiteurChoisi);
			
		}
		/* Afin de s�lectionner par d�faut le dernier mois dans la zone de liste
		** on demande toutes les cl�s, et on prend la premi�re,
		** les mois �tant tri�s d�croissants
		**/
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = "";
		include("vues/v_listeVisiteur.php");
		break;
	
	case "voirEtatFrais":
		$leMois = $_REQUEST['lstMois'];
		$_SESSION['leMois']=$leMois;
		$idVisiteur = $_REQUEST['lstVisiteur'];
		$_SESSION['idVisiteur'] = $idVisiteur;
		$idVisiteurChoisi = $idVisiteur;
		echo "voit etatFrais : ".$idVisiteur;
		$lesMois=$pdo->getLesMoisCloture($idVisiteur);
		$moisASelectionner = $leMois;
		$tabVisiteurs = $pdo->getLesVisiteurs();
		include("vues/v_listeVisiteur.php");
			
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
		$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
		$numAnnee = substr($leMois, 0,4);
		$numMois = substr($leMois, 4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif = $lesInfosFicheFrais['dateModif'];
		$dateModif = dateAnglaisVersFrancais($dateModif);
		$readOnly = "";
		$valider = 1;
		if((empty($lesFraisForfait)) && (empty($lesFraisHorsForfait))) {
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
			include("vues/v_etatFraisComptable.php");
			
		}
		break;
		
	case "validFrais":		
		$idVisiteur = $_SESSION['idVisiteur'];
		echo "bouton modifier".$idVisiteur;
		$leMois = $_SESSION['leMois'];	
		$lesFrais = $_REQUEST['lesFrais'];
		$tabVisiteurs = $pdo->getLesVisiteurs();
		//include("vues/v_listeVisiteur.php");
		
		$leVisiteur = $idVisiteur;
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur, $leMois);
		$lesFraisForfait = $pdo->getLesFraisForfait($leVisiteur, $leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur, $leMois);
		$numAnnee = substr($leMois, 0, 4);
		$numMois = substr($leMois, 4, 2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif = $lesInfosFicheFrais['dateModif'];
		$dateModif = dateAnglaisVersFrancais($dateModif);
		//include("vues/v_etatFraisComptable.php");
		
		
		//$lesFrais = $_REQUEST['lesFrais'];
		if (lesQteFraisValides($lesFrais)) {
			$pdo->majFraisForfait($leVisiteur, $leMois, $lesFrais);
		
			ajouterErreur("les éléments forfaitisés on été modifiée!");
			$type = 1;
			include("vues/v_erreurs.php");
		} else {
			ajouterErreur("Les valeurs des frais doivent être numériques");
			include("vues/v_erreurs.php");
		}
		
		$leVisiteur = $idVisiteur;
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur, $leMois);
		$lesFraisForfait = $pdo->getLesFraisForfait($leVisiteur, $leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur, $leMois);
		
		include("vues/v_resultatModif.php");
		break;
		
	case "reportRefus":
		$reportRefus = $_REQUEST['btnReportRefus'];
		$id = $_REQUEST['id'];
		$libelle = $_REQUEST['libelle'];
		$leMois = $_SESSION['leMois'];
		$idVisiteur = $_SESSION['idVisiteur'];
		echo $idVisiteur;
		if($reportRefus == 'Refuser' && !preg_match("/REFUSE :/", $libelle)){
			$pdo->majFraisHorsForfait($libelle, $id);
			include("vues/v_refus.php");
		}else{
			if($reportRefus == 'Reporter'){
				$pdo->reportFraisHorsForfait($id, $leMois, $idVisiteur);
				include('vues/v_update.php');
				
			}
		}
		break;
		
	case "validFiche":
		$idVisiteur = $_SESSION['idVisiteur'];
		echo $idVisiteur;
		$mois = $_SESSION['leMois'];
		$pdo->majEtatFicheFrais($idVisiteur, $mois, 'VA');
		$tabMontant = $pdo->getLesMontants();
		$tabQuantites = $pdo->getLesQuantites($idVisiteur, $mois);
		$montant = 0;
		for($i=0; $i<4; $i++){
			$montant += ($tabMontant[$i][0] * $tabQuantites[$i][0]); 
			break;/*rajouté*/
			
		}
		$montantHorsForfait = $pdo->getMontantHorsForfait($idVisiteur, $mois);
		$montant += $montantHorsForfait[0];
		$pdo->majMontantValide($idVisiteur, $mois, $montant);
		include("vues/v_valide.php");
		break;
}

include("vues/v_pied.php");
?>