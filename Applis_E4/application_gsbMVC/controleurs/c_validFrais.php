<?php

// info visteur
$lesVisiteurs = $pdo->getUser();
$lesVisiteursRangeOption = new RangeOption($lesVisiteurs, array("value" => "id", "name" => "nom", "correspondance" => "value"), null);

// années
for($i = 2005; $i<=date('Y'); $i++)
{
	$date[] = array("value" => $i);
}

$lesDatesOption = new RangeOption($date, array("value" => "value", "name" => "value", "correspondance" => "value"), null);

// mois
$lesMois = array();
$lesMois[1] = array('value'=> "01", 'name' => 'Janvier');
$lesMois[] = array('value'=> "02", 'name' => 'Février');
$lesMois[] = array('value'=> "03", 'name' => 'Mars');
$lesMois[] = array('value'=> "04", 'name' => 'Avril');
$lesMois[] = array('value'=> "05", 'name' => 'Mai');
$lesMois[] = array('value'=> "06", 'name' => 'Juin');
$lesMois[] = array('value'=> "07", 'name' => 'Juillet');
$lesMois[] = array('value'=> "08", 'name' => 'Août');
$lesMois[] = array('value'=> "09", 'name' => 'Septembre');
$lesMois[] = array('value'=> "10", 'name' => 'Octobre');
$lesMois[] = array('value'=> "11", 'name' => 'Novembre');
$lesMois[] = array('value'=> "12", 'name' => 'Décembre');
$lesmoisRangeOption = new RangeOption($lesMois, array("value" => "value" , "name" => "name", "correspondance" => "value"), null);

// situation
$lesSitu = array();
$lesSitu[1] = array('value'=> "CR", 'name' => 'Saisie en cours');
$lesSitu[] = array('value'=> "VA", 'name' => 'Validé');
$lesSitu[] = array('value'=> "RB", 'name' => 'Remboursé');
$lesSituOption = new RangeOption($lesSitu, array("value" => "value", "name" => "name", "correspondance" => "value"), null);

//-------------------------------

$lesfichefraishorsget  = array(); // tableau vide

//-- après le chargement des données visiteur et mois + année
if(isset($_POST['BTNValide']))
{
	$idVisiteur = $_POST['lesVisiteur'];
	$mois = $_POST['annee'].$_POST['mois'];

	$lesFicheFraisget = $pdo->getLesFraisForfait($idVisiteur, $mois); // récupéré les quantités de chaque champ
	//$afficheFicheFraisvalide = $pdo->getLesInfosFicheFrais($idVisiteur, $mois); // récupéré la date nb justifcatis et situ pour une date donné
	$lesVisiteursRangeOption = new RangeOption($lesVisiteurs, array("value" => "id", "name" => "nom", "correspondance" => "value"), $idVisiteur);
	$lesDatesOption = new RangeOption($date, array("value" => "value", "name" => "value", "correspondance" => "value"), $_POST['annee']);
	$lesmoisRangeOption = new RangeOption($lesMois,array("value" => "value" , "name" => "name", "correspondance" => "value"), $_POST['mois']);
	$lesSituOption = new RangeOption($lesSitu, array("value" => "value", "name" => "name", "correspondance" => "value"), $pdo->etatFicheFrais($idVisiteur, $mois)['idEtat']);
	$lesSituOptionhors = new RangeOption($lesSitu, array("value" => "value", "name" => "name", "correspondance" => "value"), $pdo->EtatFicheHorsFrais($idVisiteur, $mois), null);
	
	// hors forfait
	
	$lesfichefraishorsget = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
}
 
if(isset($_POST['BTNSubmit']))
{
	// modif situ
	if(isset($_POST['situ']))
	{
		$idVisiteur = $_POST['lesVisiteur'];
		$pdo->majEtatFicheFrais($_POST['lesVisiteur'], $_POST['annee'] . $_POST['mois'], $_POST['situ'], $_POST['hcMontant'], $_POST['repas'], $_POST['nuitee'], $_POST['etape'], $_POST['km']);
	}
	
	// condition d'avoir en chargement un visiteur de selectionné
	if(isset($_POST['lesVisiteur']))
	{
		$idVisiteur = $_POST['lesVisiteur'];
		$mois = $_POST['annee'] . $_POST['mois'];
		$lesFicheFraisget = $pdo->getLesFraisForfait($idVisiteur, $mois);
		//$afficheFicheFraisvalide = $pdo->getLesInfosFicheFrais($idVisiteur, $mois);
		$lesVisiteursRangeOption = new RangeOption($lesVisiteurs, array("value" => "id", "name" => "nom", "correspondance" => "value"), $_POST['lesVisiteur']);
		$lesDatesOption = new RangeOption($date, array("value" => "value", "name" => "value", "correspondance" => "value"), $_POST['annee']);
		$lesmoisRangeOption = new RangeOption($lesMois,array("value" => "value", "name" => "name", "correspondance" => "value"), $_POST['mois']);
		$lesSituOption = new RangeOption($lesSitu, array("value" => "value", "name" => "name", "correspondance" => "value"), $pdo->etatFicheFrais($idVisiteur, $mois)['idEtat']);
		$lesfichefraishorsget = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
		
		/*echo '<pre>';
		 print_r($lesFicheFraisget);
		echo '</pre>';*/
		// exit;
		
		foreach($lesfichefraishorsget as $value)
		{
			$pdo->majEtatFicheHorsFrais($value['id'], $_POST['annee'] . $_POST['mois'], $_POST['situhors' . $value['id']], $_POST['hfLib' . $value['id']], $_POST['hfMont' . $value['id']]);
		}
		
		// Récupération à nouveau des frais hors forfait (utile après une mise à jour)
		$lesfichefraishorsget = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
	}
}

include("vues/v_formValidFrais.php");

?>