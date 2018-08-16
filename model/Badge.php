<?php

class Badge {

    private $id, $nome, $explicacao;

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getNome() {
        return $this->nome;
    }

    function getExplicacao() {
        return $this->explicacao;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setExplicacao($explicacao) {
        $this->explicacao = $explicacao;
    }

}
