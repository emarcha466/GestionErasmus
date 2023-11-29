<?php
class ItemBaremable implements JsonSerializable {
    private $id;
    private $nombre;

    //Constructor
    public function __construct($id, $nombre) {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    //JsonSerializable para pasar a json
    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre
        ];
    }

    //getters setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
}