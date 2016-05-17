
<h3>Fiche de frais du mois <?php echo $numMois."-".$numAnnee?> : 
    </h3>
    <div class="encadre">
    <p>
        Etat : <?php echo $libEtat?> depuis le <?php echo $dateModif?> <br> Montant validé : <?php echo $montantValide?>
              
                     
    </p>
  	<table class="listeLegere">
  	   <caption>Eléments forfaitisés </caption>
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
	<p>Total frais kilométrique enfonction du vehicule : <?php if (isset ($resultat)){echo $km[0] . " x " . $vehicule1 . " = " .$resultat ;}else {echo "aucun type de vehicule choisi";}?></p>
    
  	<table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait -<?php echo $nbJustificatifs ?> justificatifs reçus -
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
    <b><?php if($lesFraisHorsForfait == NULL){ echo "pas de fairs hors forfait pour ce mois";} ?></b>
  </div>
  </div>
 













