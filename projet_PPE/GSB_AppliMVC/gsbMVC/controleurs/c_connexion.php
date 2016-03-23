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
		
		//crypter mdp
		$texte = trim($_POST['mdp']);
		$texte1 = SHA1('$mdp');
		$mdp = $texte1;
		if($mdp){
			echo "  le mdp a bien ete crypté  ";
		}else echo "  error  ";
					
		$pdo->majCryptMdp($login, $mdp, $texte1);	     
		//fin
		 
		$visiteur = $pdo->getInfosVisiteur($login,$mdp);
	
		if(!is_array( $visiteur)) {
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
		else if(is_array( $visiteur)&& $texte1 == $mdp){
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