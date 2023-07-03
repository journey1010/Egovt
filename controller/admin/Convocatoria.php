<?php

require_once _ROOT_CONTROLLER . 'admin/handleSanitize.php';
require_once _ROOT_CONTROLLER . 'admin/AdministrarArchivos.php';
require_once _ROOT_VIEWS . 'admin/Convocatorias.php';
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
        $this->gestorArchivos = new AdministrarArchivos($this->conexion, 'transparencia/convocatorias/' . date('Y/m/'));
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

        if (!$this->validarArchivos($nuevosArchivos, $extensionPermitidas)) {
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

        if ($this->insertAdjuntosConvocatoria($nuevosArchivos, $id)) {
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
        } catch (Throwable $e) {
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
            $this->handlerError($e, 'Clase convocatoria InsertAjuntosConvocatoria ID de registro fallido ' . $id);
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
        $sql = "SELECT titulo, descripcion, o.id AS oficina, fecha_registro, fecha_limite, fecha_finalizacion FROM convocatorias AS c 
                INNER JOIN oficinas AS o ON o.id = c.dependencia  
                WHERE c.id = ?";
        $sqlAdjuntos = "SELECT id, nombre, archivo, id_convocatoria FROM convocatorias_adjuntos WHERE id_convocatoria = ?";
        $param = [$id];

        /** Inicia el loop para las promesas */
        $loop = Loop::get();

        $promesa = $this->ejecucionConsulta($sql, $param);
        $promesaAdjuntos = $this->ejecucionConsulta($sqlAdjuntos, $param);

        React\Promise\all([$promesa, $promesaAdjuntos])->then(function ($results) {
            $stmt = $results[0];
            $stmtAdjuntos = $results[1];

            $html = $this->generarHtml($stmt);
            $htmlAdjuntos = $this->generarHtmlAdjuntos($stmtAdjuntos);

            React\Promise\all([$html, $htmlAdjuntos])->then(function ($htmlresults) {
                $view = $htmlresults[0];
                $viewAdjuntos = $htmlresults[1];

                $this->generarFinalHtml($view, $viewAdjuntos);
            }, function($error){
                $this->handlerError($error, 'Promesa generadora de vistas, convocatoria, editConvocatoria');
            });
        });
        $loop->run();
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
        return new Promise(function ($resolve, $reject) use ($sql, $param) {
            $stmt = $this->conexion->query($sql, $param, '', false);
            if ($stmt) {
                $respuesta = $stmt->fetchAll();
                $resolve($respuesta);
            } else {
                $error = new Error('Error al ejecutar consulta: ' . $sql);
                $reject($error);
            }
        });
    }

    /**
     * Crea una vista apartir de la consulta, se ejecuta de forma asincrona. 
     * Crea una variable $selectOptions que contiene una lista de oficinas (Dependencias) con la oficina de 
     * la convocatoria selecionada. 
     * @param array $stmt, contiene la devolución de una consulta sql
     * @return promise $respuesta, contiene una vista html con datos de la consulta   
    */
    private function generarHtml($stmt)
    {
        return new Promise(function ($resolve, $reject) use ($stmt) {
            $idDependencia = $stmt[0]['oficina'];

            $sql = "SELECT id, CONCAT(nombre, ' ', sigla) AS nombre FROM oficinas";
            $statement = $this->conexion->query($sql, '', '', false)->fetchAll();
            $selectOptions = '';
            foreach ($statement as $row) {
                $selected = ($row['id'] == $idDependencia) ? 'selected' : '';
                $selectOptions .= <<<Html
                <option value="{$row['id']}" $selected>{$row['nombre']}</option>
                Html;
            }

            $view = new convocatorias();
            $viewResult = $view->viewEditGeneralConvocatoria(
                $idDependencia,
                $stmt[0]['titulo'],
                $stmt[0]['descripcion'],
                $selectOptions,
                $stmt[0]['fecha_registro'],
                $stmt[0]['fecha_limite'],
                $stmt[0]['fecha_finalizacion']
            );
            $resolve($viewResult);
        });
    }

    /**
     * Crea una vista con el resultado de una consulta a base de datos. 
     * @param  array $stmtAdjuntos, contiene los adjuntos de una convocatoria en especifico.
     * @return promise $respuesta, contiene los datos de documentos adjuntos de una convocatoria.
     */
    private function generarHtmlAdjuntos($stmtAdjuntos)
    {
        return new Promise(function ($resolve, $reject) use ($stmtAdjuntos) {
            $view = new convocatorias();
            $viewResult = $view->viewEditAdjuntosConvocatoria($stmtAdjuntos);
            $resolve($viewResult);
        });
    }

    private function generarFinalHtml($view, $viewAdjuntos)
    {
        $views = new convocatorias();
        $results = $views->viewEditFinalConvocatoria($view, $viewAdjuntos);
        echo (json_encode(['status' => 'success', 'data' => $results]));
    }

    public function zoneEditor( string $function)
    {
        switch ($function){
            case 'updateGeneralDatos':
                $data = $_POST;
                $this->updateGeneralDatos($_POST);
            break;
            case 'saveAdjunto':
                $data = $_POST;
                $archivo = $_FILES['archivo'] ??  '';
                $this->saveAdjunto($data, $archivo);
            break;
            case 'saveNewAdjunto':
                $archivo = $_FILES['archivo'];
                $id = $this->SanitizeVarInput($_POST['id']);
                $this->saveNewAdjunto($id, $archivo);
            break;
        }
    }
    /**
     * Función que actualiza los datos de la tabla convocatorias. 
     *
     * @param array $data, contiende todos los datos enviador por POST
     * @return void 
     */
    private function updateGeneralDatos(array $data)
    {
        $camposRequeridos = [
            'id', 
            'titulo', 
            'descripcion', 
            'dependencia', 
            'fecha_registro', 
            'fecha_limite', 
            'fecha_finalizacion'
        ];

        foreach($camposRequeridos as $campo){
            extract([$campo => $this->SanitizeVarInput($data[$campo])]);
        }

        $sql = "UPDATE convocatorias 
                SET titulo=?, descripcion=?, dependencia=?, fecha_registro=?, fecha_limite=?, fecha_finalizacion=? 
                WHERE id=? ";
        $params = [
            $titulo, 
            $descripcion, 
            $dependencia, 
            $fecha_registro, 
            $fecha_limite, 
            $fecha_finalizacion,
            $id
        ];
        try{
            $this->conexion->query($sql, $params, '', false);
            $this->updateEstadoConvocatoria($id, $fecha2, $fecha3);
            echo (json_encode(['status'=>'success', 'message'=>'Actualización completada.']));
        }catch(Throwable $e){
            $this->handlerError($e, 'Controlador: Convocatoria, funccion : updateGeneralDatos');
            echo (json_encode(['status'=>'error', 'message'=>'Ha ocurrido un error inesperado.']));
        }

    }
    /**
     * Actualiza el estado de una convocatoria de acuerdo a la fecha actual
     *
     * @param [type] $id, identificador de la convocatoria
     * @param [type] $fecha1, fecha registro
     * @param [type] $fecha2, fecha limite
     * @param [type] $fecha3, fecha finalización
     * @return void
     */
    private function updateEstadoConvocatoria($id, $fecha2, $fecha3)
    {

        date_default_timezone_set('America/Lima'); 

        $fechaActual = new DateTime();

        if ($fechaActual > new DateTime($fecha3)) {
            $estado = 3;
        } elseif ($fechaActual >= new DateTime($fecha2)) {
            $estado = 2;
        } else {
            $estado = 1;
        }
    
        $sql = "UPDATE convocatorias SET estado = ? WHERE id = ?";
        $param = [$estado, $id];
        $this->conexion->query($sql, $param, '', false);
    }
    /**
     * Actualiza el registro de un adjunto especifico tanto en la base de datos como en el sistema de archivos
     *  
     * @param array $data, guarda el identificador y el nombre del archivo.
     * @param array|string $archivo, guarda el nuevo archivo(si se envía) o una cadena vacía.
     * @return void
     */
    private function saveAdjunto(array $data, array|string $archivo)
    {
        $id = $this->SanitizeVarInput($data['id']);
        $nombre = $this->SanitizeVarInput($data['nombre']);

        try {
            if ($this->gestorArchivos->validarArchivo($archivo, ['xls', 'pdf', 'xlsx', 'doc', 'docx']) == true) {
                $sql = "SELECT archivo FROM convocatorias_adjuntos WHERE id = :id";
                $params["id"] = $id;
                $this->gestorArchivos->borrarArchivo($sql, $params);
                $newPathFile = date('Y/m') .'/' . $this->gestorArchivos->guardarFichero($archivo, $nombre);
                $this->updateBdAdjunto($id, $nombre, $newPathFile);
                return;
            }
            $this->updateBdAdjunto($id, $nombre);
            echo (json_encode(['status'=>'success', 'message'=>'Nuevo archivo guardado.']));
        } catch (Throwable $e){
            $this->handlerError($e, 'Controlador: Convocatoria; funcion: saveAdjunto');
            echo (json_encode(['status'=>'error', 'message'=>'Ha ocurrido un error al actualizar.']));
        }
    }

    /**
     * Crea un consulta sql para actualizar los campos de un adjunto espeficico. 
     *
     * @param int $id, identificador de convocatoria
     * @param string $nombre, nuevo nombre de archivo
     * @param string $newPathFile, nueva ruta de archivo si es que existe.
     * @return void
     */
    private function updateBdAdjunto($id, $nombre, $newPathFile = null)
    {
        $sql = 'UPDATE convocatorias_adjuntos SET nombre = :nombre';
        $params[':nombre'] = $nombre;
        if($newPathFile !== null){
            $sql .= ', archivo= :archivo';
            $params[':archivo'] = $newPathFile;
        }
        $sql .= 'WHERE id = :id';
        $params[':id'] = $id;

        try{
            $this->conexion->query($sql, $params, '', false);
        } catch (Throwable $e){
            $this->handlerError($e, 'Controlador: Convocatorias; funccion: updateBdAdjunto');
        }

    }

    /**
     * Adjunto un nuevo archivo para una convocatoria en especifico
     * @param  int $id, identificador de la convocatoria
     * @param  array $archivo, nuevo  adjunto de convocatoria
     * @return void
     */
    private function saveNewAdjunto(int $id, array $archivo)
    {   
        $sql = "INSERT INTO convocatorias_adjuntos (nombre, archivo, id_convocatoria) VALUES (?,?,?)";

        try{
            $nombreArchivo = pathinfo($archivo['name'], PATHINFO_FILENAME);
            $pathFullFile = date('Y/m') . '/' . $this->gestorArchivos->guardarFichero($archivo, $nombreArchivo);
            $params =  [$nombreArchivo, $pathFullFile, $id];
            $this->conexion->query($sql, $params, '', false);
            echo (json_encode(['status'=>'success', 'message'=>'Nuevo adjunto guardado.']));
        } catch (Throwable $e){
            $this->handlerError($e, 'Controlladro: Convocatoria; funcion: saveNewAdjunto');
            echo (json_encode(['status'=>'error', 'message'=>'Ha ocurrido un error en la actualización.']));
        }
    }
}