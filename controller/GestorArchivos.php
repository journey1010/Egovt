<?php
require_once  _ROOT_MODEL . 'conexion.php';
require_once _ROOT_CONTROLLER . 'admin/handleSanitize.php';

class GestorArchivos extends handleSanitize
{

    private $ruta;

    public function __construct($ruta) 
    {
        $this->ruta = _ROOT_FILES . $ruta;
    }

    /**
     *
     * @param mixed $archivos
     * @param array $extensionesPermitidas
     * @return boolean true if extension is validate or false if not
     */
    public function validarArchivos($archivos, array $extensionesPermitidas): bool
    {
        if (empty($archivos)) {
            return false;
        }
    
        foreach ($archivos['error'] as $error) {
            if ($error !== UPLOAD_ERR_OK) {
                $respuesta = array("status" => "error", "message" => "Error al subir el archivo");
                echo(json_encode($respuesta));
                return false;
            }
        }
    
        foreach ($archivos['name'] as $archivoNombre) {
            $extension = strtolower(pathinfo($archivoNombre, PATHINFO_EXTENSION));
            if (!in_array($extension, $extensionesPermitidas)) {
                $extensionMessage = implode(', ', $extensionesPermitidas);
                $respuesta = array("status" => "error", "message" => "Extensión de archivo no permitida. Solo se permiten archivos de extensión: $extensionMessage");
                echo (json_encode($respuesta));
                return false;
            }
        }
    
        return true;
    }
    
    public function guardarArchivos(array $archivos, $titulo)
    {
        $rutaArchivo = $this->crearRuta();
        $nombresArchivos = [];
    
        foreach ($archivos['tmp_name'] as $index => $archivoTemp) {
            $now = microtime(true);
            $milliseconds = (int) (substr($now * 1000, -4));
            $archivoNombre = $archivos['name'][$index];
            $extension = strtolower(pathinfo($archivoNombre, PATHINFO_EXTENSION));
            $nuevoNombre = $titulo . '-' . $milliseconds . date("Y-m-d H-i-s") . '-' . $index . '.' . $extension;
            $pathFullFile = $rutaArchivo . $nuevoNombre;
    
            if (!move_uploaded_file($archivoTemp, $pathFullFile)) {
                echo (json_encode(["status" => "error", "message" => "No se pudo guardar el archivo para actualizar el registro."]));
                return false;
            }
    
            $nombresArchivos[] = $nuevoNombre;
        }
        return $nombresArchivos;
    }   

    public function saveFileFormatJson(array $archivos, $titulo)
    {
        $rutaArchivo = $this->crearRuta();
        $nombresArchivos = [];
    
        foreach ($archivos['tmp_name'] as $index => $archivoTemp) {
            $now = microtime(true);
            $milliseconds = (int) (substr($now * 1000, -4));
            $archivoNombre = $archivos['name'][$index];
            $extension = strtolower(pathinfo($archivoNombre, PATHINFO_EXTENSION));
            $nuevoNombre = $titulo . '-' . $milliseconds . date("Y-m-d-H-i-s") . '-' . $index . '.' . $extension;
            $pathFullFile = $rutaArchivo . $nuevoNombre;
    
            if (!move_uploaded_file($archivoTemp, $pathFullFile)) {
                return false;
            }
            $nombresArchivos[] = ['namefile'=>$archivoNombre, 'file' =>$nuevoNombre];;
        }
        return $nombresArchivos;
    }   

    private function crearRuta (): string
    {       
        $pathForFile = $this->ruta ;
        if (!file_exists($pathForFile)) {
            mkdir($pathForFile, 0755, true);
        }
        return $pathForFile;
    }

    public function borrarArchivo ($sql, $params)
    {
        $conexion  = new MySQLConnection();
        $stmt = $conexion->query($sql, $params, '', false);
        $resultado = $stmt->fetchColumn();
        $file_to_delete = $this->ruta .  $resultado;
        if (!unlink($file_to_delete)) {
            $respuesta = array("status"=>"error", "message" => "No se puede actualizar el archivo. Inténtelo más tarde o contacte con el soporte de la página.");
            print_r(json_encode($respuesta)); 
            throw new Exception("No se pudo reemplazar el archivo. Controlador de actualizacion, funcion reemplazar archivo");
        }
    }

    public function setRuta ($ruta) 
    {
        $this->ruta = $ruta;
    }
}