<?php
    require_once 'produit.class.php';

class ProdByFact {
    // table ligne

    private $numFact;
    private $produit; 
    private $qteProd;

    function __construct(string $numFact = '', Produit $produit = null, int $qteProd = 0){
        $this->numFact = $numFact;
        $this->produit = $produit;
        $this->qteProd = $qteProd;
    }

     // getters
    function getNumFact(): string {
        return $this->numFact;
    }
    function getProduit(): Produit {
        return $this->produit;
    }
    function getQteProd(): int {
        return $this->qteProd;
    }

    // setters    
    function setNumFact(string $numFact):void{
        $this->numFact = $numFact;
    }
    function setProduit(Produit $produit):void{
        $this->produit = $produit;
    }
    function setQteProd(int $qteProd):void{
        $this->qteProd = $qteProd;
    }
}
?>