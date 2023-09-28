<?php

require_once _ROOT_MODEL . 'conexion.php';
require_once(_ROOT_CONTROLLER . 'paginador.php');

class ParticipacionModel 
{
    public static function getPaticipacion($pagina, $tipoDoc)
    {
        $resultsPerPage = 10;
        $sql = 'SELECT title, type_doc, descriptions, load_date, files FROM participacion_ciudadana ';
        $sql = $tipoDoc == 'documentos' ? $sql .= 'ORDER BY id DESC' : $sql .= 'WHERE type_doc = :typeDoc ORDER BY id DESC';
        switch($tipoDoc){
            case 'documentos':
                $params = [];
            break;
            case 'presupuesto':
                $params = [':typeDoc' => 'Presupuesto Participativo'];
            break;
            case 'consejo':
                $params =  [':typeDoc'=>'Consejo de Coordinación Regional/Local'];
            break; 
            case 'audiencia':
                $params = [':typeDoc'=>'Audiencia Públicas'];
            break;
            case 'informacion':
                $params = [':typeDoc'=>'Información Adicional'];
            break;
        }
        $conexion = new MySQLConnection();

        $paginador = new Paginator($conexion, $sql, $params, $pagina, $resultsPerPage);
        $paginador->setPaginaActual($pagina);
        $resultados = $paginador->getResultados();
        $paginadorHTML = $paginador->obtenerPaginador();
        return [$resultados, $paginadorHTML];
    }

    public static function saveFormParticipacion($titulo, $descripcion, $tipoDoc, $files)
    {   
        $userName = $_SESSION['username'];
        $userIdsql = 'SELECT id FROM usuarios  where nombre_usuario = ?';
        $conexion = new MySQLConnection();
        $stmt = $conexion->query($userIdsql, [$userName], '', false);
        $userId = $stmt->fetchColumn();

        $sql = 'INSERT INTO participacion_ciudadana (title, type_doc, descriptions, load_date, user_id_who_load, files) VALUES ( :title, :tipoDoc, :descriptions, :load_date, :user_id_who_load, :files)';
        $params = [
            ':title' => $titulo,
            ':descriptions' => $descripcion,
            ':tipoDoc' => $tipoDoc,
            ':load_date' => date('Y-m-d'),
            ':user_id_who_load' => $userId,
            ':files' => $files
        ];
        $conexion->query($sql, $params, '', false);
        return true; 
    }

    public static function buscarParticipacion($startDate, $endDate, $tipoDoc)
    {
        $sql = 'SELECT title, descriptions, load_date, files 
                FROM participacion_ciudadana 
                WHERE load_date BETWEEN :startDate AND :endDate AND type_doc = :typeDoc
                ORDER BY id DESC';
        $params = [':startDate'=> $startDate, ':endDate'=>$endDate, ':typeDoc'=> $tipoDoc];
        $conexion = new MySQLConnection();
        $stmt = $conexion->query($sql, $params, '', false);
        $resultado = $stmt->fetchAll();
        return $resultado;
    }
}