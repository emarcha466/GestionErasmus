<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";

class ConvocatoriaRepo
{



    /**
     * Funcion que devuelve el estado de la convocatoria
     *
     * @param int $idConvocatoria El ID de la convocatoria.
     * @param string $fecha La fecha
     * @return string El estado de la convocatoria.
     *
     * Este método toma como argumentos un ID de convocatoria y una fecha. Busca en la base de datos la convocatoria con el ID proporcionado.
     * Si la encuentra, crea un objeto Convocatoria y comprueba en qué período se encuentra la convocatoria basándose en la fecha proporcionada.
     * Los posibles estados son: "SOLICITUD", "PRUEBAS", "LISTADO_PROVISIONAL", "LISTADO_DEFINITIVO" y "No estás en ningún período.".
     * Si no encuentra ninguna convocatoria con el ID proporcionado, devuelve "No se encontró ninguna convocatoria con el ID proporcionado.".
     */
    public static function getConvocatoriaStatus($idConvocatoria, $fecha)
    {
        $conexion = GBD::getConexion();
        $select = "SELECT * FROM convocatoria WHERE id = :idConvocatoria;";
        $stmt = $conexion->prepare($select);
        $stmt->execute([':idConvocatoria' => $idConvocatoria]);
        $convocatoria = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($convocatoria) {
            $convocatoriaObj = new Convocatoria(
                $convocatoria['id'],
                $convocatoria['num_movilidades'],
                $convocatoria['duracion'],
                $convocatoria['tipo'],
                $convocatoria['fechaIniSolicitud'],
                $convocatoria['fechaFinSolicitud'],
                $convocatoria['fechaIniPruebas'],
                $convocatoria['fechaFinPruebas'],
                $convocatoria['fechaListadoProvisional'],
                $convocatoria['fechaListadoDefinitivo'],
                $convocatoria['codigoProyecto'],
                $convocatoria['destino']
            );
            if ($fecha >= $convocatoriaObj->getFechaIniSolicitud() && $fecha <= $convocatoriaObj->getFechaFinSolicitud()) {
                return "SOLICITUD";
            } elseif ($fecha >= $convocatoriaObj->getFechaIniPruebas() && $fecha <= $convocatoriaObj->getFechaFinPruebas()) {
                return "PRUEBAS";
            } elseif ($fecha == $convocatoriaObj->getFechaListadoProvisional()) {
                return "LISTADO_PROVISIONAL";
            } elseif ($fecha == $convocatoriaObj->getFechaListadoDefinitivo()) {
                return "LISTADO_DEFINITIVO";
            } else {
                return "No estás en ningún período.";
            }
        } else {
            return "No se encontró ninguna convocatoria con el ID proporcionado.";
        }
    }

    /**
     * Funcion que devuelve un array con todas las convocatorias
     * 
     * @return array Array de clases convocatorias
     */
    public static function getConvocatorias()
    {

        $conexion = GBD::getConexion();
        $select = "select * from convocatoria;";
        $stmt = $conexion->query($select);
        $convocatorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $convocatoriasObject = [];

        foreach ($convocatorias as $convocatoria) {
            $convocatoriasObject[] = new Convocatoria(
                $convocatoria['id'],
                $convocatoria['num_movilidades'],
                $convocatoria['duracion'],
                $convocatoria['tipo'],
                $convocatoria['fechaIniSolicitud'],
                $convocatoria['fechaFinSolicitud'],
                $convocatoria['fechaIniPruebas'],
                $convocatoria['fechaFinPruebas'],
                $convocatoria['fechaListadoProvisional'],
                $convocatoria['fechaListadoDefinitivo'],
                $convocatoria['codigoProyecto'],
                $convocatoria['destino']
            );
        }
        return $convocatoriasObject;
    }

    /**
     * Funcion que devuelve una convocatoria buscando por su id
     * 
     * @param int $id Id de la convocatoria a buscar
     * @return convocatoria Convocatoria con el id pasado como parámetro
     */
    public static function getConvocatoriaById($id)
    {
        $conexion = GBD::getConexion();
        $select = "select * from convocatoria where id = :id;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $convocatoria = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($convocatoria) {
            $convoatoriaObject = new Convocatoria(
                $convocatoria['id'],
                $convocatoria['num_movilidades'],
                $convocatoria['duracion'],
                $convocatoria['tipo'],
                $convocatoria['fechaIniSolicitud'],
                $convocatoria['fechaFinSolicitud'],
                $convocatoria['fechaIniPruebas'],
                $convocatoria['fechaFinPruebas'],
                $convocatoria['fechaListadoProvisional'],
                $convocatoria['fechaListadoDefinitivo'],
                $convocatoria['codigoProyecto'],
                $convocatoria['destino']
            );
        } else {
            $convoatoriaObject = null;
        }

