<?php

class Comentario {

    private $id, $checkin, $usuario, $data, $texto;

    function getId() {
        return $this->id;
    }

    function getCheckin() {
        return $this->checkin;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getData() {
        return $this->data;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCheckin($checkin) {
        $this->checkin = $checkin;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setData($data) {
        $this->data = $data;
    }
    
    function getTexto() {
        return $this->texto;
    }

    function setTexto($texto) {
        $this->texto = $texto;
    }
}
