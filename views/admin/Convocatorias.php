<?php 

require_once ( _ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once ( _ROOT_MODEL . 'conexion.php');

class convocatorias extends handleSanitize 
{
    private $rutaAssets;
    
    public function _construct()
    {
        $this->rutaAssets = _ROOT_ASSETS_ADMIN;
    }

    public function RegistrarConvocatoria()
    {

    }

    public function ActualizarConvocatorias()
    {

    }
}