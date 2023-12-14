<?php
class Baremacion implements JsonSerializable {
    private $idConvocatoria;
    private $idSolicitud;
    private $idItemBaremable;
    private $notaProvisional;
    private $notaDefinitiva;
    private $url;
    private $nombre;
    private $importancia;
    private $requisito;
    private $valorMinimo;
    private $aportaAlumno;

    //constructor
    public function __construct($idConvocatoria, $idSolicitud, $idItemBaremable, $notaProvisional, $notaDefinitiva, $url, 
                    $nombre = null, $importancia = null, $requisito = null, $valorMinimo = null, $aportaAlumno = null) {
        $this->idConvocatoria = $idConvocatoria;
        $this->idSolicitud = $idSolicitud;
        $this->idItemBaremable = $idItemBaremable;
        $this->notaProvisional = $notaProvisional;
        $this->notaDefinitiva = $notaDefinitiva;
        $this->url = $url;
        $this->nombre = $nombre;
        $this->importancia = $importancia;
        $this->requisito = $requisito;
        $this->valorMinimo = $valorMinimo;
        $this->aportaAlumno = $aportaAlumno;
    }

    //para pasar a json
    public function jsonSerialize() {
        return [
            'idConvocatoria' => $this->idConvocatoria,
            'idSolicitud' => $this->idSolicitud,
            'idItemBaremable' => $this->idItemBaremable,
            'notaProvisional' => $this->notaProvisional,
            'notaDefinitiva' => $this->notaDefinitiva,
            'url' => $this->url,
            'nombre' => $this->nombre,
            'importancia' => $this->importancia,
            'requisito' => $this->requisito,
            'valorMinimo' => $this->valorMinimo,
            'aportaAlumno' => $this->aportaAlumno
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

    public function getNombre() {
        return $this->nombre;
    }

    public function getImportancia() {
        return $this->importancia;
    }

    public function getRequisito() {
        return $this->requisito;
    }

    public function getValorMinimo() {
        return $this->valorMinimo;
    }

    public function getAportaAlumno() {
        return $this->aportaAlumno;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setImportancia($importancia) {
        $this->importancia = $importancia;
    }

    public function setRequisito($requisito) {
        $this->requisito = $requisito;
    }

    public function setValorMinimo($valorMinimo) {
        $this->valorMinimo = $valorMinimo;
    }

    public function setAportaAlumno($aportaAlumno) {
        $this->aportaAlumno = $aportaAlumno;
    }
}
?>
