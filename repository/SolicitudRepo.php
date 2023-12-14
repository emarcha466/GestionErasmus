<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";
class SolicitudRepo
{

    /**
     * Funcion que devuelve un array con todas las solicitudes
     * 
     * @return array Array de clase solicitud
     */
    public static function getSolicitudes()
    {

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
                $solicitud['imagen'],
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
    public static function getSolicitudById($id)
    {
        $conexion = GBD::getConexion();
        $select = "select * from solicitud where id = :id;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
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
            $solicitud['imagen'],
            $solicitud['dniTutor'],
            $solicitud['apellidosTutor'],
            $solicitud['nombreTutor'],
            $solicitud['telefonoTutor'],
            $solicitud['domicilioTutor']
        );
        return $solicitudObject;
    }

    /**
     * Funcion que devuelve las solicitudes buscando por idConvocatoria
     * 
     * @param int $idConvocatoria Id de la convocatoria a buscar
     * @return array Array de objetos Solicitud con el idConvocatoria pasado como parámetro
     */
    public static function getSolicitudesByIdConvocatoria($idConvocatoria)
    {
        $conexion = GBD::getConexion();
        $select = "select * from solicitud where idConvocatoria = :idConvocatoria;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria);
        $stmt->execute();
        $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $solicitudesObjects = [];
        foreach ($solicitudes as $solicitud) {
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
                $solicitud['imagen'],
                $solicitud['dniTutor'],
                $solicitud['apellidosTutor'],
                $solicitud['nombreTutor'],
                $solicitud['telefonoTutor'],
                $solicitud['domicilioTutor']
            );
            $solicitudesObjects[] = $solicitudObject;
        }
        return $solicitudesObjects;
    }


    /**
     * Funcion que comprueba que el id, dni y pass concuerdan con los de la solicitud
     * 
     * @param int $id Id de la solicitud
     * @param string $dni Dni de la persona que ha escrito en la solicituda
     * @param string $pass Constraseña establecida en la solicitud
     * @return solicitud/boolean  Solicitud si coinciden los credenciales, False si no coincide, 
     */
    public static function solicitarSolicitud($id, $dni, $pass)
    {
        $conexion = GBD::getConexion();
        $select = "select * from solicitud where id = :id and dni like :dni and pass like :pass";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();
        $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);

        //Si las credenciales de la solicitud no es correcta
        if ($solicitud == false) {
            $solicitudObject = false;
        } //si si son correctas
        else {
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
                $solicitud['imagen'],
                $solicitud['dniTutor'],
                $solicitud['apellidosTutor'],
                $solicitud['nombreTutor'],
                $solicitud['telefonoTutor'],
                $solicitud['domicilioTutor']
            );
        }

        return $solicitudObject;
    }

    /**
     * Funcion que elimina una solicitud por su id
     * 
     * @param int $id ID de la solicitud a borrar
     * @return int Numero de solicitudes eliminadas
     */
    public static function deleteSolicitudById($id)
    {
        try {
            $conexion = GBD::getConexion();
            $delete = "delete from solicitud where id = :id";
            $stmt = $conexion->prepare($delete);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $rows = $stmt->rowCount();

            return $rows;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                // excepcion que salta al intentar eliminar una solicitud que se encuentra en baremacion
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "No se puede eliminar el proyecto ya que existe una convocatoria para el proyecto"));
            } else {
                //Cualquier otra excepcion
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => $e->getMessage()));
            }
        }
    }

    /**
     * Función que elimina las solicitudes relacionadas con una convocatoria por su ID de convocatoria
     * 
     * @param int $idConvocatoria ID de la convocatoria
     * @return int Número de filas afectadas
     */
    public static function deleteSolicitudesByIdConvocatoria($idConvocatoria)
    {
        $conexion = GBD::getConexion();
        $delete = "DELETE FROM solicitud WHERE idConvocatoria = :idConvocatoria;";
        $stmt = $conexion->prepare($delete);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria);
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Funicion que actualiza una solicitud con los parámetros de la solicitud pasada como parámetro
     * 
     * @param solicitud $solicitud Solicitud a actualizar
     * @return int 1 se se acualiza, 0 si no lo hace
     */
    public static function updateSolicitud($solicitud)
    {
        $conexion = GBD::getConexion();
        $update = "UPDATE solicitud SET dni = :dni, apellidos = :apellidos, nombre = :nombre, fechaNac = :fechaNac, 
        curso = :curso, telefono = :telefono, correo = :correo, domicilio = :domicilio, pass = :pass, 
        idConvocatoria = :idConvocatoria, imagen = :imagen, dniTutor = :dniTutor, apellidosTutor = :apellidosTutor, nombreTutor = :nombreTutor, 
        telefonoTutor = :telefonoTutor, domicilioTutor = :domicilioTutor WHERE id = :id;";
        $stmt = $conexion->prepare($update);
        $params = [
            ':id' => $solicitud->getId(),
            ':dni' => $solicitud->getDni(),
            ':apellidos' => $solicitud->getApellidos(),
            ':nombre' => $solicitud->getNombre(),
            ':fechaNac' => $solicitud->getFechaNac(),
            ':curso' => $solicitud->getCurso(),
            ':telefono' => $solicitud->getTelefono(),
            ':correo' => $solicitud->getCorreo(),
            ':domicilio' => $solicitud->getDomicilio(),
            ':pass' => $solicitud->getPass(),
            ':idConvocatoria' => $solicitud->getIdConvocatoria(),
            ':imagen' => $solicitud->getImagen(),
            ':dniTutor' => $solicitud->getDniTutor(),
            ':apellidosTutor' => $solicitud->getApellidosTutor(),
            ':nombreTutor' => $solicitud->getNombreTutor(),
            ':telefonoTutor' => $solicitud->getTelefonoTutor(),
            ':domicilioTutor' => $solicitud->getDomicilioTutor()
        ];

        $stmt->execute($params);
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Función que inserta una nueva solicitud a la bd
     * 
     * @param Solicitud $solicitud Solicitud a insertar
     * @return int 1 si se ha insertado, 0 si no se ha insertado
     */
    public static function setSolicitud($solicitud)
    {
        try {
            $conexion = GBD::getConexion();
            //inicio de la transaccion
            $conexion->beginTransaction();
            $insert = "INSERT INTO solicitud (dni, apellidos, nombre, fechaNac, curso, telefono, correo,
                domicilio, pass, idConvocatoria, imagen, dniTutor, apellidosTutor, nombreTutor, telefonoTutor, domicilioTutor) 
                VALUES (:dni, :apellidos, :nombre, :fechaNac, :curso, :telefono, :correo, :domicilio, :pass, 
                :idConvocatoria, :imagen, :dniTutor, :apellidosTutor, :nombreTutor, :telefonoTutor, :domicilioTutor);";
            $stmt = $conexion->prepare($insert);
            $params = [
                ':dni' => $solicitud->getDni(),
                ':apellidos' => $solicitud->getApellidos(),
                ':nombre' => $solicitud->getNombre(),
                ':fechaNac' => $solicitud->getFechaNac(),
                ':curso' => $solicitud->getCurso(),
                ':telefono' => $solicitud->getTelefono(),
                ':correo' => $solicitud->getCorreo(),
                ':domicilio' => $solicitud->getDomicilio(),
                ':pass' => $solicitud->getPass(),
                ':idConvocatoria' => $solicitud->getIdConvocatoria(),
                ':imagen' => $solicitud->getImagen(),
                ':dniTutor' => $solicitud->getDniTutor(),
                ':apellidosTutor' => $solicitud->getApellidosTutor(),
                ':nombreTutor' => $solicitud->getNombreTutor(),
                ':telefonoTutor' => $solicitud->getTelefonoTutor(),
                ':domicilioTutor' => $solicitud->getDomicilioTutor()
            ];
            $stmt->execute($params);
            $lastId = $conexion->lastInsertId();
            //fin de la transaccion
            $conexion->commit();

            return $lastId;
        } catch (PDOException $e) {
            $conexion->rollBack();
            if ($e->errorInfo[1] == 1062) {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "Error al añadir la solicitud"));
            } else {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => $e->getMessage()));
            }
        }
    }
}
