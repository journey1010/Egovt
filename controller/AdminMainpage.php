<?php

class AdminMainpage{

    public function show( $contenidoPage =  '')
    {  
        session_start();
        if(isset($_SESSION['username']) && isset($_SESSION['tipoUser']) ){
            $this->renderView('admin/plantillaAdmin', $_SESSION['username'], $_SESSION['tipoUser'], $contenidoPage);
        }else{
            header('Location: /administrador');
            exit;
        }
    }

    public function showContentPage($contenidoPage)
    {
        session_start();
        if(isset($_SESSION['username']) && isset($_SESSION['tipoUser']) ){
            $this->renderView('admin/plantillaAdmin', $_SESSION['username'], $_SESSION['tipoUser'], $contenidoPage);
        }else{
            header('Location: /administrador');
            exit;
        }
    }

    private function renderView(string $viewName, $userName, $tipoUser, $contenidoPage)
    {
        $viewName = ($viewName == 'ErrorView') ? 'ErrorView' : $viewName;

        $fullpath = _ROOT_VIEWS .  $viewName . '.php';

        try {

            if(!file_exists($fullpath)){
                throw new Exception ('Vista no encontrada' . $viewName);
            }
            if(pathinfo($fullpath, PATHINFO_EXTENSION)!== 'php'){
                throw new Exception ('Archivo de tipo no permitido' . $viewName);
            }
            ob_start();
            include_once $fullpath;
            echo ob_get_clean();
            return;

        }catch (Exception $e){
            $this->errorLog($e);
            return;
        }
    }

    protected function errorLog(Throwable $e){
        $errorMessage = date("Y-m-d H:i:s") . " : " . $e->getMessage() .  "\n";
        error_log($errorMessage, 3, _ROOT_PATH . '/log/error.log'  );
    }
}