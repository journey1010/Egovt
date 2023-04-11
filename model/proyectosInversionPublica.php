<?php
require_once(_ROOT_MODEL . 'conexion.php');
require_once(_ROOT_CONTROLLER . 'paginador.php');

class ProyectoInversionPublica
{
    public function pipTodos($pagina = 1)
    {
        $resultadosPorPagina = 10;
        if (!isset($conexion)) {
            $conexion = new MySQLConnection();
            $sql = "SELECT titulo, descripcion, archivo, fecha FROM obras ORDER BY fecha DESC";
            $params = '';
        }
        session_set_cookie_params(900);
        session_start();
        if (isset($_SESSION['pipTodos_instance'])) {
            $paginador = $_SESSION['pipTodos_instance'];
            $paginador->setResultadosPorPagina($resultadosPorPagina);
        } else {
            $paginador = new Paginator($conexion, $sql, $params, $pagina, $resultadosPorPagina);
            $_SESSION['pipTodos_instance'] = $paginador;
        }

        $paginador->setPaginaActual($pagina);
        $resultados = $paginador->getResultados();
        $tablaFila = '';
        foreach ($resultados as $row) {
            $titulo = $row['titulo'];
            $descripcion = $row['descripcion'];
            $archivo = strstr($row['archivo'], '/files/');
            $enlace = _BASE_URL .'/'. substr($archivo, 1);
            $fecha = $row['fecha'];

            $tablaFila .= <<<Html
            <div class="drDocColumn position-relative bg-white shadow px-7 pt-1 pb-2 mb-2">
                <div class="d-flex mb-3">
                    <div class="descrWrap">
                        <span>
                            $fecha
                        </span>
                        <h2 class="fwSemiBold">
                            <a href="$enlace">$titulo</a>
                        </h2>
                        <strong class="d-block fileSize font-weight-normal"><a href="javascript:void(0);" class="text-lDark">$descripcion</a></strong>
                    </div>
                </div>
                <a href="$enlace" class="btn btn-outline-light btnAlterDark btnNoOver btn-sm"><i class="fa fa-file-pdf-o" style="color: #e28503;"></i> Ver documento</a>
            </div>
            Html;
        }
        $paginadorHTML = $paginador->obtenerPaginador();
        return [$tablaFila, $paginadorHTML];
    }

    public function pipAdicionalesObra($pagina = 1)
    {
        $resultadosPorPagina = 10;
        if (!isset($conexion)) {
            $conexion = new MySQLConnection();
            $sql = "SELECT titulo, descripcion, archivo, fecha FROM obras WHERE tipo = 'Adicionales de obra' ORDER BY fecha DESC";
            $params = '';
        }
        session_set_cookie_params(900);
        session_start();
        if (isset($_SESSION['pipAdicionalObra_instance'])) {
            $paginador = $_SESSION['pipAdicionalObra_instance'];
            $paginador->setResultadosPorPagina($resultadosPorPagina);
        } else {
            $paginador = new Paginator($conexion, $sql, $params, $pagina, $resultadosPorPagina);
            $_SESSION['pipAdicionalObra_instance'] = $paginador;
        }

        $paginador->setPaginaActual($pagina);
        $resultados = $paginador->getResultados();
        $tablaFila = '';
        foreach ($resultados as $row) {
            $titulo = $row['titulo'];
            $descripcion = $row['descripcion'];
            $archivo = strstr($row['archivo'], '/files/');
            $enlace = _BASE_URL .'/'. substr($archivo, 1);
            $fecha = $row['fecha'];

            $tablaFila .= <<<Html
            <div class="drDocColumn position-relative bg-white shadow px-7 pt-1 pb-2 mb-2">
                <div class="d-flex mb-3">
                    <div class="descrWrap">
                        <span>
                            $fecha
                        </span>
                        <h2 class="fwSemiBold">
                            <a href="$enlace">$titulo</a>
                        </h2>
                        <strong class="d-block fileSize font-weight-normal"><a href="javascript:void(0);" class="text-lDark">$descripcion</a></strong>
                    </div>
                </div>
                <a href="$enlace" class="btn btn-outline-light btnAlterDark btnNoOver btn-sm"><i class="fa fa-file-pdf-o" style="color: #e28503;"></i> Ver documento</a>
            </div>
            Html;
        }
        $paginadorHTML = $paginador->obtenerPaginador();
        return [$tablaFila, $paginadorHTML];
    }

