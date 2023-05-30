<?php

use PhpOffice\PhpSpreadsheet\Style\NumberFormat\DateFormatter;

require_once(_ROOT_MODEL . 'conexion.php');
require_once(_ROOT_CONTROLLER . 'paginador.php');

class agendaGorel
{
    public function verAgenda($pagina = 1)
    {
        $resultadosPorPagina = 12;
        if (!isset($conexion)) {
           $conexion = new MySQLConnection();
           $sql = "SELECT fecha, hora, actividad, tema, organiza, lugar, participante FROM agenda ORDER BY fecha DESC, hora ASC";
           $params = '';
        }
        session_set_cookie_params(900);
        session_start();
        if (isset($_SESSION['verAgenda_instance'])) {
            $paginador = $_SESSION['verAgenda_instance'];
            $paginador->setResultadosPorPagina($resultadosPorPagina);
        }else {
            $paginador = new Paginator($conexion, $sql, $params, $pagina, $resultadosPorPagina);
            $_SESSION['pverAgenda_instance'] = $paginador;
        }

        $paginador->setPaginaActual($pagina);
        $resultados = $paginador->getResultados();
        $tablaFila = '';
        foreach ($resultados as $row) {
            $fechaFormat = DateTime::createFromFormat('Y-m-d', $row['fecha']);
            $formato = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
            $fecha = $formato->format($fechaFormat);
            $hora = ($row['hora']===NULL) ?  'Por definir' : $row['hora'];
            $actividad = $row['actividad'];
            $tema = $row['tema'];
            $organiza = $row['organiza'];
            $lugar = $row['lugar'];
            $participante = $row['participante'];

            $tablaFila .= <<<Html
                <div class="col-12 col-md-6 col-lg-4 d-inline-flex">
                    <article class="npbColumn shadow bg-white mb-6 mb-xl-12">
                        <div class="imgHolder position-relative">
                            <time datetime="$fecha" class="npbTimeTag font-weight-bold fontAlter position-absolute text-white px-2 py-1">$fecha</time>
                        </div>
                        <div class="npbDescriptionWrap px-5 pt-8 pb-3">
                            <strong class="text-lDark mb-1">
                                <h3 class="fwSemiBold mb-1">
                                    <strong class="text-lDark title">$tema</strong>
                                </h3>
                                <p class="text-muted">$actividad</p>
                                <ul class="list-unstyled contactInfoList mb-3">
                                    <li>
                                        <i class="text-lDark icnTheme fwMedium icomoon-clock icn position-absolute"><span class="sr-only">icon</span></i>
                                        <strong class="text-lDark title">Hora: </strong>
                                        <strong class="text-muted"><time datetime="$hora">$hora</time></strong>
                                    </li>
                                    <li>
                                        <i class="text-lDark fas fa-clipboard-user icn position-absolute"><span class="sr-only">icon</span></i>
                                        <strong class="text-lDark title">Organiza: </strong>
                                        <strong class="text-muted">$organiza</strong>
                                    </li>
                                    <li>
                                        <i class="text-lDark fas fa-map-marker-alt icn position-absolute"><span class="sr-only">icon</span></i>
                                        <strong class="text-lDark title">Lugar: </strong>
                                        <strong class="text-muted">$lugar</strong>
                                    </li>
                                    <li>
                                        <i class="text-lDark fas fa-users icn position-absolute"><span class="sr-only">icon</span></i>
                                        <strong class="text-lDark title">Participantes: </strong>
                                        <strong class="text-muted">$participante</strong>
                                    </li>
                                </ul>
                            </strong>
                        </div>
                    </article>
                </div>
            Html;
        }
        $paginadorHTML = $paginador->obtenerPaginador();
        return [$tablaFila, $paginadorHTML];
    }

