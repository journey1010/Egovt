<?php

use PhpOffice\PhpSpreadsheet\Style\NumberFormat\DateFormatter;

require_once(_ROOT_CONTROLLER . 'viewsRender.php');
require_once(_ROOT_MODEL . 'visitas.php');
require_once(_ROOT_MODEL . 'proyectosInversionPublica.php');
require_once(_ROOT_MODEL . 'agendaGorel.php');

class transparenciaController extends ViewRenderer
{
    private $ruta;

    public function __construct()
    {
        $this->ruta = _ROOT_ASSETS . 'images/';
    }

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
    //pip = proyectos de inversion publica
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

    private function handleError(Throwable $e)
    {
        $errorMessage = date('Y-m-d H:i:s') . ' : ' . $e->getMessage() . "\n";
        error_log($errorMessage, 3, _ROOT_PATH . '/log/error.log');
    }
}