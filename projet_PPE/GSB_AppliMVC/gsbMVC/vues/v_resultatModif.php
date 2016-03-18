<h3>Vue modification : Fiche de frais du mois <?php echo $numMois."-".$numAnnee?> : </h3>
    <div class="encadre">
    <form action="index.php?uc=validationFicheFrais&action=validFrais" method="post">
    <p>
        Etat : <?php echo $libEtat ?> depuis le <?php echo $dateModif ?> <br> Montant validé : <?php echo $montantValide ?>
   </p>
   
  	<table class="listeLegere">
  	   <caption><u>Eléments forfaitisés </u></caption>
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
        <form action="index.php?uc=validationFicheFrais&action=validFrais" method="post">
        <?php
          foreach (  $lesFraisForfait as $unFraisForfait  ) 
		  {
		  		$idFrais = $unFraisForfait['idfrais'];
				$quantite = $unFraisForfait['quantite'];
		?>
                <td class="qteForfait"><input type="text"  name="lesFrais[<?php echo $idFrais?>]" value="<?php echo $quantite ?>" size="10" /></td>
                
		 <?php
          }
		?>
		
		</tr>
		
    </table>
</br>
 	</form> 
    
    
  	<table class="listeLegere">
  	   <caption><u>Descriptif des éléments hors forfait :</u></caption>
  	   <caption> 
  	   nombre de justificatifs reçus :<?php echo $nbJustificatifs ?> 
  	  </caption>
             <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class='montant'>Montant</th>
                                
             </tr>
        <?php      
          foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
		  {
			$date = $unFraisHorsForfait['date'];
			$libelle = $unFraisHorsForfait['libelle'];
			$montant = $unFraisHorsForfait['montant'];
			$id = $unFraisHorsForfait['id'];
			
			$report =  "<input type='button' name='btnReportRefus' value='Reporter'>";
			$refuser =  "<input type='button' name='btnReportRefus' value='Refuser'>";
			
			
			
			
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
</div>
  </div>

  