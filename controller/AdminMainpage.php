<?php
require_once _ROOT_CONTROLLER . 'AbstractController.php';

class AdminMainpage extends AbstractController {

    
    public function show()
    {  
        session_start();
        if(isset($_SESSION['username']) && isset($_SESSION['tipoUser']) ){
            $this->renderView(_ROOT_VIEWS . 'header');
            //agregar demas comandos
            $this->renderView(_ROOT_VIEWS . 'footer');
        }else{
            header('Location: /administrador');
            exit;
        }
        
    }

    protected function SanitizeVar( string $var){
        
    }

    
}
  