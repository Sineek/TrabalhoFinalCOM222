<?php

class Premiacao {

    private $id, $checkin, $badge, $dataPremiacao;

    function getId() {
        return $this->id;
    }

    function getCheckin() {
        return $this->checkin;
    }

    function setCheckin($checkin) {
        $this->checkin = $checkin;
    }

    function getDataPremiacao() {
        return $this->dataPremiacao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setBadge($badge) {
        $this->badge = $badge;
    }

    function setDataPremiacao($dataPremiacao) {
        $this->dataPremiacao = $dataPremiacao;
    }

}
