<?php
require_once (_ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once  (_ROOT_MODEL . 'conexion.php');

class Main extends handleSanitize {

    private $ruta;
    
    public function __construct()
    {
        $this->ruta = _ROOT_FILES . 'pagina-principal/';  
    }

    public function datosGobernador() {

        try {    
            if (
                empty($_POST["titulo"]) || 
                empty($_POST["mensaje"]) || 
                empty($_POST["frase"]) || 
                empty($_POST["entrada"])
            ) {
                throw new Exception("Debe completar todos los campos del formulario.");
            }
            $conexion = new MySQLConnection();

            $titulo = $this->SanitizeVarInput($_POST["titulo"]);
            $mensaje = $this->SanitizeVarInput($_POST["mensaje"]);
            $frase = $this->SanitizeVarInput($_POST["frase"]);
            $entrada = $this->SanitizeVarInput($_POST["entrada"]);

            $archivo = $_FILES["imgGobernador"] ?? null;

            if ($this->validarArchivo($archivo) == true) {
                $this->borrarArchivo($conexion);
                $newPathFile = $this->guardarFichero($archivo, $titulo);
                $this->UpdateSetBd($conexion, $titulo, $mensaje, $frase, $entrada, $newPathFile);
                return;
            }
            $this->UpdateSetBd($conexion, $titulo, $mensaje, $frase, $entrada);
        } catch (Throwable $e) {
            $this->handlerError($e);
            return;
        }
    }  

    private function UpdateSetBd(MySQLConnection $conexion, $titulo, $mensaje, $frase, $entrada, $newPathFile = null)
    {
        $sql = "UPDATE gobernador SET titulo = :titulo, mensaje = :mensaje , entrada = :entrada, frase = :frase";
        $params[":titulo"] = $titulo;
        $params[":mensaje"] = $mensaje;
        $params[":entrada"] = $entrada;
        $params[":frase"] = $frase;
        try {
            if ($newPathFile !==null) {
                $sql .= ", img = :img";
                $params[":img"] = $newPathFile;
            }
            $sql .= " WHERE id_gobernador = 1";
            $conexion->query($sql, $params, '', false);
            $conexion->close();
            $respuesta = array ("success" => "Registro actualizado exitosamente.");
            print_r(json_encode($respuesta));

        } catch (Throwable $e) {
            $respuesta = array ("error" => "La actualizacion ha fallado.");
            print_r(json_encode($respuesta));
            $this->handlerError($e);
        }
    }

    private function validarArchivo ($archivo)
    {
        if (empty ($archivo)) {
            return false; 
        }

        $archivoNombre = $archivo['name'];
        $extensionesPermitidas = ['webpg', 'jpg'];
        $extension = strtolower(pathinfo($archivoNombre , PATHINFO_EXTENSION));

        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            $respuesta = array ("error" => "Error al subir el archivo");
            print_r(json_encode($respuesta));
            return false;
        }

        if (!in_array($extension, $extensionesPermitidas)){
            $respuesta = array ("error" => "Extensión de archivo no permitida.");
            print_r(json_encode($respuesta));
            return false;
        }
        return true; 
    }

    private function guardarFichero ($archivo, $titulo)
    {
        $rutaArchivo = $this->crearRuta();

        $archivotemp = $archivo['tmp_name'];
        $extension = strtolower(pathinfo($archivo["name"] , PATHINFO_EXTENSION));
        $nuevoNombre = $titulo . '-'. date("H-i-s-m-d-Y.") . $extension;
        $pathFullFile = $rutaArchivo . $nuevoNombre;

        if (!move_uploaded_file($archivotemp, $pathFullFile)) {
            $respuesta = array ("error" => "No se pudo guardar el archivo para actualizar el registro.");
            print_r(json_encode($respuesta));
            return;
        } 
        return $nuevoNombre;
    }
    
    private function crearRuta (): string
    {       
        $pathForFile = $this->ruta ;

        if (!file_exists($pathForFile)) {
            mkdir($pathForFile, 0777, true);
        }
        $finalPathForFile = $pathForFile . '/';
        return $finalPathForFile;
    }

    private function borrarArchivo (MySQLConnection $conexion)
    {
        $sql = "SELECT img FROM gobernador";
        $stmt = $conexion->query($sql, '', '', false);
        $resultado = $stmt->fetchColumn();
        $file_to_delete = $this->ruta .  $resultado;
        if (!unlink($file_to_delete)) {
            $respuesta = array("error" => "No se puede actualizar el archivo. Inténtelo más tarde o contacte con el soporte de la página.");
            print_r(json_encode($respuesta)); 
            throw new Exception("No se pudo reemplazar el archivo. Controlador de actualizacion, funcion reemplazar archivo");
        }
    }
}