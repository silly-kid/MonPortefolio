<form class="form-horizontal" method="post" action="index.php?uc=validFrais&action=validFrais">

<div class="page-header"><h2>Validation des frais par visiteur</h2></div>

<div class="page-header"><h3>Rechercher un visiteur</h3></div>

  <div class="form-group">
    <label for="lesVisiteur" class="col-sm-2 control-label">Choisir le visiteur</label>
    <div class="col-sm-3">
        <select class="form-control" name="lesVisiteur">
          <?php echo $lesVisiteursRangeOption->toString(); ?>
        </select>
    </div>
  </div>
  <div class="form-group">
    <label for="annee" class="col-sm-2 control-label">Année</label>
    <div class="col-sm-3">
        <select class="form-control" name="annee">
          <?php echo $lesDatesOption->toString(); ?>
        </select>
    </div>
  </div>
  <div class="form-group">
    <label for="mois" class="col-sm-2 control-label">Mois</label>
    <div class="col-sm-3">
        <select class="form-control" name="mois">
          <?php echo $lesmoisRangeOption->toString(); ?>
        </select>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-3">
      <button type="submit" class="btn btn-primary" name="BTNValide">Valider</button>
      <button type="reset" class="btn btn-danger">Réinitialiser</button>
    </div>
  </div>

<div class="page-header"><h3>Frais au forfait</h3></div>

<table class="table table-hover table-bordered table-striped">
    <thead>
        <tr>
            <th>Repas midi</th>
            <th>Nuitée</th>
            <th>Etape</th>
            <th>Km</th>
            <th>Situation</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><input type="text" class="form-control" name="repas" value="<?php echo !empty($lesFicheFraisget) ? $lesFicheFraisget[3]['quantite'] : 0; ?>" /></td>
            <td><input type="text" class="form-control" name="nuitee" value="<?php echo !empty($lesFicheFraisget) ? $lesFicheFraisget[2]['quantite'] : 0; ?>" /></td> 
            <td><input type="text" class="form-control" name="etape" value="<?php echo !empty($lesFicheFraisget) ? $lesFicheFraisget[0]['quantite'] : 0; ?>" /></td>
            <td><input type="text" class="form-control" name="km" value="<?php echo !empty($lesFicheFraisget) ? $lesFicheFraisget[1]['quantite'] : 0; ?>" /></td>
            <td> 
                <select class="form-control" name="situ">
                    <?php echo $lesSituOption->toString(); ?>
                </select>
            </td>
        </tr>
    </tbody>
</table>

<div class="page-header"><h3>Frais hors forfait</h3></div>

<table class="table table-hover table-bordered table-striped">
    <thead>
        <tr>
            <th>Date</th>
            <th>Libellé</th>
            <th>Montant</th>
            <th>Situation</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($lesfichefraishorsget as $value){ ?>
        <tr align="center">
            <td><input type="text" class="form-control" name="hfDate<?php echo $value['id']; ?>" readonly value="<?php echo !empty($lesfichefraishorsget) ? $value['date'] : 0; ?>" /></td>
            <td><input type="text" class="form-control" name="hfLib<?php echo $value['id']; ?>" value="<?php echo !empty($lesfichefraishorsget) ? $value['libelle'] : 0; ?>" /></td> 
            <td><input type="text" class="form-control" name="hfMont<?php echo $value['id']; ?>" value="<?php echo !empty($lesfichefraishorsget) ? $value['montant'] : 0; ?>" /></td>
            <td> 
            <select class="form-control" name="situhors<?php echo $value['id']; ?>">
            <?php $a = new RangeOption($lesSitu, array("value" => "value", "name" => "name", "correspondance" => "value"), $value['idEtat']); ?>
            <?php echo $a->toString(); ?>
            ?>
            </select>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<div class="form-group">
<label for="hcMontant" class="col-sm-2 control-label">Justificatif</label>
<div class="col-sm-3">
  <input type="number" step="1" class="form-control" id="hcMontant" name="hcMontant" placeholder="Nombre">
</div>
</div>

<div class="form-group">
<div class="col-sm-offset-2 col-sm-3">
  <button type="submit" class="btn btn-primary" name="BTNSubmit">Valider</button>
  <button type="reset" class="btn btn-danger">Réinitialiser</button>
</div>
</div>

</form>
