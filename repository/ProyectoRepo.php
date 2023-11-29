<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";
class ProyectoRepo
{
    /**
     * Funcion que devuelve un array con todos los proyectos
     * 
     * @return array Array de clases Proyecto
     */
    public static function getProyectos()
    {

        $conexion = GBD::getConexion();
        $select = "select * from proyecto;";
        $stmt = $conexion->query($select);
        $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $proyectosObject = [];

        foreach ($proyectos as $proyecto) {
            $proyectosObject[] = new Proyecto(
                $proyecto['codigoProyecto'],
                $proyecto['nombreProyecto'],
                $proyecto['fechaInicio'],
                $proyecto['fechaFin']
            );
        }
        return $proyectosObject;
    }

    /**
     * Funcion que devuelve un proyecto buscando por su codigoProyecto
     * 
     * @param string $codigoProyecto codigoProyecto del proyecto a buscar
     * @return Proyecto Proyecto con el codigoProyecto pasado como parámetro
     */
    public static function getProyectoByCodigo($codigoProyecto)
    {
        $conexion = GBD::getConexion();
        $select = "select * from proyecto where codigoProyecto = :codigoProyecto;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':codigoProyecto', $codigoProyecto);
        $stmt->execute();
        $proyecto = $stmt->fetch(PDO::FETCH_ASSOC);

        $proyectoObject = new Proyecto(
            $proyecto['codigoProyecto'],
            $proyecto['nombreProyecto'],
            $proyecto['fechaInicio'],
            $proyecto['fechaFin']
        );
        return $proyectoObject;
    }

    /**
     * Funcion que elimina un proyecto por su codigoProyecto
     * 
     * @param string $codigoProyecto codigoProyecto del proyecto a borrar
     * @return int 1 si lo borra, 0 si no lo borra
     */
    public static function deleteProyectoByCodigo($codigoProyecto)
    {
        try {
            $conexion = GBD::getConexion();
            $delete = "delete from proyecto where codigoProyecto = :codigoProyecto;";
            $stmt = $conexion->prepare($delete);
            $stmt->bindParam(':codigoProyecto', $codigoProyecto);
            $stmt->execute();
            $rows = $stmt->rowCount();
            return $rows;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                // excepcion que salta al intentar eliminar un proyecto que tiene alguna convocatoria
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
     * Funcion que actualiza un proyecto con los parámetros del proyecto pasado como parámetro
     * 
     * @param Proyecto $proyecto Proyecto a actualizar
     * @return int 1 se se acualiza, 0 si no lo hace
     */
    public static function updateProyecto($proyecto)
    {
        $conexion = GBD::getConexion();
        $update = "UPDATE proyecto SET nombreProyecto = :nombreProyecto, fechaInicio = :fechaInicio, fechaFin = :fechaFin WHERE codigoProyecto = :codigoProyecto;";
        $stmt = $conexion->prepare($update);
        $params = [
            ':codigoProyecto' => $proyecto->getCodigoProyecto(),
            ':nombreProyecto' => $proyecto->getNombreProyecto(),
            ':fechaInicio' => $proyecto->getFechaInicio(),
            ':fechaFin' => $proyecto->getFechaFin()
        ];

        $stmt->execute($params);
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Funcion que inserta un nuevo proyecto a la bd
     * 
     * @param Proyecto $proyecto Proyecto a insertar
     * @return int 1 si se ha insertado, 0 si no se ha insertado
     */
    public static function setProyecto($proyecto)
    {
        try {
            $conexion = GBD::getConexion();
            $insert = "INSERT INTO proyecto (codigoProyecto, nombreProyecto, fechaInicio, fechaFin) VALUES (:codigoProyecto, :nombreProyecto, :fechaInicio, :fechaFin);";
            $stmt = $conexion->prepare($insert);
            $params = [
                ':codigoProyecto' => $proyecto->getCodigoProyecto(),
                ':nombreProyecto' => $proyecto->getNombreProyecto(),
                ':fechaInicio' => $proyecto->getFechaInicio(),
                ':fechaFin' => $proyecto->getFechaFin()
            ];
            $stmt->execute($params);
            $rows = $stmt->rowCount();

            return $rows;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "Error al añadir el proyecto"));
            } else {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => $e->getMessage()));
            }
        }
    }
}
