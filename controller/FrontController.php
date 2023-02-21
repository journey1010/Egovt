<?php

abstract class FrontController {
    
    protected $secure;
  
    abstract function template ();

    protected function errorLog(Exception $e){
        $errorMessage = date('Y-m-d H:i:s') . ':' . $e->getMessage() . '\n';
        error_log($errorMessage, 3, _ROOT_PATH . '/log/error.log'  );
    }

    protected function renderView($viewName){

        $viewname = $this->SanitizeVar($viewName);

        try {

            $fullpath = _ROOT_VIEWS .  $viewname . '.php';
            
            if(!file_exists($fullpath)){
                include_once _ROOT_CONTROLLER . 'NotFoundController.php';
                throw new Exception ('View not found' . $viewName);
            }
            if(pathinfo($fullpath, PATHINFO_EXTENSION)!== 'php'){
                throw new Exception ('invalid file type' . $viewName);
            }
            ob_start();
            include_once $fullpath;
            echo ob_get_clean();

        }catch (Exception $e){
            $this->errorLog($e);
        }

    }

    protected function SanitizeVar ($var) {
        $var = trim($var);
        $var = filter_var($var, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $var = preg_replace('/[^a-zA-Z0-9]/', '', $var);
        return $var;
    }

    protected function checkCache(){

    }
    public function cacheView(){
        
    }

}