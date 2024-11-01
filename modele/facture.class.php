<?php
    require_once 'forfait.class.php';

class Facture {
    private $numFact;
    private $dateFact;
    private $commentFact;
    private $tauxRemiseFact;
    private $idCli;
    private $forfait;

    function __construct(string $numFact ='', string $dateFact = '', string $commentFact = '', string $tauxRemiseFact = '',
    string $idCli = '', Forfait $forfait = null) {
        $this->numFact = $numFact;
        $this->dateFact = $dateFact;
        $this->commentFact = $commentFact;
        $this->tauxRemiseFact = $tauxRemiseFact;
        $this->idCli = $idCli;
        $this->forfait = $forfait;
    }

     // getters
    function getNumFact(): string {
        return $this->numFact;
    }

    function getDateFact(): string {
        return $this->dateFact;
    }

    function getCommentFact(): string {
        return $this->commentFact;
    }

    function getTauxRemiseFact(): string {
        return $this->tauxRemiseFact;
    }

    function getIdCli(): string {
        return $this->idCli;
    }

    function getForfait(): Forfait {
        return $this->forfait;
    }

    // setters    
    function setNumFact(string $numFact): void {
        $this->numFact = $numFact;
    }

    function setDateFact(string $dateFact): void {
        $this->dateFact = $dateFact;
    }

    function setCommentFact(string $commentFact): void {
        $this->commentFact = $commentFact;
    }

    function setTauxRemiseFact(string $tauxRemiseFact): void {
        $this->tauxRemiseFact = $tauxRemiseFact;
    }

    function setIdCli(string $idCli): void {
        $this->idCli = $idCli;
    }

    function setForfait(Forfait $forfait): void {
        $this->forfait = $forfait;
    }
}
?>