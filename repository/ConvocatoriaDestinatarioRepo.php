<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";
class ConvocatoriaDestinatarioRepo
{
    /**
     * Funcion que devuelve un array con todos los destinatarios de una convocatoria
     * 
     * @param int $idConvocatoria Id de la convocatoria
     * @return array Array de clases Destinatario
     */
    public static function getDestinatariosByConvocatoriaId($idConvocatoria)
    {
        $conexion = GBD::getConexion();
        $select = "select d.* from destinatario d 
               join convocatoria_destinatario cd on d.codigoGrupo = cd.codigoGrupo
               where cd.idConvocatoria = :idConvocatoria;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria);
        $stmt->execute();
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
     * Funcion que elimina los destinatarios de una convocatoria por su idConvocatoria
     * 
     * @param int $idConvocatoria idConvocatoria de la convocatoria a borrar
     * @return int Número de filas afectadas
     */
    public static function deleteDestinatariosByConvocatoriaId($idConvocatoria)
    {
        $conexion = GBD::getConexion();
        $delete = "delete from convocatoria_destinatario where idConvocatoria = :idConvocatoria;";
        $stmt = $conexion->prepare($delete);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria);
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Funcion que inserta nuevas relaciones entre una convocatoria y varios destinatarios a la bd
     * 
     * @param int $idConvocatoria Id de la convocatoria
     * @param array $codigosGrupo Array con los codigosGrupo de los destinatarios
     * @return int Número de filas insertadas
     */
    public static function setDestinatariosParaConvocatoria($idConvocatoria, $codigosGrupo)
    {
        try {
            $conexion = GBD::getConexion();
            $insert = "INSERT INTO convocatoria_destinatario (codigoGrupo, idConvocatoria) VALUES (:codigoGrupo, :idConvocatoria);";
            $stmt = $conexion->prepare($insert);
            $rows = 0;

            foreach ($codigosGrupo as $codigoGrupo) {
                $params = [
                    ':codigoGrupo' => $codigoGrupo,
                    ':idConvocatoria' => $idConvocatoria
                ];
                $stmt->execute($params);
                $rows += $stmt->rowCount();
            }

            return $rows;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "Error al añadir los destinatarios a la convocatoria"));
            } else {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => $e->getMessage()));
            }
        }
    }
}
