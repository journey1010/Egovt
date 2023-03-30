<?php

class Paginator {
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
        $this->paginaActual = $paginaActual;
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

    public function obtenerPaginador($color) {
        $paginador = '';

        if ($this->totalDePaginas > 1) {
            $paginador .= '<ul class="pagination justify-content-center">';

            if ($this->paginaActual > 1) {
              $paginador .= '<li class="page-item"><a class="page-link" href="?pagina=' . ($this->paginaActual - 1) . '">Anterior</a></li>';
            }

            for ($i = 1; $i <= $this->totalDePaginas; $i++) {
              if ($i == $this->paginaActual) {
                $paginador .= '<li class="page-item active bg-'.$color.'"><a class="page-link" href="#">' . $i . '</a></li>';
              } else {
                $paginador .= '<li class="page-item"><a class="page-link" href="?pagina=' . $i . '">' . $i . '</a></li>';
              }
            }

            if ($this->paginaActual < $this->totalDePaginas) {
              $paginador .= '<li class="page-item"><a class="page-link" href="?pagina=' . ($this->paginaActual + 1) . '">Siguiente</a></li>';
            }

            $paginador .= '</ul>';
        }

        return $paginador;
    }

    private function calcularTotalPaginas() {  
        return ceil($this->getTotalResultados() / $this->resultadosPorPagina);
    }

}