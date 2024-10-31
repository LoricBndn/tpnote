<?php
class Forfait {
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

    function getLib(): string {
        return $this->libForfait;
    }

    function getMt(): string {
        return $this->mtForfait;
    }

    // setters    
    function setId(string $id): void {
        $this->idForfait = $id;
    }

    function setLib(string $lib): void {
        $this->libForfait = $lib;
    }

    function setMt(string $mt): void {
        $this->mtForfait = $mt;
    }
}