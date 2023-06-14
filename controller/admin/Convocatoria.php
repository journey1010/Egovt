<?php

require_once _ROOT_CONTROLLER . 'admin/handleSanitize.php';
require_once _ROOT_CONTROLLER . 'admin/AdministrarArchivos.php';
require_once _ROOT_MODEL . 'conexion.php';
class Convocatoria extends handleSanitize
{
    private $conexion;
    private $gestorArchivos;
    public function __construct()
    {
        $this->conexion = new MySQLConnection();
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
        foreach ($camposRequeridos as $campo) {
            extract([$campo => $this->SanitizeVarInput($_POST[$campo])]);
        }
        $extensionPermitidas = ['docx', 'xlsx', 'xls', 'pdf', 'txt', 'doc'];
        $archivos =  $_FILES['archivosConvocatorias'];
        $nuevosArchivos = $this->reorganizarArchivos($archivos);

        if(!$this->validarArchivos($nuevosArchivos, $extensionPermitidas)) {
            return;
        }

        $id = $this->InsertConvocatoria(
            $tituloConvocatoria, 
            $fechaInicioConvocatoria, 
            $fechaLimiteConvocatoria, 
            $fechaFinalConvocatoria, 
            $dependenciaConvocatoria, 
            $descripcionConvocatoria
        );

        if ($id === false) {
            $respuesta = ['status' => 'error', 'message' => 'Error al registrar convocatoria.'];
            echo json_encode($respuesta);
            return;
        }

        if($this->insertAdjuntosConvocatoria($nuevosArchivos, $id)){
            $respuesta = ['status' => 'success', 'message' => 'Datos registrados con éxito.'];
            echo json_encode($respuesta);
        } else {
            $respuesta = ['status' => 'error', 'message' => 'Fallo en registrar archivos'];
            echo json_encode($respuesta);
        }
    }

    /**
     * Reorganiza el @param array $archivos en un array cuyas posiciones guardan otro array (Una matriz de matrices)
     * @return array
    */
    private function reorganizarArchivos(array $archivos): array
    {
        $nuevosArchivos = [];
        foreach ($archivos as $propiedad => $valores) {
            foreach ($valores as $indice => $valor) {
                $nuevosArchivos[$indice][$propiedad] = $valor;
            }
        }
        return $nuevosArchivos;
    }

    /**
     * Valida multipes archivos 
     * @param array $archivos
     * @param array $extensionPermitidas
     * @return boolean
     * @see $this->gestorArchivos->validarArchivo
    */
    private function validarArchivos($archivos, $extensionPermitidas)
    {
        foreach ($archivos as $archivo) {
            if (!$this->gestorArchivos->validarArchivo($archivo, $extensionPermitidas)) {
                return false;
            }
        }
        return true;
    }

    private function InsertConvocatoria($titulo, $fechIni, $fechLimit, $fechEnd, $dependencia, $descripcion)
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
        $params = [$titulo, $descripcion, '1', $fechIni, $fechLimit, $fechEnd, $dependencia];
        try {
            $this->conexion->query($sql, $params, '', false);
            return $this->obtenerUltimoIdConvocatoria();
        } catch (Throwable $e) {
            $this->handlerError($e,  'Clase convocatoria funcion InserConvocatoria');
            return false;
        }
    }

    /**
     * Obtiene el ultimo id de registrado de la tabla convocatoria
     * @return string
    */

    public function obtenerUltimoIdConvocatoria()
    {
        try {
            $sql = "SELECT id FROM convocatorias ORDER BY id DESC";
            $stmt = $this->conexion->query($sql, '', '', false);
            $id = $stmt->fetchColumn();
            return $id;
        } catch (Throwable $e){
            $this->handlerError($e, 'Clase convocatoria funcion obtenerUltimioIdConvocatoria');
        }
    }

    /**
     * Guarda en Base de Datos los documentos adjuntos de la convocatoria
     * @param array $archivo
     * @param string $id
     * @return bool
    */ 

    private function insertAdjuntosConvocatoria($archivo, $id): bool
    {
        $sqlAdjuntos = "INSERT INTO convocatorias_adjuntos (nombre, archivo, id_convocatoria) VALUES (?,?,?)";
        $fecha = date('Y/m');
        try {
            foreach ($archivo as $index => $datosArchivo) {
                $nombreArchivo = pathinfo($datosArchivo['name'], PATHINFO_FILENAME);
                $pathFullFile = $fecha . '/' . $this->gestorArchivos->guardarFichero($datosArchivo, $nombreArchivo);
                $params = [$nombreArchivo, $pathFullFile, $id];
                $this->conexion->query($sqlAdjuntos, $params, '', false);
            }
            return true;
        } catch (Throwable $e) {
            $this->handlerError($e, 'Clase convocatoria InsertAjuntosConvocatoria ID de registro fallido '.$id);
            return false;
        }
    }
    
}