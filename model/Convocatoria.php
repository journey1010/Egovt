<?php

use PhpOffice\PhpSpreadsheet\Helper\Html;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\FunctionPrefix;

require_once _ROOT_MODEL . 'conexion.php';
require_once _ROOT_CONTROLLER . 'paginador.php';
require_once _ROOT_CONTROLLER . 'admin/handleSanitize.php';

class Convocatoria extends handleSanitize
{
   public function verConvocatoria($pagina = 1)
   {
      $resultadosPorPagina = 10;
      if (!isset($conexion)) {
         $conexion = new MySQLConnection();
         $sql = "SELECT conv.titulo AS titulo, conv.descripcion AS descripcion, conv.estado AS estado, conv.fecha_limite AS fecha_limite , ofi.nombre AS nombre, GROUP_CONCAT( adj.nombre, ';', adj.archivo ) AS adjuntos FROM convocatorias AS conv 
                  INNER JOIN oficinas AS ofi ON conv.dependencia = ofi.id 
                  INNER JOIN convocatorias_adjuntos AS adj ON conv.id = adj.id_convocatoria
                  GROUP BY conv.id
                  ORDER BY conv.fecha_registro DESC";
         $params = '';
      }
      session_set_cookie_params(['lifetime' => 60]);
      if (session_status() == PHP_SESSION_NONE) {
         session_start();
      }
      if (isset($_SESSION['convocatoria']) && $_SESSION['convocatoria'] instanceof Paginator) {
         $paginador = $_SESSION['convocatoria'];
         $paginador->setResultadosPorPagina($resultadosPorPagina);
      } else {
         $paginador = new Paginator($conexion, $sql, $params, $pagina, $resultadosPorPagina);
         $_SESSION['convocatoria'] = $paginador;
      }

      $paginador->setPaginaActual($pagina);
      $resultados = $paginador->getResultados();
      $paginadorHTML = $paginador->obtenerPaginador();
      $respuesta = $this->viewConvocatoria($resultados);
      return [$respuesta, $paginadorHTML];
   }
   /**
    * Crea una vista para las convocatorias apartir de los datos de la consulta sql
    * @param  array $resultados. contiene los datos de la convocatoria
    * @return string
    * @see viewEstado()
    * @see viewAdjuntos()
    */
   private function viewConvocatoria(array $resultados): string
   {
      $image = _ROOT_ASSETS . 'images/image-convocatoria.webp';
      $viewConvocatoria = '';
      foreach ($resultados as $row) {
         $fechaFormat = DateTime::createFromFormat('Y-m-d', $row['fecha_limite']);
         $formato = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
         $fecha = $formato->format($fechaFormat);
         $adjuntos = $this->viewAdjuntos($row['adjuntos']);
         $estado  = $this->viewEstado($row['estado']);
         $viewConvocatoria .= <<<Html
         <article class="ueEveColumn__list bg-light mt-3 position-relative px-4 py-3 px-lg-8 py-lg-6">
               <div class="d-lg-flex align-items-md-center">
                  <div class="imgHolder overflow-hidden flex-shrink-0 mr-4 mr-lg-10 mb-1 mb-md-0">
                     <img src="$image" class="img-fluid" alt="logo convocatoria">
                  </div>
                  <div class="d-md-flex align-items-md-center flex-grow-1">
                     <div class="descrWrap flex-grow-1">
                           <strong class="tagTitle d-block text-success fwSemiBold mb-2">Gobierno Regional de Loreto</strong>
                           <h3 class="fwMedium">
                              {$row['titulo']}
                           </h3>
                           <strong class="tagTitle d-block text-black fwSemiBold mb-2">
                              {$row['descripcion']}
                           </strong>
                           <ul class="list-unstyled ueScheduleList mb-0">
                              <li>
                              <i class="icomoon-clock icn position-absolute"><span class="sr-only">icon</span></i>
                              Fecha Limite de Postulación: $fecha
                              </li>
                              <li>
                              <i class="icomoon-location icn position-absolute"><span class="sr-only">icon</span></i>
                              Dependencia : {$row['nombre']}
                              </li>
                           </ul>
                           <ul class="list-unstyled ueScheduleList mb-0">
                              $adjuntos
                           </ul>
                     </div>
                     $estado
                  </div>
               </div>
         </article>
         Html;
      }
      return $viewConvocatoria;
   }

   /**
    * Separa un array y crea una vista html.
    * @param  string  $adjuntos, contiene los datos (concatenados) de los documentos adjuntos de una convocatoria.  
    * @return string  vista de los adjuntos de una convocatoria
    */
   private function viewAdjuntos(string  $adjuntos): string
   {
      $viewAdjunto = '';
      $documentos = explode(',', $adjuntos);
      foreach ($documentos as $documento) {
         $datos = explode(';', $documento);
         $url = _BASE_URL . '/files/transparencia/convocatorias/' . $datos[1];
         $viewAdjunto .= <<<Html
         <li>
            <a href="$url" target="_blank" download>
               <i class="fal fa-arrow-square-down icn position-absolute"><span class="sr-only">icon</span></i>
               {$datos[0]}
            </a>
         </li>
         Html;
      }
      return $viewAdjunto;
   }

