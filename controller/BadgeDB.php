<?php

require_once("Database.php");
require_once("../model/Badge.php");

class BadgeDB {

    public static function getBadgePorId($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Badge WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        $badge = new Badge();
        $badge->setId($id);
        $badge->setExplicacao($row['explicacao']);
        $badge->setNome($row['nome']);
        return $badge;
    }

}
