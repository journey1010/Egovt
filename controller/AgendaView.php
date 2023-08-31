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

        $pathJs = self::$pathCache;
        $moreScript = <<<html
        <script src="{$pathJs}bootstrap-datepicker.js"></script>
        <script src="{$pathJs}material-kit.js"></script>
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

    public static function searchAgendaView($desde, $hasta, $palabra)
    {
        if(!self::validateDate($desde, 'Y-m-d') || !self::validateDate($hasta, 'Y-m-d')){
            $respuesta = ['status' => 'error', 'data'=>''];
            echo (json_encode($respuesta));
            return;
        }

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