<?php
class User implements JsonSerializable {
    private $usuario;
    private $pass;

    //constructor
    public function __construct($usuario, $pass) {
        $this->usuario = $usuario;
        $this->pass = $pass;
    }

    //para pasar a json
    public function jsonSerialize() {
        return [
            'usuario' => $this->usuario,
            'pass' => $this->pass
        ];
    }

    //getters y setters
    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getPass() {
        return $this->pass;
    }

    public function setPass($pass) {
        $this->pass = $pass;
    }

    
}
