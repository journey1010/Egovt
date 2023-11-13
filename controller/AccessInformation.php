<?php 

require_once _ROOT_CONTROLLER . 'BaseViewInterfaz.php';

class AccessInformation extends BaseViewInterfaz
{
    public function showView()
    {
        $pathJs = self::$pathJs;
        $moreScript = <<<html
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{$pathJs}access_information.js"></script>
        html;
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(self::$pathCache . 'transparencia/acceso_a_la_informacion/main/');
        $render->setCacheTime(2678400);
        $render->render('header', '', false);
        $render->render('transparencia/acceso_a_la_informacion/acceso_a_la_informacion', '', false);
        $render->render('footer', $dataFooter, false);
    }
}