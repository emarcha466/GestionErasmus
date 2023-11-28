<?php
class Convocatoria implements JsonSerializable {
    private $id;
    private $num_movilidades;
    private $duracion;
    private $tipo;
    private $fechaIniSolicitud;
    private $fechaFinSolicitud;
    private $fechaIniPruebas;
    private $fechaFinPruebas;
    private $fechaListadoProvisional;
    private $fechaListadoDefinitivo;
    private $codigoProyecto;
    private $destino;


    // Constructor
    public function __construct($id, $num_movilidades, $duracion, $tipo, $fechaIniSolicitud, $fechaFinSolicitud, $fechaIniPruebas, $fechaFinPruebas, $fechaListadoProvisional, $fechaListadoDefinitivo, $codigoProyecto, $destino) {
        $this->id = $id;
        $this->num_movilidades = $num_movilidades;
        $this->duracion = $duracion;
        $this->tipo = $tipo;
        $this->fechaIniSolicitud = $fechaIniSolicitud;
        $this->fechaFinSolicitud = $fechaFinSolicitud;
        $this->fechaIniPruebas = $fechaIniPruebas;
        $this->fechaFinPruebas = $fechaFinPruebas;
        $this->fechaListadoProvisional = $fechaListadoProvisional;
        $this->fechaListadoDefinitivo = $fechaListadoDefinitivo;
        $this->codigoProyecto = $codigoProyecto;
        $this->destino = $destino;
    }

    //JSONRIZABLE para el caso que se necesite crear un json de la clase
    public function jsonSerialize(){
        return [
            'id' => $this->id,
            'num_movilidades' => $this->num_movilidades,
            'duracion' => $this->duracion,
            'tipo' => $this->tipo,
            'fechaIniSolicitud' => $this->fechaIniSolicitud,
            'fechaFinSolicitud' => $this->fechaFinSolicitud,
            'fechaIniPruebas' => $this->fechaIniPruebas,
            'fechaFinPruebas' => $this->fechaFinPruebas,
            'fechaListadoProvisional' => $this->fechaListadoProvisional,
            'fechaListadoDefinitivo' => $this->fechaListadoDefinitivo,
            'codigoProyecto' => $this->codigoProyecto,
            'destino' => $this->destino,
        ];
    }

    // Getters  Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNumMovilidades() {
        return $this->num_movilidades;
    }

    public function setNumMovilidades($num_movilidades) {
        $this->num_movilidades = $num_movilidades;
    }

    public function getDuracion() {
        return $this->duracion;
    }

    public function setDuracion($duracion) {
        $this->duracion = $duracion;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getFechaIniSolicitud() {
        return $this->fechaIniSolicitud;
    }

    public function setFechaIniSolicitud($fechaIniSolicitud) {
        $this->fechaIniSolicitud = $fechaIniSolicitud;
    }

    public function getFechaFinSolicitud() {
        return $this->fechaFinSolicitud;
    }

    public function setFechaFinSolicitud($fechaFinSolicitud) {
        $this->fechaFinSolicitud = $fechaFinSolicitud;
    }

    public function getFechaIniPruebas() {
        return $this->fechaIniPruebas;
    }

    public function setFechaIniPruebas($fechaIniPruebas) {
        $this->fechaIniPruebas = $fechaIniPruebas;
    }

    public function getFechaFinPruebas() {
        return $this->fechaFinPruebas;
    }

    public function setFechaFinPruebas($fechaFinPruebas) {
        $this->fechaFinPruebas = $fechaFinPruebas;
    }

    public function getFechaListadoProvisional() {
        return $this->fechaListadoProvisional;
    }

    public function setFechaListadoProvisional($fechaListadoProvisional) {
        $this->fechaListadoProvisional = $fechaListadoProvisional;
    }

    public function getFechaListadoDefinitivo() {
        return $this->fechaListadoDefinitivo;
    }

    public function setFechaListadoDefinitivo($fechaListadoDefinitivo) {
        $this->fechaListadoDefinitivo = $fechaListadoDefinitivo;
    }

    public function getCodigoProyecto() {
        return $this->codigoProyecto;
    }

    public function setCodigoProyecto($codigoProyecto) {
        $this->codigoProyecto = $codigoProyecto;
    }

    public function getDestino() {
        return $this->destino;
    }

    public function setDestino($destino) {
        $this->destino = $destino;
    }
}