        return $convoatoriaObject;
    }

    /**
     * Funcion pasando una fecha, develve las convocatorias que su periodo de solicitud se encuentre activo en la fecha pasada
     * 
     * @param date Fecha que se quiere comprobar
     * @return array Convocatorias cuyo periode de solicitud se encuentre abierto
     */
    public static function getConvocatoriasEnPeriodoSolicitud($date)
    {
        $conexion = GBD::getConexion();
        $select = "SELECT * FROM convocatoria WHERE fechaIniSolicitud <= :date AND fechaFinSolicitud >= :date;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        $convocatorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $convocatoriasObject = [];

        foreach ($convocatorias as $convocatoria) {
            $convocatoriasObject[] = new Convocatoria(
                $convocatoria['id'],
                $convocatoria['num_movilidades'],
                $convocatoria['duracion'],
                $convocatoria['tipo'],
                $convocatoria['fechaIniSolicitud'],
                $convocatoria['fechaFinSolicitud'],
                $convocatoria['fechaIniPruebas'],
                $convocatoria['fechaFinPruebas'],
                $convocatoria['fechaListadoProvisional'],
                $convocatoria['fechaListadoDefinitivo'],
                $convocatoria['codigoProyecto'],
                $convocatoria['destino']
            );
        }

        return $convocatoriasObject;
    }

    /**
     * Funcion que elimnina una convocatoria por su id
     * 
     * @param int $id Id de la convocatoria a borrar
     * @return int 1 si la borra, 0 si no la borra
     */
    public static function deleteConvocatoriaById($id)
    {
        $conexion = GBD::getConexion();
        $conexion->beginTransaction();

        try {
            //Elimino las solicitudes a la convocatoria
            SolicitudRepo::deleteSolicitudesByIdConvocatoria($id);
            //Elimino las baremaciones relacionadas con la convocatoria
            BaremacionRepo::deleteBaremacionById($id);

            //Elimino items baremables de la convocatoria
            ConvocatoriaItemBaremableRepo::deleteItemsBaremablesByConvocatoriaId($id);

            //Elimino destinatarios de la convocatoria
            ConvocatoriaDestinatarioRepo::deleteDestinatariosByConvocatoriaId($id);

            //Elimino baremacionIdioma de la convocatoria
            ConvocatoriaBaremoIdiomaRepo::deleteConvocatoriaBaremoIdiomaByIdConvocatoria($id);

            //Elimino la convocatoria
            $delete = "DELETE FROM convocatoria WHERE id = :id";
            $stmt = $conexion->prepare($delete);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $rows = $stmt->rowCount();

            $conexion->commit();
            return $rows;
        } catch (PDOException $e) {
            $conexion->rollBack();
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => $e->getMessage()));
            return 0;
        }
    }


    /**
     * Funicion que actualiza una convocatoria con los parámetros de la convocatoria pasada como parámetro
     * 
     * @param convocatoria $convocatoria Convocatoria a actualizar
     * @return int 1 se se acualiza, 0 si no lo hace
     */
    public static function updateConvocatoria($convocatoria)
    {
        $conexion = GBD::getConexion();
        $update = "UPDATE convocatoria SET num_movilidades = :num_movilidades, duracion = :duracion, tipo = :tipo, fechaIniSolicitud = :fechaIniSolicitud
                                        , fechaFinSolicitud = :fechaFinSolicitud, fechaIniPruebas = :fechaIniPruebas, fechaFinPruebas = :fechaFinPruebas, 
                                        fechaListadoProvisional = :fechaListadoProvisional, fechaListadoDefinitivo = :fechaListadoDefinitivo, 
                                        codigoProyecto = :codigoProyecto, destino = :destino WHERE id = :id;";
        $stmt = $conexion->prepare($update);
        $params = [
            ':id' => $convocatoria->getId(),
            ':num_movilidades' => $convocatoria->getNumMovilidades(),
            ':duracion' => $convocatoria->getDuracion(),
            ':tipo' => $convocatoria->getTipo(),
            ':fechaIniSolicitud' => $convocatoria->getFechaIniSolicitud(),
            ':fechaFinSolicitud' => $convocatoria->getFechaFinSolicitud(),
            ':fechaIniPruebas' => $convocatoria->getFechaIniPruebas(),
            ':fechaFinPruebas' => $convocatoria->getFechaFinPruebas(),
            ':fechaListadoProvisional' => $convocatoria->getFechaListadoProvisional(),
            ':fechaListadoDefinitivo' => $convocatoria->getFechaListadoDefinitivo(),
            ':codigoProyecto' => $convocatoria->getCodigoProyecto(),
            ':destino' => $convocatoria->getDestino()
        ];

        $stmt->execute($params);
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Funcion que inserta una nueva convocatoria a la bd
     * 
     * @param convocatoria Convocatoria a insertar
     * @return int 1 si se ha insertado, 0 si no se ha insertado
     */
    public static function setConvocatoria($convocatoria)
    {
        try {
            $conexion = GBD::getConexion();
            //inicio la transaccion
            $conexion->beginTransaction();
            $insert = "INSERT INTO convocatoria (num_movilidades, duracion, tipo, fechaIniSolicitud, fechaFinSolicitud, fechaIniPruebas, fechaFinPruebas, 
                fechaListadoProvisional, fechaListadoDefinitivo, codigoProyecto, destino) VALUES (:num_movilidades, :duracion, :tipo, :fechaIniSolicitud, 
                :fechaFinSolicitud, :fechaIniPruebas, :fechaFinPruebas, :fechaListadoProvisional, :fechaListadoDefinitivo, :codigoProyecto, :destino);";
            $stmt = $conexion->prepare($insert);
            $params = [
                ':num_movilidades' => $convocatoria->getNumMovilidades(),
                ':duracion' => $convocatoria->getDuracion(),
                ':tipo' => $convocatoria->getTipo(),
                ':fechaIniSolicitud' => $convocatoria->getFechaIniSolicitud(),
                ':fechaFinSolicitud' => $convocatoria->getFechaFinSolicitud(),
                ':fechaIniPruebas' => $convocatoria->getFechaIniPruebas(),
                ':fechaFinPruebas' => $convocatoria->getFechaFinPruebas(),
                ':fechaListadoProvisional' => $convocatoria->getFechaListadoProvisional(),
                ':fechaListadoDefinitivo' => $convocatoria->getFechaListadoDefinitivo(),
                ':codigoProyecto' => $convocatoria->getCodigoProyecto(),
                ':destino' => $convocatoria->getDestino()
            ];
            $stmt->execute($params);
            $lastId = $conexion->lastInsertId();
            //finalizo la transaccion
            $conexion->commit();
            return $lastId;
        } catch (PDOException $e) {
            //revierto los cambios en caso de error
            $conexion->rollBack();
            if ($e->errorInfo[1] == 1062) {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "Error al añadir la convocatoria"));
            } else {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => $e->getMessage()));
            }
        }
    }
}

$convocatoria = new Convocatoria(
    null,
    10,
    150,
    'Larga duración',
    '2023-01-01',
    '2023-02-28',
    '2023-03-01',
    '2023-04-30',
    '2023-05-01',
    '2023-06-30',
    'PROJ005',
    'Destino12'
);

$convocatoria2 = new Convocatoria(
    1,
    10,
    150,
    'Larga duración',
    '2023-01-01',
    '2023-02-28',
    '2023-03-01',
    '2023-04-30',
    '2023-05-01',
    '2023-06-30',
    'PROJ005',
    'Destino12'
);

$date = date('Y-m-d');
//var_dump(ConvocatoriaRepo::setConvocatoria($convocatoria));
//var_dump(ConvocatoriaRepo::updateConvocatoria($convocatoria2));
//var_dump(ConvocatoriaRepo::deleteConvocatoriaById(8));
//var_dump(ConvocatoriaRepo::getConvocatorias());
//var_dump(ConvocatoriaRepo::getConvocatoriaById(1));
//var_dump(ConvocatoriaRepo::getConvocatoriasEnPeriodoSolicitud($date));