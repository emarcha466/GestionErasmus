<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "\GestionErasmus/helpers/autocargador.php";

class UserRepo
{
    /**
     * Funcion que devuelve un array con todos los usuarios
     * 
     * @return array Array de clases User
     */
    public static function getUsers()
    {
        $conexion = GBD::getConexion();
        $select = "select * from user;";
        $stmt = $conexion->query($select);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $usersObject = [];

        foreach ($users as $user) {
            $usersObject[] = new User(
                $user['usuario'],
                $user['pass']
            );
        }
        return $usersObject;
    }

    /**
     * Funcion que devuelve un usuario buscando por su nombre de usuario
     * 
     * @param string $usuario Nombre de usuario del usuario a buscar
     * @return User Usuario con el nombre de usuario pasado como parámetro
     */
    public static function getUserByUsuario($usuario)
    {
        $conexion = GBD::getConexion();
        $select = "select * from user where usuario = :usuario;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $userObject = new User(
            $user['usuario'],
            $user['pass']
        );
        return $userObject;
    }

    /**
     * Funcion que elimina un usuario por su nombre de usuario
     * 
     * @param string $usuario Nombre de usuario del usuario a borrar
     * @return int 1 si lo borra, 0 si no lo borra
     */
    public static function deleteUserByUsuario($usuario)
    {
        $conexion = GBD::getConexion();
        $delete = "delete from user where usuario = :usuario;";
        $stmt = $conexion->prepare($delete);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Funcion que actualiza un usuario con los parámetros del usuario pasado como parámetro
     * 
     * @param User $user Usuario a actualizar
     * @return int 1 se se acualiza, 0 si no lo hace
     */
    public static function updateUser($user)
    {
        $conexion = GBD::getConexion();
        $update = "UPDATE user SET pass = :pass WHERE usuario = :usuario;";
        $stmt = $conexion->prepare($update);
        $params = [
            ':usuario' => $user->getUsuario(),
            ':pass' => $user->getPass()
        ];

        $stmt->execute($params);
        $rows = $stmt->rowCount();
        return $rows;
    }

    /**
     * Funcion que inserta un nuevo usuario a la bd
     * 
     * @param User $user Usuario a insertar
     * @return int 1 si se ha insertado, 0 si no se ha insertado
     */
    public static function setUser($user)
    {
        try {
            $conexion = GBD::getConexion();
            $insert = "INSERT INTO user (usuario, pass) VALUES (:usuario, :pass);";
            $stmt = $conexion->prepare($insert);
            $params = [
                ':usuario' => $user->getUsuario(),
                ':pass' => $user->getPass()
            ];
            $stmt->execute($params);
            $rows = $stmt->rowCount();

            return $rows;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "Error al añadir el usuario"));
            } else {
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => $e->getMessage()));
            }
        }
    }

    /**
     * Funcion que verifica si un nombre de usuario y una contraseña coinciden con un usuario en la bd
     * 
     * @param string $usuario Nombre de usuario del usuario a verificar
     * @param string $pass Contraseña del usuario a verificar
     * @return bool True si el usuario y la contraseña coinciden, False en caso contrario
     */
    public static function verifyUser($usuario, $pass)
    {
        $conexion = GBD::getConexion();
        $select = "select * from user where usuario = :usuario and pass = :pass;";
        $stmt = $conexion->prepare($select);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();
        $rows = $stmt -> rowCount();
        if($rows>0){
            $correcto = true;
        }else{
            $correcto = false;
        }
        return $correcto;
    }
}
