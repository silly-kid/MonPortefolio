﻿<?php
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
switch($action){
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
	case 'valideConnexion':{
		$login = $_REQUEST['login'];
		$mdp = $_REQUEST['mdp'];
		
		//crypter mdp
		/*
		echo "Mot de passe avant : ";
		echo $mdp;
		$texte = trim($_POST['mdp']);
		$texte1 = md5('$mdp');
		$mdp = $texte1;
		if($mdp){
			echo "  le mdp a ete crypté  ";
		}else echo "  error  ";
			
		echo "  texte1 : ";
		echo $texte1;
		
		echo "  mdp cryptage : ";
		echo $mdp;
		
		$pdo->majCryptMdp($login, $mdp, $texte1);
		
		
		echo "  mdp changer dans bdd : ";
		echo $mdp;
		$mdp = $pdo->getInfosmdp($login);
	
		echo "  verif : ";
		echo $login;
		echo $mdp;
		//fin
		 */
		
		$visiteur = $pdo->getInfosVisiteur($login,$mdp);
		if(!is_array( $visiteur)) {
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
		else if(is_array( $visiteur)){
			$id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
			$statut = $visiteur['statut'];
			connecter($id,$nom,$prenom,$statut);
			include("vues/v_sommaire.php");
		}
		break;
	}
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>