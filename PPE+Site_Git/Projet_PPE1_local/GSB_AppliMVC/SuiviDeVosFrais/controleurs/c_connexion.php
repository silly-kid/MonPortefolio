<?php

/**
 * Contrôleur de connexion
 * @author Flora Carriere
 */

if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion'; //demande de connexion
}
$action = $_REQUEST['action']; //recupère action
switch($action){
	case 'demandeConnexion':{
		include("vues/v_connexion.php"); //vue pour se connecter
		break;
	}
	case 'valideConnexion':{ //validation de la connection
		$login = $_REQUEST['login']; //recupération du login
		$mdp = $_REQUEST['mdp']; //recupération du mot de passe
		
		//crypter mdp
		$texte = trim($_POST['mdp']);
		$texte1 = SHA1('$mdp'); //cryptage du mdp en SHA1
		$mdp = $texte1;
		if($mdp){
			echo "  le mdp a bien ete crypté  ";
		}else echo "  error : problème mdp non crypté  ";
					
		$pdo->majCryptMdp($login, $mdp, $texte1); //envoie du mdp crypté dans bdd	     
		
		 
		$visiteur = $pdo->getInfosVisiteur($login,$mdp); //recupération des infos
	
		if(!is_array( $visiteur)) { //en cas d'erreur
			ajouterErreur("Login ou mot de passe incorrect");//message d'erreur
			include("vues/v_erreurs.php"); //vue des erreurs
			include("vues/v_connexion.php"); //vue de connexion
		}
		else if(is_array( $visiteur)&& $texte1 == $mdp){ //connexion avec le mdp crypté et les infos ok 
			$id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
			$statut = $visiteur['statut']; //définie le type visiteur ou comptable
			connecter($id,$nom,$prenom,$statut); //connection avec les infos 
			include("vues/v_sommaire.php"); //vue du sommaire en fonction du type de visiteur
		}
		break;
	}
	default :{
		include("vues/v_connexion.php"); //vue pour se connecter 
		break;
	}
}
?>