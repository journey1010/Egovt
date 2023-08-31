<?php

require _ROOT_CONTROLLER . 'Agenda/Agenda.php';
require _ROOT_CONTROLLER . 'Convocatoria/ConvocatoriaView.php';
require _ROOT_CONTROLLER . 'ProyectosInversion/ProyectosInversionPublicaView.php';
require _ROOT_CONTROLLER . 'Visitas/VisitasView.php';

spl_autoload_register(function ($nombreClase){
    $pathClass = _ROOT_CONTROLLER . $nombreClase . 'View.php';
    require_once $pathClass;
});

class transparenciaController
{
    public function visitasMain()
    {
        VisitasView::mainView();   
    }

    public function visitasNew($pagina = 1)
    {
        VisitasView::newVisitsView($pagina);
    }

    public function visitasNewPost()
    {
        VisitasView::searchVisitsView($_POST['fecha']);
    }

    public function visitasOld()
    {
        VisitasView::oldVisitsView();
    }
    
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
                "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css"
            ];
            $moreScript = <<<html
            <script src="{$this->rutaJs}jquery.dataTables.min.js"></script>
            <script src="{$this->rutaJs}proyectoInversion.js"></script>
            html;
            $dataFooter = [
                'año' => date('Y'),
                'scripts' => $moreScript
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
            ];
            $moreScript = <<<html
            <script src="{$this->rutaJs}jquery.dataTables.min.js"></script>
            <script src="{$this->rutaJs}proyectoInversion.js"></script>
            html;
            $dataFooter = [
                'año' => date('Y'),
                'scripts' => $moreScript
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
            ];
            $moreScript = <<<html
            <script src="{$this->rutaJs}jquery.dataTables.min.js"></script>
            <script src="{$this->rutaJs}proyectoInversion.js"></script>
            html;
            $dataFooter = [
                'año' => date('Y'),
                'scripts' => $moreScript
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
            ];
            $moreScript = <<<html
            <script src="{$this->rutaJs}jquery.dataTables.min.js"></script>
            <script src="{$this->rutaJs}proyectoInversion.js"></script>
            html;
            $dataFooter = [
                'año' => date('Y'),
                'scripts' => $moreScript
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
            ];

            $moreScript = <<<html
            <script src="{$this->rutaJs}jquery.dataTables.min.js"></script>
            <script src="{$this->rutaJs}proyectoInversion.js"></script>
            html;
            $dataFooter = [
                'año' => date('Y'),
                'scripts' => $moreScript
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
                "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css"
            ];
            $moreScript = <<<html
            <script src="{$this->rutaJs}jquery.dataTables.min.js"></script>
            <script src="{$this->rutaJs}proyectoInversion.js"></script>
            html;
            $dataFooter = [
                'año' => date('Y'),
                'scripts' => $moreScript
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
                "link" => _ROOT_ASSETS . 'css/datepicker.css'                
            ];
            $moreScript = <<<html
            <script src="{$this->rutaJs}bootstrap-datepicker.js"></script>
            <script src="{$this->rutaJs}material-kit.js"></script>
            <script src="{$this->rutaJs}pagination.min.js"></script>
            <script src="{$this->rutaJs}agenda.js"></script>
            html;
            $dataFooter = [
                'año' => date('Y'),
                'scripts' => $moreScript
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
        $fechaDesde = htmlspecialchars($_POST['fechaDesde'], ENT_QUOTES, 'UTF-8');
        $fechaHasta = htmlspecialchars($_POST['fechaHasta'], ENT_QUOTES, 'UTF-8');
        $palabra = htmlspecialchars($_POST['palabra'], ENT_QUOTES, 'UTF-8');

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
            ];

            $moreScript = <<<html
            <script src="{$this->rutaJs}bootstrap-datepicker.js"></script>
            <script src="{$this->rutaJs}material-kit.js"></script>
            <script src="{$this->rutaJs}pagination.min.js"></script>
            <script src="{$this->rutaJs}convocatoria.js"></script>
            html;
            $dataFooter = [
                'año' => date('Y'),
                'script' => $moreScript
            ];
            $this->render('header', '', false);
            $this->render('transparencia/convocatoria/convocatoria', $data, false);
            $this->render('footer', $dataFooter, false);
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
        if(empty($fechaDesde) || empty($fechaHasta)){
            $respuesta = array('status'=>'error', 'data'=>'');
            echo(json_encode($respuesta));
            return false;
        }
        $convocatoria = new Convocatoria();
        $resultado = $convocatoria->buscarConvocatoria($fechaDesde, $fechaHasta, $palabra);
        $respuesta = array ('status'=>'success', 'data'=>$resultado);
        echo (json_encode($respuesta));
    }
}