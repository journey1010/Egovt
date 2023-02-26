<?php
require_once _ROOT_CONTROLLER . 'AbstractController.php';
class MainpageController extends AbstractController {

    
    public function show()
    {  
        $this->renderView('header');
        $this->renderView('main');
        $this->renderView('footer');
        
    }

    protected function SanitizeVar( string $var){
        
    }

    
}
  