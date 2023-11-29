<?php
class Proyecto implements JsonSerializable{
    
    private $codigoProyecto;
    private $nombreProyecto;
    private $fechaInicio;
    private $fechaFin;

    //construcor
    public function __construct($codigoProyecto, $nombreProyecto, $fechaInicio, $fechaFin) {
        $this->codigoProyecto = $codigoProyecto;
        $this->nombreProyecto = $nombreProyecto;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    //jsonserialize para pasar a json
    public function jsonSerialize() {
        return [
            'codigoProyecto' => $this->codigoProyecto,
            'nombreProyecto' => $this->nombreProyecto,
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin
        ];
    }

    //getter setters
    public function getCodigoProyecto() {
        return $this->codigoProyecto;
    }

    public function setCodigoProyecto($codigoProyecto) {
        $this->codigoProyecto = $codigoProyecto;
    }

    public function getNombreProyecto() {
        return $this->nombreProyecto;
    }

    public function setNombreProyecto($nombreProyecto) {
        $this->nombreProyecto = $nombreProyecto;
    }

    public function getFechaInicio() {
        return $this->fechaInicio;
    }

    public function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    public function getFechaFin() {
        return $this->fechaFin;
    }

    public function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }

   

}