<?php
class Candidato implements JsonSerializable {
    private $dni;
    private $apellidos;
    private $nombre;
    private $fechaNac;
    private $curso;
    private $telefono;
    private $correo;
    private $domicilio;
    private $pass;
    private $idConvocatoria;
    private $dniTutor;
    private $apellidosTutor;
    private $nombreTutor;
    private $telefonoTutor;
    private $domicilioTutor;


    // constructor
    // los datos del tutor son opcionales
    public function __construct($dni, $apellidos, $nombre, $fechaNac, $curso, $telefono, $correo, $domicilio, $pass, $idConvocatoria, 
    $dniTutor = null, $apellidosTutor = null, $nombreTutor = null, $telefonoTutor = null, $domicilioTutor = null) {
        $this->dni = $dni;
        $this->apellidos = $apellidos;
        $this->nombre = $nombre;
        $this->fechaNac = $fechaNac;
        $this->curso = $curso;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->domicilio = $domicilio;
        $this->pass = $pass;
        $this->idConvocatoria = $idConvocatoria;
        $this->dniTutor = $dniTutor;
        $this->apellidosTutor = $apellidosTutor;
        $this->nombreTutor = $nombreTutor;
        $this->telefonoTutor = $telefonoTutor;
        $this->domicilioTutor = $domicilioTutor;
    }


    //jsonserializable

    public function jsonSerialize(){
        return [
            'dni' => $this->dni,
            'apellidos' => $this->apellidos,
            'nombre' => $this->nombre,
            'fechaNac' => $this->fechaNac,
            'curso' => $this->curso,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
            'domicilio' => $this->domicilio,
            'pass' => $this->pass,
            'idConvocatoria' => $this->idConvocatoria,
            'dniTutor' => $this->dniTutor,
            'apellidosTutor' => $this->apellidosTutor,
            'nombreTutor' => $this->nombreTutor,
            'telefonoTutor' => $this->telefonoTutor,
            'domicilioTutor' => $this->domicilioTutor,
        ];
    }

    //getters y setters

    public function getDni() {
        return $this->dni;
    }

    public function setDni($dni) {
        $this->dni = $dni;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getFechaNac() {
        return $this->fechaNac;
    }

    public function setFechaNac($fechaNac) {
        $this->fechaNac = $fechaNac;
    }

    public function getCurso() {
        return $this->curso;
    }

    public function setCurso($curso) {
        $this->curso = $curso;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function getDomicilio() {
        return $this->domicilio;
    }

    public function setDomicilio($domicilio) {
        $this->domicilio = $domicilio;
    }

    public function getPass() {
        return $this->pass;
    }

    public function setPass($pass) {
        $this->pass = $pass;
    }

    public function getIdConvocatoria() {
        return $this->idConvocatoria;
    }

    public function setIdConvocatoria($idConvocatoria) {
        $this->idConvocatoria = $idConvocatoria;
    }

    public function getDniTutor() {
        return $this->dniTutor;
    }

    public function setDniTutor($dniTutor) {
        $this->dniTutor = $dniTutor;
    }

    public function getApellidosTutor() {
        return $this->apellidosTutor;
    }

    public function setApellidosTutor($apellidosTutor) {
        $this->apellidosTutor = $apellidosTutor;
    }

    public function getNombreTutor() {
        return $this->nombreTutor;
    }

    public function setNombreTutor($nombreTutor) {
        $this->nombreTutor = $nombreTutor;
    }

    public function getTelefonoTutor() {
        return $this->telefonoTutor;
    }

    public function setTelefonoTutor($telefonoTutor) {
        $this->telefonoTutor = $telefonoTutor;
    }

    public function getDomicilioTutor() {
        return $this->domicilioTutor;
    }

    public function setDomicilioTutor($domicilioTutor) {
        $this->domicilioTutor = $domicilioTutor;
    }
}
