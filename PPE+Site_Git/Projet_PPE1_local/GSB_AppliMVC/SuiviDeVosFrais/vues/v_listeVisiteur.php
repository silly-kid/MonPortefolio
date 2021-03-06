
 <div id="contenu">
    <h2>Validation des Fiches de Frais</h2>
    <h3>Fiche &agrave; s&eacute;lectionner</h3>
    <form action="index.php?uc=validationFicheFrais&action=selectionnerMois" method="post" id="idFormVisiteur">
    <input type="hidden" id="idVisiteurChoisi" name="idVisiteurChoisi" value="">
    </form>
    
    <form action="index.php?uc=validationFicheFrais&action=voirEtatFrais" method="post">
        <div class="corpsForm">
            <p>
                <label for="lstVisiteur" accesskey="n">Visiteurs : </label>
                <select id="lstVisiteur" name="lstVisiteur">
                	<option value="">Choisissez un visiteur</option>
                    <?php
                    foreach ($tabVisiteurs as $unVisiteur) {
                        ?>
                        <option onclick="chargerLesMois(this);" value="<?php echo $unVisiteur['id']; ?>" <?php if($idVisiteurChoisi == $unVisiteur['id']){ ?>selected <?php } ?> ><?php echo $unVisiteur['prenom'] . " " . $unVisiteur['nom']; ?></option>
                        <?php
                    }
                    ?>
                </select> 
            </p>
            <p>
	 
        		<label for="lstMois" accesskey="n">Mois : </label>
        			<select id="lstMois" name="lstMois">
        			<option value="" <?php if($moisASelectionner == ""){ ?>  selected <?php } ?>  ></option>
            	<?php
					foreach ($lesMois as $unMois)
					{
			    		$mois = $unMois['mois'];
						$numAnnee =  $unMois['numAnnee'];
						$numMois =  $unMois['numMois'];
					if($mois == $moisASelectionner){
				?>
				<option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
					}
					else{ ?>
					<option value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
					<?php 
					}
			
				}
	           
			   ?>    
            
        </select>
      </p>
        </div>
        <div class="piedForm">
            <p>
                <input id="ok" type="submit" value="Valider" size="20" />
            </p> 
        </div>
    </form>
</div>
<script type="text/javascript"> //quand un visiteur est choisi, on propose les mois

	function chargerLesMois(obj){ //chargement des mois en fonction du visiteur choisi
		document.getElementById("idVisiteurChoisi").value = obj.value;
		document.getElementById("idFormVisiteur").submit();
	}

</script>