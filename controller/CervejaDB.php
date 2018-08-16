<?php

require_once("Database.php");
require_once("../model/Cerveja.php");

class CervejaDB {

    public static function getCervejaPorId($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Cerveja WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        $cerveja = new Cerveja();
        $cerveja->setId($id);
        $cerveja->setCervejaria($row['cervejaria']);
        $cerveja->setNome($row['nome']);
        $cerveja->setTeorAlcoolico($row['teorAlcoolico']);
        $cerveja->setTipo($row['tipo']);
        return $cerveja;
    }
    
    public static function getCervejaPorNome($nome) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Cerveja WHERE nome = :nome';
        $statement = $db->prepare($query);
        $statement->bindValue(':nome', $nome);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        $cerveja = new Cerveja();
        $cerveja->setId($row['id']);
        $cerveja->setCervejaria($row['cervejaria']);
        $cerveja->setNome($row['nome']);
        $cerveja->setTeorAlcoolico($row['teorAlcoolico']);
        $cerveja->setTipo($row['tipo']);
        return $cerveja;
    }
    
    public static function getCervejasPorNome($nome) {
        $db = Database::getDB();
        $query = "SELECT * FROM Cerveja WHERE nome like '%".$nome."%'";
        $statement = $db->prepare($query);
        $statement->bindValue(':nome', $nome);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $cervejas = [];
        foreach ($rows as $row) {
            $cerveja = new Cerveja();
            $cerveja->setId($row['id']);
            $cerveja->setCervejaria($row['cervejaria']);
            $cerveja->setNome($row['nome']);
            $cerveja->setTeorAlcoolico($row['teorAlcoolico']);
            $cerveja->setTipo($row['tipo']);
            $cervejas[] = $cerveja;
        }
        return $cervejas;
    }
    
    public static function getTodasCervejas() {
        $db = Database::getDB();
        $query = "SELECT * FROM Cerveja";
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $cervejas = [];
        foreach ($rows as $row) {
            $cerveja = new Cerveja();
            $cerveja->setId($row['id']);
            $cerveja->setCervejaria($row['cervejaria']);
            $cerveja->setNome($row['nome']);
            $cerveja->setTeorAlcoolico($row['teorAlcoolico']);
            $cerveja->setTipo($row['tipo']);
            $cervejas[] = $cerveja;
        }
        return $cervejas;
    }
    
    public static function getCervejasPorIdCervejaria($id) {
        $db = Database::getDB();
        $query = "SELECT * FROM Cerveja WHERE cervejaria = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $cervejas = [];
        foreach ($rows as $row) {
            $cerveja = new Cerveja();
            $cerveja->setId($row['id']);
            $cerveja->setCervejaria($row['cervejaria']);
            $cerveja->setNome($row['nome']);
            $cerveja->setTeorAlcoolico($row['teorAlcoolico']);
            $cerveja->setTipo($row['tipo']);
            $cervejas[] = $cerveja;
        }
        return $cervejas;
    }
    
    public static function getTiposCerveja() {
        $db = Database::getDB();
        $query = "SELECT tipo FROM Cerveja GROUP BY tipo";
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $cervejas = [];
        foreach ($rows as $row) {
            $cerveja = new Cerveja();
            $cerveja->setTipo($row['tipo']);
            $cervejas[] = $cerveja;
        }
        return $cervejas;
    }
    
    public static function addCerveja($nome, $teor, $tipo, $cervejaria) {
        $db = Database::getDB();
        $query = "INSERT INTO Cerveja (nome, tipo, teorAlcoolico, cervejaria) VALUES (:nome, :tipo, :teor, :cervejaria)";
        $statement = $db->prepare($query);
        $statement->bindValue(':nome', $nome);
        $statement->bindValue(':tipo', $tipo);
        $statement->bindValue(':teor', $teor);
        $statement->bindValue(':cervejaria', $cervejaria);
        $statement->execute();
        $statement->closeCursor();
    }

}
