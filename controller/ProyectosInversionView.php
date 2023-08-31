<?php

require_once _ROOT_CONTROLLER . 'BaseViewInterfaz.php';
require_once _ROOT_MODEL . 'proyectosInversionPublica.php';

/**
 * Pip = Proyectos de inversión pública
 */
class ProyectosInversionView extends BaseViewInterfaz
{
    public static function allView($pagina = 1)
    {   
        if(!self::isNumeric($pagina)){
            self::viewForNotNumericPage();
            return;
        }

        $pip = new ProyectoInversionPublica();
        list($tablaFila, $paginadorHtml) = $pip->pipTodos($pagina);

        $data = [
            "tablaFila" => $tablaFila,
            "paginadorHtml" => $paginadorHtml,
            "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css"
        ];

        $pathJs = self::$pathJs;
        $moreScript = <<<html
        <script src="{$pathJs}jquery.dataTables.min.js"></script>
        <script src="{$pathJs}proyectoInversion.js"></script>
        html;
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];

        $render = new ViewRenderer();
        $render->setCacheDir( self::$pathCache . 'transparencia/pip/todos');
        $render->setCacheTime(25200);
        $render->render('header', '', false);
        $render->render('transparencia/ProyectosInversion/proyectosinversion', $data, false);
        $render->render('footer', $dataFooter, false);
    }

    public static function adicionalesObraView($pagina = 1)
    {   
        if(!self::isNumeric($pagina)){
            self::viewForNotNumericPage();
            return;
        }

        $pip = new ProyectoInversionPublica();
        list($tablaFila, $paginadorHtml) = $pip->pipAdicionalesObra($pagina);

        $data = [
            "tablaFila" => $tablaFila,
            "paginadorHtml" => $paginadorHtml,
            "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css",
        ];
        $pathJs = self::$pathJs;
        $moreScript = <<<html
        <script src="{$pathJs}jquery.dataTables.min.js"></script>
        <script src="{$pathJs}proyectoInversion.js"></script>
        html;
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(_ROOT_CACHE . 'transparencia/pip/adicionalesObra/');
        $render->setCacheTime(25200);
        $render->render('header', '', false);
        $render->render('transparencia/ProyectosInversion/proyectosinversion', $data, false);
        $render->render('footer', $dataFooter, false);
    }

    public static function liquidacionObraView($pagina = 1)
    {
        if(!self::isNumeric($pagina)){
            self::viewForNotNumericPage();
            return;
        }

        $pip = new ProyectoInversionPublica();
        list($tablaFila, $paginadorHtml) = $pip->pipLiquidacionObra($pagina);

        $data = [
            "tablaFila" => $tablaFila,
            "paginadorHtml" => $paginadorHtml,
            "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css",
        ];
        $pathJs = self::$pathCache;
        $moreScript = <<<html
        <script src="{$pathJs}jquery.dataTables.min.js"></script>
        <script src="{$pathJs}proyectoInversion.js"></script>
        html;
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(_ROOT_CACHE . 'transparencia/pip/liquidacionObra/');
        $render->setCacheTime(25200);
        $render->render('header', '', false);
        $render->render('transparencia/ProyectosInversion/proyectosinversion', $data, false);
        $render->render('footer', $dataFooter, false);
    }

    public static function supervisionObraView($pagina = 1)
    {
        if(!self::isNumeric($pagina)){
            self::viewForNotNumericPage();
            return;
        }

        $pip = new ProyectoInversionPublica();
        list($tablaFila, $paginadorHtml) = $pip->pipSupervisionObra($pagina);

        $data = [
            "tablaFila" => $tablaFila,
            "paginadorHtml" => $paginadorHtml,
            "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css",
        ];
        $pathJs = self::$pathCache;
        $moreScript = <<<html
        <script src="{$pathJs}jquery.dataTables.min.js"></script>
        <script src="{$pathJs}proyectoInversion.js"></script>
        html;
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(_ROOT_CACHE . 'transparencia/pip/supervisionObraView/');
        $render->setCacheTime(25200);
        $render->render('header', '', false);
        $render->render('transparencia/ProyectosInversion/proyectosinversion', $data, false);
        $render->render('footer', $dataFooter, false);
    }

    public static function historicoObraView($pagina = 1)
    {
        if(!self::isNumeric($pagina)){
            self::viewForNotNumericPage();
            return;
        }

        $pip = new ProyectoInversionPublica();
        list($tablaFila, $paginadorHtml) = $pip->pipHistorico($pagina);

        $data = [
            "tablaFila" => $tablaFila,
            "paginadorHtml" => $paginadorHtml,
            "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css",
        ];

        $pathJs = self::$pathCache;
        $moreScript = <<<html
        <script src="{$pathJs}jquery.dataTables.min.js"></script>
        <script src="{$pathJs}proyectoInversion.js"></script>
        html;
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(_ROOT_CACHE . 'transparencia/pip/historicoObra/');
        $render->setCacheTime(1);
        $render->render('header', '', false);
        $render->render('transparencia/ProyectosInversion/proyectosinversion', $data, false);
        $render->render('footer', $dataFooter, false);
    }

    public static function informacionAdicionalView($pagina = 1)
    {
        if(!self::isNumeric($pagina)){
            self::viewForNotNumericPage();
            return;
        }

        $pip = new ProyectoInversionPublica();
        list($tablaFila, $paginadorHtml) = $pip->pipInformacionAdicional($pagina);

        $data = [
            "tablaFila" => $tablaFila,
            "paginadorHtml" => $paginadorHtml,
            "dataTableCss" => _ROOT_ASSETS . "css/jquery.dataTables.min.css"
        ];

        $pathJs = self::$pathCache;
        $moreScript = <<<html
        <script src="{$pathJs}jquery.dataTables.min.js"></script>
        <script src="{$pathJs}proyectoInversion.js"></script>
        html;
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(_ROOT_CACHE . 'transparencia/pip/informacionAdcional/');
        $render->setCacheTime(1);
        $render->render('header', '', false);
        $render->render('transparencia/ProyectosInversion/proyectosinversion', $data, false);
        $render->render('footer', $dataFooter, false);
    }

    public static function searchObra($tipo, $año, $palabra)
    {
        try {
            $tipo = htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8');
            $palabra = htmlspecialchars($palabra, ENT_QUOTES, 'UTF-8');
            $año = filter_var($año, FILTER_VALIDATE_INT);
            if(!$año){
                throw new Exception('$año no es una fecha.');
            }
            $pip = new ProyectoInversionPublica();
            $resultado = $pip->BuscarObra($tipo, $año, $palabra);
            echo $resultado;
        } catch (Throwable $e) {
            $respuesta = ['error' => 'Ha ocurrido un error inesperado.'];
            echo(json_encode($respuesta));
            Helper::handlerError($e);
        }
    }
}