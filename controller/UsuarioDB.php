<?php

require_once("Database.php");
require_once("../model/Usuario.php");

class UsuarioBD {
    
     public static function getUsuarioPorId($id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Usuario WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        $usuario = new Usuario();
        $usuario->setId($id);
        $usuario->setNome($row['nome']);
        $usuario->setDataNascimento($row['dataNascimento']);
        $usuario->setLogin($row['login']);
        $usuario->setSenha($row['senha']);
        return $usuario;
    }
    
    public static function getTodosUsuarios() {
        $db = Database::getDB();
        $query = 'SELECT * FROM Usuario';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $usuarios = [];
        foreach ($rows as $row) {
            $usuario = new Usuario();
            $usuario->setNome($row['nome']);
            $usuario->setId($row['id']);
            $usuario->setDataNascimento($row['dataNascimento']);
            $usuarios[] = $usuario;
        }
        return $usuarios;
    }
    
    public static function getUsuarioPorLogin($login) {
        $db = Database::getDB();
        $query = "SELECT * FROM Usuario WHERE login = :login";
        $statement = $db->prepare($query);
        $statement->bindValue(':login', $login);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        $usuario = new Usuario();
        $usuario->setId($row['id']);
        $usuario->setNome($row['nome']);
        $usuario->setDataNascimento($row['dataNascimento']);
        $usuario->setLogin($row['login']);
        $usuario->setSenha($row['senha']);
        return $usuario;
    }
    
    public static function getConfirmacao($login, $senha) {
        $db = Database::getDB();
        $query = 'SELECT * FROM Usuario WHERE login = :login and senha = :senha';
        $statement = $db->prepare($query);
        $statement->bindValue(':login', $login);
        $statement->bindValue(':senha', $senha);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if($row['login'] == $login){
            return true;
        }
        return false;
    }
    
    public static function addUsuario($nome, $data, $login, $senha) {
        $db = Database::getDB();
        $query1 = 'SELECT * FROM Usuario WHERE login = :login';
        $statement1 = $db->prepare($query1);
        $statement1->bindValue(':login', $login);
        $statement1->execute();
        $row = $statement1->fetch();
        $statement1->closeCursor();
        if($row['login'] == $login){
            return "Existe";
        }
        $query2 = 'INSERT INTO Usuario (nome, dataNascimento, login, senha) VALUES (:nome, :data, :login, :senha)';
        $statement2 = $db->prepare($query2);
        $statement2->bindValue(':nome', $nome);
        $statement2->bindValue(':data', $data);
        $statement2->bindValue(':login', $login);
        $statement2->bindValue(':senha', $senha);
        $statement2->execute();
        return true;
    }
    
    public static function getUsuariosPorNome($nome) {
        $db = Database::getDB();
        $query = "SELECT * FROM Usuario WHERE nome like '%".$nome."%'";
        $statement = $db->prepare($query);
        $statement->bindValue(':nome', $nome);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $usuarios = [];
        foreach ($rows as $row) {
            $usuario = new Usuario();
            $usuario->setNome($row['nome']);
            $usuario->setID($row['id']);
            $usuario->setDataNascimento($row['dataNascimento']);
            $usuarios[] = $usuario;
        }
        return $usuarios;
    }
    
}
