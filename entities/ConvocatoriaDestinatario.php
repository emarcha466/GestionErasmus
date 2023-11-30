<?php
class ConvocatoriaDestinatario implements JsonSerializable {
    private $codigoGrupo;
    private $idConvocatoria;

    //constructor
    public function __construct($codigoGrupo, $idConvocatoria) {
        $this->codigoGrupo = $codigoGrupo;
        $this->idConvocatoria = $idConvocatoria;
    }

    //para pasar a json
    public function jsonSerialize() {
        return [
            'codigoGrupo' => $this->codigoGrupo,
            'idConvocatoria' => $this->idConvocatoria
        ];
    }

    //gettes y settes
    public function getCodigoGrupo() {
        return $this->codigoGrupo;
    }

    public function setCodigoGrupo($codigoGrupo) {
        $this->codigoGrupo = $codigoGrupo;
    }

    public function getIdConvocatoria() {
        return $this->idConvocatoria;
    }

    public function setIdConvocatoria($idConvocatoria) {
        $this->idConvocatoria = $idConvocatoria;
    }  
}
