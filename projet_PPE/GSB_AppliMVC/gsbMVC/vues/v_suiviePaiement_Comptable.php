<h3>Fiche de frais du mois <?php echo $numMois."-".$numAnnee?> : 
    </h3>
    <div class="encadre">
    <p>
        Etat : <?php echo $libEtat?> depuis le <?php echo $dateModif?> <br> Montant valid� : <?php echo $montantValide?>
              
                     
    </p>
  	<table class="listeLegere">
  	   <caption>El�ments forfaitis�s </caption>
        <tr>
         <?php
         foreach ( $lesFraisForfait as $unFraisForfait ) 
		 {
			$libelle = $unFraisForfait['libelle'];
		?>	
			<th> <?php echo $libelle?></th>
		 <?php
        }
		?>
		</tr>
        <tr>
        <?php
          foreach (  $lesFraisForfait as $unFraisForfait  ) 
		  {
				$quantite = $unFraisForfait['quantite'];
		?>
                <td class="qteForfait"><?php echo $quantite?> </td>
		 <?php
          }
		?>
		</tr>
    </table>
  	<table class="listeLegere">
  	   <caption>Descriptif des �l�ments hors forfait -<?php echo $nbJustificatifs ?> justificatifs re�us -
       </caption>
             <tr>
                <th class="date">Date</th>
                <th class="libelle">Libell�</th>
                <th class='montant'>Montant</th>                
             </tr>
        <?php      
          foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
		  {
			$date = $unFraisHorsForfait['date'];
			$libelle = $unFraisHorsForfait['libelle'];
			$montant = $unFraisHorsForfait['montant'];
		?>
             <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
             </tr>
        <?php 
          }
		?>
    </table>
    <div class="piedForm">
      <p>
      
      <?php $valider = "<input type='button' name='btnValidSuivie' value='Valider'>"; ?>
      <td><a href="index.php?uc=validationFicheFrais&action=remboursement"><?php echo $valider ?></a></td>
      
      </p> 
</div>
  </div>
  </div>
 
