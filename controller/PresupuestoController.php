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
            'dataTable' => $resultados,
            'Paginidaor' => $paginadorHtml,
        ];

        $dataFooter = [
            'año' => date('Y'),
            'scripts' => ''
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(self::$pathCache . 'transparencia/view/main/');
        $render->setCacheTime(86400);
        $render->render('header', '', false);
        $render->render('transparencia/Presupuesto/SaldoBalanceView', $data, false);
        $render->render('footer', $dataFooter, false);
    }
}