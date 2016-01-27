<?php
/**
 * Vue permettant de valider les frais forfaitisés d'une fiche de frais d'un
 * visiteur pour un mois donné
 *
 * @author denis BEKAERT
 * @package default
 * @version 2.0
 *
 */
?>
    <h3>Fiche de frais de <?php echo $leVisiteur?> du mois <?php echo $leMois?></h3>
    <form method="post" action="index.php?uc=validerFrais&action=actualiserFraisForfait">
        <div class="corpsForm">
            <!-- Affichage de l'état de la fiche de frais -->
            <h3>Etat de la fiche : <?php echo $lesInfosFicheFrais['libelle'];?></h3>
                <!-- Tableau des frais forfait -->
                <table class="listeLegere">
                    <caption>Frais au forfait</caption>
                    <tr><?php
                        foreach ($lesFraisForfait as $unFraisForfait){
                            $libelle = htmlspecialchars
                                    ($unFraisForfait['libelle'], ENT_QUOTES);?>
                            <th><?php echo $libelle?></th><?php
                        }?>
                    </tr>
                    <tr><?php
                        foreach ($lesFraisForfait as $unFraisForfait){
                            $libelle = htmlspecialchars
                                    ($unFraisForfait['libelle'], ENT_QUOTES);
                            $quantite = htmlspecialchars
                                    ($unFraisForfait['quantite'], ENT_QUOTES);
                            $idFrais = htmlspecialchars
                                    ($unFraisForfait['idFrais'], ENT_QUOTES);?>
                            <td class="qteForfait">
                                <input id="idFrais" size="18" 
                                       name="lesFrais[<?php echo $idFrais?>]"
                                       value="<?php echo $quantite?>">
                            </td><?php
                        }?>
                    </tr>
                </table>
                <br />
            <!-- Tableau des frais hors forfais -->
                <table class="listeLegere">
                    <caption>Frais hors forfait</caption>
                    <tr>
                        <th class="date">Date</th>
                        <th class="libelle">Libelle</th>
                        <th class="montant">Montant</th>
                        <th class='situation'>Situation</th>
                    </tr>
                    <?php foreach ($lesFraisHorsForfait as $unFraisHorsForfait){
                        $date = htmlspecialchars
                                ($unFraisHorsForfait['date'], ENT_QUOTES);
                        $montant = htmlspecialchars
                                ($unFraisHorsForfait['montant'], ENT_QUOTES);
                        $idFrais = htmlspecialchars
                                ($unFraisHorsForfait['id'], ENT_QUOTES);
                        $refuse = htmlspecialchars
                                ($unFraisHorsForfait['refuse'], ENT_QUOTES);
                        if($refuse == 1){
                            $libelle = "<b>[REFUSE]</b> ";
                        }
                        else{
                            $libelle = "";
                        }
                        $libelle .= htmlspecialchars
                                ($unFraisHorsForfait['libelle'], ENT_QUOTES);?>
                    <tr>
                        <td>
                            <?php echo $date?>
                        </td>
                        <td>
                            <?php echo $libelle?>
                        </td>
                        <td>
                            <?php echo $montant?>
                        </td>
                        <td>
                            <a href="index.php?uc=validerFrais&action=supprimerFraisHF&
                               idFrais=<?php echo $idFrais?>"
                               onclick="return confirm
                                   ('Voulez vous vraiment supprimer ce frais?')">
                                Supprimer</a>
                            <a href="index.php?uc=validerFrais&action=reporterFraisHF&
                               idFrais=<?php echo $idFrais?>"
                               onclick="return confirm
                                   ('Voulez vous vraiment reporter ce frais?')">
                            Reporter</a>
                        </td>
                    </tr><?php
                    }?>
                </table>
                <br />
                <?php $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];?>
                Nombre de justificatifs : <input id="nbJustif" name="nbJustif" size="5" 
                                                 value="<?php echo $nbJustificatifs?>">
            <br />
            <div class="piedForm">
                <input type="reset" id="Effacer" value="Effacer"
                       title="Efface les modifications saisies">
                <input type="submit" id="Actualiser" value="Actualiser" 
                       title="Actualise la fiche avec les nouvelles valeurs">
            </div>
            <br />
        </div>
    </form>
    <?php
    // Activation du bouton valider si nous somme au moins le 10 du mois
    // suivant de la date de la fiche de frais
    $leMoisActuel = date('Y').date('m').date('d');
    $leMoisControle = substr($leMois, 3, 4).  substr($leMois, 0, 2).'10';
    $result = $leMoisActuel - $leMoisControle;
    $idEtat = $lesInfosFicheFrais['idEtat'];
    if ($idEtat == 'CL'){?>
    <form method="post" action="index.php?uc=validerFrais&action=validerFrais">
        <br />
        <div class="piedForm"><?php
            if ($result >= 100){?>
            <input type="submit" id="Valider" value="Valider"
                   title="Valide la fiche définitivement"
                   onclick="return confirm
                       ('Attention! Avant de valider, pensez bien à actualiser tout\n\
changement.\n\n\
Aucune modifiction ne pourra être apporté après sa validation')"><?php
            }else{?>
            <input type="submit" id="Valider" value="Valider"
                   title="Validation possible à partir du 10" disabled=""><?php
            }?>
        </div>
    </form><?php
    }?>