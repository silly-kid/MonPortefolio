<h3>Fiche de frais du mois <?php echo $numMois."-".$numAnnee?> : 
    </h3>
    <div class="encadre">
    <form action="index.php?uc=validationFicheFrais&action=validFrais" method="post">
    <p>
        Etat : <?php echo $libEtat?> depuis le <?php echo $dateModif?> <br> 
        Montant validé : <?php echo $montantValide?>
              
                     
    </p>
  	<table class="listeLegere">
  	   <caption>Eléments forfaitisés </caption>
        <tr>
         <?php
         foreach ( $lesFraisForfait as $unFraisForfait ) 
		 {
			$libelle = $unFraisForfait['libelle'];
			$button = "<td class='qteForfait'><input type='submit' value='Modifier'></td>";
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
		<td><?php echo $button ?></td>
		</tr>
		
    </table>
  	<table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait : 
  	   <?php echo $nbJustificatifs ?> justificatifs reçus
  	  
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
			
			$report = "<td><input type='submit' name='btnReportRefus' value='Reporter'></td>";
			$refuser = "<td><input type='reset' name='btnReportRefus' value='Refuser'></td>";
			
			
			
			
		?>
             <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
                 
                <td><?php echo $report ?></td>
                <td><?php echo $refuser ?></td>
             </tr>
        <?php 
          }
		?>
    </table>
    <div class="piedForm">
      <p>
        <input type='submit' name='btsValidFrais'  value='Valider'>
      </p> 
</div>
  </div>
  </div>
 
