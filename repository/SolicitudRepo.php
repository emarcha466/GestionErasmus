<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";
class SolicitudoRepo{

    /**
     * Funcion que devuelve un array con todas las solicitudes
     * 
     * @return array Array de clase solicitud
     */
    public static function getSolicitudes(){

        $conexion = GBD::getConexion();
        $select = "select * from solicitud;";
        $stmt = $conexion->query($select);
        $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $solicitudesObject = [];

        foreach ($solicitudes as $solicitud) {
            $solicitudesObject[] = new Solicitud(
                $solicitud['id'],
                $solicitud['dni'],
                $solicitud['apellidos'],
                $solicitud['nombre'],
                $solicitud['fechaNac'],
                $solicitud['curso'],
                $solicitud['telefono'],
                $solicitud['correo'],
                $solicitud['domicilio'],
                $solicitud['pass'],
                $solicitud['idConvocatoria'],
                $solicitud['dniTutor'],
                $solicitud['apellidosTutor'],
                $solicitud['nombreTutor'],
                $solicitud['telefonoTutor'],
                $solicitud['domicilioTutor']
            );
    }
        return $solicitudesObject;
    }


    /**
     * Funcion que devuelve una solicitud buscando por su id
     * 
     * @param int $id Id de la solicitud a buscar
     * @return solicitud Solicitud con el id pasado como parámetro
     */
    public static function getSolicitudById($id){
        $conexion = GBD::getConexion();
        $select = "select * from solicitud where id = :id;";
        $stmt = $conexion->prepare($select);
        $stmt ->bindParam(':id', $id);
        $stmt ->execute();
        $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);

        $solicitudObject = new Solicitud(
            $solicitud['id'],
            $solicitud['dni'],
            $solicitud['apellidos'],
            $solicitud['nombre'],
            $solicitud['fechaNac'],
            $solicitud['curso'],
            $solicitud['telefono'],
            $solicitud['correo'],
            $solicitud['domicilio'],
            $solicitud['pass'],
            $solicitud['idConvocatoria'],
            $solicitud['dniTutor'],
            $solicitud['apellidosTutor'],
            $solicitud['nombreTutor'],
            $solicitud['telefonoTutor'],
            $solicitud['domicilioTutor']
        );
        return $solicitudObject;
    }


    /**
     * Funcion que comprueba que el id, dni y pass concuerdan con los de la solicitud
     * 
     * @param int $id Id de la solicitud
     * @param string $dni Dni de la persona que ha escrito en la solicituda
     * @param string $pass Constraseña establecida en la solicitud
     * @return boolean True coincide, False si no coincide
     */
    public static function solicitarSolicitud($id,$dni,$pass){
        $conexion = GBD::getConexion();
        $select = "select * from solicitud where id = :id and dni like :dni and pass like :pass";
        $stmt = $conexion ->prepare($select);
        $stmt ->bindParam(':id',$id);
        $stmt ->bindParam(':dni',$dni);
        $stmt ->bindParam(':pass',$pass);
        $stmt -> execute();
        $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);

        $solicitudObject = new Solicitud(
            $solicitud['id'],
            $solicitud['dni'],
            $solicitud['apellidos'],
            $solicitud['nombre'],
            $solicitud['fechaNac'],
            $solicitud['curso'],
            $solicitud['telefono'],
            $solicitud['correo'],
            $solicitud['domicilio'],
            $solicitud['pass'],
            $solicitud['idConvocatoria'],
            $solicitud['dniTutor'],
            $solicitud['apellidosTutor'],
            $solicitud['nombreTutor'],
            $solicitud['telefonoTutor'],
            $solicitud['domicilioTutor']
        );
        return $solicitudObject;
    }

    /**
     * Funcion que elimina una solicitud por su id
     * 
     * @param int $id ID 
     */
    public static function deleteSolicitudById($id){

    }
}