<?php

require_once("Database.php");
require_once("../model/Checkin.php");
require_once("PremiacaoDB.php");
class CheckinBD {
    
    public static function getCheckinPorId($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Checkin WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        $checkin = new Checkin();
        $checkin->setId($id);
        $checkin->setCerveja($row['cerveja']);
        $checkin->setConsumidor($row['consumidor']);
        $checkin->setData($row['data']);
        $checkin->setEstrelas($row['estrelas']);
        return $checkin;
    }
    
    public static function getCheckinsPorIdUsuario($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Checkin WHERE consumidor = :id ORDER BY data DESC';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $checkins = [];
        foreach($rows as $row){
            $checkin = new Checkin();
            $checkin->setId($row['id']);
            $checkin->setCerveja($row['cerveja']);
            $checkin->setConsumidor($row['consumidor']);
            $checkin->setData($row['data']);
            $checkin->setEstrelas($row['estrelas']);
            $checkins[] = $checkin;
        }
        return $checkins;
    }
    
    public static function getTodosCheckin() {
        $db = Database::getDB();
        $query = 'SELECT * FROM Checkin ORDER BY data DESC';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $checkins = [];
        foreach($rows as $row){
            $checkin = new Checkin();
            $checkin->setId($row['id']);
            $checkin->setCerveja($row['cerveja']);
            $checkin->setConsumidor($row['consumidor']);
            $checkin->setData($row['data']);
            $checkin->setEstrelas($row['estrelas']);
            $checkins[] = $checkin;
        }
        return $checkins;
    }
    
    public static function getCheckinsPorIdCerveja($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Checkin WHERE cerveja = :id ORDER BY data DESC';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $checkins = [];
        foreach($rows as $row){
            $checkin = new Checkin();
            $checkin->setId($row['id']);
            $checkin->setCerveja($row['cerveja']);
            $checkin->setConsumidor($row['consumidor']);
            $checkin->setData($row['data']);
            $checkin->setEstrelas($row['estrelas']);
            $checkins[] = $checkin;
        }
        return $checkins;
    }
    
    public static function getCheckinsPorIdCervejaria($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Checkin ck, Cerveja cv WHERE cv.cervejaria = :id AND cv.id = ck.cerveja ORDER BY data DESC';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $checkins = [];
        foreach($rows as $row){
            $checkin = new Checkin();
            $checkin->setId($row['0']);
            $checkin->setCerveja($row['cerveja']);
            $checkin->setConsumidor($row['consumidor']);
            $checkin->setData($row['data']);
            $checkin->setEstrelas($row['estrelas']);
            $checkins[] = $checkin;
        }
        return $checkins;
    }
    
    public static function getMediaEstrelasPorIdCervejaria($id) {
        $checkins = CheckinBD::getCheckinsPorIdCervejaria($id);
        $quantidade = count($checkins);
        if($quantidade === 0){
            return 0;
        }
        $soma = 0;
        foreach ($checkins as $checkin){
            $soma += $checkin->getEstrelas();
        }
        return $soma/$quantidade;
    }
    
    public static function getMediaEstrelasPorIdCerveja($id) {
        $checkins = CheckinBD::getCheckinsPorIdCerveja($id);
        $quantidade = count($checkins);
        if($quantidade === 0){
            return 0;
        }
        $soma = 0;
        foreach ($checkins as $checkin){
            $soma += $checkin->getEstrelas();
        }
        return $soma/$quantidade;
    }
    
    public static function getQntCheckinsUnicoPorIdUsuario($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Checkin WHERE consumidor = :id GROUP BY cerveja';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        return count($rows);
    }
    
    public static function addCheckin($estrelas, $consumidor, $cerveja) {
        $db = Database::getDB();
        $query1 = 'INSERT INTO Checkin (estrelas, consumidor, cerveja) VALUES (:estrelas, :consumidor, :cerveja)';
        $statement1 = $db->prepare($query1);
        $statement1->bindValue(':estrelas', $estrelas);
        $statement1->bindValue(':consumidor', $consumidor);
        $statement1->bindValue(':cerveja', $cerveja);
        $statement1->execute();
        $statement1->closeCursor();
        
        $query2 = 'SELECT MAX(id) FROM checkin';
        $statement2 = $db->prepare($query2);
        $statement2->execute();
        $row = $statement2->fetch();
        $statement2->closeCursor();
        
        $idCheckin = $row['MAX(id)'];
        
        if(count(CheckinBD::getCheckinsPorIdUsuario($consumidor)) == 1){ // Badge 1 - Primeiro checkin
            PremiacaoBD::premiaIdCheckin($idCheckin, 1);
        }
        
        if(date('G')-5 >= 18 && date('G')-5 <= 21){ // Badge 2 - Happy Hour 18 as 21
            PremiacaoBD::premiaIdCheckin($idCheckin, 2);
        }
        
        if((date('w') == 5 && date('G') >= 5) || (date('w') == 6 && date('G') < 5)){ // Badge 3 - Sexta
            PremiacaoBD::premiaIdCheckin($idCheckin, 3);
        }
        
        if(CheckinBD::getQntCheckinsUnicoPorIdUsuario($consumidor) == 5){ // Badge 4 - 25 cervejas
            PremiacaoBD::premiaIdCheckin($idCheckin, 4);
        }
        
        if(CheckinBD::getQntCheckinsUnicoPorIdUsuario($consumidor) == 50){ // Badge 5 - 50 cervejas
            PremiacaoBD::premiaIdCheckin($idCheckin, 5);
        }
        
        if(CheckinBD::getQntCheckinsUnicoPorIdUsuario($consumidor) == 100){ // Badge 6 - 100 cervejas
            PremiacaoBD::premiaIdCheckin($idCheckin, 6);
        }
        
        if(CheckinBD::checkinComCervejaDiferente($consumidor, $cerveja)){ // Badge 7 - Cerveja diferente
            PremiacaoBD::premiaIdCheckin($idCheckin, 7);
        }
        
        if(CheckinBD::tresCheckinsEmUmaHora($consumidor)){ // Badge 8 - 3 cervejas em menos de 1 hora
            PremiacaoBD::premiaIdCheckin($idCheckin, 8);
        }
        
        if(CheckinBD::tresCheckinsMesmaCerveja($consumidor, $cerveja)){ // Badge 9 - 3x a mesma cerveja
            PremiacaoBD::premiaIdCheckin($idCheckin, 9);
        }
    }
    
    public static function checkinComCervejaDiferente($consumidor, $cerveja) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Checkin WHERE consumidor = :id AND cerveja = :cerveja';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $consumidor);
        $statement->bindValue(':cerveja', $cerveja);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        if(count($rows) == 1){
            return true;
        }
        return false;
    }
    
    public static function tresCheckinsEmUmaHora($consumidor) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Checkin WHERE consumidor = :id ORDER BY data DESC LIMIT 3';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $consumidor);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $umaHoraAtras = strtotime('-6 hour');
        if(strtotime(date($rows[2]['data'])) > $umaHoraAtras){
            return true;
        }
        return false;
    }
    
    public static function tresCheckinsMesmaCerveja($consumidor, $cerveja) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Checkin WHERE consumidor = :id AND cerveja = :cerveja';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $consumidor);
        $statement->bindValue(':cerveja', $cerveja);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        if(count($rows) == 3){
            return true;
        }
        return false;
    }
    
    
}
