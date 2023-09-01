<?php

require_once _ROOT_CONTROLLER .  'viewsRender.php';
require_once _ROOT_MODEL . 'conexion.php';
require_once _ROOT_PATH . '/vendor/autoload.php';
require_once _ROOT_MODEL . 'MainpageModel.php';

class MainpageController extends ViewRenderer { 
    private $ruta;
    private $conexion;

    public function __construct()
    {
        $this->ruta = _ROOT_ASSETS . 'images/';
    }

    public function show()
    {  
        $this->setCacheDir(_ROOT_CACHE . 'pagina_principal');
        $this->setCacheTime(1); 

        list($Banner, $Gobernador, $Directorio, $Convocatoria, $Modal) = MainpageModel::builder();
        $data = [
            'banners' => $Banner,
            'titulo' => $Gobernador[0],
            'entrada' => $Gobernador[1],
            'mensaje' => $Gobernador[2],
            'frase' => $Gobernador[3],
            'img' => $this->ruta . $Gobernador[4],
            'enlaceVideo' => $Gobernador[5],
            'pattern' => $this->ruta . 'bgPattern1.png',
            'gobernadorBackground' => $this->ruta . 'gobernadorBackground.webp',
            'año' => date('Y'),
            'ImgInfoLoreto' => $this->ruta . 'bg01.png', 
            'directorio' => $Directorio,
            'convocatorias' => $Convocatoria
        ];
        list($modal, $script) = $Modal;
        if (empty($modal)){
            $data['modal'] = '';
            $data['script'] = '';
        } else {
            $data['modal'] = $modal;
            $data['script'] = $script;
        }
        
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => ''
        ];
        $this->render('header', '', false);
        $this->render( 'main', $data, false);
        $this->render('footer', $dataFooter, false);
    }
}