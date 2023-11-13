<?php

require_once _ROOT_MODEL . 'conexion.php';

class AccessInformationModel 
{
    public static function save(
        $nombreCompleto,
        $tipoDocumento,
        $numeroDocumento,
        $personaEdad,         
        $email,
        $telefono,
        $direccion,
        $departamento,
        $provincia,
        $distrito,
        $descripcion,
        $archivo = null
        )
    {
        $conexion = new MySQLConnection();
        $sql = "INSERT INTO access_to_information (full_name, type_doc, doc_number, range_age, email, phone, address, departamento, provincia, distrito, descriptions, file)
                values  (:nombreCompleto, :tipoDocumento, :numeroDocumento, :personaEdad, :email, :telefono, :direccion, :departamento, :provincia, :distrito, :descripcion, :archivo) ";
        $params = [
            ':nombreCompleto'=> $nombreCompleto,  
            ':tipoDocumento'=> $tipoDocumento,
            ':numeroDocumento'=> $numeroDocumento, 
            ':personaEdad'=> $personaEdad,          
            ':email'=> $email, 
            ':telefono'=> $telefono, 
            ':direccion'=> $direccion, 
            ':departamento'=> $departamento, 
            ':provincia' => $provincia,
            ':distrito'=> $distrito, 
            ':descripcion'=> $descripcion,
            ':archivo'=> $archivo
        ];
        $stmt = $conexion->query($sql, $params, '', false);
        return  true;
    }
}