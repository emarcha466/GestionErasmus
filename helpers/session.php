<?php
class session{
    public static function createSession($sesion,$valor){
        session_start();
        $_SESSION[$sesion]=$valor;
    }

    public static function foundSession($sesion){
        return isset( $_SESSION[$sesion]);
    }

    public static function arrayToSession($sesion, $array){
        $_SESSION[$sesion] = $array;
    }
}