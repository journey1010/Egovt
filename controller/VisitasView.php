<?php

require_once _ROOT_CONTROLLER . 'BaseViewInterfaz.php';
require_once _ROOT_MODEL . 'visitas.php'; 

class VisitasView extends BaseViewInterfaz
{
    public static function mainView()
    {
        $data = [
            'imageNew' => self::$pathImg . 'nuevasVisitas.jpg',
            'imageOld' => self::$pathImg . 'oldVisitas.jpg'
        ];
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => ''
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(self::$pathCache . 'transparencia/view/main/');
        $render->setCacheTime(2678400);
        $render->render('header', '', false);
        $render->render('transparencia/visitasgorel/main', $data, true);
        $render->render('footer', $dataFooter, false);
    }
     
    public static function newVisitsView($pagina = 1)
    {
        if(!self::isNumeric($pagina)){
            self::viewForNotNumericPage();
            return;
        }

        $visitas = new visitas();
        list($tablaFila, $paginadorHtml) = $visitas->visitasNuevas($pagina);

        $data = [
            "tablaFila" => $tablaFila,
            "paginadorHtml" => $paginadorHtml,
            "link" =>  self::$pathCss . 'datepicker.css',
            "dataTableCss" =>  self::$pathCss . "jquery.dataTables.min.css",
        ];

        $pathJs = self::$pathJs;
        $moreScript = <<<html
        <script src="{$pathJs}bootstrap-datepicker.js"></script>
        <script src="{$pathJs}material-kit.js"></script>
        <script src="{$pathJs}jquery.dataTables.min.js"></script>
        <script src="{$pathJs}visitas.js"></script>
        html;

        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(self::$pathCache . 'transparencia/view/new/');
        $render->setCacheTime(86000);
        $render->render('header', '', false);
        $render->render('transparencia/visitasgorel/newVisitas', $data, false);
        $render->render('footer', $dataFooter, false);
    }

    public static function oldVisitsView()
    {
        $visitas = new visitas();
        $data = [
            "tablaFila" => $visitas->visitasOld(),
            "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css",
        ];
        $path = self::$pathJs;
        $moreScript = <<<html
        <script src="{$path}jquery.dataTables.min.js"></script>
        html;
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];
        $render = new ViewRenderer();
        $render->setCacheDir(_ROOT_CACHE . 'transparencia/visitas/old/');
        $render->setCacheTime(83600);
        $render->render('header', '', false);
        $render->render('transparencia/visitasgorel/oldVisitas', $data, true);
        $render->render('footer', $dataFooter, false);
    }

    public static function searchVisitsView($fecha)
    {
        if(!self::validateDate($fecha, 'Y-m-d')){
            $respuesta = ['error' => 'Ha ocurrido un error inesperado en la solicitud.'];
            echo (json_encode($respuesta));
            return;
        }
        try {
            $visitas = new visitas();
            $resultado = $visitas->visitasNuevasPost($fecha);
            echo $resultado;
        } catch (Throwable $e) {
            $respuesta = ['error' => 'Ha ocurrido un error inesperado.'];
            echo(json_encode($respuesta));
            Helper::handlerError($e, 'VisitasView::searchVisits');
        }
    }
}
