<h3>Fiche de frais du mois <?php echo $numMois."-".$numAnnee?> : </h3>
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
    
     <p>Legend pour les types de vehicule :</p>
			<ul>
			<li> 1 = (Véhicule 4CV Diesel) </li>
			<li> 2 = (Véhicule 5/6CV Diesel) </li>
			<li> 3 = (Véhicule 4CV Essence) </li>
			<li> 4 = (Véhicule 5/6CV Essence) </li>
			</ul>
			<p>
			Prix au kilomètre selon la puissance du véhicule déclaré auprès des services comptables :
			</p>
			<ul>
				<li>(Véhicule 4CV Diesel) 0.52 € / Km</li>
				<li>(Véhicule 5/6CV Diesel) 0.58 € / Km</li>
				<li>(Véhicule 4CV Essence) 0.62 € / Km</li>
				<li>(Véhicule 5/6CV Essence) 0.67 € / Km</li>
			</ul>
	<p>Total frais kilométrique enfonction du vehicule : <?php echo $km[0] . " x " . $vehicule1 . " = " .$resultat ?></p> 
	
    <div class="piedForm">
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" /> 
   
    </div>
	</p>
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
                 
                <td><a href="index.php?uc=validationFicheFrais&action=reportRefus&btnReportRefus=Reporter&id=<?php echo $id ?>&libelle=<?php echo $libelle ?>"><?php echo $report ?></a></td>
                <?php  if ($libelle[0] == 'R') {?> <a></a> <?php } else {?> 
                <td><a href="index.php?uc=validationFicheFrais&action=reportRefus&btnReportRefus=Refuser&id=<?php echo $id ?>&libelle=<?php echo $libelle ?>"><?php echo $refuser ?></a></td>
                <?php } ?>
             </tr>
        <?php 
          }
		?>
    </table>
     <b><?php if($lesFraisHorsForfait == NULL){ echo "pas de fairs hors forfait pour ce mois";} ?></b>
    <div class="piedForm">
      <p>
      <?php $valider = "<input type='button' name='btnValideFiche' value='Valider'>"; ?>
      <td><a href="index.php?uc=validationFicheFrais&action=validFiche"><?php echo $valider ?></a></td>
      
      </p> 
</div>
</form>
  </div>
  </div>