    public function pipLiquidacionObra ($pagina = 1)
    {
        $resultadosPorPagina = 10;
        if (!isset($conexion)) {
            $conexion = new MySQLConnection();
            $sql = "SELECT titulo, descripcion, archivo, fecha FROM obras WHERE tipo = 'Liquidación de obras' ORDER BY fecha DESC";
            $params = '';
        }
        session_set_cookie_params(900);
        session_start();
        if (isset($_SESSION['pipLiquidacionObra_instance'])) {
            $paginador = $_SESSION['pipLiquidacionObra_instance'];
            $paginador->setResultadosPorPagina($resultadosPorPagina);
        } else {
            $paginador = new Paginator($conexion, $sql, $params, $pagina, $resultadosPorPagina);
            $_SESSION['pipLiquidacionObra_instance'] = $paginador;
        }

        $paginador->setPaginaActual($pagina);
        $resultados = $paginador->getResultados();
        $tablaFila = '';
        foreach ($resultados as $row) {
            $titulo = $row['titulo'];
            $descripcion = $row['descripcion'];
            $archivo = strstr($row['archivo'], '/files/');
            $enlace = _BASE_URL .'/'. substr($archivo, 1);
            $fecha = $row['fecha'];

            $tablaFila .= <<<Html
            <div class="drDocColumn position-relative bg-white shadow px-7 pt-1 pb-2 mb-2">
                <div class="d-flex mb-3">
                    <div class="descrWrap">
                        <span>
                            $fecha
                        </span>
                        <h2 class="fwSemiBold">
                            <a href="$enlace">$titulo</a>
                        </h2>
                        <strong class="d-block fileSize font-weight-normal"><a href="javascript:void(0);" class="text-lDark">$descripcion</a></strong>
                    </div>
                </div>
                <a href="$enlace" class="btn btn-outline-light btnAlterDark btnNoOver btn-sm"><i class="fa fa-file-pdf-o" style="color: #e28503;"></i> Ver documento</a>
            </div>
            Html;
        }
        $paginadorHTML = $paginador->obtenerPaginador();
        return [$tablaFila, $paginadorHTML]; 
    }

    public function pipSupervisionObra ($pagina = 1)
    {
        $resultadosPorPagina = 10;
        if (!isset($conexion)) {
            $conexion = new MySQLConnection();
            $sql = "SELECT titulo, descripcion, archivo, fecha FROM obras WHERE tipo = 'Supervisión de contrataciones' ORDER BY fecha DESC";
            $params = '';
        }
        session_set_cookie_params(900);
        session_start();
        if (isset($_SESSION['pipSupervisionObra_instance'])) {
            $paginador = $_SESSION['pipSupervisionObra_instance'];
            $paginador->setResultadosPorPagina($resultadosPorPagina);
        } else {
            $paginador = new Paginator($conexion, $sql, $params, $pagina, $resultadosPorPagina);
            $_SESSION['pipSupervisionObra_instance'] = $paginador;
        }

        $paginador->setPaginaActual($pagina);
        $resultados = $paginador->getResultados();
        $tablaFila = '';
        foreach ($resultados as $row) {
            $titulo = $row['titulo'];
            $descripcion = $row['descripcion'];
            $archivo = strstr($row['archivo'], '/files/');
            $enlace = _BASE_URL .'/'. substr($archivo, 1);
            $fecha = $row['fecha'];

            $tablaFila .= <<<Html
            <div class="drDocColumn position-relative bg-white shadow px-7 pt-1 pb-2 mb-2">
                <div class="d-flex mb-3">
                    <div class="descrWrap">
                        <span>
                            $fecha
                        </span>
                        <h2 class="fwSemiBold">
                            <a href="$enlace">$titulo</a>
                        </h2>
                        <strong class="d-block fileSize font-weight-normal"><a href="javascript:void(0);" class="text-lDark">$descripcion</a></strong>
                    </div>
                </div>
                <a href="$enlace" class="btn btn-outline-light btnAlterDark btnNoOver btn-sm"><i class="fa fa-file-pdf-o" style="color: #e28503;"></i> Ver documento</a>
            </div>
            Html;
        }
        $paginadorHTML = $paginador->obtenerPaginador();
        return [$tablaFila, $paginadorHTML]; 
    }

