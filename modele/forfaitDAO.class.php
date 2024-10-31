<?php
    require_once 'connexion.php'; 
    require_once 'forfait.class.php';

class ForfaitDAO {
    private $bd;
    private $select;

    function __construct(){
        $this->bd = new Connexion();
        $this->select = 'SELECT id_forfait, lib_forfait, mt_forfait FROM `forfait_livraison`';
    }

    function insert (Forfait $forfait) : void {
        $this->bd->execSQL("INSERT INTO forfait_livraison (id_forfait, lib_forfait, mt_forfait)
                            VALUES (:id, :lib, :mt)"
                            ,[':id'=>$forfait->getId() ,':lib'=>$forfait->getLib(), ':mt'=>$forfait->getMt()]);
    }    

    function delete (string $idForfait) : void {
        $this->bd->execSQL("DELETE FROM forfait_livraison 
                            WHERE id_forfait = :idForfait", [':idForfait'=>$idForfait]);
    } 

    function update (Forfait $forfait) : void {
        $this->bd->execSQL("UPDATE forfait_livraison 
                            SET lib_forfait = :lib, mt_forfait = :mt
                            WHERE id_forfait = :id"
                            ,[':id'=>$forfait->getId() ,':lib'=>$forfait->getLib(), ':mt'=>$forfait->getMt()]);
    }    

    private function loadQuery (array $result) : array { 
        $forfaits = [];
        foreach($result as $row) {
            $forfait = new Forfait(); 
            $forfait->setId($row['id_forfait']);
            $forfait->setLib($row['lib_forfait']);
            $forfait->setMt($row['mt_forfait']);
            $forfaits[] = $forfait;
        }
        return $forfaits;
    }

    function getAll () : array {
        return ($this->loadQuery($this->bd->execSQLselect($this->select)));
    }

    function getById (string $id) : Forfait {
        $unForfait = new Forfait();
        $lesForfaits = $this->loadQuery($this->bd->execSQLselect($this->select ." WHERE
        id_forfait = :id", [':id'=>$id]) );
        if (count($lesForfaits) > 0) { 
            $unForfait = $lesForfaits[0]; 
        }
        return $unForfait;
        // il y a un seul élément dans le tableau de salles ➔ indice 0 return $unForfait;
    }	

    function existe (string $id) : bool {
        $req = "SELECT * 
                FROM forfait_livraison 
                WHERE id_forfait = :id";
        $res = ($this->loadQuery($this->bd->execSQLselect($req, [':id'=>$id])));
        return ($res != []); // si tableau de salles est vide alors le forfait n’existe pas
    }
}    
?>