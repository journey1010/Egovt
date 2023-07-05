<?php

use PhpOffice\PhpSpreadsheet\Style\NumberFormat\DateFormatter;

require_once(_ROOT_CONTROLLER . 'viewsRender.php');
require_once(_ROOT_MODEL . 'visitas.php');
require_once(_ROOT_MODEL . 'proyectosInversionPublica.php');
require_once(_ROOT_MODEL . 'agendaGorel.php');
require_once(_ROOT_MODEL . 'Convocatoria.php');

class transparenciaController extends ViewRenderer
{
    private $ruta;

    public function __construct()
    {
        $this->ruta = _ROOT_ASSETS . 'images/';
    }
    /**
     * Genera una vista general para acceder a al registro de visitas actual y antiguo.
     * @return void
    */
    public function visitasMain()
    {
        $this->setCacheDir(_ROOT_CACHE . 'transparencia/visitas/');
        $this->setCacheTime(2678400);
        $data = [
            'imageNew' => _ROOT_ASSETS . 'images/nuevasVisitas.jpg',
            'imageOld' => _ROOT_ASSETS . 'images/oldVisitas.jpg'
        ];
        $dataFooter = [
            'logoWhite' => $this->ruta . 'logoWhite.png',
            'año' => date('Y')
        ];
        $this->render('header', '', false);
        $this->render('transparencia/visitasgorel/main', $data, true);
        $this->render('footer', $dataFooter, false);
    }

    /**
     * Genera una vista paginada para el nuevo registro de visitas.
     *
     * @param integer $pagina, establece el número de pagina actual
     * @return void
     */
    public function visitasNew($pagina = 1)
    {
        if (!is_numeric($pagina)) {
            $this->setCacheDir(_ROOT_CACHE);
            $this->setCacheTime(1);
            $this->render('ErrorView', '', true);
            return;
        }
        try {
            $this->setCacheDir(_ROOT_CACHE . 'transparencia/visitas/');
            $this->setCacheTime(86000);

            $visitas = new visitas();
            list($tablaFila, $paginadorHtml) = $visitas->visitasNuevas($pagina);

            $data = [
                "tablaFila" => $tablaFila,
                "paginadorHtml" => $paginadorHtml,
                "link" => _ROOT_ASSETS . 'css/datepicker.css',
                "jsDatapicker" => _ROOT_ASSETS . 'js/bootstrap-datepicker.js',
                "jsMaterialkit" => _ROOT_ASSETS . 'js/material-kit.js',
                "jsVisitas" => _ROOT_ASSETS . 'jsVisitas.js',
                "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css",
                "dataTableJs" => _ROOT_ASSETS . "js/jquery.dataTables.min.js"
            ];
            $dataFooter = [
                'año' => date('Y')
            ];
            $this->render('header', '', false);
            $this->render('transparencia/visitasgorel/newVisitas', $data, false);
            $this->render('footer', $dataFooter, false);
        } catch (Throwable $e) {
            $this->handleError($e);
        }
    }

    /**
     * Recibe una solicitud de busqueda para el registro de visitas
     * Devuelve en formato de json el resultado de la busqueda.
     * @return void
     */
    public function visitasNewPost()
    {
        if (empty($_POST['fecha']) && strtotime($_POST['fecha'])) {
            $respuesta = array("error" => "Ha ocurrido un error inesperado en la solicitud.");
            print_r(json_encode($respuesta));
            return;
        }
        $fecha = $_POST['fecha'];
        $nueva_fecha = date_format(date_create_from_format('d/m/Y', $fecha), 'Y-m-d');
        try {
            $visitas = new visitas();
            $resultado = $visitas->visitasNuevasPost($nueva_fecha);
            echo $resultado;
        } catch (Throwable $e) {
            $respuesta = array("error" => "Ha ocurrido un error inesperado.");
            print_r(json_encode($respuesta));
            $this->handleError($e);
        }
    }

    public function visitasOld()
    {
        $this->setCacheDir(_ROOT_CACHE . 'transparencia/visitas/');
        $this->setCacheTime(83600);
        $visitas = new visitas();
        $resultado = $visitas->visitasOld();
        $data = [
            "tablaFila" => $resultado,
            "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css",
            "dataTableJs" => _ROOT_ASSETS . "js/jquery.dataTables.min.js"
        ];
        $dataFooter = [
            'año' => date('Y')
        ];
        $this->render('header', '', false);
        $this->render('transparencia/visitasgorel/oldVisitas', $data, false);
        $this->render('footer', $dataFooter, false);
    }
    
