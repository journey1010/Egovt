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
        <script src="{$pathJs}jquery.dataTables.min.js"></script>
        <script src="{$pathJs}visitas.js?v=1.1"></script>
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
        $pathJs = self::$pathJs;
        $moreScript = <<<html
        <script src="{$pathJs}jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                var table = $('#tabla').DataTable({
                    stateSave: true,
                    paging: true,
                    searching: false,
                    ordering: false,
                    info: false,
                    pagingType: "simple_numbers",
                    language: {
                        lengthMenu: "Mostrar _MENU_ registros por página",
                        zeroRecords: "No se encontraron resultados",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        infoEmpty: "Mostrando 0 a 0 de 0 registros",
                        paginate: {
                            first: 'Primera',
                            last: 'Última',
                            next: 'Siguiente',
                            previous: 'Anterior'
                        }
                    }
                });
            });
        </script>
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

    public static function searchVisitsView()
    {
        $fecha = $_POST['fecha'];
        if(!self::validateDate($fecha)){
            $respuesta = ['error' => 'Sin registros! Vuelva a intentar con otra fecha.'];
            echo (json_encode($respuesta));
            return;
        }
        try {
            $visitas = new visitas();
            $resultado = $visitas->visitasNuevasPost($fecha);
            echo $resultado;
        } catch (Throwable $e) {
            $respuesta = ['error' => 'Sin registros! Vuelva a intentar con otra fecha.'];
            echo(json_encode($respuesta));
            Helper::handlerError($e, 'VisitasView::searchVisits');
        }
    }
}
