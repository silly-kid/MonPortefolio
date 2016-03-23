<?php
include("vues/v_sommaire.php");
$idVisiteur = $_SESSION['idVisiteur'];
$mois = getMois(date("d/m/Y"));
$numAnnee =substr( $mois,0,4);
$numMois =substr( $mois,4,2);
$action = $_REQUEST['action'];
echo $action;

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
			ajouterErreur("Les valeurs des frais doivent être numériques");
			include("vues/v_erreurs.php");
		}
	  break;
	}
	case 'validerCreationFrais':{
		$dateFrais = $_REQUEST['dateFrais'];
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
//mission 5 :
echo "l'idVisiteur :";
echo $idVisiteur;
echo "  le mois : ";
echo $mois;
$km = $pdo->getFraiskm($idVisiteur, $mois);
$vehicule = $pdo->getVehicule($idVisiteur, $mois);
echo " km : ";
echo $km;
echo $vehicule;

$vehicule1 = 0;
if($vehicule){
	if($vehicule == '1'){
		$vehicule1 == 0.52;
	}
	elseif($vehicule == '2'){
		$vehicule1 == 0.58;
	}
	elseif($vehicule == '3'){
		$vehicule1 == 0.62;
	}
	elseif($vehicule == '4'){
		$vehicule1 == 0.67;
	}
}
else {
	echo "erreur";
}
$resultat = $km * $vehicule1;
echo $resultat;
//fin misson 5 

include("vues/v_listeFraisForfait.php");
include("vues/v_listeFraisHorsForfait.php");

?>