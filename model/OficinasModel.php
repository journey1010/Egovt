<?php

require_once(_ROOT_MODEL . 'conexion.php');

class OficinasModel 
{
    public static function listOficinas ()
    {
        $conexion = new MySQLConnection();
        $sql = "SELECT * FROM oficinas";
        $stmt =  $conexion->query($sql, '', '', false);
        return $stmt->fetchAll();
    }
}