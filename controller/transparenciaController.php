<?php 
require_once _ROOT_CONTROLLER . 'AbstractController.php'; 

class transparenciaController extends AbstractController{

    public function visitas()
    {
        $this->renderView('transparencia/visitasgorel/visitasgorel');
    }

    protected function SanitizeVar(string $var)
    {
        
    }
}
