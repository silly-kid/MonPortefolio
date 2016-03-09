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
			$modifier = "<input type='button' name='btnModifier' value='Modifier'>";
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
		<td><a href="index.php?uc=validationFicheFrais&action=validFrais"><?php echo $modifier ?></a></td>
		</tr>
		
    </table>
  	<table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait :</caption>
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
                 
                <td><a href="index.php?uc=validationFicheFrais&action=reportRefus&btnReportRefus=Reporter&id=<?php echo $id ?>&libelle=<?php echo $libelle ?>"><?php echo $report ?></a></td>
                <?php  if ($libelle[0] == 'R') {?> <a></a> <?php } else {?> 
                <td><a href="index.php?uc=validationFicheFrais&action=reportRefus&btnReportRefus=Refuser&id=<?php echo $id ?>&libelle=<?php echo $libelle ?>"><?php echo $refuser ?></a></td>
                <?php } ?>
             </tr>
        <?php 
          }
		?>
    </table>
    <div class="piedForm">
      <p>
      
      <?php $valider = "<input type='button' name='btnValideFiche' value='Valider'>"; ?>
      <td><a href="index.php?uc=validationFicheFrais&action=validFiche"><?php echo $valider ?></a></td>
      
      </p> 
</div>
</form>
  </div>
  </div>
 
