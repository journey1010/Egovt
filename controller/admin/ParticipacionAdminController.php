<?php

require_once _ROOT_CONTROLLER . 'admin/handleSanitize.php';
require_once _ROOT_CONTROLLER . 'admin/AdministrarArchivos.php';
require_once _ROOT_MODEL . 'conexion.php';
require_once _ROOT_MODEL . 'ParticipacionModel.php';

Class ParticipacionAdminController extends handleSanitize 
{
    private $conexion;
    private $gestorArchivos;
    
    public function __construct()
    {
        $this->conexion = new MySQLConnection();
        $this->gestorArchivos = new AdministrarArchivos($this->conexion, 'transparencia/participacion-ciudadana/' . date('Y/m/'));
    }

    public function index($metodo)
    {
        switch($metodo){
            case 'registrar-archivos':
                $this->registrarParticipacion();
            break;
        }
    }

    protected function registrarParticipacion()
    {
        if(!isset($_POST['titulo'])){
            echo (json_encode(['status'=>'error', 'message'=>'El campo titulo no debe estar vacío.']));
            return;
        }
        if(!isset($_POST['tipoDoc'])){
            echo (json_encode(['status'=>'error', 'message'=>'El campo tipo de documento no debe estar vacío.']));
            return;
        }
        if(!isset($_FILES['archivosParticipacion'])){
            echo (json_encode(['status'=>'error', 'message'=>'El campo archivo no debe estar vacío.']));
            return; 
        }

        $extensionPermitidas = ['docx', 'xlsx', 'xls', 'pdf', 'txt', 'doc', 'ppt', 'pptx'];
        $archivos =  $_FILES['archivosParticipacion'];
        $nuevosArchivos = $this->reorganizarArchivos($archivos);
        if (!$this->validarArchivos($nuevosArchivos, $extensionPermitidas)) {
            echo (json_encode(['status'=>'error', 'message'=>'Extensión de archivo no permitido.']));
            return;
        }

        $titulo = htmlspecialchars($_POST['titulo'], ENT_QUOTES, 'utf-8');
        $descripcion = empty($_POST['descripcion']) ? null : htmlspecialchars($_POST['descripcion'], ENT_QUOTES, 'utf-8');
        $fecha = date('Y-m-d');
        $tipoDoc = htmlspecialchars($_POST['tipoDoc'], ENT_QUOTES, 'utf-8');
        $pathFullFile = [];
        foreach ($nuevosArchivos as $index => $datosArchivo) {
            $pathFullFile []= ['namefile'=> pathinfo($datosArchivo['name'], PATHINFO_FILENAME), 'file' => $this->gestorArchivos->guardarFichero($datosArchivo, 'documento-adjunto')];
        }
        ParticipacionModel::saveFormParticipacion($titulo,$descripcion,$tipoDoc, json_encode($pathFullFile));
        echo (json_encode(['status'=>'success', 'message'=>'Registro guardado.']));
    }

    /**
     * Reorganiza el @param array $archivos en un array cuyas posiciones guardan otro array (Una matriz de matrices)
     * @return array
     */
    private function reorganizarArchivos(array $archivos): array
    {
        $nuevosArchivos = [];
        foreach ($archivos as $propiedad => $valores) {
            foreach ($valores as $indice => $valor) {
                $nuevosArchivos[$indice][$propiedad] = $valor;
            }
        }
        return $nuevosArchivos;
    }

    /**
     * Valida multiples archivos 
     * @param array $archivos contiene archivos recividos por $_POST[]
     * @param array $extensionPermitidas lista de extensiones admitidas por el sistema
     * @return bool
     * @see $this->gestorArchivos->validarArchivo, función heredada que validad archivos individuales
     */
    private function validarArchivos($archivos, $extensionPermitidas): bool
    {
        foreach ($archivos as $archivo) {
            if (!$this->gestorArchivos->validarArchivo($archivo, $extensionPermitidas)) {
                return false;
            }
        }
        return true;
    }
}