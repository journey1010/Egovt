<?php
require_once (_ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once (_ROOT_CONTROLLER . 'admin/AdministrarArchivos.php');
require_once (_ROOT_MODEL . 'conexion.php');

class Convocatoria extends handleSanitize 
{
    private $conexion;
    private $gestorArchivos;

    public function __construct()
    {
        $this->conexion = new MySQLConnection ();
        $this->gestorArchivos = new AdministrarArchivos($this->conexion, 'convocatorias/');
    }
    public function registrar()
    {
        $camposRequeridos =  [
            'tituloConvocatoria', 
            'fechaInicioConvocatoria', 
            'fechaLimiteConvocatoria', 
            'fechaFinalConvocatoria', 
            'dependenciaConvocatoria',
            'descripcionConvocatoria'
        ];
        foreach($camposRequeridos as $campo){
            extract([$campo => $this->SanitizeVarInput($_POST[$campo])]);
        }
        $extensionPermitidas = ['docx', 'xlsx', 'xls', 'pdf', 'txt', 'doc'];
        $archivo =  $_FILES['archivosConvocatorias']; 
        if($this->gestorArchivos->validarArchivo($archivo, $extensionPermitidas) === false){
            return; 
        }
    }

    private function InsertConvocatoria($titulo, $fechIni, $fechLimit, $fechEnd, $dependencia, $descripcion, $archivos)
    {
        $sql = "INSERT INTO convocatorias (
            titulo, 
            descripcion, 
            estado, 
            fecha_registro, 
            fecha_limite, 
            fecha_finalizacion, 
            dependencia
            ) VALUES (?,?,?,?,?,?,?) ";
        $params = [$titulo, $descripcion, '1', $fechIni, $fechLimit, $fechEnd];
        try{
            if ($this->conexion->query($sql, $params, '', false)=== FALSE){
                Throw new Exception('Fallo al Insertar datos para el registro de convocatorias, función InsertConvocatorias');
            }
            $lastId = function(){
                $sql = "SELECT id FROM convocatorias ORDER BY id DESC";
                $stmt = $this->conexion->query($sql, '', '', false);
                $id = $stmt->fetchColumn();
                return $id;
            };
            return $lastId();
        } catch (Throwable $e){
            $this->handlerError($e);
            $respuesta = array('status'=>'error', 'message'=>'Error al registrar convocatoria.');
            echo (json_encode($respuesta));
        }  
    }
    
    private function InsertAdjuntosConvocatoria ($archivo, $id)
    {
        $sqlAdjuntos = "INSERT INTO convocatorias_adjuntos (nombre, archivo, id_convocatoria) VALUES (?,?,?)"; 
        $fecha = date('Y/m');
        try {
            foreach($archivo as $index => $nombreArchivo){
                $pathFullFile = $fecha .'/' . $this->gestorArchivos->guardarFichero($archivo[$index], $nombreArchivo);
                $params = [$nombreArchivo, $pathFullFile, $id]; 
                $this->conexion->query($sqlAdjuntos, $params, '', false);
            }
            $respuesta = ['status'=>'success', 'message' => '']
        } catch (Throwable $e){ 
            $this->handlerError($e);
        }

    }
}