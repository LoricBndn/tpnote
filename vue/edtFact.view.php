<html>
    <head>
        <meta charset="utf-8">
        <title>Liste des factures</title>
        <link rel="stylesheet" href="../vue/css/facture_edit.css">
        <link rel="stylesheet" href="../vue/css/facture_liste.css">
    </head>
    <body>
        <div id="div_facture_liste_titre" class="divtitre">Détail d'une facture</div>
        <div id="div_facture_detail">
            <div class="facture_rubriquee">
                <div>
                    <span class="labeltitre">IDENTIFICATION</span>
                </div>
                <div>
                    <label for="edt_facture_num">Numéro</label>
                    <span><input id="edt_facture_num" placeholder="n° facture" size="5" type="text" value="<?= $valeurs['num'] ?>"></span>
                </div>
                <div>
                    <label for="edt_facture_date">le</label>
                    <span>
                        <input id="edt_facture_date" size="10" type="date" value="<?= $valeurs['date'] ?>">
                    </span>
                    <span><textarea id="edt_facture_commentaire" placeholder="Commentaire non obligatoire" cols="140"
                    rows="4" value="<?= $valeurs['commentaire'] ?>"></textarea></span>
                </div>
            </div>
            <div class="facture_rubrique">
                <div>
                    <span class="labeltitre">CLIENT</span>
                </div>
                <div>
                    <label for="edt_facture_codeclient">Code</label>
                    <span><input id="edt_facture_codeclient" placeholder="n° client" size="5" type="text" value="<?= $valeurs['num'] ?>"></span>
                    <label id="lbl_facture_detail_client" class="facture_commentaire"><?= $detail['client'] ?></label>
                </div>
            </div>
            <div class="facture_rubrique">
                <div>
                    <span class="labeltitre">INFOS COMMERCIALES</span>
                </div>
                <div>
                    <label for="edt_facture_liv">Livraison</label>
                    <span>
                        <select id="select_livraison">
                            <?php
                                foreach ($forfaits as $cle=>$valeur){
                                    echo "<option value='$cle'";
                                    if ($cle == $valeurs['forfait']) {
                                        echo ' selected';
                                    }
                                    echo ">", $valeur, "</option>";
                                }
                            ?>
                        </select>
                    </span>
                    <label id="lbl_facture_detail_liv" class="facture_commentaire"><?= $detail['livraison'] ?></label>
                </div>
                <div>
                    <label for="edt_facture_remise">Remise</label>
                    <span>
                        <input type="number" id="edt_facture_remise" class="facture_remise" size="1"/>
                        <label for="edt_facture_remise">%</label>
                    </span>
                    <label class="labelerreur"><?= $erreurs['remise'] ?></label>
                </div>
                <div class="facture_sousrubrique">
                    <div id="div_facture_produit">
                        <div class="divtitre">
                            HT :
                            <label><?= $produit['ht'] ?></label>
                            - Remise :
                            <label><?= $produit['remise'] ?></label>
                            - A payer :
                            <label><?= $produit['apayer'] ?></label>
                        </div>
                        <table id="table_produit">
                            <thead>
                                <tr>
                                    <th>code</th>
                                    <th>libellé</th>
                                    <th>type</th>
                                    <th>origine</th>
                                    <th>conditionnement</th>
                                    <th>PU</th>
                                    <th>quantité</th>
                                    <th>montant</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($lignes as $ligne) {
                                        echo $ligne; // tableau de lignes à créer dans /controleur/factProd.php
                                    }
                                ?>
                            </tbody>
                        </table>
                    <div class="divaction">
                        <input id="btn_produit_ajouter" type="button" value="Ajouter">
                    </div>
                </div>
            </div>

                <div class="divaction">
                    <input id="btn_facture_retour" class="btnretour" value="Retour" type="button">
                    <input id="btn_facture_valider" value="Valider" type="button">
                    <input id="btn_facture_annuler" class="btnannuler" value="Annuler" type="button">
                </div>
            </div>
        </div>
    </body>
</html>