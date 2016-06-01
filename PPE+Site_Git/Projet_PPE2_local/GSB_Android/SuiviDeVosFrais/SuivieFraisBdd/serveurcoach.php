<!-- <script> alert("ddddddd"); </script> -->
<?php
include "fonctions.php";


//if (isset($_REQUEST["op"])) {
echo "ddddddddd" ;
	/*if ($_REQUEST["op"]=="recup") {

		try {
			$cnx = connexionPDO();
			$req = $cnx->prepare("select * from fraismois");
			$req->execute();
		  
			while ($ligne = $req->fetch(PDO::FETCH_ASSOC)){
				$resultat[]=$ligne;
			}
			print(json_encode($resultat));
			
		} catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage();
			die();
		}

	}elseif ($_REQUEST["op"]=="enreg") {//*/

		// récupération des paramètres en post
		$km = $_REQUEST["km"] ;
		$etape = $_REQUEST["etape"] ;
		$nuitee = $_REQUEST["nuitee"] ;
		$repas = $_REQUEST["repas"] ;
print "*".$km."*".$etape."*".$nuitee."*".$repas."*" ;	
		// insertion dans la base de données
		try {
			$cnx = connexionPDO();
			$req = $cnx->prepare("insert into fraismois (km, etape, nuitee, repas) values ( $km, $etape, $nuitee, $repas)");
			$req->execute();
			
		} catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage();
			die();
		}

	//}

//}

?>