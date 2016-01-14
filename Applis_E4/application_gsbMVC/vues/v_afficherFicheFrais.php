<?php
/**
 * Vue permettant d'afficher les fiches de frais avec l'idEtat 'CL' et 'VA'
 *
 * @author denis BEKAERT
 * @package default
 * @version 2.0
 *
 */
?>
<div id="contenu">
    <h3>Suivie du paiement des fiches de frais</h3>
        <div class="corpsForm">
            <table class="listeLegere">
                <caption>Liste des fiches de frais à régler et non validées</caption>
                <tr><?php
                $tabFicheFrais = array('Visiteur', 'Mois','Montant',
                    'Etat de la fiche', '');
                foreach ($tabFicheFrais as $uneEntree){?>
                    <th><?php
                    echo $uneEntree;?>
                    </th><?php
                }?>
                </tr><?php
                    // Parcour du tableau de fiches de frais
                    foreach ($lesFichesDeFrais as $uneFicheDeFrais){?>
                        <tr><?php
                            // Variables nécessaires
                            $idVisiteur = htmlspecialchars
                                    ($uneFicheDeFrais['id'], ENT_QUOTES);
                            $prenom = htmlspecialchars
                                    ($uneFicheDeFrais['prenom'], ENT_QUOTES);
                            $nom = htmlspecialchars
                                    ($uneFicheDeFrais['nom'], ENT_QUOTES);
                            $mois = htmlspecialchars
                                    ($uneFicheDeFrais['mois'], ENT_QUOTES);
                            $leMois = substr($mois, 4, 2).'/'.substr($mois, 0, 4);
                            $montant = htmlspecialchars(
                                    $uneFicheDeFrais['montantValide'], ENT_QUOTES);
                            $idEtat = htmlspecialchars(
                                    $uneFicheDeFrais['idEtat'], ENT_QUOTES);
                            $leMoisActuel = date('Y').date('m').date('d');
                            $leMoisControle = substr($leMois, 3, 4).substr
                                    ($leMois, 0, 2).'10';
                             $href = "index.php?uc=validerFrais&"
                                     . "action=voirFicheFrais";
                            
                            // Variables pour les fiche de frais Validées
                            if ($idEtat == 'VA'){
                            $etat = 'Validée et mis en paiement';
                            
                            // Variables pour les fiches de frais Cloturées
                            }elseif ($idEtat == 'CL'){
                                $etat = 'Fiche non validée!';
                            }
                            ?>
                            <!-- Remplissage ligne par ligne des infos -->
                            <td><?php 
                                echo $prenom.' '.$nom?>
                            </td>
                            <td><?php
                                echo substr($mois, 4, 2)."/".  substr($mois, 0, 4)?>
                            </td>
                            <td><?php
                                echo $montant?>
                            </td>
                            <td><?php
                                echo $etat?>
                            </td>
                            <td>
                                <!-- options possible sur la fiche de frais -->
                                <a href=<?php echo $href
                                        ."&idVisiteur=".$idVisiteur
                                        ."&mois=".$mois
                                        ."&montantValide=".$montant
                                        ."&nom=".$nom
                                        ."&prenom=".$prenom?>>
                                voir la fiche</a>
                            </td>
                        </tr><?php
                    }?>
            </table>
        </div>
</div>