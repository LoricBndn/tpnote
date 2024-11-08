<?php
    require_once 'forfait.class.php';
    require_once 'client.class.php';

class Facture {
    private $numFact;
    private $dateFact;
    private $commentFact;
    private $tauxRemiseFact;
    private $client;
    private $forfait;

    function __construct(string $numFact ='', string $dateFact = '', string $commentFact = '', int $tauxRemiseFact = 0,
    Client $client = '', Forfait $forfait = null) {
        $this->numFact = $numFact;
        $this->dateFact = $dateFact;
        $this->commentFact = $commentFact;
        $this->tauxRemiseFact = $tauxRemiseFact;
        $this->client = $client;
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

    function getTauxRemiseFact(): int {
        return $this->tauxRemiseFact;
    }

    function getClient(): Client {
        return $this->client;
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

    function setTauxRemiseFact(int $tauxRemiseFact): void {
        $this->tauxRemiseFact = $tauxRemiseFact;
    }

    function setClient(Client $client): void {
        $this->client = $client;
    }

    function setForfait(Forfait $forfait): void {
        $this->forfait = $forfait;
    }
}
?>