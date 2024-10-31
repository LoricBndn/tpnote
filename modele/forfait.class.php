<?php
class Client {
    
    private $idForfait;
    private $libForfait;
    private $mtForfait;

    // constructeur    
    function __construct(string $id = '', string $lib = '', string $mt = '') {
        $this->idForfait = $id;
        $this->libForfait = $lib;
        $this->mtForfait = $mt;
    }

    // getters
    function getId(): string {
        return $this->idForfait;
    }

    function getCiv(): string {
        return $this->libForfait;
    }

    function getNom(): string {
        return $this->mtForfait;
    }

    // setters    
    function setId(string $id): void {
        $this->idForfait = $id;
    }

    function setCiv(string $lib): void {
        $this->libForfait = $lib;
    }

    function setNom(string $mt): void {
        $this->mtForfait = $mt;
    }
}