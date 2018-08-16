<?php

require_once("Database.php");
require_once("../model/Comentario.php");
require_once("PremiacaoDB.php");
class ComentarioBD {
    
    public static function getComentarioPorId($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Comentario WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        $comentario = new Comentario();
        $comentario->setId($id);
        $comentario->setCheckin($row['checkin']);
        $comentario->setUsuario($row['usuario']);
        $comentario->setData($row['data']);
        $comentario->setTexto($row['texto']);
        return $comentario;
    }
    
    public static function getComentariosPorIdCheckin($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Comentario WHERE checkin = :id ORDER BY data ASC';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $comentarios = [];
        foreach($rows as $row){
            $comentario = new Comentario();
            $comentario->setId($row['id']);
            $comentario->setCheckin($row['checkin']);
            $comentario->setUsuario($row['usuario']);
            $comentario->setData($row['data']);
            $comentario->setTexto($row['texto']);
            $comentarios[] = $comentario;
        }
        return $comentarios;
    }
    
    public static function addComentario($idCheckin, $usuario, $texto) {
        $db = Database::getDB();
        $query = 'INSERT INTO Comentario (usuario, checkin, texto) VALUES (:usuario, :checkin, :texto)';
        $statement = $db->prepare($query);
        $statement->bindValue(':checkin', $idCheckin);
        $statement->bindValue(':usuario', $usuario);
        $statement->bindValue(':texto', $texto);
        $statement->execute();
        $statement->closeCursor();
        
        $checkin = CheckinBD::getCheckinPorId($idCheckin);
        if(!PremiacaoBD::temBadgeComentarioPorIdUsuario($checkin->getConsumidor())){ // Badge 10 - Ganhou primeiro comentário
            PremiacaoBD::premiaIdCheckin($checkin->getId(), 10);
        }
    }
}
