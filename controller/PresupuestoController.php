<?php
require_once _ROOT_MODEL . 'PresupuestoModel.php';
require_once _ROOT_CONTROLLER . 'BaseViewInterfaz.php';

class PresupuestoController extends BaseViewInterfaz
{

    public function showSaldo($pagina = 1)
    {
        if(!self::isNumeric($pagina)){
            self::viewForNotNumericPage();
            return;
        }
        list($resultados, $paginadorHtml) = PresupuestoModel::getSaldoBalance($pagina);

        $data = [
            'link' => self::$pathCss . 'datepicker.css',
            'dataTable' => $resultados,
            'Paginidaor' => $paginadorHtml
        ];
        $pathJs = self::$pathJs;
        $moreScript = <<<html
            <script src="{$pathJs}pagination.min.js"></script>
            <script src="{$pathJs}bootstrap-datepicker.js"></script>
            <script src="{$pathJs}SaldoBalance.js"></script>
        html;
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(self::$pathCache . 'transparencia/view/main/');
        $render->setCacheTime(86400);
        $render->render('header', '', false);
        $render->render('transparencia/Presupuesto/SaldoBalanceView', $data, false);
        $render->render('footer', $dataFooter, false);
    }

    public function buscarSaldoBalance()
    {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        if(!self::validateDate($startDate) && !self::validateDate($endDate)){
            echo (json_encode(['error' => 'Sin registros! Vuelva a intentar con otra fecha.']));
            return;
        }
        try {
            $resultado = PresupuestoModel::buscarSaldoBalance($startDate, $endDate);
            echo (json_encode(['status'=>'success', 'data'=>$resultado]));
        } catch (Throwable $e) {
            echo(json_encode(['status'=>'error', 'message' => 'Sin registros! Vuelva a intentar con otra fecha.']));
            Helper::handlerError($e, 'PresupuestoController::buscarSaldoBalance');
        }
    }
}