<?php
require_once "autocargador.php";

class login{

    public static function identifica($usuario,$contrasena){
        return UserRepo::verifyUser($usuario,$contrasena);
    }
}