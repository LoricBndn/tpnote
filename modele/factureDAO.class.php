<?php
    require_once 'connexion.php';
    require_once 'facture.class.php';
    require_once 'forfaitDAO.class.php';
    require_once 'clientDAO.class.php';
    require_once 'prodByFactDAO.class.php';

class FactureDAO {
    private $bd;
    private $select;

    function __construct(){
        $this->bd = new Connexion();
        $this->select = 'SELECT num_fact, date_fact, comment_fact, taux_remise_fact, id_cli, id_forfait FROM facture';
    }
    
    function insert (Facture $facture) : void {
        $this->bd->execSQL("INSERT INTO CONTIENT (num_fact, date_fact, comment_fact, taux_remise_fact, id_cli, id_forfait)
                            VALUES (:numFact, :dateFact, :commentFact, :tauxRemiseFact, :idCli, :idForfait)",
                            [':numFact'=>$facture->getNumFact(), ':dateFact'=>$facture->getDateFact(),
                            ':commentFact'=>$facture->getCommentFact(), ':tauxRemiseFact'=>$facture->getTauxRemiseFact(), 
                            ':idCli'=>$facture->getClient()->getId(), ':idForfait'=>$facture->getForfait()->getId()]);
    }    

    function delete (string $numFact) : void {
        $this->bd->execSQL("DELETE FROM facture 
                            WHERE num_fact = :numFact", [':numFact'=>$numFact]);
    }

 
    function update (Facture $facture) : void {
        $this->bd->execSQL("UPDATE facture 
                            SET date_fact = :dateFact, comment_fact = :commentFact, taux_remise_fact = :tauxRemiseFact, 
                            id_cli = :idCli, id_forfait = :idForfait
                            WHERE num_fact = :numFact",
                            [':numFact'=>$facture->getNumFact(), ':dateFact'=>$facture->getDateFact(),
                            ':commentFact'=>$facture->getCommentFact(), ':tauxRemiseFact'=>$facture->getTauxRemiseFact(), 
                            ':idCli'=>$facture->getClient()->getId(), ':idForfait'=>$facture->getForfait()->getId()]);
    }    

    private function loadQuery (array $result) : array {
        $forfaitDAO = new ForfaitDAO(); 
        $clientDAO = new ClientDAO();
        $factures = [];
        foreach($result as $row) {
            $forfait = $forfaitDAO->getById($row['id_forfait']);
            $client = $clientDAO->getById($row['id_cli']);
            $facture = new Facture(); 
            $facture->setNumFact($row['num_fact']);
            $facture->setDateFact($row['date_fact']);
            $facture->setCommentFact($row['comment_fact']);
            $facture->setTauxRemiseFact($row['taux_remise_fact']);
            $facture->setClient($client);
            $facture->setForfait($forfait);
            $factures[] = $facture;
        }
        return $factures;
    }

    function getAll () : array {
        return ($this->loadQuery($this->bd->execSQLselect($this->select)));
    }

    function getByNum (string $numFact) : Facture {
        $uneFacture = new Facture();
        $lesFactures = $this->loadQuery($this->bd->execSQLselect($this->select ." WHERE
        num_fact = :numFact", [':numFact'=>$numFact]) );
        if (count($lesFactures) > 0) { 
            $uneFacture = $lesFactures[0]; 
        }
        return $uneFacture;
        // il y a un seul élément dans le tableau de factures ➔ indice 0 return $uneFacture;
    }	

    function existe (string $numFact) : bool {
        $req = "SELECT * 
                FROM facture 
                WHERE num_fact = :numFact";
        $res = ($this->loadQuery($this->bd->execSQLselect($req, [':numFact'=>$numFact])));
        return ($res != []); // si tableau de factures est vide alors la facture n’existe pas
    }

    function getTotalNbProd(string $numFact) : int {
        // Renvoie la quantité totale des produits d'une facture
        $res = $this->bd->execSQLselect("SELECT SUM(qte_prod) as total FROM ligne WHERE num_fact = :numFact", [':numFact'=>$numFact]);
		return (isset($res[0]['total'])) ? $res[0]['total'] : 0;
    }

    function getMontantTotalSansRemise(string $numFact) : int {
        $totalSansRemise = 0;
        $prodByFactDAO = new ProdByFactDAO();
        $produits = $this->bd->execSQLselect("SELECT code_prod FROM ligne WHERE num_fact = :numFact", [':numFact' => $numFact]);
        foreach ($produits as $produit) {
            $codeProd = $produit['code_prod'];
            $totalSansRemise += $prodByFactDAO->getMontantProduit($numFact, $codeProd);
        }
        return $totalSansRemise;
    }

    function getMontantTotalAvecRemise(string $numFact) : int {
        $totalSansRemise = $this->getMontantTotalSansRemise($numFact);
        $res = $this->bd->execSQLselect("SELECT taux_remise_fact FROM facture WHERE num_fact = :numFact", 
                                        [':numFact' => $numFact]);
        $tauxRemise = (isset($res[0]['taux_remise_fact'])) ? $res[0]['taux_remise_fact'] : 0;
        $totalAvecRemise = $totalSansRemise * (1 - $tauxRemise / 100);
        return $totalAvecRemise;
    }

}