    /**
     * Genera una vista de todos los proyectos de inversión pública (pip)
     * @param integer $pagina, establece la pagina actual.
     * @return void
     */
    public function pipTodos($pagina = 1)
    {
        if (!is_numeric($pagina)) {
            $this->setCacheDir(_ROOT_CACHE);
            $this->setCacheTime(86000);
            $this->render('ErrorView', '', true);
            return;
        }
        try {
            $this->setCacheDir(_ROOT_CACHE . 'transparencia/visitas/');
            $this->setCacheTime(1);

            $pip = new ProyectoInversionPublica();
            list($tablaFila, $paginadorHtml) = $pip->pipTodos($pagina);

            $data = [
                "tablaFila" => $tablaFila,
                "paginadorHtml" => $paginadorHtml,
                "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css",
                "dataTableJs" => _ROOT_ASSETS . "js/jquery.dataTables.min.js"
            ];
            $dataFooter = [
                'año' => date('Y')
            ];
            $this->render('header', '', false);
            $this->render('transparencia/ProyectosInversion/proyectosinversion', $data, false);
            $this->render('footer', $dataFooter, false);
        } catch (Throwable $e) {
            $this->handleError($e);
        }
    }

    public function pipAdicionalesObra($pagina = 1)
    {
        if (!is_numeric($pagina)) {
            $this->setCacheDir(_ROOT_CACHE);
            $this->setCacheTime(86000);
            $this->render('ErrorView', '', true);
            return;
        }
        try {
            $this->setCacheDir(_ROOT_CACHE . 'transparencia/visitas/');
            $this->setCacheTime(1);

            $pip = new ProyectoInversionPublica();
            list($tablaFila, $paginadorHtml) = $pip->pipAdicionalesObra($pagina);

            $data = [
                "tablaFila" => $tablaFila,
                "paginadorHtml" => $paginadorHtml,
                "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css",
                "dataTableJs" => _ROOT_ASSETS . "js/jquery.dataTables.min.js"
            ];
            $dataFooter = [
                'año' => date('Y')
            ];
            $this->render('header', '', false);
            $this->render('transparencia/ProyectosInversion/proyectosinversion', $data, false);
            $this->render('footer', $dataFooter, false);
        } catch (Throwable $e) {
            $this->handleError($e);
        }
    }

    public function pipLiquidacionObra($pagina = 1)
    {
        if (!is_numeric($pagina)) {
            $this->setCacheDir(_ROOT_CACHE);
            $this->setCacheTime(86000);
            $this->render('ErrorView', '', true);
            return;
        }
        try {
            $this->setCacheDir(_ROOT_CACHE . 'transparencia/visitas/');
            $this->setCacheTime(1);

            $pip = new ProyectoInversionPublica();
            list($tablaFila, $paginadorHtml) = $pip->pipLiquidacionObra($pagina);

            $data = [
                "tablaFila" => $tablaFila,
                "paginadorHtml" => $paginadorHtml,
                "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css",
                "dataTableJs" => _ROOT_ASSETS . "js/jquery.dataTables.min.js"
            ];
            $dataFooter = [
                'año' => date('Y')
            ];
            $this->render('header', '', false);
            $this->render('transparencia/ProyectosInversion/proyectosinversion', $data, false);
            $this->render('footer', $dataFooter, false);
        } catch (Throwable $e) {
            $this->handleError($e);
        }
    }

    public function pipSupervisionObra($pagina = 1)
    {
        if (!is_numeric($pagina)) {
            $this->setCacheDir(_ROOT_CACHE);
            $this->setCacheTime(86000);
            $this->render('ErrorView', '', true);
            return;
        }
        try {
            $this->setCacheDir(_ROOT_CACHE . 'transparencia/visitas/');
            $this->setCacheTime(1);

            $pip = new ProyectoInversionPublica();
            list($tablaFila, $paginadorHtml) = $pip->pipSupervisionObra($pagina);

            $data = [
                "tablaFila" => $tablaFila,
                "paginadorHtml" => $paginadorHtml,
                "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css",
                "dataTableJs" => _ROOT_ASSETS . "js/jquery.dataTables.min.js"
            ];
            $dataFooter = [
                'año' => date('Y')
            ];
            $this->render('header', '', false);
            $this->render('transparencia/ProyectosInversion/proyectosinversion', $data, false);
            $this->render('footer', $dataFooter, false);
        } catch (Throwable $e) {
            $this->handleError($e);
        }
    }

