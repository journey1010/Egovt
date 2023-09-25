<?php

require_once _ROOT_MODEL . 'conexion.php';
require_once(_ROOT_CONTROLLER . 'paginador.php');

class PresupuestoModel 
{
    public static function getSaldoBalance($pagina)
    {   
        session_set_cookie_params(['lifetime' => 60]);
        session_start();

        $resultsPerPage = 12;
        $sql = "SELECT title, CONCAT(YEAR(load_date), '/',MONTH(load_date), '/', path_file )as pathfile, load_date FROM saldos_de_balance ORDER BY id DESC";
        $params = [];

        if (isset($_SESSION['saldo_balance'])) {
            $paginador = $_SESSION['saldo_balance'];
            $paginadorHTML = $paginador->setResultadosPorPagina($resultsPerPage);
        } else {
            $conexion = new MySQLConnection();
            $paginador = new Paginator($conexion, $sql, $params, $pagina, $resultsPerPage);
            $_SESSION['saldo_balance'] = $paginador;
        }

        $paginador->setPaginaActual($pagina);
        $resultados = $paginador->getResultados();
        $paginadorHTML = $paginador->obtenerPaginador();
        return [$resultados, $paginadorHTML];
    }
}