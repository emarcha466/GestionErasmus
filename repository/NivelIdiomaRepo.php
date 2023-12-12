<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";

class NivelIdiomaRepo
{

    /**
     * Obtiene todos los niveles de idioma de la base de datos.
     *
     * @return array Un array de objetos NivelIdioma.
     */
    public static function getNivelIdiomas()
    {
        $conexion = GBD::getConexion();
        $select = "select * from nivelIdioma;";
        $stmt = $conexion->query($select);
        $nivelIdiomas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $nivelIdiomasObject = [];

        foreach ($nivelIdiomas as $nivelIdioma) {
            $nivelIdiomasObject[] = new NivelIdioma(
                $nivelIdioma['id'],
                $nivelIdioma['nombre']
            );
        }
        return $nivelIdiomasObject;
    }

    /**
     * Obtiene un nivel de idioma por su ID.
     *
     * @param int $id El ID del nivel de idioma.
     * @return NivelIdioma Un objeto NivelIdioma.
     */
    public static function getNivelIdiomaById($id)
    {
        $conexion = GBD::getConexion();
        $select = "select * from nivelIdioma where id = :id;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $nivelIdioma = $stmt->fetch(PDO::FETCH_ASSOC);

        $nivelIdiomaObject = new NivelIdioma(
            $nivelIdioma['id'],
            $nivelIdioma['nombre']
        );
        return $nivelIdiomaObject;
    }

    /**
     * Elimina un nivel de idioma por su ID.
     *
     * @param int $id El ID del nivel de idioma.
     * @return int Devuelve 1 si el nivel de idioma se ha eliminado correctamente, 0 en caso contrario.
     */
    public static function deleteNivelIdiomaById($id)
    {
        $conexion = GBD::getConexion();
        $delete = "delete from nivelIdioma where id = :id;";
        $stmt = $conexion->prepare($delete);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Actualiza un nivel de idioma en la base de datos.
     *
     * @param NivelIdioma $nivelIdioma Un objeto NivelIdioma.
     * @return int Devuelve 1 si el nivel de idioma se ha actualizado correctamente, 0 en caso contrario.
     */
    public static function updateNivelIdioma($nivelIdioma)
    {
        $conexion = GBD::getConexion();
        $update = "UPDATE nivelIdioma SET nombre = :nombre WHERE id = :id;";
        $stmt = $conexion->prepare($update);
        $params = [
            ':id' => $nivelIdioma->getId(),
            ':nombre' => $nivelIdioma->getNombre()
        ];

        $stmt->execute($params);
        $rows = $stmt->rowCount();
        return $rows;
    }
    /**
     * Inserta un nuevo nivel de idioma en la base de datos.
     *
     * @param NivelIdioma $nivelIdioma Un objeto NivelIdioma.
     * @return int Devuelve 1 si el nivel de idioma se ha insertado correctamente, 0 en caso contrario.
     */
    public static function setNivelIdioma($nivelIdioma)
    {
        try {
            $conexion = GBD::getConexion();
            $insert = "INSERT INTO nivelIdioma (id, nombre) VALUES (:id, :nombre);";
            $stmt = $conexion->prepare($insert);
            $params = [
                ':id' => $nivelIdioma->getId(),
                ':nombre' => $nivelIdioma->getNombre()
            ];
            $stmt->execute($params);
            $rows = $stmt->rowCount();

            return $rows;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "Error al añadir el nivel de idioma"));
            } else {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => $e->getMessage()));
            }
        }
    }
}
