<?php

require_once _ROOT_CONTROLLER . 'admin/handleSanitize.php';
require_once _ROOT_CONTROLLER . 'admin/AdministrarArchivos.php';
require_once _ROOT_MODEL . 'conexion.php';
require_once _ROOT_PATH . '/vendor/autoload.php';

use React\EventLoop\Loop;
use React\Promise\Promise;

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
     * Valida multiples archivos 
     * @param array $archivos contiene archivos recividos por $_POST[]
     * @param array $extensionPermitidas lista de extensiones admitidas por el sistema
     * @return boolean
     * @see $this->gestorArchivos->validarArchivo, función heredada que validad archivos individuales
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

    /**
     * Función que devuelve una vista de una convocatoria especifica
     * con todos sus datos y adjuntos. Utiliza promesas para ejecutar
     * sus consultas al mismo tiempo.
     * @return json que contiene el estado de las respuesta y su valor. 
    */
    public  function editConvocatoria()
    {
        $id = $this->SanitizeVarInput($_POST['id']);
        $sql = "SELECT titulo, descripcion, o.nombre, fecha_registro, fecha_limite, fecha_finalizacion FROM convocatorias AS c 
                INNER JOIN oficinas AS o ON o.id = c.dependencia  
                WHERE c.id = ?";
        $sqlAdjuntos = "SELECT id, nombre, archivo, id_convocatoria FROM convocatorias_adjuntos WHERE id_convocatoria = ?";
        $param = [$id];

        /** Inicia el loop para las promesas */
        $loop = Loop::get();

        $promesa = $this->ejecucionConsulta($sql, $param);
        $promesaAdjuntos = $this->ejecucionConsulta($sqlAdjuntos, $param);

        React\Promise\all([$promesa, $promesaAdjuntos])->then(function($results){
            $stmt = $results[0];
            $stmtAdjuntos = $results[1];

            $html = $this->generarHtml($stmt);
            $htmlAdjuntos = $this->generarHtmlAdjuntos($stmtAdjuntos);

            React\Promise\all([$html, $htmlAdjuntos])->then(function($htmlresults){
                $view = $htmlresults[0];
                $viewAdjuntos = $htmlresults[1];

                $this->generarFinalHtml($view, $viewAdjuntos);
            })
            ->otherwise(function(Throwable $error){
                $this->handlerError($error, 'Promesa generadora de vistas, convocatoria, editConvocatoria');
            });
        });
    }

    /**
     * Función que retorna un objeto de la clase promise, este objeto contiene el resultado de la ejecucion de una consulta
     * Si la consulta falla devuleve un error Throwable. 
     * @param string $sql, guarda una consulta sql parametrizada
     * @param string $param, guarda un parametro para la consulta sql
     * @return object|Throwable 
    */
    private function ejecucionConsulta(string $sql, array $param)
    {
        return new Promise( function($resolve, $reject) use ($sql, $param) {
            $stmt = $this->conexion->query($sql, $param, '', false);
            if($stmt){
                $resolve($stmt);
            } else {
                $error = new Error ('Error al ejecutar consulta: ' . $sql);
                $reject($error);
            }
        });
    }
}