    public function pipHistorico($pagina = 1)
    {
        if (!is_numeric($pagina)) {
            $this->setCacheDir(_ROOT_CACHE);
            $this->setCacheTime(86000);
            $this->render('ErrorView', '', true);
            return;
        }
        try {
            $this->setCacheDir(_ROOT_CACHE . 'transparencia/visitas/');
            $this->setCacheTime(1);

            $pip = new ProyectoInversionPublica();
            list($tablaFila, $paginadorHtml) = $pip->pipHistorico($pagina);

            $data = [
                "tablaFila" => $tablaFila,
                "paginadorHtml" => $paginadorHtml,
                "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css",
                "dataTableJs" => _ROOT_ASSETS . "js/jquery.dataTables.min.js"
            ];
            $dataFooter = [
                'año' => date('Y')
            ];
            $this->render('header', '', false);
            $this->render('transparencia/ProyectosInversion/proyectosinversion', $data, false);
            $this->render('footer', $dataFooter, false);
        } catch (Throwable $e) {
            $this->handleError($e);
        }
    }

    public function pipInformacionAdicional($pagina = 1)
    {
        if (!is_numeric($pagina)) {
            $this->setCacheDir(_ROOT_CACHE);
            $this->setCacheTime(86000);
            $this->render('ErrorView', '', true);
            return;
        }
        try {
            $this->setCacheDir(_ROOT_CACHE . 'transparencia/visitas/');
            $this->setCacheTime(1);

            $pip = new ProyectoInversionPublica();
            list($tablaFila, $paginadorHtml) = $pip->pipInformacionAdicional($pagina);

            $data = [
                "tablaFila" => $tablaFila,
                "paginadorHtml" => $paginadorHtml,
                "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css",
                "dataTableJs" => _ROOT_ASSETS . "js/jquery.dataTables.min.js"
            ];
            $dataFooter = [
                'año' => date('Y')
            ];
            $this->render('header', '', false);
            $this->render('transparencia/ProyectosInversion/proyectosinversion', $data, false);
            $this->render('footer', $dataFooter, false);
        } catch (Throwable $e) {
            $this->handleError($e);
        }
    }

    /**
     * Recibe una solicitud de busqueda para el registro de proyectos de inversión pública
     * Devuelve en formato de json el resultado de la busqueda.
     * @return void
     */
    public function BuscarObra()
    {
        $tipo = htmlspecialchars(($_POST['tipo']), ENT_QUOTES, "UTF-8");
        $año = htmlspecialchars(($_POST['año']), ENT_QUOTES, "UTF-8");
        $palabra = htmlspecialchars(($_POST['palabra']), ENT_QUOTES, "UTF-8");

        try {
            $pip = new ProyectoInversionPublica();
            $resultado = $pip->BuscarObra($tipo, $año, $palabra);
            echo $resultado;
        } catch (Throwable $e) {
            $respuesta = array("error" => "Ha ocurrido un error inesperado.");
            print_r(json_encode($respuesta));
            $this->handleError($e);
        }
    }
    /**
     * Genera una vista de las actividades o agendas del gobernador. 
     * @param integer $pagina, establece la página actual 
     * @return void
     */
    public function agendaGorel($pagina = 1)
    {
        if (!is_numeric($pagina)) {
            $this->setCacheDir(_ROOT_CACHE);
            $this->setCacheTime(86000);
            $this->render('ErrorView', '', true);
            return;
        }
        try {
            $this->setCacheDir(_ROOT_CACHE . 'transparencia/agendaGorel/');
            $this->setCacheTime(1);

            $agendaGorel = new agendaGorel();
            list($tablaFila, $paginadorHtml) = $agendaGorel->verAgenda($pagina);

            $data = [
                "tablaFila" => $tablaFila,
                "paginadorHtml" => $paginadorHtml,
                "link" => _ROOT_ASSETS . 'css/datepicker.css',
                "jsDatapicker" => _ROOT_ASSETS . 'js/bootstrap-datepicker.js',
                "jsMaterialkit" => _ROOT_ASSETS . 'js/material-kit.js',
                "paginator" => _ROOT_ASSETS . 'js/pagination.min.js'
                
            ];
            $dataFooter = [
                'año' => date('Y')
            ];
            $this->render('header', '', false);
            $this->render('transparencia/agendaGorel/agendaGorel', $data, false);
            $this->render('footer', $dataFooter, false);            
        }catch (Throwable $e) {
            $this->handleError($e);
        }
    }
    
