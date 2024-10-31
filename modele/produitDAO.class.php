<?php
    require_once 'connexion.php'; 
    require_once 'produit.class.php';

class ProduitDAO {
    private $bd;
    private $select;

    function __construct(){
        $this->bd = new Connexion();
        $this->select = 'SELECT code_prod, lib_prod, type, origine, conditionnement, tarif_ht FROM `produit`';
    }

    function insert (Produit $produit) : void {
        $this->bd->execSQL("INSERT INTO produit (code_prod, lib_prod, type, origine, conditionnement, tarif_ht)
                            VALUES (:codeProd, :libProd, :type, :origine, :conditionnement, :tarifHt)", 
                            [':codeProd'=>$produit->getCode(), ':libProd'=>$produit->getLib(), ':type'=>$produit->getType(),
                            ':origine'=>$produit->getOrigine(), ':conditionnement'=>$produit->getConditionnement(), 
                            ':tarifHt'=>$produit->getTarifHt()]);
    }    

    function delete (string $codeProd) : void {
        $this->bd->execSQL("DELETE FROM produit 
                            WHERE code_prod = :codeProd", [':codeProd'=>$codeProd ]);
    } 

    function update (Produit $produit) : void {
        $this->bd->execSQL("UPDATE produit 
                            SET lib_prod = :libProd, type = :type, origine = :origine, 
                            conditionnement = :conditionnement, tarif_ht = :tarifHt
                            WHERE code_prod = :codeProd",
                            [':codeProd'=>$produit->getCode(), ':libProd'=>$produit->getLib(), ':type'=>$produit->getType(),
                            ':origine'=>$produit->getOrigine(), ':conditionnement'=>$produit->getConditionnement(), 
                            ':tarifHt'=>$produit->getTarifHt()]);
    }    

    private function loadQuery (array $result) : array { 
        $produits = [];
        foreach($result as $row) {
            $produit = new Produit(); 
            $produit->setCode($row['code_prod']); 
            $produit->setLib($row['lib_prod']); 
            $produit->setType($row['type']); 
            $produit->setOrigine($row['origine']); 
            $produit->setConditionnement($row['conditionnement']); 
            $produit->setTarifHt($row['tarif_ht']); 
            $produits[] = $produit;
        }
        return $produits;
    }

    function getAll () : array {
        return ($this->loadQuery($this->bd->execSQLselect($this->select)));
    }

    function getByCode (string $codeProd) : Produit {
        $unProduit = new Produit();
        $lesProduits = $this->loadQuery($this->bd->execSQLselect($this->select ." WHERE
        code_prod = :codeProd", [':codeProd'=>$codeProd]) );
        if (count($lesProduits) > 0) { 
            $unProduit = $lesProduits[0]; 
        }
        return $unProduit;
        // il y a un seul élément dans le tableau de salles ➔ indice 0 return $unProduit;
    }	

    function existe (string $codeProd) : bool {
        $req = "SELECT * 
                FROM produit 
                WHERE code_prod = :codeProd";
        $res = ($this->loadQuery($this->bd->execSQLselect($req, [':codeProd'=>$codeProd])));
        return ($res != []); // si tableau de salles est vide alors l'équipement' n’existe pas
    }

    function getNonFacture (string $numFact) : array {
        // retourne le tableau des produits non présents dans la facture $numFact. 
        return ($this->loadQuery($this->bd->execSQLselect($this->select ."
                                    WHERE code_prod NOT IN (
                                        SELECT code_prod
                                        FROM ligne
                                        WHERE code_prod = :codeProd)",
                                    [':codeProd'=>$numFact])));
    }
}    

?>