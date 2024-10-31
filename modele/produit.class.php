<?php
class Produit {
    
    private $codeProd;
    private $libProd;
    private $type;
    private $origine;
    private $conditionnement;
    private $tarifHt;

    // constructeur    
    function __construct(string $code = '', string $lib = '', string $type = '', string $origine = '', string $conditionnement = '', 
                        string $tarifHt = '') {
        $this->codeProd = $code;
        $this->libProd = $lib;
        $this->type = $type;
        $this->origine = $origine;
        $this->conditionnement = $conditionnement;
        $this->tarifHt = $tarifHt;
    }

    // getters
    function getCode(): string {
        return $this->codeProd;
    }

    function getLib(): string {
        return $this->libProd;
    }

    function getType(): string {
        return $this->type;
    }

    function getOrigine(): string {
        return $this->origine;
    }

    function getConditionnement(): string {
        return $this->conditionnement;
    }

    function getTarifHt(): string {
        return $this->tarifHt;
    }

    // setters    
    function setCode(string $code): void {
        $this->codeProd = $code;
    }

    function setLib(string $lib): void {
        $this->libProd = $lib;
    }

    function setType(string $type): void {
        $this->type = $type;
    }

    function setOrigine(string $origine): void {
        $this->origine = $origine;
    }

    function setConditionnement(string $conditionnement): void {
        $this->conditionnement = $conditionnement;
    }

    function setTarifHt(string $tarifHt): void {
        $this->tarifHt = $tarifHt;
    }
}