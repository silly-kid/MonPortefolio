<?php
include("vues/v_sommaire.php");
// Variables n�cessaire
$action = $_REQUEST['action'];
switch ($action){
	// Affiche les fiches de frais Valid�es et Clotur�es
	case 'afficherFiche':
		$lesFichesDeFrais = $pdo->getLesFicheFraisVA_CL();
		/**
		 * Inclus "vues/v_afficherFicheFrais.php"
		 *
		 * Affiche les fiche de frais Valid�es et Clotur�es
		 */
		include("vues/v_afficherFicheFrais.php");
		break;
	default :
		break;
}