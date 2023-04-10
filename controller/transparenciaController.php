<?php 
require_once (_ROOT_CONTROLLER . 'viewsRender.php');
require_once(_ROOT_MODEL . 'visitas.php');

class transparenciaController extends ViewRenderer{

    public function visitasMain()
    {
        $this->setCacheDir(_ROOT_CACHE . 'transparencia/visitas/');
        $this->setCacheTime(2678400);
        $data = [
            'imageNew' => _ROOT_ASSETS . 'images/nuevasVisitas.jpg', 
            'imageOld' => _ROOT_ASSETS . 'images/oldVisitas.jpg'
        ];
        $this->render('header', '', false);
        $this->render('transparencia/visitasgorel/main',$data , true);
        $this->render('footer', '', false);
    }

    public function visitasNew( $pagina = 1)
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

            $visitas = new visitas ();
            list($tablaFila, $paginadorHtml) = $visitas->visitasNuevas($pagina);
            
            $data = [
                "tablaFila" => $tablaFila,
                "paginadorHtml" => $paginadorHtml,
                "link" => _ROOT_ASSETS . 'css/datepicker.css', 
                "jsDatapicker" => _ROOT_ASSETS . 'js/bootstrap-datepicker.js',
                "jsMaterialkit" => _ROOT_ASSETS . 'js/material-kit.js',
                "jsVisitas" => _ROOT_ASSETS . 'jsVisitas.js'
            ];
            $this->render('header', '', false);
            $this->render('transparencia/visitasgorel/newVisitas', $data, false);
            $this->render('footer', '', false);
        } catch (Throwable $e) {
            $this->handleError($e);
        }
    }

    public function visitasNewPost(){
        if(empty($_POST['fecha']) && strtotime($_POST['fecha'])) {
            $respuesta = array ("error" => "Ha ocurrido un error inesperado en la solicitud.");
            print_r(json_encode($respuesta));
            return;
        }
        $fecha = $_POST['fecha'];
        $nueva_fecha = date_format(date_create_from_format('d/m/Y', $fecha), 'Y-m-d');
        try {
            $visitas = new visitas ();
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
            "tablaFila" => $resultado
        ];
        $this->render('header', '', false);
        $this->render('transparencia/visitasgorel/oldVisitas', $data, false);
        $this->render('footer', '', false);
    }

    private function handleError(Throwable $e){
        $errorMessage = date('Y-m-d H:i:s') . ' : ' . $e->getMessage() . "\n";
        error_log($errorMessage, 3, _ROOT_PATH . '/log/error.log');
    }
}