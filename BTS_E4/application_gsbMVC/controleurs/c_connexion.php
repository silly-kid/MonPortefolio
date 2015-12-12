<?php
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
		$visiteur = $pdo->getInfosVisiteur($login,$mdp);
		$comptable = $pdo->getInfosComptable($login, $mdp);
		if ($comptable == NULL){
			if(!is_array( $visiteur)){
				ajouterErreur("Login ou mot de passe visiteur incorrect");
				include("vues/v_erreurs.php");
				include("vues/v_connexion.php");
			}
		}
		elseif ($visiteur == Null){
			if(!is_array( $comptable)){
			ajouterErreur("Login ou mot de passe comptable incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
			}
		}
		elseif(is_array( $visiteur)){
			$id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
			connecter($id,$nom,$prenom);
			include("vues/v_sommaire.php");
		}
		else{
			$id = $comptable['id'];
			$nom = $comptable['nom'];
			$prenom = $comptable['prenom'];
			connecter_comptable($id,$nom,$prenom);
			include("vues/v_sommaire_comptable.php");
		}
		break;
	}
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>