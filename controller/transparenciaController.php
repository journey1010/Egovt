<?php 
require_once (_ROOT_CONTROLLER . 'viewsRender.php');

class transparenciaController extends ViewRenderer{

    public function visitasMain()
    {
        $this->setCacheDir(_ROOT_CACHE . 'transparencia/visitas/');
        //$this->setCacheTime(86400);
        $this->setCacheTime(10);
        $data = [
            "imagenFondo" => _ROOT_ASSETS . 'images/bannerVistas.jpg', 
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

    }

    public function visitasOld()
    {

    }
}