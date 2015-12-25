<?php

// info visteur
$lesVisiteurs = $pdo->getUser();
$lesVisiteursRangeOption = new RangeOption($lesVisiteurs, array("value" => "id", "name" => "nom", "correspondance" => "value"), null);

// ann�es
for($i = 2005; $i<=date('Y'); $i++)
{
	$date[] = array("value" => $i);
}

$lesDatesOption = new RangeOption($date, array("value" => "value", "name" => "value", "correspondance" => "value"), null);

// mois
$lesMois = array();
$lesMois[1] = array('value'=> "01", 'name' => 'Janvier');
$lesMois[] = array('value'=> "02", 'name' => 'F�vrier');
$lesMois[] = array('value'=> "03", 'name' => 'Mars');
$lesMois[] = array('value'=> "04", 'name' => 'Avril');
$lesMois[] = array('value'=> "05", 'name' => 'Mai');
$lesMois[] = array('value'=> "06", 'name' => 'Juin');
$lesMois[] = array('value'=> "07", 'name' => 'Juillet');
$lesMois[] = array('value'=> "08", 'name' => 'Ao�t');
$lesMois[] = array('value'=> "09", 'name' => 'Septembre');
$lesMois[] = array('value'=> "10", 'name' => 'Octobre');
$lesMois[] = array('value'=> "11", 'name' => 'Novembre');
$lesMois[] = array('value'=> "12", 'name' => 'D�cembre');
$lesmoisRangeOption = new RangeOption($lesMois, array("value" => "value" , "name" => "name", "correspondance" => "value"), null);

// situation
$lesSitu = array();
$lesSitu[1] = array('value'=> "CR", 'name' => 'Saisie en cours');
$lesSitu[] = array('value'=> "VA", 'name' => 'Valid�');
$lesSitu[] = array('value'=> "RB", 'name' => 'Rembours�');
$lesSituOption = new RangeOption($lesSitu, array("value" => "value", "name" => "name", "correspondance" => "value"), null);

//-------------------------------

$lesfichefraishorsget  = array(); // tableau vide

//-- apr�s le chargement des donn�es visiteur et mois + ann�e
if(isset($_POST['BTNValide']))
{
	$idVisiteur = $_POST['lesVisiteur'];
	$mois = $_POST['annee'].$_POST['mois'];

	$lesFicheFraisget = $pdo->getLesFraisForfait($idVisiteur, $mois); // r�cup�r� les quantit�s de chaque champ
	//$afficheFicheFraisvalide = $pdo->getLesInfosFicheFrais($idVisiteur, $mois); // r�cup�r� la date nb justifcatis et situ pour une date donn�
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
	
	// condition d'avoir en chargement un visiteur de selectionn�
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
		
		// R�cup�ration � nouveau des frais hors forfait (utile apr�s une mise � jour)
		$lesfichefraishorsget = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
	}
}

include("vues/v_formValidFrais.php");

?>