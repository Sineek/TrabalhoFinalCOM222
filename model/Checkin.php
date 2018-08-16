<?php

class Checkin {

    private $id, $data, $estrelas, $consumidor, $cerveja;

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getData() {
        return $this->data;
    }

    function getEstrelas() {
        return $this->estrelas;
    }

    function getConsumidor() {
        return $this->consumidor;
    }

    function getCerveja() {
        return $this->cerveja;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setEstrelas($estrelas) {
        $this->estrelas = $estrelas;
    }

    function setConsumidor($consumidor) {
        $this->consumidor = $consumidor;
    }

    function setCerveja($cerveja) {
        $this->cerveja = $cerveja;
    }

}
