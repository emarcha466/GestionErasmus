<?php
class NivelIdioma implements JsonSerializable {
    private $id;
    private $nombre;

    // Constructor
    public function __construct($id, $nombre) {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    // Implementación de JsonSerializable
    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
        ];
    }

    // Getters y setters
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
}
