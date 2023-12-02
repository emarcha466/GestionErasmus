<?php
class Baremacion implements JsonSerializable {
    private $idConvocatoria;
    private $idSolicitud;
    private $idItemBaremable;
    private $notaProvisional;
    private $notaDefinitiva;
    private $url;

    //constructor
    public function __construct($idConvocatoria, $idSolicitud, $idItemBaremable, $notaProvisional, $notaDefinitiva, $url) {
        $this->idConvocatoria = $idConvocatoria;
        $this->idSolicitud = $idSolicitud;
        $this->idItemBaremable = $idItemBaremable;
        $this->notaProvisional = $notaProvisional;
        $this->notaDefinitiva = $notaDefinitiva;
        $this->url = $url;
    }

    //para pasar a json
    public function jsonSerialize() {
        return [
            'idConvocatoria' => $this->idConvocatoria,
            'idSolicitud' => $this->idSolicitud,
            'idItemBaremable' => $this->idItemBaremable,
            'notaProvisional' => $this->notaProvisional,
            'notaDefinitiva' => $this->notaDefinitiva,
            'url' => $this->url
        ];
    }

    //getters y setters
    public function getIdConvocatoria() {
        return $this->idConvocatoria;
    }

    public function getIdSolicitud() {
        return $this->idSolicitud;
    }

    public function getIdItemBaremable() {
        return $this->idItemBaremable;
    }

    public function getNotaProvisional() {
        return $this->notaProvisional;
    }

    public function getNotaDefinitiva() {
        return $this->notaDefinitiva;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setIdConvocatoria($idConvocatoria) {
        $this->idConvocatoria = $idConvocatoria;
    }

    public function setIdSolicitud($idSolicitud) {
        $this->idSolicitud = $idSolicitud;
    }

    public function setIdItemBaremable($idItemBaremable) {
        $this->idItemBaremable = $idItemBaremable;
    }

    public function setNotaProvisional($notaProvisional) {
        $this->notaProvisional = $notaProvisional;
    }

    public function setNotaDefinitiva($notaDefinitiva) {
        $this->notaDefinitiva = $notaDefinitiva;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    
}
?>
