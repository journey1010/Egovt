<?php
require_once _ROOT_CONTROLLER . 'AbstractController.php';

class AdminMainpage extends AbstractController {

    
    public function show()
    
    {  
        session_start();
        echo "adadad";
        if(isset($_SESSION['username']) && isset($_SESSION['tipoUser']) ){
            echo "hola";
            $this->renderView(_ROOT_VIEWS_ADMIN . 'header');
            //agregar demas comandos
            $this->renderView(_ROOT_VIEWS_ADMIN . 'footer');
        }else{
            header('Location: /administrador');
            exit;
        }

        
    }




    protected function SanitizeVar( string $var){
        
    }
    
}
  