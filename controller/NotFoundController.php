<?php

require_once _ROOT_CONTROLLER . 'AbstractController.php';

class NotFoundController extends AbstractController{

    public function show()
    {
        $this->renderView('header');
        $this->renderView('ErrorView');
        $this->renderView('footer');
         
    }
    protected function SanitizeVar( string $var){
        
    }

}