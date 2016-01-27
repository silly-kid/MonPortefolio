    <!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    
        <h2>
    
</h2>
    
      </div>  
        <ul id="menuList">
        	<?php  if($_SESSION['statut'] == "visiteur"){?>
			<li >
				  Visiteur :<br>
				<?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?>
			</li>
           <li class="smenu">
              <a href="index.php?uc=gererFrais&action=saisirFrais" title="Saisie fiche de frais ">Saisie fiche de frais</a>
           </li>
           <li class="smenu">
              <a href="index.php?uc=etatFrais&action=selectionnerMois" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
           </li>
 	   <li class="smenu">
              <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
           </li>
           <?php }else{?>
           <li >
				  Comptable :<br>
				<?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?>
			</li>
      		<li class="smenu">
				<a href="index.php?uc=validationFicheFrais&action=selectionnerVisiteur" title="Valider fiche de frais">Validation fiche de frais</a>
       		</li>
        	<li class="smenu">
            	<a href="index.php?uc=suiviPaiement&action=selectionnerFrais" title="Suivie fiche de frais">Suivie fiche de frais</a>
       		</li>
       		<li class="smenu">
              <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
           </li>
       		    <?php } ?>
         </ul>
        
    </div>
    