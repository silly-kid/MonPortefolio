<!-- <script> alert("ddddddd"); </script> -->
<?php
include "fonctions.php"; //fonction avec le fichier fonction.php
if (isset($_REQUEST["op"])) {

	if ($_REQUEST["op"]=="fraishf") {
		
		$id = $_REQUEST["id"];
		$montant = $_REQUEST["montant"];
		$motif = $_REQUEST["motif"];
		$jour = $_REQUEST["jour"];
		
		try {
			$cnx = connexionPDO();
			
			$RequeteHf="INSERT INTO fraishf (id, montant, motif, jour) VALUES ('".$id."','".$montant."', '".$motif."', '".$jour."');";
			echo $RequeteHf;
			$req5 = $cnx->prepare($RequeteHf);
			$req5->execute();
			}
			
		} catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}elseif ($_REQUEST["op"]=="enreg") {
		
		// récupération des paramètres en post
		echo " ajout des paramettres";

		$id = $_REQUEST["id"];
		$km = $_REQUEST["km"];
		$etape = $_REQUEST["etape"];
		$nuitee = $_REQUEST["nuitee"];
		$repas = $_REQUEST["repas"];
		
		print "*".$km."*".$etape."*".$nuitee."*".$repas."*" ;
	
		// insertion dans la base de données
		try {
			$cnx = connexionPDO(); //connection
			$RequeteVerifSaisie="SELECT id from fraismois where id = '".$id."' ";
			$req1= $cnx->prepare($RequeteVerifSaisie);
			$req1->execute();
			$nbIdfrais = $req1->fetch();
			if (!empty($nbIdfrais["id"])){
				$RequeteUpdate="UPDATE fraismois SET km='".$km."', etape='".$etape."', nuitee='".$nuitee."', repas='".$repas."' where id = '".$id."' ";
				echo $RequeteUpdate;
				$req2= $cnx->prepare($RequeteUpdate);
				$req2->execute();
			}
			else{
				$Requete="INSERT INTO fraismois (id, km, etape, nuitee, repas) VALUES ('".$id."','".$km."', '".$etape."', '".$nuitee."', '".$repas."');"; //ajout des données dans bdd
				echo "Ma requete : ".$Requete;
				$req = $cnx->prepare($Requete);
				$req->execute();
				echo "requete execute";
			}
		}catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage(); //en cas d'erreur 
			die();
		}
	}elseif ($_REQUEST["op"]=="supprHf") {
		
		$id = $_REQUEST["id"];
		
		
		try {
			$cnx = connexionPDO();
			$RequeteHfsupp="DELETE FROM fraishf where id='".$id."' ;"; 
			echo $RequeteHfsupp;
			$req4 = $cnx->prepare($RequeteHfsupp);
			$req4->execute();
			
		} catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage();
			die();
		}
		
		
		
	}elseif ($_REQUEST["op"]=="login") {
		
		$login = $_REQUEST["login"];
		$mdp = $_REQUEST["mdp"];
		$id = $_REQUEST["id"];
		
		try {
			$cnx = connexionPDO(); //connection
			$RequeteVerifSaisie="SELECT * FROM visiteur where login='".$login."' ";
			$req1= $cnx->prepare($RequeteVerifSaisie);
			$req1->execute();
			$nbIdfrais = $req1->fetch();
			if (!empty($nbIdfrais["id"])){
				$RegMessage="Login ou mot de passe incorect"; 
				echo $RequeteMessage;
				
			}else{
				$Requetelogin="Connection ok";
				echo "Ma requete : ".$Requetelogin;
				
			}
		}catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage(); //en cas d'erreur 
			die();
		}		
		
	}
}
?>