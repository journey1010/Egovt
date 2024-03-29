<?php

require_once _ROOT_CONTROLLER .  'BaseViewInterfaz.php';
require_once _ROOT_MODEL . 'agendaGorel.php';

class AgendaView extends BaseViewInterfaz 
{
    public static function agendaView($pagina = 1)
    {
        if(!self::isNumeric($pagina)){
            self::viewForNotNumericPage();
            return;
        }
        $agendaGorel = new agendaGorel();
        list($tablaFila, $paginadorHtml) = $agendaGorel->verAgenda($pagina);

        $data = [
            "tablaFila" => $tablaFila,
            "paginadorHtml" => $paginadorHtml,
            "link" => _ROOT_ASSETS . 'css/datepicker.css'                
        ];

        $pathJs = self::$pathJs;
        $moreScript = <<<html
        <script src="{$pathJs}bootstrap-datepicker.js"></script>
        <script src="{$pathJs}pagination.min.js"></script>
        <script src="{$pathJs}agenda.js"></script>
        html;
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(_ROOT_CACHE . 'transparencia/agenda/');
        $render->setCacheTime(17000);
        $render->render('header', '', false);
        $render->render('transparencia/agendaGorel/agendaGorel', $data, false);
        $render->render('footer', $dataFooter, false);      
    }

    public static function searchAgendaView()
    {   
        $desde = $_POST['fechaDesde'];
        $hasta = $_POST['fechaHasta'];
        if(!self::validateDate($desde) || !self::validateDate($hasta)){
            $respuesta = ['status' => 'error', 'data'=>''];
            echo (json_encode($respuesta));
            return;
        }
        $palabra = htmlspecialchars($_POST['palabra'], ENT_QUOTES, 'UTF-8');

        try{
            $agendaGorel = new agendaGorel();
            $resultado = $agendaGorel->buscarAgenda($desde, $hasta, $palabra);
            $respuesta = ['status'=>'success', 'data'=>$resultado];
            echo (json_encode($respuesta));
        } catch(Throwable $e){
            Helper::handlerError($e);
            echo (json_encode(['status'=>'error', 'data'=>'']));
        }
    }
}