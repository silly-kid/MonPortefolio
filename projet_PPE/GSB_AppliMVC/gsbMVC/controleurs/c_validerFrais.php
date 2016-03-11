<?php
include('vues/v_sommaire.php');
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];

echo $action;

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
		$idVisiteur = $_REQUEST['lstVisiteur'];
		$idVisiteurChoisi = $idVisiteur;
		$lesMois=$pdo->getLesMoisCloture($idVisiteur);//rajouté
		$moisASelectionner = $leMois;//rajouté
		
		$tabVisiteurs = $pdo->getLesVisiteurs();//rajouté
		include("vues/v_listeVisiteur.php");//rajouté
		
		//if (isset($_POST['lstVisiteur']))
		//{
			//echo "pas vide";
		//}
		//else {
			//echo "vide";
		//}
			
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
		$button = "<td class='qteForfait'><input type='button' value='Modifier'></td>";
		$report = "<input type='button' name='btnReportRefus' value='Reporter'>";
		$refuser = "<input type='button' name='btnReportRefus' value='Refuser'>";
		$valider = 1;
		if((empty($lesFraisForfait)) && (empty($lesFraisHorsForfait))) {
			include("vues/v_pasDeFicheFrais.php");
		} else {
			include("vues/v_etatFraisComptable.php");
			
		}
		break;
		
	case "validFrais":		
		$idVisiteur = $_SESSION['idVisiteur'];
		$leMois = $_SESSION['leMois'];		
		$tabVisiteurs = $pdo->getLesVisiteurs();//rajouté
		include("vues/v_listeVisiteur.php");//rajouté
		
		$lesFrais = $pdo->getLesFraisForfait($idVisiteur, $leMois); //rajout�
		$pdo->majFraisForfait($idVisiteur, $leMois, $lesFrais);
		include("vues/v_affichModif.php");
		
		break;
		
	case "reportRefus":
		$reportRefus = $_REQUEST['btnReportRefus'];
		$id = $_REQUEST['id'];
		$libelle = $_REQUEST['libelle'];
		$leMois = $_SESSION['leMois'];
		$idVisiteur = $_SESSION['idVisiteur'];
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