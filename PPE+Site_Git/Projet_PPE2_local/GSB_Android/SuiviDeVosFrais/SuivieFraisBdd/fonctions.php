<?php
    function connexionPDO(){
        $login="root"; //login
        $mdp="";		//mot de passe
        $bd="gbs_frais_android"; //nom de la bse de donnée
        $serveur="localhost"; //localhost 
        try {
            $conn = new PDO("mysql:host=$serveur;dbname=$bd", $login, $mdp); //connection
            return $conn;
			echo "connection ok";
        } catch (PDOException $e) {
            print "Erreur de connexion PDO :prb connection bdd"; //en cas d'erreur
            die();
        }
    }
?>
