<?php
require_once (_ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once (_ROOT_MODEL . 'conexion.php');

class oficinas extends handleSanitize {

    public function RegistrarOficina () {
        try {
            $jerarquia = $_POST['jerarquia'];    
            $nombre = $_POST['nombre'];    
            $sigla = $_POST['sigla'];

            if (!empty ($jerarquia) && !empty($nombre) && !empty($sigla))  {
                $jerarquia = $this->SanitizeVarInput($jerarquia);    
                $nombre = $this->SanitizeVarInput($nombre);
                $sigla = $this->SanitizeVarInput($sigla);                

                $jerarquia=strtoupper($jerarquia);
                $nombre = strtoupper($nombre);
                $sigla = strtoupper($sigla);

                $conexion = new MySQLConnection ();
                $sqlSentence = "INSERT INTO oficinas (nombre, sigla, jerarquia) VALUES (?,?,?)";
                $params = [$nombre, $sigla, $jerarquia];
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
            $jerarquia = $this->SanitizeVarInput($_POST['jerarquia']);    
            $nombre = $this->SanitizeVarInput($_POST['nombre']);
            $sigla = $this->SanitizeVarInput($_POST['sigla']);

            $conexion = new MySQLConnection();
            $sqlSentence = "UPDATE oficinas SET  nombre  = ?, sigla = ? , jerarquia = ? WHERE id= ?";
            $params =  [$nombre, $sigla, $jerarquia, $id];
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