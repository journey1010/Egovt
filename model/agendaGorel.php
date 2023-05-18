<?php
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
            $fecha = $row['fecha'];
            $hora = ($row['hora']===NULL) ?  'Por definir' : $row['hora'];
            $actividad = $row['actividad'];
            $tema = $row['tema'];
            $organiza = $row['organiza'];
            $lugar = $row['lugar'];
            $participante = $row['participante'];

            $tablaFila .= <<<Html
                <div class="col-12 col-md-6 col-lg-4">
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
}