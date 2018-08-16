<?php

class Cerveja {

    private $id, $nome, $tipo, $teorAlcoolico, $cervejaria;

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

    function getTeorAlcoolico() {
        return $this->teorAlcoolico;
    }

    function getCervejaria() {
        return $this->cervejaria;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setTeorAlcoolico($teorAlcoolico) {
        $this->teorAlcoolico = $teorAlcoolico;
    }

    function setCervejaria($cervejaria) {
        $this->cervejaria = $cervejaria;
    }

}
