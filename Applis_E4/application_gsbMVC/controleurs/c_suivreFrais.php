<?php
include("vues/v_sommaire.php");
// Variables nécessaire
$action = $_REQUEST['action'];
switch ($action){
	// Affiche les fiches de frais Validées et Cloturées
	case 'afficherFiche':
		$lesFichesDeFrais = $pdo->getLesFicheFraisVA_CL();
		/**
		 * Inclus "vues/v_afficherFicheFrais.php"
		 *
		 * Affiche les fiche de frais Validées et Cloturées
		 */
		include("vues/v_afficherFicheFrais.php");
		break;
	default :
		break;
}