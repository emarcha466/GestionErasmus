<?php
class Destinatario implements JsonSerializable {
    private $codigoGrupo;
    private $nombre;

    //constructor
    public function __construct($codigoGrupo, $nombre) {
        $this->codigoGrupo = $codigoGrupo;
        $this->nombre = $nombre;
    }

    //para pasar a json
    public function jsonSerialize() {
        return [
            'codigoGrupo' => $this->codigoGrupo,
            'nombre' => $this->nombre
        ];
    }

    //getters y setters
    public function getCodigoGrupo() {
        return $this->codigoGrupo;
    }

    public function setCodigoGrupo($codigoGrupo) {
        $this->codigoGrupo = $codigoGrupo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    
}