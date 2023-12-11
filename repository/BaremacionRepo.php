<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";

class BaremacionRepo
{

    /**
     * Función que devuelve un array con todas las baremaciones
     * 
     * @return array Array de clases Baremacion
     */
    public static function getBaremaciones()
    {
        $conexion = GBD::getConexion();
        $select = "SELECT * FROM baremacion;";
        $stmt = $conexion->query($select);
        $baremaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $baremacionesObject = [];

        foreach ($baremaciones as $baremacion) {
            $baremacionesObject[] = new Baremacion(
                $baremacion['idConvocatoria'],
                $baremacion['idSolicitud'],
                $baremacion['idItemBaremable'],
                $baremacion['notaProvisional'],
                $baremacion['notaDefinitiva'],
                $baremacion['url']
            );
        }
        return $baremacionesObject;
    }

    /**
     * Función que devuelve una baremacion buscando por su idConvocatoria, idSolicitud, y idItemBaremable
     * 
     * @param int $idConvocatoria idConvocatoria de la baremacion a buscar
     * @param int $idSolicitud idSolicitud de la baremacion a buscar
     * @param int $idItemBaremable idItemBaremable de la baremacion a buscar
     * @return Baremacion Baremacion con el idConvocatoria, idSolicitud, y idItemBaremable pasado como parámetro
     */
    public static function getBaremacionById($idConvocatoria, $idSolicitud, $idItemBaremable)
    {
        $conexion = GBD::getConexion();
        $select = "SELECT * FROM baremacion WHERE idConvocatoria = :idConvocatoria AND idSolicitud = :idSolicitud AND idItemBaremable = :idItemBaremable;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria);
        $stmt->bindParam(':idSolicitud', $idSolicitud);
        $stmt->bindParam(':idItemBaremable', $idItemBaremable);
        $stmt->execute();
        $baremacion = $stmt->fetch(PDO::FETCH_ASSOC);

        $baremacionObject = new Baremacion(
            $baremacion['idConvocatoria'],
            $baremacion['idSolicitud'],
            $baremacion['idItemBaremable'],
            $baremacion['notaProvisional'],
            $baremacion['notaDefinitiva'],
            $baremacion['url']
        );
        return $baremacionObject;
    }

    /**
     * Función que devuelve una baremacion buscando por su idConvocatoria y idSolicitud
     * 
     * @param int $idConvocatoria idConvocatoria de la baremacion a buscar
     * @param int $idSolicitud idSolicitud de la baremacion a buscar
     * @return array Array de Baremacion con el idConvocatoria y idSolicitud pasado como parámetro
     */
    public static function getBaremacionByIdConvocatoriaAndIdSolicitud($idConvocatoria, $idSolicitud)
    {
        $conexion = GBD::getConexion();
        $select = "SELECT * FROM baremacion WHERE idConvocatoria = :idConvocatoria AND idSolicitud = :idSolicitud;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria);
        $stmt->bindParam(':idSolicitud', $idSolicitud);
        $stmt->execute();
        $baremaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $baremacionesObject = [];
        foreach ($baremaciones as $baremacion) {
            $baremacionesObject[] = new Baremacion(
                $baremacion['idConvocatoria'],
                $baremacion['idSolicitud'],
                $baremacion['idItemBaremable'],
                $baremacion['notaProvisional'],
                $baremacion['notaDefinitiva'],
                $baremacion['url']
            );
        }
        return $baremacionesObject;
    }

