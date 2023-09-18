<?php
require_once (_ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once (_ROOT_MODEL . 'conexion.php');

class oficinas extends handleSanitize {

    public function RegistrarOficina () {
        try {
            $nombre = $_POST['nombre'];    
            $sigla = $_POST['sigla'];

            if (!empty($nombre) && !empty($sigla))  {    
                $nombre = $this->SanitizeVarInput($nombre);
                $sigla = $this->SanitizeVarInput($sigla);                

                $conexion = new MySQLConnection ();
                $sqlSentence = "INSERT INTO oficinas (nombre, sigla) VALUES (?,?)";
                $params = [$nombre, $sigla];
                $conexion->query($sqlSentence, $params, '' , false);
                $conexion->close();
                $respuesta = array("success" => "Registro existosamente guardado");
                print_r(json_encode($respuesta));
            } else {
                $respuesta = array("error" => "Alguno de los datos de registro esta vacío.");
                print_r(json_encode($respuesta));
            }
        } catch (Throwable $e) {
            $this->handlerError($e);
            $respuesta = array("error" => "Error en la ejecucion del registro");
            print_r(json_encode($respuesta));  
        }
        return;
    }

    public function ActualizarOficina ()
    {
        try{
            $id =$this->SanitizeVarInput($_POST['id']);        
            $nombre = $this->SanitizeVarInput($_POST['nombre']);
            $sigla = $this->SanitizeVarInput($_POST['sigla']);

            $conexion = new MySQLConnection();
            $sqlSentence = "UPDATE oficinas SET nombre  = ?, sigla = ? WHERE id= ?";
            $params =  [$nombre, $sigla, $id];
            $conexion->query($sqlSentence, $params,  '', false);
            $conexion->close();
            $respuesta = array("success" => "Actualización existosa");
            print_r(json_encode($respuesta)); 
        } catch (Throwable $e) {
            $this->handlerError($e);
            $respuesta = array("Error" => "Error al ejecutar actualización.");
            print_r(json_encode($respuesta));
        }
        return;
    }
}