    public function buscarAgenda($fechaDesde, $fechaHasta, $palabra)
    {
        $conexion = new MySQLConnection();
        $sql = "SELECT * FROM agenda WHERE 1=1";
        $params = array();
        if(!empty($fechaDesde)){
            $sql .= " AND fecha  >= :fecha_desde";
            $params[':fecha_desde'] = $fechaDesde;
        }
        if(!empty($fechaHasta)){
            $sql .= " AND fecha <= :fecha_hasta";
            $params[':fecha_hasta']=$fechaHasta;
        }
        if(!empty($palabra)){
            $sql .= " AND (actividad LIKE :palabra1 OR tema LIKE :palabra2 OR organiza LIKE :palabra3 OR lugar LIKE :palabra4 OR participante LIKE :palabra5)";
            $params[':palabra1'] = '%' . $palabra . '%';
            $params[':palabra2'] = '%' . $palabra . '%';
            $params[':palabra3'] = '%' . $palabra . '%';
            $params[':palabra4'] = '%' . $palabra . '%';
            $params[':palabra5'] = '%' . $palabra . '%';
        }
        $sql .= " LIMIT 500 ";
        try {
            $stmt  = $conexion->query($sql, $params, '', false);
            $resultados = $stmt->fetchAll();
            $tabla_respuesta = $this->makeTblForBuscarAgenda($resultados);
            return $tabla_respuesta;
        } catch (Throwable $e) {
            $this->handlerError($e);
        }
    }

    private function makeTblForBuscarAgenda($resultados)
    {
        $tablaFila = [];
        foreach ($resultados as $row) {
            $fechaFormat = DateTime::createFromFormat('Y-m-d', $row['fecha']);
            $formato = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
            $fecha = $formato->format($fechaFormat);
            $hora = ($row['hora']===NULL) ?  'Por definir' : $row['hora'];
            $actividad = $row['actividad'];
            $tema = $row['tema'];
            $organiza = $row['organiza'];
            $lugar = $row['lugar'];
            $participante = $row['participante'];

            $tablaFila[] = <<<Html
                <div class="col-12 col-md-6 col-lg-4 d-inline-flex">
                    <article class="npbColumn shadow bg-white mb-6 mb-xl-12">
                        <div class="imgHolder position-relative">
                            <time datetime="$fecha" class="npbTimeTag font-weight-bold fontAlter position-absolute text-white px-2 py-1">$fecha</time>
                        </div>
                        <div class="npbDescriptionWrap px-5 pt-8 pb-3">
                            <strong class="text-lDark mb-1">
                                <h3 class="fwSemiBold mb-1">
                                    <strong class="text-lDark title">$tema</strong>
                                </h3>
                                <p class="text-muted">$actividad</p>
                                <ul class="list-unstyled contactInfoList mb-3">
                                    <li>
                                        <i class="text-lDark icnTheme fwMedium icomoon-clock icn position-absolute"><span class="sr-only">icon</span></i>
                                        <strong class="text-lDark title">Hora: </strong>
                                        <strong class="text-muted"><time datetime="$hora">$hora</time></strong>
                                    </li>
                                    <li>
                                        <i class="text-lDark fas fa-clipboard-user icn position-absolute"><span class="sr-only">icon</span></i>
                                        <strong class="text-lDark title">Organiza: </strong>
                                        <strong class="text-muted">$organiza</strong>
                                    </li>
                                    <li>
                                        <i class="text-lDark fas fa-map-marker-alt icn position-absolute"><span class="sr-only">icon</span></i>
                                        <strong class="text-lDark title">Lugar: </strong>
                                        <strong class="text-muted">$lugar</strong>
                                    </li>
                                    <li>
                                        <i class="text-lDark fas fa-users icn position-absolute"><span class="sr-only">icon</span></i>
                                        <strong class="text-lDark title">Participantes: </strong>
                                        <strong class="text-muted">$participante</strong>
                                    </li>
                                </ul>
                            </strong>
                        </div>
                    </article>
                </div>
            Html;
        }
        return $tablaFila;
    }

    private function handlerError(Throwable $e) 
    {
        $errorMessage = date("Y-m-d H:i:s") . " : " . $e->getMessage() . "\n";
        error_log($errorMessage, 3, _ROOT_PATH . '/log/error.log' );
        return;
    }
}