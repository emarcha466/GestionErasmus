<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";

class ConvocatoriaRepo{

    /**
     * Funcion que devuelve un array con todas las convocatorias
     * 
     * @return array Array de clases convocatorias
     */
    public static function getConvocatorias(){

        $conexion = GBD::getConexion();
        $select = "select * from convocatoria;";
        $stmt = $conexion->query($select);
        $convocatorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $convocatoriasObject = [];

        foreach($convocatorias as $convocatoria){
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
    public static function getConvocatoriaById($id){
        $conexion = GBD::getConexion();
        $select = "select * from convocatoria where id = :id;";
        $stmt = $conexion->prepare($select);
        $stmt ->bindParam(':id', $id);
        $stmt ->execute();
        $convocatoria = $stmt->fetch(PDO::FETCH_ASSOC);

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
        return $convoatoriaObject;
    }

    /**
     * Funcion pasando una fecha, develve las convocatorias que su periodo de solicitud se encuentre activo en la fecha pasada
     * 
     * @param date Fecha que se quiere comprobar
     * @return array Convocatorias cuyo periode de solicitud se encuentre abierto
     */
    public static function getConvocatoriasEnPeriodoSolicitud($date){
        $conexion = GBD::getConexion();
        $select = "SELECT * FROM convocatoria WHERE fechaIniSolicitud <= :date AND fechaFinSolicitud >= :date;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        $convocatorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $convocatoriasObject = [];

        foreach($convocatorias as $convocatoria) {
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
    public static function deleteConvocatoriaById($id){
        $conexion = GBD::getConexion();
        $delete = "delete from convocatoria where id = :id;";
        $stmt = $conexion->prepare($delete);
        $stmt ->bindParam(':id', $id);
        $stmt ->execute();
        $rows = $stmt -> rowCount();
        return $rows;
    }

    
    /**
     * Funicion que actualiza una convocatoria con los parámetros de la convocatoria pasada como parámetro
     * 
     * @param convocatoria $convocatoria Convocatoria a actualizar
     * @return int 1 se se acualiza, 0 si no lo hace
     */
    public static function updateConvocatoria($convocatoria){
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

        $stmt -> execute($params);
        $rows = $stmt ->rowCount();
        return $rows;
    }

    /**
     * Funcion que inserta una nueva convocatoria a la bd
     * 
     * @param convocatoria Convocatoria a insertar
     * @return int 1 si se ha insertado, 0 si no se ha insertado
     */
    public static function setConvocatoria($convocatoria){
        try {
            $conexion = GBD::getConexion();
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
            $rows = $stmt->rowCount();

            return $rows;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                http_response_code(400);
                echo json_encode(array("status"=>"error", "message"=>"Error al añadir la convocatoria"));
            } else {
                http_response_code(400);
                echo json_encode(array("status"=>"error", "message"=>$e->getMessage()));
            }
        }
    }
}   

$convocatoria = new Convocatoria(null, 10, 150, 'Larga duración', '2023-01-01', '2023-02-28', '2023-03-01', '2023-04-30',
    '2023-05-01', '2023-06-30', 'PROJ005', 'Destino12');

$convocatoria2 = new Convocatoria(1, 10, 150, 'Larga duración', '2023-01-01', '2023-02-28', '2023-03-01', '2023-04-30',
'2023-05-01', '2023-06-30', 'PROJ005', 'Destino12');

$date = date('Y-m-d');
var_dump(ConvocatoriaRepo::setConvocatoria($convocatoria));
//var_dump(ConvocatoriaRepo::updateConvocatoria($convocatoria2));
//var_dump(ConvocatoriaRepo::deleteConvocatoriaById(8));
//var_dump(ConvocatoriaRepo::getConvocatorias());
//var_dump(ConvocatoriaRepo::getConvocatoriaById(1));
//var_dump(ConvocatoriaRepo::getConvocatoriasEnPeriodoSolicitud($date));