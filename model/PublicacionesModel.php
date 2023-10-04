<?php

require_once _ROOT_MODEL . 'conexion.php';
require_once(_ROOT_CONTROLLER . 'paginador.php');

class PublicacionesModel 
{
    public static function getPublicaciones($pagina)
    {   
        session_set_cookie_params(['lifetime' => 60]);
        session_start();

        $resultsPerPage = 6;
        $sql = "SELECT id, title, type_doc, descriptions, docs_date, load_date, files FROM publicaciones ORDER BY id DESC";
        $params = [];
      
        if (isset($_SESSION['publicaciones'])) {
            $paginador = $_SESSION['publicaciones'];
            $paginadorHTML = $paginador->setResultadosPorPagina($resultsPerPage);
        } else {
            $conexion = new MySQLConnection();
            $paginador = new Paginator($conexion, $sql, $params, $pagina, $resultsPerPage);
            $_SESSION['publicaciones'] = $paginador;
        }

        $paginador->setPaginaActual($pagina);
        $resultados = $paginador->getResultados();
        $paginadorHTML = $paginador->obtenerPaginador();
        return [$resultados, $paginadorHTML];
    }

    public static function saveFormPublicaciones($titulo, $descripcion, $tipoDoc, $archivo, $fecha)
    {
        $userName = $_SESSION['username'];
        $userIdsql = 'SELECT id FROM usuarios  where nombre_usuario = ?';
        $conexion = new MySQLConnection();
        $stmt = $conexion->query($userIdsql, [$userName], '', false);
        $userId = $stmt->fetchColumn();

        $sql = 'INSERT INTO publicaciones (title, type_doc, descriptions, docs_date, load_date, user_id_load, files ) VALUES (:title, :typeDoc, :descriptions, :docs_date, :load_date, :user_id_who_load, :path_file)';
        $params = [
            ':title'=>$titulo,
            ':typeDoc'=>$tipoDoc,
            ':descriptions'=>$descripcion,
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
        $sql = 'SELECT title, type_doc, descriptions, load_date, files, docs_date 
                FROM publicaciones 
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