    public function pipHistorico ($pagina = 1)
    {
        $resultadosPorPagina = 10;
        if (!isset($conexion)) {
            $conexion = new MySQLConnection();
            $sql = "SELECT titulo, descripcion, archivo, fecha FROM obras WHERE tipo = 'Historico' ORDER BY fecha DESC";
            $params = '';
        }
        session_set_cookie_params(900);
        session_start();
        if (isset($_SESSION['pipHistorico_instance'])) {
            $paginador = $_SESSION['pipHistorico_instance'];
            $paginador->setResultadosPorPagina($resultadosPorPagina);
        } else {
            $paginador = new Paginator($conexion, $sql, $params, $pagina, $resultadosPorPagina);
            $_SESSION['pipHistorico_instance'] = $paginador;
        }

        $paginador->setPaginaActual($pagina);
        $resultados = $paginador->getResultados();
        $tablaFila = '';
        foreach ($resultados as $row) {
            $titulo = $row['titulo'];
            $descripcion = $row['descripcion'];
            $archivo = strstr($row['archivo'], '/files/');
            $enlace = _BASE_URL .'/'. substr($archivo, 1);
            $fecha = $row['fecha'];

            $tablaFila .= <<<Html
            <div class="drDocColumn position-relative bg-white shadow px-7 pt-1 pb-2 mb-2">
                <div class="d-flex mb-3">
                    <div class="descrWrap">
                        <span>
                            $fecha
                        </span>
                        <h2 class="fwSemiBold">
                            <a href="$enlace">$titulo</a>
                        </h2>
                        <strong class="d-block fileSize font-weight-normal"><a href="javascript:void(0);" class="text-lDark">$descripcion</a></strong>
                    </div>
                </div>
                <a href="$enlace" class="btn btn-outline-light btnAlterDark btnNoOver btn-sm"><i class="fa fa-file-pdf-o" style="color: #e28503;"></i> Ver documento</a>
            </div>
            Html;
        }
        $paginadorHTML = $paginador->obtenerPaginador();
        return [$tablaFila, $paginadorHTML]; 
    }

    public function pipInformacionAdicional ($pagina = 1)
    {
        $resultadosPorPagina = 10;
        if (!isset($conexion)) {
            $conexion = new MySQLConnection();
            $sql = "SELECT titulo, descripcion, archivo, fecha FROM obras WHERE tipo = 'Información Adicional' ORDER BY fecha DESC";
            $params = '';
        }
        session_set_cookie_params(900);
        session_start();
        if (isset($_SESSION['pipInformacionAdicional_instance'])) {
            $paginador = $_SESSION['pipInformacionAdicional_instance'];
            $paginador->setResultadosPorPagina($resultadosPorPagina);
        } else {
            $paginador = new Paginator($conexion, $sql, $params, $pagina, $resultadosPorPagina);
            $_SESSION['pipInformacionAdicional_instance'] = $paginador;
        }

        $paginador->setPaginaActual($pagina);
        $resultados = $paginador->getResultados();
        $tablaFila = '';
        foreach ($resultados as $row) {
            $titulo = $row['titulo'];
            $descripcion = $row['descripcion'];
            $archivo = strstr($row['archivo'], '/files/');
            $enlace = _BASE_URL .'/'. substr($archivo, 1);
            $fecha = $row['fecha'];

            $tablaFila .= <<<Html
            <div class="drDocColumn position-relative bg-white shadow px-7 pt-1 pb-2 mb-2">
                <div class="d-flex mb-3">
                    <div class="descrWrap">
                        <span>
                            $fecha
                        </span>
                        <h2 class="fwSemiBold">
                            <a href="$enlace">$titulo</a>
                        </h2>
                        <strong class="d-block fileSize font-weight-normal"><a href="javascript:void(0);" class="text-lDark">$descripcion</a></strong>
                    </div>
                </div>
                <a href="$enlace" class="btn btn-outline-light btnAlterDark btnNoOver btn-sm"><i class="fa fa-file-pdf-o" style="color: #e28503;"></i> Ver documento</a>
            </div>
            Html;
        }
        $paginadorHTML = $paginador->obtenerPaginador();
        return [$tablaFila, $paginadorHTML]; 
    }
    
