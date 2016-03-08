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
			$button = "<td class='qteForfait'><input type='button' value='Modifier'></td>";
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
		<a href="index.php?uc=validationFicheFrais&action=validFrais"><td><?php echo $button ?> </td></a>
		</tr>
		
    </table>
  	<table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait : 
  	   <?php echo $nbJustificatifs ?> nombre de justificatifs reçus
  	  
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
			
			$report = "<td><input type='button' name='btnReportRefus' value='Reporter'></td>";
			$refuser = "<td><input type='button' name='btnReportRefus' value='Refuser'></td>";
			
			
			
			
		?>
             <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
                 
                <td><a href="index.php?uc=validationFicheFrais&action=reportRefus"><?php echo $report ?></a></td>
                <td><a href="index.php?uc=validationFicheFrais&action=reportRefus"><?php echo $refuser ?></a></td>
             </tr>
        <?php 
          }
		?>
    </table>
    <div class="piedForm">
      <p>
        <input href="index.php?uc=validationFicheFrais&action=validFiche" type='submit' name='btsValidFrais'  value='Valider'>
      </p> 
</div>
  </div>
  </div>
 
