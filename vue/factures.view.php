<html>
    <head>
        <meta charset="utf-8">
        <title>Liste des factures</title>
        <link rel="stylesheet" href="../vue/css/facture_liste.css">
    </head>
    <body>
        <div id="div_facture_liste_titre" class="divtitre">Liste des factures</div>

        <table id="table_facture">
        
                <tr>
                    <th></th>
                    <th>Numéro</th>
                    <th>Le</th>
                    <th>Client</th>
                    <th></th>
                    <th></th>
                    <th>Sans remise</th>
                    <th>Avec remise</th>
                    <th>Livraison</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                    foreach($lignes as $ligne) {
                        echo $ligne; // tableau de lignes à créer dans /controleur/factures.php
                    }
                ?>
        </table>

        <div class="divaction">
            <a href="editFact.php?op=a" class="ajout">Ajouter une salle</a>
        </div>
    </body>
</html>