<?php
require_once (_ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once (_ROOT_MODEL . 'conexion.php');

class obra extends handleSanitize {

    private $ruta;
    
    public function __construct()
    {
        $this->ruta = _ROOT_FILES . 'transparencia/obras/';  
    }

    public function RegistrarObra () 
    {
        try{
            if (
                !empty($_POST["titulo"]) && 
                !empty($_POST["tipo"]) && 
                !empty($_POST["fecha"]) && 
                !empty($_POST["descripcion"]) && 
                !empty($_FILES["archivo"])
                ) {
                    
                $titulo = $this->SanitizeVarInput($_POST["titulo"]);
                $tipo = $this->SanitizeVarInput($_POST["tipo"]);
                $fecha = $this->SanitizeVarInput($_POST["fecha"]);
                $descripcion = $this->SanitizeVarInput($_POST["descripcion"]);
    
                $archivo = $_FILES["archivo"];
                $archivotemp = $_FILES['archivo']['tmp_name'];             
                $archivoNombre = $archivo["name"];
                $extensionesPermitidas = array("xlsx", "pdf", "doc", "docx", "xls");
                $extension = strtolower(pathinfo($archivoNombre, PATHINFO_EXTENSION));
    
                if (isset($archivo) && $archivo["error"] == UPLOAD_ERR_OK && in_array($extension, $extensionesPermitidas)) {
                    $pathFullFile = $this->guardarFichero($archivotemp, $titulo, $extension);
                    $this->registrarIntoBd ($titulo, $tipo, $fecha, $descripcion, $pathFullFile );
                    $respuesta = array("success" => "Datos guardados con éxito.");
                    print_r(json_encode($respuesta));
                } else {
                    $respuesta = ["error" => "Extensión de archivo no permitido."];
                    print_r(json_encode($respuesta));
                }
            } else {
                $respuesta = ["error" => "Debe completar todos los campos del formulario."];
                print_r(json_encode($respuesta));
            }
        } catch (Throwable $e) {
            $this->handlerError($e);
        }
        return;  
    }

    private function guardarFichero ($archivotemp, $nombre, $extension)
    {
        $rutaArchivo = $this->crearRuta();
        $viejoNombre = $archivotemp;  
        $nuevoNombre = $nombre . '-'. date("H-i-s-m-d-Y.") . $extension;
        $pathFullFile = $rutaArchivo . $nuevoNombre;

        $guardar = move_uploaded_file($viejoNombre , $pathFullFile );
        if ($guardar) {
          return $pathFullFile;
        } else {
            $respuesta = array("error" => "Error al guardar el archivo");
            print_r(json_encode($respuesta));        
            die;
        }
    }

    private function crearRuta (): string
    {
        $año = date ('Y');
        $mes = date ('m');
        
        $pathForFile = $this->ruta . $año . '/' . $mes;

        if (!file_exists($pathForFile)) {
            mkdir($pathForFile, 0777, true);
        }
        $finalPathForFile = $pathForFile . '/';
        return $finalPathForFile;
    }

    private function registrarIntoBd ($titulo, $tipo, $fecha, $descripcion, $pathFullFile ) 
    {
        $fechaSubida = date('Y-m-d H:i:s');
        $conexion = new MySQLConnection();
        $sql  = "INSERT INTO obras (
            titulo,
            descripcion,
            tipo,
            archivo,
            fecha,
            fecha_subida
        ) VALUES ( ?,?,?,?,?,? )";

        $params = [$titulo, $descripcion, $tipo, $pathFullFile, $fecha, $fechaSubida ];
        $conexion->query($sql, $params, '', false);
        $conexion->close();
        return; 
    }

    public function BuscarObra () 
    {
        $tipo = $this->SanitizeVarInput($_POST['tipo']);
        $fecha = $this->SanitizeVarInput($_POST['fecha']);
        $ordenar = $this->SanitizeVarInput($_POST['ordenar']);
        $palabra = $this->SanitizeVarInput($_POST['palabra']);

        $conexion = new MySQLConnection();
        $sql = "SELECT id, titulo, descripcion, tipo, fecha, fecha_subida FROM obras WHERE 1=1";

        if (!empty($tipo)) {
          $sql .= " AND tipo = :tipo";
          $params[':tipo'] = $tipo;
        }
        
        if (!empty($fecha)) {
          $sql .= " AND fecha = :fecha";
          $params[':fecha'] = $fecha;
        }
        
        if (!empty($palabra)) {
          $sql .= " AND (titulo LIKE :palabra OR descripcion LIKE :palabra_desc OR tipo LIKE :palabra_tipo OR fecha  LIKE :palabra_fech)";
          $params[':palabra'] = '%' . $palabra . '%';
          $params[':palabra_fech'] = '%' . $palabra . '%';
          $params[':palabra_desc'] = '%' . $palabra . '%';
          $params[':palabra_tipo'] = '%' . $palabra . '%';
        }
        
        if ($ordenar == 'DESC') {
          $sql .= " ORDER BY fecha_subida DESC";
        } elseif ($ordenar == 'ASC') {
          $sql .= " ORDER BY fecha_subida ASC";
        }

        try {
            $stmt = $conexion->query($sql, $params, '', false);
            $conexion->close();
            $resultado = $stmt->fetchAll(); 
            $table_respuesta = $this->makeTblForBuscarObra($resultado);
            echo $table_respuesta;    
        } catch (Throwable $e) {
            $this->handlerError($e);
            $respuesta = array("error" => "Error al consultar registros");
            echo(json_encode($respuesta));
        }
        return;
    }

    private function makeTblForBuscarObra ($resultado): string 
    {
        $tablaRow = '';
        foreach ($resultado as $row ) {
            $id = $row['id'];
            $titulo = $row['titulo'];
            $descripcion = $row['descripcion'];
            $tipo = $row['tipo'];
            $fecha = $row['fecha'];
            $fecha_subida = $row['fecha_subida'];

            $tablaRow .= "<tr>";
            $tablaRow .= "<td class=\"text-center\">$id</td>";
            $tablaRow .= "<td class=\"text-center\">$titulo</td>";
            $tablaRow .= "<td class=\"text-center\" style=\"max-width: 300px;\" >$descripcion</td>";
            $tablaRow .= "<td class=\"text-center\">$tipo</td>";
            $tablaRow .= "<td class=\"text-center\">$fecha</td>";
            $tablaRow .= "<td class=\"text-center\">$fecha_subida</td>";
            $tablaRow .= '
                <td class="text-center align-middle">
                    <i class="fa fa-edit mr-2 edit-icon" style="color:#9c74dd !important"></i>
                    <i class="fa fa-window-close fa-lg cancel-icon" style="color: #b40404; --fa-secondary-color: #c7fbff; display:none;"></i>
                </td>
            ';
            $tablaRow .= "</tr>";
        }

        $tabla = <<<Html
        <table class="table table-hover table-md w-100" id="resultadosBusquedaObras">
            <thead class="table-bordered" >
                <tr>
                    <th class="text-center">id</th>
                    <th class="text-center">Titulo</th>
                    <th class="text-center">Descripción</th>
                    <th style="text-center">Tipo</th>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Fecha de carga</th>
                    <th style="width: 80px" class="text-center ">Editar</th>
                </tr>
            </thead>
            <tbody>
                $tablaRow
            </tbody>
        </table>  
        Html;
        
        return $tabla;
    }

    public function ActualizarObra () 
    {
    }
}