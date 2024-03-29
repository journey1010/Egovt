<?php

require_once _ROOT_MODEL . 'ParticipacionModel.php';
require_once _ROOT_CONTROLLER . 'BaseViewInterfaz.php';

class ParticipacionController extends BaseViewInterfaz
{   
    public function showParticipacion($pagina = 1, $tipo = 'documentos')
    {
        if(!self::isNumeric($pagina)){
            self::viewForNotNumericPage();
            return;
        }
        list($resultados, $paginadorHtml) = ParticipacionModel::getPaticipacion($pagina, $tipo);

        $data = [
            'link' => self::$pathCss . 'datepicker.css',
            'dataTable' => $resultados,
            'Paginador' => $paginadorHtml,
            'tipo' => $tipo
        ];

        $pathJs = self::$pathJs;
        $moreScript = <<<html
            <script src="{$pathJs}pagination.min.js"></script>
            <script src="{$pathJs}bootstrap-datepicker.js"></script>
            <script src="{$pathJs}participacion.js"></script>
        html;
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(self::$pathCache . 'transparencia/participacion/main/');
        $render->setCacheTime(86400);
        $render->render('header', '', false);
        $render->render('transparencia/Participacion/ParticipacionMainView', $data, false);
        $render->render('footer', $dataFooter, false);
    }

    public function buscarParticipacion()
    {
        if(!self::validateDate($_POST['startDate']) && !self::validateDate( $_POST['endDate'])){
            echo (json_encode(['status'=>'error', 'message' => 'Sin registros! Vuelva a intentar con otra fecha.']));
            return;
        }
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $tipoDoc = htmlspecialchars($_POST['typeDoc'], ENT_QUOTES, 'utf-8');

        try {
            $resultado = ParticipacionModel::buscarParticipacion($startDate, $endDate, $tipoDoc);
            echo (json_encode(['status'=>'success', 'data'=>$resultado]));
        } catch (Throwable $e) {
            echo(json_encode(['status'=>'error', 'message' => 'Sin registros! Vuelva a intentar con otra fecha.']));
            Helper::handlerError($e, 'PresupuestoController::buscarSaldoBalance');
        }
    }
}