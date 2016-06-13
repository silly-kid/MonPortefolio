<div id="contenu">
      <h2>Renseigner ma fiche de frais du mois <?php echo $numMois."-".$numAnnee ?></h2>
         
      <form method="POST"  action="index.php?uc=gererFrais&action=validerMajFraisForfait">
      <div class="corpsForm">
          
          <fieldset>
            <legend>Eléments forfaitisés
            </legend>
			<?php
				foreach ($lesFraisForfait as $unFrais)
				{
					$idFrais = $unFrais['idfrais'];
					$libelle = $unFrais['libelle'];
					$quantite = $unFrais['quantite'];
			?>
					<p>
						<label for="idFrais"><?php echo $libelle ?></label>
						<input type="text" id="idFrais" name="lesFrais[<?php echo $idFrais?>]" size="10" maxlength="5" value="<?php echo $quantite?>" > <!- ->
					</p>
			
			<?php
				}
			?>
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
			
			
			
           
          </fieldset>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>
  