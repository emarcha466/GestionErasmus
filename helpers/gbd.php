<?php
require_once 'db_config.php';
class GBD{
    private static $conexion;

    public static function getConexion()
    {
        // * Preguntar a manolo
        if(!isset($conexion)){
            // self::$conexion = new PDO('mysql:host=localhost;dbname=erasmus','emilio','emilio');
            self::$conexion = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        }
        return self::$conexion;
    }
}