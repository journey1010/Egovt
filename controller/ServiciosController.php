<?php
require_once (_ROOT_CONTROLLER .  'viewsRender.php');

class ServiciosController extends ViewRenderer
{
    private $ruta;
    
    public function __construct()
    {   
        $this->ruta = _ROOT_ASSETS . 'images/';
    }

    public function ServiciosMain()
    {
        $this->setCacheDir(_ROOT_CACHE . 'servicios');
        $this->setCacheTime(90); 
        $data = [
            'ObservatorioViolencia' => $this->ruta .  'aplicaciones/observatorio.webp',
            'visorLoreto' => $this->ruta .  'aplicaciones/visorloreto.webp',
            'procompite' => $this->ruta . 'aplicaciones/procompite.webp',
            'seguridad' => $this->ruta . 'aplicaciones/seguridad.webp',
            'estadisticaIdr' => $this->ruta . 'aplicaciones/estadisticaidr.webp'
        ];

        $dataFooter = [
            'año' => date('Y'),
            'scripts' => ''
        ];

        $this->render('header', '', false);
        $this->render( 'servicios/MainAplicaciones', $data, true);
        $this->render('footer', $dataFooter, false);
    }
}