   /**
    * Modifica la vista del cuadro estado de acuerdo al estado de la convocatoria
    * @param int $estado, es el estado de la convocatoria
    * @return string $vieEstado, contiene la vista del estado
    */
   private function viewEstado(int $estado): string
   {
      switch ($estado) {
         case 1:
            $text = 'Abierto';
            break;
         case 2:
            $text = 'Cerrado';
            break;
         case 3:
            $text = 'Finalizado';
            break;
      }
      $viewEstado = <<<Html
      <a href="javascript:void(0);" class="btn btnCustomLightOutline bdrWidthAlter btn-sm text-capitalize position-relative border-1 p-0 flex-shrink-0 ml-md-4" style="border-color: #06163A; width: 120px" data-hover="$text" target="_blank">
         <span class="d-block btnText">$text</span>
      </a>
      Html;
      return $viewEstado;
   }
   /**
    * crea una consulta dinamica para realizar una busqueda en los registros de convocatoria. 
    * @param string $fechaDesde, fecha bottom,
    * @param string $fechaHasta, fecha top,
    * @param string $palabra, palabra clave a buscar 
   */
   public function buscarConvocatoria(string $fechaDesde, string $fechaHasta, string $palabra)
   {
      $conexion = new MySQLConnection();
      $sql = "SELECT conv.titulo AS titulo, conv.descripcion AS descripcion, conv.estado AS estado, conv.fecha_limite AS fecha_limite , ofi.nombre AS nombre, GROUP_CONCAT( adj.nombre, ';', adj.archivo ) AS adjuntos FROM convocatorias AS conv 
               INNER JOIN oficinas AS ofi ON conv.dependencia = ofi.id 
               INNER JOIN convocatorias_adjuntos AS adj ON conv.id = adj.id_convocatoria
               WHERE 1=1
            "; 
      $params = array();
      if(!empty($fechaDesde)){
         $sql .= " AND conv.fecha_registro  >= :fecha_desde";
         $params[':fecha_desde'] = $fechaDesde;
     }
     if(!empty($fechaHasta)){
         $sql .= " AND conv.fecha_registro <= :fecha_hasta";
         $params[':fecha_hasta']=$fechaHasta;
     }
     if(!empty($palabra)){
         $sql .= " AND (conv.titulo LIKE :palabra1 OR conv.descripcion LIKE :palabra2 )";
         $params[':palabra1'] = '%' . $palabra . '%';
         $params[':palabra2'] = '%' . $palabra . '%';
     }
     $sql .= " GROUP BY conv.id ORDER BY conv.fecha_registro DESC LIMIT 100 ";
     try {
         $stmt  = $conexion->query($sql, $params, '', false);
         $resultados = $stmt->fetchAll();
         $respuesta= $this->viewConvocatoriaPost($resultados);
         return $respuesta;
     } catch (Throwable $e) {
         $this->handlerError($e);
     }
   }
    
   private function viewConvocatoriaPost(array $resultados): array
   {
      $image = _ROOT_ASSETS . 'images/image-convocatoria.webp';
      $viewConvocatoria = [];
      foreach ($resultados as $row) {
         $fechaFormat = DateTime::createFromFormat('Y-m-d', $row['fecha_limite']);
         $formato = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
         $fecha = $formato->format($fechaFormat);
         $adjuntos = $this->viewAdjuntos($row['adjuntos']);
         $estado  = $this->viewEstado($row['estado']);
         $viewConvocatoria []= <<<Html
         <article class="ueEveColumn__list bg-light mt-3 position-relative px-4 py-3 px-lg-8 py-lg-6">
               <div class="d-lg-flex align-items-md-center">
                  <div class="imgHolder overflow-hidden flex-shrink-0 mr-4 mr-lg-10 mb-1 mb-md-0">
                     <img src="$image" class="img-fluid" alt="logo convocatoria">
                  </div>
                  <div class="d-md-flex align-items-md-center flex-grow-1">
                     <div class="descrWrap flex-grow-1">
                           <strong class="tagTitle d-block text-success fwSemiBold mb-2">Gobierno Regional de Loreto</strong>
                           <h3 class="fwMedium">
                              {$row['titulo']}
                           </h3>
                           <strong class="tagTitle d-block text-black fwSemiBold mb-2">
                              {$row['descripcion']}
                           </strong>
                           <ul class="list-unstyled ueScheduleList mb-0">
                              <li>
                              <i class="icomoon-clock icn position-absolute"><span class="sr-only">icon</span></i>
                              Fecha Limite de Postulación: $fecha
                              </li>
                              <li>
                              <i class="icomoon-location icn position-absolute"><span class="sr-only">icon</span></i>
                              Dependencia : {$row['nombre']}
                              </li>
                           </ul>
                           <ul class="list-unstyled ueScheduleList mb-0">
                              $adjuntos
                           </ul>
                     </div>
                     $estado
                  </div>
               </div>
         </article>
         Html;
      }
      return $viewConvocatoria;
   }
}