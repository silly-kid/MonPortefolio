<?php
include("vues/v_sommaire.php");

$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];

switch($action){
	case 'selectionnerMois':{
		include("vues/v_listeMois.php");
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = $lesCles[0];
		//include("vues/v_listeMois.php");
		break;
	}
	case 'voirEtatFrais':{
		include("vues/v_etatFrais.php");
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

$lesMois = array();
$lesMois[1] = array('value'=> "01", 'name' => 'de Janvier');
$lesMois[] = array('value'=> "02", 'name' => 'de Février');
$lesMois[] = array('value'=> "03", 'name' => 'de Mars');
$lesMois[] = array('value'=> "04", 'name' => 'd\'Avril');
$lesMois[] = array('value'=> "05", 'name' => 'de Mai');
$lesMois[] = array('value'=> "06", 'name' => 'de Juin');
$lesMois[] = array('value'=> "07", 'name' => 'de Juillet');
$lesMois[] = array('value'=> "08", 'name' => 'd\'Août');
$lesMois[] = array('value'=> "09", 'name' => 'de Septembre');
$lesMois[] = array('value'=> "10", 'name' => 'd\'Octobre');
$lesMois[] = array('value'=> "11", 'name' => 'de Novembre');
$lesMois[] = array('value'=> "12", 'name' => 'de Décembre');

$displayDate = $lesMois[date('n')]['name'];

	$libEtat = $lesInfosFicheFrais['libEtat'];
	$montantValide = $lesInfosFicheFrais['montantValide'];
	$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
	$dateModif =  $lesInfosFicheFrais['dateModif'];
	$dateModif =  dateAnglaisVersFrancais($dateModif);
	include("vues/v_etatFrais.php");
	}
}
?>