    /**
     * Función que elimina una baremacion por su idConvocatoria, idSolicitud, y idItemBaremable
     * 
     * @param int $idConvocatoria idConvocatoria de la baremacion a borrar
     * @param int $idSolicitud idSolicitud de la baremacion a borrar
     * @param int $idItemBaremable idItemBaremable de la baremacion a borrar
     * @return int 1 si lo borra, 0 si no lo borra
     */
    public static function deleteBaremacion($idConvocatoria, $idSolicitud, $idItemBaremable)
    {
        $conexion = GBD::getConexion();
        $delete = "DELETE FROM baremacion WHERE idConvocatoria = :idConvocatoria AND idSolicitud = :idSolicitud AND idItemBaremable = :idItemBaremable;";
        $stmt = $conexion->prepare($delete);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria);
        $stmt->bindParam(':idSolicitud', $idSolicitud);
        $stmt->bindParam(':idItemBaremable', $idItemBaremable);
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
    }



    /**
     * Función que elimina una baremacion por su idConvocatoria y idSolicitud
     * 
     * @param int $idConvocatoria idConvocatoria de la baremacion a borrar
     * @param int $idSolicitud idSolicitud de la baremacion a borrar
     * @return int 1 si lo borra, 0 si no lo borra
     */
    public static function deleteBaremacionByIdConvocatoriaAndIdSolicitud($idConvocatoria, $idSolicitud)
    {
        $conexion = GBD::getConexion();
        $delete = "DELETE FROM baremacion WHERE idConvocatoria = :idConvocatoria AND idSolicitud = :idSolicitud;";
        $stmt = $conexion->prepare($delete);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria);
        $stmt->bindParam(':idSolicitud', $idSolicitud);
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Función que elimina una baremacion por su idConvocatoria
     * 
     * @param int $idConvocatoria idConvocatoria de la baremacion a borrar
     * @return int 1 si lo borra, 0 si no lo borra
     */
    public static function deleteBaremacionById($idConvocatoria)
    {
        $conexion = GBD::getConexion();
        $delete = "DELETE FROM baremacion WHERE idConvocatoria = :idConvocatoria;";
        $stmt = $conexion->prepare($delete);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria);
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
    }


    /**
     * Función que actualiza una baremacion con los parámetros de la baremacion pasado como parámetro
     * 
     * @param Baremacion $baremacion Baremacion a actualizar
     * @return int 1 se se acualiza, 0 si no lo hace
     */

    public static function updateBaremacion($baremacion)
    {
        $conexion = GBD::getConexion();
        $update = "UPDATE baremacion SET notaProvisional = :notaProvisional, notaDefinitiva = :notaDefinitiva, url = :url WHERE idConvocatoria = :idConvocatoria AND idSolicitud = :idSolicitud AND idItemBaremable = :idItemBaremable;";
        $stmt = $conexion->prepare($update);
        $params = [
            ':idConvocatoria' => $baremacion->getIdConvocatoria(),
            ':idSolicitud' => $baremacion->getIdSolicitud(),
            ':idItemBaremable' => $baremacion->getIdItemBaremable(),
            ':notaProvisional' => $baremacion->getNotaProvisional(),
            ':notaDefinitiva' => $baremacion->getNotaDefinitiva(),
            ':url' => $baremacion->getUrl()
        ];

        $stmt->execute($params);
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Función que inserta una nueva baremacion a la bd
     * 
     * @param Baremacion $baremacion Baremacion a insertar
     * @return int 1 si se ha insertado, 0 si no se ha insertado
     */
    public static function setBaremacion($baremacion)
    {
        try {
            $conexion = GBD::getConexion();
            $insert = "INSERT INTO baremacion (idConvocatoria, idSolicitud, idItemBaremable, notaProvisional, notaDefinitiva, url) VALUES (:idConvocatoria, :idSolicitud, :idItemBaremable, :notaProvisional, :notaDefinitiva, :url);";
            $stmt = $conexion->prepare($insert);
            $params = [
                ':idConvocatoria' => $baremacion->getIdConvocatoria(),
                ':idSolicitud' => $baremacion->getIdSolicitud(),
                ':idItemBaremable' => $baremacion->getIdItemBaremable(),
                ':notaProvisional' => $baremacion->getNotaProvisional(),
                ':notaDefinitiva' => $baremacion->getNotaDefinitiva(),
                ':url' => $baremacion->getUrl()
            ];
            $stmt->execute($params);
            $rows = $stmt->rowCount();
            return $rows;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "Error al añadir la baremacion"));
            } else {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => $e->getMessage()));
            }
        }
    }
}
