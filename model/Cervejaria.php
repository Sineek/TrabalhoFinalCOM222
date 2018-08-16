<?php

class Cervejaria {

    private $id, $nome, $tipo, $local;

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getNome() {
        return $this->nome;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getLocal() {
        return $this->local;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setLocal($local) {
        $this->local = $local;
    }
}
