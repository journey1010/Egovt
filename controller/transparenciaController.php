<?php 
require_once _ROOT_CONTROLLER . 'AbstractController.php'; 

class transparenciaController extends AbstractController{

    public function visitas()
    {
        $this->renderView('header');
        $this->renderView('transparencia/visitasgorel/visitasgorel');
        $this->renderView('footer');
    }

    protected function SanitizeVar(string $var)
    {
        
    }
}
