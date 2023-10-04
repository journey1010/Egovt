<?php

require_once _ROOT_MODEL . 'PublicacionesModel.php';
require_once _ROOT_CONTROLLER . 'BaseViewInterfaz.php';

class PublicacionesController extends BaseViewInterfaz
{
    public function showPublicaciones($pagina = 1)
    {
        if(!self::isNumeric($pagina)){
            self::viewForNotNumericPage();
            return;
        }
        list($resultados, $paginadorHtml) = PublicacionesModel::getPublicaciones($pagina);

        $data = [
            'link' => self::$pathCss . 'datepicker.css',
            'dataTable' => $resultados,
            'Paginador' => $paginadorHtml
        ];
        $pathJs = self::$pathJs;
        $moreScript = <<<html
            <script src="{$pathJs}pagination.min.js"></script>
            <script src="{$pathJs}bootstrap-datepicker.js"></script>
            <script src="{$pathJs}publicaciones.js"></script>
        html;
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(self::$pathCache . 'publicaciones/main/');
        $render->setCacheTime(86400);
        $render->render('header', '', false);
        $render->render('publicaciones/publicacionesView', $data, false);
        $render->render('footer', $dataFooter, false);
    }

    public function buscarSaldoBalance()
    {
        if(empty($_POST['startDate']) || !is_numeric($_POST['startDate'])){
            echo (json_encode(['status'=>'error', 'message'=> 'Sin registros! Vuelva a intentar con otra fecha.']));
            return;
        }
        $startDate = $_POST['startDate'];

        try {
            $resultado = PresupuestoModel::buscarSaldoBalance($startDate);
            echo (json_encode(['status'=>'success', 'data'=>$resultado]));
        } catch (Throwable $e) {
            echo(json_encode(['status'=>'error', 'message' => 'Sin registros! Vuelva a intentar con otra fecha.']));
            Helper::handlerError($e, 'PresupuestoController::buscarSaldoBalance');
        }
    }
}