<?php

require_once("Database.php");
require_once("../model/Premiacao.php");
require_once("BadgeDB.php");

class PremiacaoBD {

    public static function getPremiacaoPorId($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Premiacao WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        $premiacao = new Premiacao();
        $premiacao->setId($id);
        $premiacao->setBadge($row['badge']);
        $premiacao->setDataPremiacao($row['dataPremiacao']);
        $premiacao->setUsuario($row['usuario']);
        return $premiacao;
    }
    
    public static function getBadgesPorIdUsuario($id) {
        $db = Database::getDB();
        $query = 'SELECT p.badge FROM Checkin c, Premiacao p WHERE c.consumidor = :id AND c.id = p.checkin';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $badges = [];
        foreach($rows as $row){
            $badge = BadgeDB::getBadgePorId($row['badge']);
            $badges[] = $badge;
        }
        return $badges;
    }
    
    public static function getBadgesPorIdCheckin($id) {
        $db = Database::getDB();
        $query = 'SELECT p.badge FROM Checkin c, Premiacao p WHERE c.id = :id AND c.id = p.checkin';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $badges = [];
        foreach($rows as $row){
            $badge = BadgeDB::getBadgePorId($row['badge']);
            $badges[] = $badge;
        }
        return $badges;
    }
    
    public static function temBadgeComentarioPorIdUsuario($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Checkin c, Premiacao p WHERE c.consumidor = :id AND c.id = p.checkin AND p.badge = 10';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if($row['badge'] == 10){
            return true;
        }
        return false;
    }
    
    public static function premiaIdCheckin($checkin, $badge) {
        $db = Database::getDB();
        $query = 'INSERT INTO Premiacao (checkin, badge) VALUES (:chekins, :badge)';
        $statement = $db->prepare($query);
        $statement->bindValue(':chekins', $checkin);
        $statement->bindValue(':badge', $badge);
        $statement->execute();
        $statement->closeCursor();
    }

}
