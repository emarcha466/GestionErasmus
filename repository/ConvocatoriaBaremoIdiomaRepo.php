<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";

class ConvocatoriaBaremoIdiomaRepo
{
    /**
     * Obtiene todos los ConvocatoriaBaremoIdioma de la base de datos.
     *
     * @return array Un array de objetos ConvocatoriaBaremoIdioma.
     */
    public static function getConvocatoriaBaremoIdiomas()
    {
        $conexion = GBD::getConexion();
        $select = "select * from convocatoriaBaremoIdioma;";
        $stmt = $conexion->query($select);
        $convocatoriaBaremoIdiomas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $convocatoriaBaremoIdiomasObject = [];

        foreach ($convocatoriaBaremoIdiomas as $convocatoriaBaremoIdioma) {
            $convocatoriaBaremoIdiomasObject[] = new ConvocatoriaBaremoIdioma(
                $convocatoriaBaremoIdioma['idIdioma'],
                $convocatoriaBaremoIdioma['idConvocatoria'],
                $convocatoriaBaremoIdioma['puntos']
            );
        }
        return $convocatoriaBaremoIdiomasObject;
    }

    /**
     * Obtiene un ConvocatoriaBaremoIdioma por su idIdioma y idConvocatoria.
     *
     * @param int $idIdioma El idIdioma del ConvocatoriaBaremoIdioma.
     * @param int $idConvocatoria El idConvocatoria del ConvocatoriaBaremoIdioma.
     * @return ConvocatoriaBaremoIdioma Un objeto ConvocatoriaBaremoIdioma.
     */
    public static function getConvocatoriaBaremoIdiomaById($idIdioma, $idConvocatoria)
    {
        $conexion = GBD::getConexion();
        $select = "select * from convocatoriaBaremoIdioma where idIdioma = :idIdioma and idConvocatoria = :idConvocatoria;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':idIdioma', $idIdioma);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria);
        $stmt->execute();
        $convocatoriaBaremoIdioma = $stmt->fetch(PDO::FETCH_ASSOC);

        $convocatoriaBaremoIdiomaObject = new ConvocatoriaBaremoIdioma(
            $convocatoriaBaremoIdioma['idIdioma'],
            $convocatoriaBaremoIdioma['idConvocatoria'],
            $convocatoriaBaremoIdioma['puntos']
        );
        return $convocatoriaBaremoIdiomaObject;
    }

    /**
     * Elimina un ConvocatoriaBaremoIdioma por su idIdioma y idConvocatoria.
     *
     * @param int $idIdioma El idIdioma del ConvocatoriaBaremoIdioma.
     * @param int $idConvocatoria El idConvocatoria del ConvocatoriaBaremoIdioma.
     * @return int Devuelve 1 si el ConvocatoriaBaremoIdioma se ha eliminado correctamente, 0 en caso contrario.
     */
    public static function deleteConvocatoriaBaremoIdiomaById($idIdioma, $idConvocatoria)
    {
        $conexion = GBD::getConexion();
        $delete = "delete from convocatoriaBaremoIdioma where idIdioma = :idIdioma and idConvocatoria = :idConvocatoria;";
        $stmt = $conexion->prepare($delete);
        $stmt->bindParam(':idIdioma', $idIdioma);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria);
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Elimina un ConvocatoriaBaremoIdioma por su idConvocatoria.
     *
     * @param int $idConvocatoria El idConvocatoria del ConvocatoriaBaremoIdioma.
     * @return int Devuelve 1 si el ConvocatoriaBaremoIdioma se ha eliminado correctamente, 0 en caso contrario.
     */
    public static function deleteConvocatoriaBaremoIdiomaByIdConvocatoria($idConvocatoria)
    {
        $conexion = GBD::getConexion();
        $delete = "delete from convocatoriaBaremoIdioma where idConvocatoria = :idConvocatoria;";
        $stmt = $conexion->prepare($delete);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria);
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
    }


    /**
     * Actualiza un ConvocatoriaBaremoIdioma en la base de datos.
     *
     * @param ConvocatoriaBaremoIdioma $convocatoriaBaremoIdioma Un objeto ConvocatoriaBaremoIdioma.
     * @return int Devuelve 1 si el ConvocatoriaBaremoIdioma se ha actualizado correctamente, 0 en caso contrario.
     */
    public static function updateConvocatoriaBaremoIdioma($convocatoriaBaremoIdioma)
    {
        $conexion = GBD::getConexion();
        $update = "UPDATE convocatoriaBaremoIdioma SET puntos = :puntos WHERE idIdioma = :idIdioma and idConvocatoria = :idConvocatoria;";
        $stmt = $conexion->prepare($update);
        $params = [
            ':idIdioma' => $convocatoriaBaremoIdioma->getIdIdioma(),
            ':idConvocatoria' => $convocatoriaBaremoIdioma->getIdConvocatoria(),
            ':puntos' => $convocatoriaBaremoIdioma->getPuntos()
        ];

        $stmt->execute($params);
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Inserta un nuevo ConvocatoriaBaremoIdioma en la base de datos.
     *
     * @param ConvocatoriaBaremoIdioma $convocatoriaBaremoIdioma Un objeto ConvocatoriaBaremoIdioma.
     * @return int Devuelve 1 si el ConvocatoriaBaremoIdioma se ha insertado correctamente, 0 en caso contrario.
     */
    public static function setConvocatoriaBaremoIdioma($convocatoriaBaremoIdioma)
    {
        try {
            $conexion = GBD::getConexion();
            $insert = "INSERT INTO convocatoriaBaremoIdioma (idIdioma, idConvocatoria, puntos) VALUES (:idIdioma, :idConvocatoria, :puntos);";
            $stmt = $conexion->prepare($insert);
            $params = [
                ':idIdioma' => $convocatoriaBaremoIdioma->getIdIdioma(),
                ':idConvocatoria' => $convocatoriaBaremoIdioma->getIdConvocatoria(),
                ':puntos' => $convocatoriaBaremoIdioma->getPuntos()
            ];
            $stmt->execute($params);
            $rows = $stmt->rowCount();

            return $rows;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "Error al añadir el convocatoriaBaremoIdioma"));
            } else {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => $e->getMessage()));
            }
        }
    }
}
