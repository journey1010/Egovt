<?php

require_once (_ROOT_CONTROLLER .  'viewsRender.php');

spl_autoload_register(function($nombreClase) {
    $rutaArchivo = _ROOT_MODEL . $nombreClase . '.php';
    if(file_exists($rutaArchivo)) {
        require_once $rutaArchivo;
    }
});

class MainpageController extends ViewRenderer {

    public function show()
    {  
        $this->setCacheDir(_ROOT_CACHE . 'pagina_principal');
        $this->setCacheTime(1); // cambiar  a 86400 (un día en segundos)
    
        $this->render('header', '', false);
        $this->render( 'main', '', false);
        $this->render('footer', '', false);
    }  
} 