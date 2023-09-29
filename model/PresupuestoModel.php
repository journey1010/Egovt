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
        $sql = "SELECT title, CONCAT(YEAR(load_date), '/',DATE_FORMAT(load_date, '%m'), '/', path_file )as pathfile, load_date FROM saldos_de_balance ORDER BY id DESC";
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

    public static function registrarSaldoBalance($titulo, $archivo, $fecha)
    {
        $userName = $_SESSION['username'];
        $userIdsql = 'SELECT id FROM usuarios  where nombre_usuario = ?';
        $conexion = new MySQLConnection();
        $stmt = $conexion->query($userIdsql, [$userName], '', false);
        $userId = $stmt->fetchColumn();

        $sql = 'INSERT INTO saldos_de_balance (title, load_date, user_id_who_load, path_file) VALUES (:title, :load_date, :user_id_who_load, :path_file )';
        $params = [':title'=>$titulo, ':load_date'=>$fecha, ':user_id_who_load'=>$userId, ':path_file'=>$archivo];
        $conexion->query($sql, $params, '', false);
        return true;
    }

    public static function buscarSaldoBalance($startDate, $endDate)
    {
        $sql = "SELECT title, CONCAT(YEAR(load_date), '/',DATE_FORMAT(load_date, '%m'), '/', path_file )as pathfile, load_date 
                FROM saldos_de_balance 
                WHERE load_date BETWEEN :startDate AND :endDate
                ORDER BY id DESC";
        $params = [':startDate'=> $startDate, ':endDate'=>$endDate];
        $conexion = new MySQLConnection();
        $stmt = $conexion->query($sql, $params, '', false);
        $resultado = $stmt->fetchAll();
        return $resultado;
    }
}