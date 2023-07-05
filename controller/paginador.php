<?php
require_once (_ROOT_CONTROLLER . 'admin/handleSanitize.php');

class Paginator extends handleSanitize {
    private $conexion;
    private $sentencia;
    private $params;
    private $paginaActual;
    private $resultadosPorPagina;
    private $totalDePaginas;

    public function __construct($conexion, $sentencia, $params, $paginaActual, $resultadosPorPagina) {
        $this->conexion = $conexion;
        $this->sentencia = $sentencia;
        $this->params = $params;
        $this->paginaActual = $paginaActual;
        $this->resultadosPorPagina = $resultadosPorPagina;
        $this->totalDePaginas = $this->calcularTotalPaginas();
    }

    public function getPaginaActual() {
        return $this->paginaActual;
    }

    public function setPaginaActual($paginaActual) {   
        $this->paginaActual = $this->SanitizeVarInput($paginaActual);
    }

    public function getResultadosPorPagina() {
        return $this->resultadosPorPagina;
    }

    public function setResultadosPorPagina($resultadosPorPagina) { 
        $this->resultadosPorPagina = $resultadosPorPagina;
        $this->totalDePaginas = $this->calcularTotalPaginas(); 
    }

    public function getTotalResultados() {
        $stmt = $this->conexion->query($this->sentencia, $this->params, '', false);
        $total = count($stmt->fetchAll());
        return $total;
    }

    public function getResultados() {
        $limit = $this->resultadosPorPagina;
        $offset = ($this->paginaActual - 1) * $limit;

        $sentenciaConLimite = $this->sentencia . " LIMIT $offset, $limit ";
        $stmt = $this->conexion->query($sentenciaConLimite, $this->params, '', false);
        return $stmt->fetchAll();
    }

    public function obtenerPaginador() {

        $paginador = '<nav aria-label="Page navigation">';

        if ($this->totalDePaginas > 1) {
            $paginador .= '<ul class="pagination justify-content-center pt-2">';

            if ($this->paginaActual > 1) {
              $paginador .= '<li class="page-item"><a class="page-link" href="?page=' . ($this->paginaActual - 1) . '">Anterior</a></li>';
            }

            $rangoPaginas = 9; 
        
            $paginaInicio = max(1, $this->paginaActual - floor($rangoPaginas / 2));
            $paginaFin = min($this->totalDePaginas, $paginaInicio + $rangoPaginas - 1);
            
            for ($i = $paginaInicio; $i <= $paginaFin; $i++) {
                if ($i == $this->paginaActual) {
                    $paginador .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '<span class="sr-only">(current)</span></a></li>';
                } else {
                    $paginador .= '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                }
            }

            if ($this->paginaActual < $this->totalDePaginas) {
              $paginador .= '<li class="page-item"><a class="page-link" href="?page=' . ($this->paginaActual + 1) . '">Siguiente <i class="fa fa-chevron-right icn"><span class="sr-only">icon</span></i></a></li>';
            }

            $paginador .= '</ul></nav>';
        }

        return $paginador;
    }

    private function calcularTotalPaginas() {  
        return ceil($this->getTotalResultados() / $this->resultadosPorPagina);
    }
}