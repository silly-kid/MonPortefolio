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
	case 'demandeConnexion':{ //demande de connection
		include("vues/v_connexion.php"); //vue pour se connecter
		break;
	}
	case 'valideConnexion':{ //validation de la connection
		$login = $_REQUEST['login']; //recupération du login
		$mdp = $_REQUEST['mdp']; //recupération du mot de passe
		
		
		//crypter le mot de passe
		echo "mdp avant d'être crypté : ";
		echo $mdp;
		
		//$texte = trim($_POST['mdp']);//recupère le mdp avec la méthode POST + trim () retourne chaine et suppr char inv
		$texte1 = SHA1($mdp); //cryptage du mdp en SHA1
		$mdp = $texte1;
		if($mdp){
			ajouterErreur("Le mot de passe a bien été crypté");//message pour le mdp est bien crypté
			include("vues/v_erreurs.php");
			
		}else {
				ajouterErreur("Erreur crypt mot de passe");//message il y a eu un prob
				include("vues/v_erreurs.php");
		}
					
		//$pdo->majCryptMdp($login, $mdp, $texte1); //envoie du mdp crypté dans bdd
		$visiteur = $pdo->getInfosVisiteur($login,$mdp); //recupération des infos du visiteurs
		$tentative = $pdo->getTentative($login); //récupère nm de tentative
		
		echo "le nmb de tentative :";
		echo $tentative[0];
		echo " le mdp crypté : ";
		echo $mdp;
	
		if(!is_array( $visiteur)) {//en cas d'erreur
			if($tentative[0] > 5){
				ajouterErreur("Trop de tentative, contacter le responsable");//message il y a eu un prob
				include("vues/v_erreurs.php");
				//inclure vues pour changer de mdp : include("vues/v_changermdp.php);
			}	
			else{
			ajouterErreur("Login ou mot de passe incorrect");//message d'erreur
			$tentative[0] = $tentative[0] + 1; //ajout de 1 aux nmb de tentative
			echo $tentative[0];
			include("vues/v_erreurs.php"); //vue des erreurs
			include("vues/v_connexion.php"); }//vue de connexion pour recommencer
		}
		else if(is_array( $visiteur)){ //connexion avec le mdp crypté et les infos ok .&& $texte1 == $mdp
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