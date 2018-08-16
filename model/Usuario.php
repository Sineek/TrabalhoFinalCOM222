<?php

class Usuario {

    private $id, $nome, $dataNascimento, $login, $senha;

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getNome() {
        return $this->nome;
    }

    function getDataNascimento() {
        return $this->dataNascimento;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }
    
    function getLogin() {
        return $this->login;
    }

    function getSenha() {
        return $this->senha;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }


}
