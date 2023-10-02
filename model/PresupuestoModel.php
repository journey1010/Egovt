<?php

require_once _ROOT_MODEL . 'conexion.php';
require_once(_ROOT_CONTROLLER . 'paginador.php');

class PresupuestoModel 
{
    public static function getSaldoBalance($pagina)
    {   
        session_set_cookie_params(['lifetime' => 60]);
        session_start();

        $resultsPerPage = 6;
        $sql = "SELECT id, title, load_date, files, docs_date FROM saldos_de_balance ORDER BY id DESC";
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

    public static function saveFormSaldoBalance($titulo, $archivo, $fecha)
    {
        $userName = $_SESSION['username'];
        $userIdsql = 'SELECT id FROM usuarios  where nombre_usuario = ?';
        $conexion = new MySQLConnection();
        $stmt = $conexion->query($userIdsql, [$userName], '', false);
        $userId = $stmt->fetchColumn();

        $sql = 'INSERT INTO saldos_de_balance (title, load_date, user_id_who_load, files, docs_date) VALUES (:title, :load_date, :user_id_who_load, :path_file, :docs_date )';
        $params = [
            ':title'=>$titulo,
            ':load_date'=>date('Y-m-d'),
            ':user_id_who_load'=>$userId,
            ':path_file'=>$archivo,
            ':docs_date' =>$fecha
        ];
        $conexion->query($sql, $params, '', false);
        return true;
    }

    public static function buscarSaldoBalance($startDate)
    {
        $sql = 'SELECT title, load_date, files, docs_date 
                FROM saldos_de_balance 
                WHERE YEAR(docs_date) = :startDate 
                ORDER BY id DESC
                ';
        $params = [':startDate'=> $startDate];
        $conexion = new MySQLConnection();
        $stmt = $conexion->query($sql, $params, '', false);
        $resultado = $stmt->fetchAll();
        return $resultado;
    }
}