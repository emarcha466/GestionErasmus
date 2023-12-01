<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";
class ItemBaremableRepo
{
    /**
     * Funcion que devuelve un array con todos los items baremables
     * 
     * @return array Array de clases ItemBaremable
     */
    public static function getItemBaremables()
    {

        $conexion = GBD::getConexion();
        $select = "select * from itemBaremable;";
        $stmt = $conexion->query($select);
        $itemsBaremables = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $itemsBaremablesObject = [];

        foreach ($itemsBaremables as $itemBaremable) {
            $itemsBaremablesObject[] = new ItemBaremable(
                $itemBaremable['id'],
                $itemBaremable['nombre']
            );
        }
        return $itemsBaremablesObject;
    }

    /**
     * Funcion que devuelve un item baremable buscando por su id
     * 
     * @param int $id Id del item baremable a buscar
     * @return ItemBaremable ItemBaremable con el id pasado como parámetro
     */
    public static function getItemBaremableById($id)
    {
        $conexion = GBD::getConexion();
        $select = "select * from itemBaremable where id = :id;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $itemBaremable = $stmt->fetch(PDO::FETCH_ASSOC);

        $itemBaremableObject = new ItemBaremable(
            $itemBaremable['id'],
            $itemBaremable['nombre']
        );
        return $itemBaremableObject;
    }

    /**
     * Funcion que elimina un item baremable por su id
     * 
     * @param int $id Id del item baremable a borrar
     * @return int 1 si lo borra, 0 si no lo borra
     */
    public static function deleteItemBaremableById($id)
    {
        $conexion = GBD::getConexion();
        $delete = "delete from itemBaremable where id = :id;";
        $stmt = $conexion->prepare($delete);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Funcion que actualiza un item baremable con los parámetros del item baremable pasado como parámetro
     * 
     * @param ItemBaremable $itemBaremable ItemBaremable a actualizar
     * @return int 1 se se acualiza, 0 si no lo hace
     */
    public static function updateItemBaremable($itemBaremable)
    {
        $conexion = GBD::getConexion();
        $update = "UPDATE itemBaremable SET nombre = :nombre WHERE id = :id;";
        $stmt = $conexion->prepare($update);
        $params = [
            ':id' => $itemBaremable->getId(),
            ':nombre' => $itemBaremable->getNombre()
        ];

        $stmt->execute($params);
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Funcion que inserta un nuevo item baremable a la bd
     * 
     * @param ItemBaremable $itemBaremable ItemBaremable a insertar
     * @return int 1 si se ha insertado, 0 si no se ha insertado
     */
    public static function setItemBaremable($itemBaremable)
    {
        try {
            $conexion = GBD::getConexion();
            $insert = "INSERT INTO itemBaremable (nombre) VALUES (:nombre);";
            $stmt = $conexion->prepare($insert);
            $params = [
                ':nombre' => $itemBaremable->getNombre()
            ];
            $stmt->execute($params);
            $rows = $stmt->rowCount();

            return $rows;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "Error al añadir el item baremable"));
            } else {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => $e->getMessage()));
            }
        }
    }
}
