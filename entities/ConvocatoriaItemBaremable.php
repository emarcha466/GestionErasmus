<?php
class ConvocatoriaItemBaremable implements JsonSerializable{

    private $idConvocatoria;
    private $idItem;
    private $importancia;
    private $requisito;
    private $valorMinimo;
    private $aportaAlumno;

    //constructor
    public function __construct($idConvocatoria, $idItem, $importancia, $requisito, $valorMinimo, $aportaAlumno) {
        $this->idConvocatoria = $idConvocatoria;
        $this->idItem = $idItem;
        $this->importancia = $importancia;
        $this->requisito = $requisito;
        $this->valorMinimo = $valorMinimo;
        $this->aportaAlumno = $aportaAlumno;
    }

    //para pasar a json
    public function jsonSerialize() {
        return [
            'idConvocatoria' => $this->idConvocatoria,
            'idItem' => $this->idItem,
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

    public function setIdConvocatoria($idConvocatoria) {
        $this->idConvocatoria = $idConvocatoria;
    }

    public function getIdItem() {
        return $this->idItem;
    }

    public function setIdItem($idItem) {
        $this->idItem = $idItem;
    }

    public function getImportancia() {
        return $this->importancia;
    }

    public function setImportancia($importancia) {
        $this->importancia = $importancia;
    }

    public function getRequisito() {
        return $this->requisito;
    }

    public function setRequisito($requisito) {
        $this->requisito = $requisito;
    }

    public function getValorMinimo() {
        return $this->valorMinimo;
    }

    public function setValorMinimo($valorMinimo) {
        $this->valorMinimo = $valorMinimo;
    }

    public function getAportaAlumno() {
        return $this->aportaAlumno;
    }

    public function setAportaAlumno($aportaAlumno) {
        $this->aportaAlumno = $aportaAlumno;
    }

    
}