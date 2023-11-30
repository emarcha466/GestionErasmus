<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";

class ConvocatoriaItemBaremableRepo {
    /**
     * Funcion que devuelve un array con todos los items baremables de una convocatoria
     * 
     * @param int $idConvocatoria Id de la convocatoria
     * @return array Array de clases ConvocatoriaItemBaremable
     */
    public static function getItemsBaremablesByConvocatoriaId($idConvocatoria)
    {
        $conexion = GBD::getConexion();
        $select = "select cib.* from convocatoria_itemBaremable cib 
                   where cib.idConvocatoria = :idConvocatoria;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria);
        $stmt->execute();
        $itemsBaremables = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $itemsBaremablesObject = [];

        foreach ($itemsBaremables as $itemBaremable) {
            $itemsBaremablesObject[] = new ConvocatoriaItemBaremable(
                $itemBaremable['idConvocatoria'],
                $itemBaremable['idItem'],
                $itemBaremable['importancia'],
                $itemBaremable['requisito'],
                $itemBaremable['valorMinimo'],
                $itemBaremable['aportaAlumno']
            );
        }
        return $itemsBaremablesObject;
    }

    /**
     * Funcion que elimina los items baremables de una convocatoria por su idConvocatoria
     * 
     * @param int $idConvocatoria idConvocatoria de la convocatoria a borrar
     * @return int Número de filas afectadas
     */
    public static function deleteItemsBaremablesByConvocatoriaId($idConvocatoria)
    {
        $conexion = GBD::getConexion();
        $delete = "delete from convocatoria_itemBaremable where idConvocatoria = :idConvocatoria;";
        $stmt = $conexion->prepare($delete);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria);
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Funcion que inserta nuevas relaciones entre una convocatoria y varios items baremables a la bd
     * 
     * @param int $idConvocatoria Id de la convocatoria
     * @param array $itemsBaremables Array con los items baremables
     * @return int Número de filas insertadas
     */
    public static function setItemsBaremablesParaConvocatoria($idConvocatoria, $itemsBaremables)
    {
        try {
            $conexion = GBD::getConexion();
            $insert = "INSERT INTO convocatoria_itemBaremable (idConvocatoria, idItem, importancia, requisito, valorMinimo, aportaAlumno) 
                       VALUES (:idConvocatoria, :idItem, :importancia, :requisito, :valorMinimo, :aportaAlumno);";
            $stmt = $conexion->prepare($insert);
            $rows = 0;

            foreach ($itemsBaremables as $itemBaremable) {
                $params = [
                    ':idConvocatoria' => $idConvocatoria,
                    ':idItem' => $itemBaremable->getIdItem(),
                    ':importancia' => $itemBaremable->getImportancia(),
                    ':requisito' => $itemBaremable->getRequisito(),
                    ':valorMinimo' => $itemBaremable->getValorMinimo(),
                    ':aportaAlumno' => $itemBaremable->getAportaAlumno()
                ];
                $stmt->execute($params);
                $rows += $stmt->rowCount();
            }

            return $rows;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "Error al añadir los items baremables a la convocatoria"));
            } else {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => $e->getMessage()));
            }
        }
    }
}
