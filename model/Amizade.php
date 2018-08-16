<?php

class Amizade {

    private $id, $usuario1, $usuario2, $aceita, $dataInicio;

    function getId() {
        return $this->id;
    }

    function getUsuario1() {
        return $this->usuario1;
    }

    function getUsuario2() {
        return $this->usuario2;
    }

    function getDataInicio() {
        return $this->dataInicio;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsuario1($usuario1) {
        $this->usuario1 = $usuario1;
    }

    function setUsuario2($usuario2) {
        $this->usuario2 = $usuario2;
    }

    function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    function getAceita() {
        return $this->aceita;
    }

    function setAceita($aceita) {
        $this->aceita = $aceita;
    }

}
