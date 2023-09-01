<?php

require_once _ROOT_CONTROLLER . 'BaseViewInterfaz.php';
require_once _ROOT_MODEL . 'Convocatoria.php';

class ConvocatoriaView extends BaseViewInterfaz 
{
    public static function convocatoriaView($pagina = 1)
    {
        if(!self::isNumeric($pagina)){
            self::viewForNotNumericPage();
            return;
        }

        $convocatoria = new Convocatoria();
        list($lista, $paginadorHtml) = $convocatoria->verConvocatoria($pagina);
        $data = [
            'lista' => $lista,
            'paginador' => $paginadorHtml,
            'image' => _ROOT_ASSETS . 'images/image-convocatoria.webp',
            'link' => _ROOT_ASSETS . 'css/datepicker.css',
        ];

        $pathJs = self::$pathJs;
        $moreScript = <<<html
        <script src="{$pathJs}bootstrap-datepicker.js"></script>
        <script src="{$pathJs}pagination.min.js"></script>
        <script src="{$pathJs}convocatoria.js"></script>
        html;
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];
        
        $render = new ViewRenderer();
        $render->setCacheDir(_ROOT_CACHE . 'transparencia/convocatoria/');
        $render->setCacheTime(25200);
        $render->render('header', '', false);
        $render->render('transparencia/convocatoria/convocatoria', $data, false);
        $render->render('footer', $dataFooter, false);
    }

    public static function searchConvocatoriaView()
    {   
        $desde = $_POST['fechaDesde'];
        $hasta = $_POST['fechaHasta'];
        if(!self::validateDate($desde) || !self::validateDate($hasta)){
            echo(json_encode(['status'=>'error', 'data'=>'']));
            return false;
        }
        $palabra = htmlspecialchars($_POST['palabra'], ENT_QUOTES, 'UTF-8');

        try {
            $convocatoria = new Convocatoria();
            $resultado = $convocatoria->buscarConvocatoria($desde, $hasta, $palabra);
            echo (json_encode(['status'=>'success', 'data'=>$resultado]));
        }   catch(Throwable $e){
            Helper::handlerError($e, 'ConvocatoriaView::searchConvocatoriaView');
            echo(json_encode(['status'=>'error', 'data'=>'']));
        }
    }
}