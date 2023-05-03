<?php
require 'vendor/autoload.php';
require_once (_ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once (_ROOT_CONTROLLER . 'admin/AdministrarArchivos.php');
require_once (_ROOT_MODEL . 'conexion.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

class RRHH extends handleSanitize {
    private $file;
    private $conexion;

    public function __construct( )
    {   
        $this->file = _ROOT_FILES . 'asistencia/';
        $this->conexion = new MySQLConnection();
    }

    public function loadFile()
    {
        try {    
            $gestorArchivo = new AdministrarArchivos($this->conexion, "asistencia/");
            $archivo = $_FILES["archivo"];
            if ($gestorArchivo->validarArchivo($archivo, ['xls', 'xlsx']) == false) {
                return;
            }

            $this->file = _ROOT_FILES . 'asistencia/' .  $gestorArchivo->guardarFichero($archivo, 'Registro de visitas');
            $respuesta = array("status" => "success", "message" => "Archivo recibido con éxito.");
            echo (json_encode($respuesta));
        } catch (Throwable $e) {
            $this->handlerError($e) ;
        }
    }

    public function readExcel()
    {
        try {
            $sql = "INSERT INTO asistencia (id_empleado, nombres, departamento, fecha, hora) VALUES ";
            $spreedsheet = IOFactory::load($this->file);
            $worksheet = $spreedsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = 'E';
            
            for($row = 3; $row <= $highestRow; $row++){
                $sqlValues = "(";
                for($col = 'A'; $col <= $highestColumn; $col++){
                    $cell = $worksheet->getCell($col.$row);
                    $value = $cell->getValue();
                    $sqlValues .= "'".addslashes($value)."', ";        
                }
                $sqlValues = rtrim($sqlValues, ", ").")";
                $sql .= $sqlValues.", ";
            }
            $sql = rtrim($sql, ", ");
            $this->conexion->query($sql, '', '', false);
            $respuesta = array('status'=>'success', 'message'=>'Registro de marcación registrado.'); 
            echo (json_encode($respuesta));
        } catch (Throwable $e) {
            $this->handlerError($e);
        }
    }

    public function busqueda()
    {
        try {

        } catch(Throwable $e) {
            $this->handlerError($e);
        }
    } 

    private function selectForBusqueda()
    {
        try {

        } catch(Throwable $e) {
            $this->handlerError($e);
        }
    }
}