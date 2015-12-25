<?php
include("vues/v_sommaire.php");


$idVisiteur = estConnecte();//$_SESSION['idVisiteur'];
$mois = getMois(date("d/m/Y"));
$numAnnee =substr( $mois,0,4);
$numMois =substr( $mois,4,2);
$action = $_REQUEST['action'];

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

$numMois = $lesMois[date('n')]['name'];

switch($action){
	case 'saisirFrais':{
		if($pdo->estPremierFraisMois($idVisiteur,$mois)){
			$pdo->creeNouvellesLignesFrais($idVisiteur,$mois);
		}
		break;
	}
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
	case 'supprimerFrais':{
		$idFrais = $_REQUEST['idFrais'];
	    $pdo->supprimerFraisHorsForfait($idFrais);
		break;
	}
}
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
include("vues/v_listeFraisForfait.php");

?>