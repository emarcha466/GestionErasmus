<?php
class GBD{
    private static $conexion;

    public static function getConexion()
    {
        if(!isset($conexion)){
            self::$conexion = new PDO('mysql:host=localhost;dbname=erasmus','emilio','emilio');
        }
        return self::$conexion;
    }
}