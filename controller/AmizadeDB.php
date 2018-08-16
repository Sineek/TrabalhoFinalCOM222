<?php

require_once("Database.php");
require_once("../model/Amizade.php");

class AmizadeBD {

    public static function getAmizadePorId($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Amizade WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        $amizade = new Amizade();
        $amizade->setId($id);
        $amizade->setUsuario1($row['usuario1']);
        $amizade->setUsuario2($row['usuario2']);
        $amizade->setDataInicio($row['dataInicio']);
        return $amizade;
    }
    
    public static function saoAmigos($id1, $id2) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Amizade WHERE (usuario1 = :id1 AND usuario2 = :id2) OR (usuario1 = :id2 AND usuario2 = :id1)';
        $statement = $db->prepare($query);
        $statement->bindValue(':id1', $id1);
        $statement->bindValue(':id2', $id2);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if($row['usuario1'] != null && $row['usuario2'] && $row['aceita']){
            return true;
        }
        return false;
    }
    
    public static function solicitadoAmizade($logado, $perfil) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Amizade WHERE usuario1 = :id1 AND usuario2 = :id2';
        $statement = $db->prepare($query);
        $statement->bindValue(':id1', $logado);
        $statement->bindValue(':id2', $perfil);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if($row['usuario1'] == $logado && $row['aceita'] == false){
            return true;
        }
        return false;
    }
    
    public static function solicitarAmizade($logado, $perfil) {
        $db = Database::getDB();
        $query = 'INSERT INTO Amizade (usuario1, usuario2) VALUES (:id1, :id2)';
        $statement = $db->prepare($query);
        $statement->bindValue(':id1', $logado);
        $statement->bindValue(':id2', $perfil);
        $statement->execute();
        $statement->closeCursor();
    }
    
    public static function aceitarAmizade($logado, $perfil) {
        $db = Database::getDB();
        $query = 'UPDATE Amizade SET aceita = 1 WHERE usuario1 = :id1 AND usuario2 = :id2';
        $statement = $db->prepare($query);
        $statement->bindValue(':id1', $perfil);
        $statement->bindValue(':id2', $logado);
        $statement->execute();
        $statement->closeCursor();
    }
}
