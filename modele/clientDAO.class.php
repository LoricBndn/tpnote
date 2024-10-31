<?php
    require_once 'connexion.php'; 
    require_once 'client.class.php';

class ClientDAO{
    private $bd;
    private $select;

    function __construct(){
        $this->bd = new Connexion();
        $this->select = 'SELECT id_cli, civ_cli, nom_cli, prenom_cli, tel_cli, mel_cli, adr_cli, cp_cli, 
                        commune_cli, tauxmax_remise_cli, motdepasse_cli FROM `client`';
    }

    function insert (Client $client) : void {
        $this->bd->execSQL("INSERT INTO client (id_cli, civ_cli, nom_cli, prenom_cli, tel_cli, mel_cli, adr_cli, cp_cli, 
                            commune_cli, tauxmax_remise_cli, motdepasse_cli)
                            VALUES (id, :civ, :nom, :prenom, :tel, :mel, :adr, :cp, :commune, :tauxMaxRemise, :motDePasse)"
                            ,[':id'=>$client->getId() ,':civ'=>$client->getCiv(), ':nom'=>$client->getNom(), 
                            ':prenom'=>$client->getPrenom(), ':tel'=>$client->getTel(), ':mel'=>$client->getMel(),
                            ':adr'=>$client->getAdr(), ':cp'=>$client->getCp(), ':commune'=>$client->getCommune(), 
                            ':tauxMaxRemise'=>$client->getTauxMaxRemise(), ':motDePasse'=>$client->getMotDePasse()]);
    }    

    function delete (string $idCli) : void {
        $this->bd->execSQL("DELETE FROM client 
                            WHERE id_cli = :idCli", [':idCli'=>$idCli]);
    } 

    function update (Client $client) : void {
        $this->bd->execSQL("UPDATE client 
                            SET civ_cli = :civ, nom_cli = :nom, prenom_cli = :prenom, tel_cli = :tel, mel_cli = :mel, 
                            adr_cli = :adr, cp_cli = :cp, commune_cli = :commune, tauxmax_remise_cli = :tauxMaxRemise,
                            motdepasse_cli = :motDePasse
                            WHERE id_cli = :id"
                            ,[':id'=>$client->getId() ,':civ'=>$client->getCiv(), ':nom'=>$client->getNom(), 
                            ':prenom'=>$client->getPrenom(), ':tel'=>$client->getTel(), ':mel'=>$client->getMel(),
                            ':adr'=>$client->getAdr(), ':cp'=>$client->getCp(), ':commune'=>$client->getCommune(), 
                            ':tauxMaxRemise'=>$client->getTauxMaxRemise(), ':motDePasse'=>$client->getMotDePasse()]);
    }    

    private function loadQuery (array $result) : array { 
        $clients = [];
        foreach($result as $row) {
            $client = new Client(); 
            $client->setId($row['id_cli']);
            $client->setCiv($row['civ_cli']);
            $client->setNom($row['nom_cli']);
            $client->setPrenom($row['prenom_cli']);
            $client->setTel($row['tel_cli']);
            $client->setMel($row['mel_cli']);
            $client->setAdr($row['adr_cli']);
            $client->setCp($row['cp_cli']);
            $client->setCommune($row['commune_cli']);
            $client->setTauxMaxRemise($row['tauxmax_remise_cli']);
            $client->setMotDePasse($row['motdepasse_cli']);
            $clients[] = $client;
        }
        return $clients;
    }

    function getAll () : array {
        return ($this->loadQuery($this->bd->execSQLselect($this->select)));
    }

    function getById (string $id) : Client {
        $unClient = new Client();
        $lesClients = $this->loadQuery($this->bd->execSQLselect($this->select ." WHERE
        id_cli = :id", [':id'=>$id]) );
        if (count($lesClients) > 0) { 
            $unClient = $lesClients[0]; 
        }
        return $unClient;
        // il y a un seul élément dans le tableau de salles ➔ indice 0 return $unClient;
    }	

    function existe (string $id) : bool {
        $req = "SELECT * 
                FROM client 
                WHERE id_cli = :id";
        $res = ($this->loadQuery($this->bd->execSQLselect($req, [':id'=>$id])));
        return ($res != []); // si tableau de salles est vide alors l'équipement' n’existe pas
    }
}    
?>