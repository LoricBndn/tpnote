<?php
class Client {
    
    private $idCli;
    private $civCli;
    private $nomCli;
    private $prenomCli;
    private $telCli;
    private $melCli;
    private $adrCli;
    private $cpCli;
    private $communeCli;
    private $tauxMaxRemiseCli;
    private $motDePasseCli;

    // constructeur    
    function __construct(string $id = '', string $civ = '', string $nom = '', string $prenom = '', string $tel = '', 
                        string $mel = '', string $adr = '', string $cp = '', string $commune = '', string $tauxMaxRemise = '',
                        string $motDePasse = '') {
        $this->idCli = $id;
        $this->civCli = $civ;
        $this->nomCli = $nom;
        $this->prenomCli = $prenom;
        $this->telCli = $tel;
        $this->melCli = $mel;
        $this->adrCli = $adr;
        $this->cpCli = $cp;
        $this->communeCli = $commune;
        $this->tauxMaxRemiseCli = $tauxMaxRemise;
        $this->motDePasseCli = $motDePasse;
    }

    // getters
    function getId(): string {
        return $this->idCli;
    }

    function getCiv(): string {
        return $this->civCli;
    }

    function getNom(): string {
        return $this->nomCli;
    }

    function getPrenom(): string {
        return $this->prenomCli;
    }

    function getTel(): string {
        return $this->telCli;
    }

    function getMel(): string {
        return $this->melCli;
    }

    function getAdr(): string {
        return $this->adrCli;
    }

    function getCp(): string {
        return $this->cpCli;
    }

    function getCommune(): string {
        return $this->communeCli;
    }

    function getTauxMaxRemise(): string {
        return $this->tauxMaxRemiseCli;
    }

    function getMotDePasse(): string {
        return $this->motDePasseCli;
    }

    // setters    
    function setId(string $id): void {
        $this->idCli = $id;
    }

    function setCiv(string $civ): void {
        $this->civCli = $civ;
    }

    function setNom(string $nom): void {
        $this->nomCli = $nom;
    }

    function setPrenom(string $prenom): void {
        $this->prenomCli = $prenom;
    }

    function setTel(string $tel): void {
        $this->telCli = $tel;
    }

    function setMel(string $mel): void {
        $this->melCli = $mel;
    }

    function setAdr(string $adr): void {
        $this->adrCli = $adr;
    }

    function setCp(string $cp): void {
        $this->cpCli = $cp;
    }

    function setCommune(string $commune): void {
        $this->communeCli = $commune;
    }

    function setTauxMaxRemise(string $tauxMaxRemise): void {
        $this->tauxMaxRemiseCli = $tauxMaxRemise;
    }

    function setMotDePasse(string $motDePasse): void {
        $this->motDePasseCli = $motDePasse;
    }
}