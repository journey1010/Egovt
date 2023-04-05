<?php 
require_once (_ROOT_CONTROLLER . 'viewsRender.php');

class transparenciaController extends ViewRenderer{

    public function visitasMain()
    {
        $this->setCacheDir(_ROOT_CACHE . 'transparencia/visitas/');
        $this->setCacheTime(2678400);
        $data = [
            'imageNew' => _ROOT_ASSETS . 'images/nuevasVisitas.jpg', 
            'imageOld' => _ROOT_ASSETS . 'images/oldVisitas.jpg'
        ];
        $this->render('header', '', false);
        $this->render('transparencia/visitasgorel/main',$data , true);
        $this->render('footer', '', false);
    }

    public function visitasNew()
    {
        $this->setCacheDir(_ROOT_CACHE . 'transparencia/visitas/');
        $this->setCacheTime(1);
        
        $data = [
            "link" => _ROOT_ASSETS . 'css/datepicker.css', 
            "jsDatapicker" => _ROOT_ASSETS . 'js/bootstrap-datepicker.js',
            "jsMaterialkit" => _ROOT_ASSETS . 'js/material-kit.js'
        ];
        $this->render('header', '', false);
        $this->render('transparencia/visitasgorel/newVisitas', $data, true);
        $this->render('footer', '', false);
    }

    public function visitasOld()
    {

    }

}