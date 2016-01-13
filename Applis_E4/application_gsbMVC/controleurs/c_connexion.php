<?php
// Si $_REQUEST['action'] n’existe pas on crée une entrée $_REQUEST['action']
// avec comme valeur 'demandeConnexion'

if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}

$action = $_REQUEST['action'];
switch($action){
	case 'demandeConnexion':{
		/**
		 * Inclus "vue/v_connexion.php"
		 * Affiche la vue permettant à l'utilisateur de saisir les données nécessaires
		 * à la connexion
		 */
		include("vues/v_connexion.php");
		break;
	}
	// Tentative de connexion
	case 'valideConnexion':{
		$login = $_REQUEST['login'];
		$mdp = $_REQUEST['mdp'];
		$visiteur = $pdo->getInfosVisiteur($login, $mdp);
		$comptable = $pdo->getInfosComptable($login, $mdp);
		// Connection échouée
		if ($comptable == FALSE && $visiteur == FALSE){
			ajouterErreur("Login ou mot de passe visiteur ou comptable incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
		// Connexion réussie
		else if(is_array( $visiteur)){
			$id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
			connecter($id,$nom,$prenom);
			include("vues/v_sommaire.php");
			include("vues/v_contenuVide.php");
		}
		else if(is_array( $comptable)){
			$id = $comptable['id'];
			$nom = $comptable['nom'];
			$prenom = $comptable['prenom'];
			connecter_comptable($id,$nom,$prenom);
			include("vues/v_sommaire.php");
			include("vues/v_contenuVide.php");
		}
		break;
	}
	case 'deconnexion':{
		session_destroy();
		header("Location: index.php");
		break;
	}
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>