    public function BuscarObra ($tipo, $año, $palabra) 
    {
        $conexion = new MySQLConnection();
        $sql = "SELECT titulo, descripcion, fecha, archivo FROM obras WHERE 1=1";

        if (!empty($tipo)) {
          $sql .= " AND tipo LIKE :tipo";
          $params[':tipo'] = $tipo;
        }
        
        if (!empty($año)) {
          $sql .= " AND YEAR(fecha) LIKE :fecha";
          $params[':fecha'] = $año;
        }
        
        if (!empty($palabra)) {
          $sql .= " AND (titulo LIKE :palabra OR descripcion LIKE :palabra_desc OR tipo LIKE :palabra_tipo OR YEAR(fecha)  LIKE :palabra_fech)";
          $params[':palabra'] = '%' . $palabra . '%';
          $params[':palabra_fech'] = '%' . $palabra . '%';
          $params[':palabra_desc'] = '%' . $palabra . '%';
          $params[':palabra_tipo'] = '%' . $palabra . '%';
        }

        try {
            $stmt = $conexion->query($sql, $params, '', false);
            $resultado = $stmt->fetchAll(); 
            $table_respuesta = $this->makeTblForBuscarObra($resultado);
            echo $table_respuesta;    
        } catch (Throwable $e) {
            $respuesta = array("error" => "Error al consultar registros");
            print_r(json_encode($respuesta));
            $this->handlerError($e);
        }
        return;
    }

    private function makeTblForBuscarObra ($resultado): string 
    {
        $tablaFila = '';
        foreach ($resultado as $row) {
            $titulo = $row['titulo'];
            $descripcion = $row['descripcion'];
            $archivo = strstr($row['archivo'], '/files/');
            $enlace = _BASE_URL .'/'. substr($archivo, 1);
            $fecha = $row['fecha'];

            $tablaFila .= <<<Html
            <tr>
            <td>
            <div class="drDocColumn position-relative bg-white shadow px-7 pt-1 pb-2 mb-2">
                <div class="d-flex mb-3">
                    <div class="descrWrap">
                        <span>
                            $fecha
                        </span>
                        <h2 class="fwSemiBold">
                            <a href="$enlace">$titulo</a>
                        </h2>
                        <strong class="d-block fileSize font-weight-normal"><a href="javascript:void(0);" class="text-lDark">$descripcion</a></strong>
                    </div>
                </div>
                <a href="$enlace" class="btn btn-outline-light btnAlterDark btnNoOver btn-sm"><i class="fa fa-file-pdf-o" style="color: #e28503;"></i> Ver documento</a>
            </div>
            </td>
            </tr>
            Html;
        }

        $tabla = <<<Html
        <table class="table table-hover table-md w-100" id="resultadosBusquedaObras">
            <thead>
                <th>
                </th>
            </thead>
            <tbody>
                $tablaFila
            </tbody>
        </table>  
        Html;  
        return $tabla;
    }

    private function handlerError(Throwable $e) 
    {
        $errorMessage = date("Y-m-d H:i:s") . " : " . $e->getMessage() . "\n";
        error_log($errorMessage, 3, _ROOT_PATH . '/log/error.log' );
        return;
    }
}
