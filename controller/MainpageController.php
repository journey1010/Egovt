<?php
require_once _ROOT_CONTROLLER . 'AbstractController.php';
class MainpageController extends AbstractController {

    
    public function show()
    {  
<<<<<<< Updated upstream:controller/MainpageController.php
        $this->renderView('header');
        $this->renderView('main');
        $this->renderView('footer');
=======
        session_start();
        if(isset($_SESSION['username']) && isset($_SESSION['tipoUser']) ){
            $this->renderView(_ROOT_VIEWS . 'header');
            //agregar demas comandos
            $this->renderView(_ROOT_VIEWS . 'footer');
        }else{
            header('Location: /administrador');
            exit;
        }
>>>>>>> Stashed changes:controller/AdminMainpage.php
        
    }

    protected function SanitizeVar( string $var){
        
    }

    
}
  