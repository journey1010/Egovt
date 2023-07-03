<?php

use PhpOffice\PhpSpreadsheet\Style\NumberFormat\DateFormatter;

require_once(_ROOT_MODEL . 'conexion.php');
require_once(_ROOT_CONTROLLER . 'paginador.php');

class casGorel
{
    public function verCas($pagina = 1)
    {
        $resultadosPorPagina = 12;
        if (!isset($conexion)) {
            $conexion = new MySQLConnection();
            $sql = "SELECT cas.id, cas.titulo, cas.descripcion, cas.estado, cas.fecha_inicio_inscripcion, cas.fecha_cierre_inscripcion, cas.fecha_resultado_final, cas.dependencia, oficinas.nombre FROM cas INNER JOIN oficinas ON cas.dependencia = oficinas.id ORDER BY cas.fecha_inicio_inscripcion DESC";
            $params = '';
         }
         session_set_cookie_params(900);
         session_start();
         if (isset($_SESSION['pverCas_instance'])) {
            $paginador = $_SESSION['pverCas_instance'];
            $paginador->setResultadosPorPagina($resultadosPorPagina);
         }else {
            $paginador = new Paginator($conexion, $sql, $params, $pagina, $resultadosPorPagina);
            $_SESSION['pverAgenda_instance'] = $paginador;
         }

         $paginador->setPaginaActual($pagina);
         $resultados = $paginador->getResultados();
         $tablaFila = '';
         foreach ($resultados as $row){
            
            $id=$row['id'];
            $logo=$row['dependencia'];
            $oficina=$row['nombre'];
            $titulo=$row['titulo'];
            $descripcion = $row['descripcion'];
         }
    }


    private function handlerError(Throwable $e) 
    {
        $errorMessage = date("Y-m-d H:i:s") . " : " . $e->getMessage() . "\n";
        error_log($errorMessage, 3, _ROOT_PATH . '/log/error.log' );
        return;
    }
}