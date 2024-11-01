<?php
    require_once 'connexion.php';
    require_once 'prodByFact.class.php';
    require_once 'produitDAO.class.php';

class ProdByFactDAO {
    private $bd;
    private $select;

    function __construct(){
        $this->bd = new Connexion();
        $this->select = 'SELECT num_fact, code_prod, qte_prod FROM ligne';
    }
    
    function insert (ProdByFact $prodByFact) : void {
        $this->bd->execSQL("INSERT INTO CONTIENT (num_fact, code_prod, qte_prod)
                            VALUES (:numFact, :codeProd, :qteProd)",
                            [':numFact'=>$prodByFact->getNumFact(), 
                            ':codeProd'=>$prodByFact->getProduit()->getCode(),
                            ':qteProd'=>$prodByFact->getQteProd()]);
    }    

    function deleteByNumFactByCodeProd (string $numFact, string $codeProd) : void{
        $this->bd->execSQL("DELETE 
                            FROM ligne 
                            WHERE num_fact = :numFact 
                            AND code_prod = :codeProd",
                            [':numFact'=>$numFact, ':codeProd'=>$codeProd ]);
    }

    function deleteByNumFact (string $numFact) : void {
        $this->bd->execSQL("DELETE 
                            FROM ligne 
                            WHERE num_fact = :numFact",
                            [':numFact'=>$numFact]);
    }

    function update (ProdByFact $prodByFact) : void {
        $this->bd->execSQL("UPDATE ligne 
                            SET qte_prod = :qteProd 
                            WHERE num_fact = :numFact AND code_prod = :codeProd",
                            [':numFact'=>$prodByFact->getNumFact(), 
                            ':codeProd'=>$prodByFact->getProduit()->getCode(),
                            ':qteProd'=>$prodByFact->getQteProd()]);									
     }

     private function loadQuery (array $result) : array { 
        $produitDAO = new ProduitDAO(); 
        $lesProdByFact = []; 
        foreach($result as $row) {
            $produit = $produitDAO->getByCode($row['code_prod']);
            $lesProdByFact[] = new ProdByFact($row['num_fact'], $produit, $row['qte_prod']);
        }
        return $lesProdByFact;
    }

    function getAll () : array {
        return ($this->loadQuery($this->bd->execSQLselect($this->select)));
    }

    function getByNumFact (string $numFact) : array {
        return ($this->loadQuery($this->bd->execSQLselect($this->select ." 
                                                    WHERE num_fact = :numFact",
                                                    [':numFact'=>$numFact])));
    }

    function getByNumFactByCodeProd (string $numFact, string $codeProd) : array	{
        return	($this->loadQuery($this->bd->execSQLselect($this->select ." 
                                                    WHERE num_fact = :numFact
                                                    AND code_prod = :codeProd",
                                                    [':numFact'=>$numFact, ':codeProd'=>$codeProd ])));
    }

    function existe (string $numFact, string $codeProd) : bool {
        $req = "SELECT * 
                FROM    ligne 
                WHERE   code_prod = :codeProd
                AND     num_fact = :numFact";
        $res = ($this->loadQuery($this->bd->execSQLselect($req, [':codeProd'=>$codeProd, 'numFact'=>$numFact])));
        return ($res != []); // si tableau de factures est vide alors le produit n’existe pas
    }
}
?>