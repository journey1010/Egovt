<?php
require_once(_ROOT_MODEL . 'conexion.php');
require_once(_ROOT_CONTROLLER . 'paginador.php');

class visitas
{

    public function visitasNuevas($pagina = 1)
    {
        $resultadosPorPagina = 15;
        if (!isset($conexion)) {
            $conexion = new MySQLConnection();
            $sql = "SELECT v.apellidos_nombres as apnombre, v.dni as dni, CONCAT(o.nombre, ' ', o.sigla ) AS oficina, v.persona_a_visitar as visita, v.hora_de_ingreso as hringreso, v.hora_de_salida as hrsalida, v.quien_autoriza as quienautoriza,
                v.motivo as motivo FROM visitas AS v INNER JOIN oficinas AS o ON v.area_que_visita =  o.id ";
            $params = '';
        }
        
        session_set_cookie_params(900);
        session_start();
        if (isset($_SESSION['visitas_instance'])) {
            $paginador = $_SESSION['visitas_instance'];
            $paginadorHTM = $paginador->setResultadosPorPagina($resultadosPorPagina);
        } else {
            $paginador = new Paginator($conexion, $sql, $params, $pagina, $resultadosPorPagina);
            $_SESSION['visitas_instance'] = $paginador;
        }
        $paginador->setPaginaActual($pagina);
        $resultados = $paginador->getResultados();
        $tablaFila = '';
        foreach ($resultados as $row) {
            $apnombre = $row['apnombre'];
            $dni = $row['dni'];
            $oficina = $row['oficina'];
            $visita = $row['visita'];
            $hringreso = $row['hringreso'];
            $hrsalida = $row['hrsalida'];
            $quienautoriza = $row['quienautoriza'];
            $motivo = $row['motivo'];

            $tablaFila .= <<<Html
                <tr>
                <td class="text-nowrap"><i class="fa fa-eye details-control"></i> $apnombre</td>    
                <td>$dni</td>
                <td>$oficina</td>
                <td>$visita</td>
                <td class="text-nowrap">$hringreso</td>
                <td class="text-nowrap">$hrsalida</td>
                <td>$quienautoriza</td>
                <td>$motivo</td>
                </tr>
            Html;
        }
        $paginadorHTML = $paginador->obtenerPaginador();
        return [$tablaFila, $paginadorHTML];
    }

    public function visitasNuevasPost(string $fecha)
    {
        $conexion = new MySQLConnection();
        $sql = "SELECT v.apellidos_nombres as apnombre, v.dni as dni, CONCAT(o.nombre, ' ', o.sigla ) AS oficina, v.persona_a_visitar as visita, v.hora_de_ingreso as hringreso, v.hora_de_salida as hrsalida, v.quien_autoriza as quienautoriza,
        v.motivo as motivo FROM visitas AS v INNER JOIN oficinas AS o ON v.area_que_visita =  o.id  WHERE DATE(v.hora_de_ingreso)= :fecha ";
        $params[":fecha"] = $fecha;
        $stmt =  $conexion->query($sql, $params, '', false);
        $resultado = $stmt->fetchAll();
        $tablaFila = '';
        foreach ($resultado as $row) {
            $apnombre = $row['apnombre'];
            $dni = $row['dni'];
            $oficina = $row['oficina'];
            $visita = $row['visita'];
            $hringreso = $row['hringreso'];
            $hrsalida = $row['hrsalida'];
            $quienautoriza = $row['quienautoriza'];
            $motivo = $row['motivo'];

            $tablaFila .= <<<Html
                <tr>
                <td class="text-nowrap"><i class="fa fa-eye details-control"></i> $apnombre</td>    
                <td>$dni</td>
                <td>$oficina</td>
                <td>$visita</td>
                <td class="text-nowrap">$hringreso</td>
                <td class="text-nowrap">$hrsalida</td>
                <td>$quienautoriza</td>
                <td>$motivo</td>
                </tr>
            Html;
        }

        $tabla = <<<Html
        <table id="tabla" class="border border-danger dataTable responsive table-hover" style="width:100%">
            <thead class="bg-danger text-white">
                <tr>
                    <th class="text-nowrap ">Nombres del Visitante</th>
                    <th>Documento</th>
                    <th>Área</th>
                    <th class="text-nowrap">¿A quién visita?</th>
                    <th>Ingreso</th>
                    <th>Salida</th>
                    <th>Autorización</th>
                    <th>Motivo</th>
                </tr>
            </thead>
            <tbody>
                $tablaFila
            </tbody>
        </table>
        <nav  aria-label="Page navigation" >
            <ul class="pagination justify-content-center pt-2"></ul>
        </nav>
        Html;
        return $tabla;
    }

    public function visitasOld()
    {
        $conexion = new MySQLConnection();
        $sql = "SELECT id, descripcion, fecha, ruta_archivo FROM old_visitas ORDER BY id DESC";
        $stmt = $conexion->query($sql, '',  '', false);
        $resultados = $stmt->fetchAll();
        $tablaFila = '';
        foreach ($resultados as $row) {
            $id= $row['id'];
            $descripcion= $row['descripcion'];
            $fecha= $row['fecha'];
            $archivo= _BASE_URL . '/files/transparencia/old_visitas/'. $row['ruta_archivo'];
            $tablaFila .= <<<Html
            <tr>
                <td class="text-nowrap">$id</td>
                <td class="text-nowrap">$descripcion</td>    
                <td>$fecha</td>
                <td class="text-nowrap"><a href="$archivo" style="color: red"><i class="fa fa-file-pdf-o"></i> $fecha</a></td>
            </tr>
            Html;
        }
        return $tablaFila;
    }
}