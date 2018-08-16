<?php

require_once("Database.php");
require_once("../model/Cervejaria.php");

class CervejariaDB {

    public static function getCervejariaPorId($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM cervejaria WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        $cervejaria = new Cervejaria();
        $cervejaria->setId($row['id']);
        $cervejaria->setLocal($row['local']);
        $cervejaria->setNome($row['nome']);
        $cervejaria->setTipo($row['tipo']);
        return $cervejaria;
    }

    public static function getCervejariasPorNome($nome) {
        $db = Database::getDB();
        $query = "SELECT * FROM Cervejaria WHERE nome like '%".$nome."%'";
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $cervejarias = [];
        foreach ($rows as $row) {
            $cervejaria = new Cervejaria();
            $cervejaria->setId($row['id']);
            $cervejaria->getLocal($row['local']);
            $cervejaria->setNome($row['nome']);
            $cervejaria->setTipo($row['tipo']);
            $cervejarias[] = $cervejaria;
        }
        return $cervejarias;
    }
    
    public static function getCervejariaPorNome($nome) {
        $db = Database::getDB();
        $query = "SELECT * FROM Cervejaria WHERE nome = :nome";
        $statement = $db->prepare($query);
        $statement->bindValue(':nome', $nome);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        $cervejaria = new Cervejaria();
        $cervejaria->setId($row['id']);
        $cervejaria->getLocal($row['local']);
        $cervejaria->setNome($row['nome']);
        $cervejaria->setTipo($row['tipo']);
        return $cervejaria;
    }
    
    public static function getTodasCervejarias() {
        $db = Database::getDB();
        $query = "SELECT * FROM Cervejaria";
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $cervejarias = [];
        foreach ($rows as $row) {
            $cervejaria = new Cervejaria();
            $cervejaria->setId($row['id']);
            $cervejaria->getLocal($row['local']);
            $cervejaria->setNome($row['nome']);
            $cervejaria->setTipo($row['tipo']);
            $cervejarias[] = $cervejaria;
        }
        return $cervejarias;
    }
    
    public static function addCervejaria($nome, $tipo, $local) {
        $db = Database::getDB();
        $query = "INSERT INTO Cervejaria (nome, tipo, local) VALUES (:nome, :tipo, :local)";
        $statement = $db->prepare($query);
        $statement->bindValue(':nome', $nome);
        $statement->bindValue(':tipo', $tipo);
        $statement->bindValue(':local', $local);
        $statement->execute();
        $statement->closeCursor();
    }
}
