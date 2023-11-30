<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";

class DestinatarioRepo {
    /**
     * Funcion que devuelve un array con todos los destinatarios
     * 
     * @return array Array de clases Destinatario
     */
    public static function getDestinatarios()
    {
        $conexion = GBD::getConexion();
        $select = "select * from destinatario;";
        $stmt = $conexion->query($select);
        $destinatarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $destinatariosObject = [];

        foreach ($destinatarios as $destinatario) {
            $destinatariosObject[] = new Destinatario(
                $destinatario['codigoGrupo'],
                $destinatario['nombre']
            );
        }
        return $destinatariosObject;
    }

    /**
     * Funcion que devuelve un destinatario buscando por su codigoGrupo
     * 
     * @param string $codigoGrupo codigoGrupo del destinatario a buscar
     * @return Destinatario Destinatario con el codigoGrupo pasado como parámetro
     */
    public static function getDestinatarioByCodigoGrupo($codigoGrupo)
    {
        $conexion = GBD::getConexion();
        $select = "select * from destinatario where codigoGrupo = :codigoGrupo;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':codigoGrupo', $codigoGrupo);
        $stmt->execute();
        $destinatario = $stmt->fetch(PDO::FETCH_ASSOC);

        $destinatarioObject = new Destinatario(
            $destinatario['codigoGrupo'],
            $destinatario['nombre']
        );
        return $destinatarioObject;
    }

    /**
     * Funcion que elimina un destinatario por su codigoGrupo
     * 
     * @param string $codigoGrupo codigoGrupo del destinatario a borrar
     * @return int 1 si lo borra, 0 si no lo borra
     */
    public static function deleteDestinatarioByCodigoGrupo($codigoGrupo)
    {
        $conexion = GBD::getConexion();
        $delete = "delete from destinatario where codigoGrupo = :codigoGrupo;";
        $stmt = $conexion->prepare($delete);
        $stmt->bindParam(':codigoGrupo', $codigoGrupo);
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Funcion que actualiza un destinatario con los parámetros del destinatario pasado como parámetro
     * 
     * @param Destinatario $destinatario Destinatario a actualizar
     * @return int 1 se se acualiza, 0 si no lo hace
     */
    public static function updateDestinatario($destinatario)
    {
        $conexion = GBD::getConexion();
        $update = "UPDATE destinatario SET nombre = :nombre WHERE codigoGrupo = :codigoGrupo;";
        $stmt = $conexion->prepare($update);
        $params = [
            ':codigoGrupo' => $destinatario->getCodigoGrupo(),
            ':nombre' => $destinatario->getNombre()
        ];

        $stmt->execute($params);
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Funcion que inserta un nuevo destinatario a la bd
     * 
     * @param Destinatario $destinatario Destinatario a insertar
     * @return int 1 si se ha insertado, 0 si no se ha insertado
     */
    public static function setDestinatario($destinatario)
    {
        try {
            $conexion = GBD::getConexion();
            $insert = "INSERT INTO destinatario (codigoGrupo, nombre) VALUES (:codigoGrupo, :nombre);";
            $stmt = $conexion->prepare($insert);
            $params = [
                ':codigoGrupo' => $destinatario->getCodigoGrupo(),
                ':nombre' => $destinatario->getNombre()
            ];
            $stmt->execute($params);
            $rows = $stmt->rowCount();

            return $rows;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "Error al añadir el destinatario"));
            } else {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => $e->getMessage()));
            }
        }
    }
}
