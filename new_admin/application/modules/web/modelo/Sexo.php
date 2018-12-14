<?php

abstract class Sexo {

    const MASCULINO = "M";
    const FEMENINO = "F";

    static function getList() {
        $datos = array(
            "F" => "femenino",
            "M" => "masculino",
        );
        return $datos;
    }

}
