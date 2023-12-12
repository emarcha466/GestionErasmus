<?php
class ConvocatoriaBaremoIdioma implements JsonSerializable {
    private $idIdioma;
    private $idConvocatoria;
    private $puntos;

    // Constructor
    public function __construct($idIdioma, $idConvocatoria, $puntos) {
        $this->idIdioma = $idIdioma;
        $this->idConvocatoria = $idConvocatoria;
        $this->puntos = $puntos;
    }

    // Implementación de JsonSerializable
    public function jsonSerialize() {
        return [
            'idIdioma' => $this->idIdioma,
            'idConvocatoria' => $this->idConvocatoria,
            'puntos' => $this->puntos,
        ];
    }
    // Getters y setters
    public function getIdIdioma() {
        return $this->idIdioma;
    }

    public function getIdConvocatoria() {
        return $this->idConvocatoria;
    }

    public function getPuntos() {
        return $this->puntos;
    }

    public function setIdIdioma($idIdioma) {
        $this->idIdioma = $idIdioma;
    }

    public function setIdConvocatoria($idConvocatoria) {
        $this->idConvocatoria = $idConvocatoria;
    }

    public function setPuntos($puntos) {
        $this->puntos = $puntos;
    }

    
}
?>