    /**
     * Recibe una solicitud de busqueda para el registro de agendas o actividades oficiales del gobernador.
     * Devuelve en formato de json el resultado de la busqueda.
     * @return void
     */
    public function agendaGorelPost()
    {   
        $camposRequeridos = ['fechaDesde', 'fechaHasta', 'palabra'];
        foreach($camposRequeridos as $campo){
            extract([$campo =>htmlspecialchars($_POST[$campo])]);
        }
        try {
            $fechaDesde = date_format(date_create_from_format('d/m/Y', $fechaDesde), 'Y-m-d');
            $fechaHasta = date_format(date_create_from_format('d/m/Y', $fechaHasta), 'Y-m-d');
        } catch (Throwable $e) {
            $respuesta = array('status' => 'error');
            echo (json_encode($respuesta));
            return;
        }

        if($fechaDesde === FALSE or $fechaHasta === FALSE){
            $respuesta = array('status'=>'error', 'data'=>'');
            echo(json_encode($respuesta));
            return;
        }
        try{
            $agendaGorel = new agendaGorel();
            $resultado = $agendaGorel->buscarAgenda($fechaDesde, $fechaHasta, $palabra);
            $respuesta = array('status'=>'success', 'data'=>$resultado);
            echo (json_encode($respuesta));
        } catch(Throwable $e){
            $this->handleError($e);
        }
    }

    /**
     * Generar una vista para las convocatorias de trabajo. 
     * @return void
    */
    public function convocatorias($pagina = 1)
    {
        if (!is_numeric($pagina)) {
            $this->setCacheDir(_ROOT_CACHE);
            $this->setCacheTime(86000);
            $this->render('ErrorView', '', true);
            return;
        }
        try {
            $this->setCacheDir(_ROOT_CACHE . 'transparencia/cas/');
            $this->setCacheTime(3600);
            $convocatoria = new Convocatoria();
            list($lista, $paginadorHtml) = $convocatoria->verConvocatoria($pagina);
            $data = [
                'lista' => $lista,
                'paginador' => $paginadorHtml,
                'image' => _ROOT_ASSETS . 'images/image-convocatoria.webp',
                'link' => _ROOT_ASSETS . 'css/datepicker.css',
                'jsDatapicker' => _ROOT_ASSETS . 'js/bootstrap-datepicker.js',
                'jsMaterialkit' => _ROOT_ASSETS . 'js/material-kit.js',
                'paginator' => _ROOT_ASSETS . 'js/pagination.min.js'
            ];
            $dataFooter = [
                'año' => date('Y')
            ];
            $this->render('header', '', false);
            $this->render('transparencia/convocatoria/convocatoria', $data, false);
            $this->render('footer', $data, false);
        } catch(Throwable $e){
            $this->handleError($e);
        }
    }

    /**
     * Recibe una solicitud de busqueda para el registro convocatorias de trabajo del gobierno regional.
     * Devuelve en formato de json el resultado de la busqueda.
     * @return void
     */
    public function convocatoriasPost()
    {
        list($fechaDesde, $fechaHasta, $palabra) = $this->cleanDataPost($_POST);
        $convocatoria = new Convocatoria();
        $resultado = $convocatoria->buscarConvocatoria($fechaDesde, $fechaHasta, $palabra);
        $respuesta = array ('status'=>'success', 'data'=>$resultado);
        echo (json_encode($respuesta));
    }
    /**
     * Convierte las fechas desde y fecha (Enviadas por POST)hasta en formatos validos para poder trabajar con la base datos.
     * @param  array $post, contiene datos enviados en un solicitud POST
     * @return array 
    */

    private function cleanDataPost(array $post)
    {
        $camposRequeridos = ['fechaDesde', 'fechaHasta', 'palabra'];
        foreach($camposRequeridos as $campo){
            extract([$campo =>htmlspecialchars($post[$campo])]);
        }
        try {
            $fechaDesde = date_format(date_create_from_format('d/m/Y', $fechaDesde), 'Y-m-d');
            $fechaHasta = date_format(date_create_from_format('d/m/Y', $fechaHasta), 'Y-m-d');
        } catch (Throwable $e) {
            $respuesta = array('status' => 'error');
            echo (json_encode($respuesta));
            return;
        }

        if($fechaDesde === FALSE or $fechaHasta === FALSE){
            $respuesta = array('status'=>'error', 'data'=>'');
            echo(json_encode($respuesta));
            return;
        }
        return [$fechaDesde, $fechaHasta, $palabra];
    }

    private function handleError(Throwable $e)
    {
        $errorMessage = date('Y-m-d H:i:s') . ' : ' . $e->getMessage() . "\n";
        error_log($errorMessage, 3, _ROOT_PATH . '/log/error.log');
    }
}