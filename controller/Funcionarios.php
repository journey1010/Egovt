<?php

require_once _ROOT_CONTROLLER . 'BaseViewInterfaz.php';
require_once _ROOT_MODEL . 'visitas.php'; 
require_once _ROOT_MODEL . 'OficinasModel.php';

class Funcionarios extends  BaseViewInterfaz
{
    public static function showFuncionarios()
    {
        $data = [
            'oficinas' => OficinasModel::listOficinas()
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(self::$pathCache . 'pagina_principal/funcionarios/');
        $render->setCacheTime(2678400);
        $render->render('gobierno/funcionarios', $data, false);
    }
}
