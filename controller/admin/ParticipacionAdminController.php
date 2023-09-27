<?php

require_once _ROOT_CONTROLLER . 'admin/handleSanitize.php';
require_once _ROOT_CONTROLLER . 'admin/AdministrarArchivos.php';
require_once _ROOT_MODEL . 'conexion.php';
require_once _ROOT_MODEL . 'ParticipacionModel.php';

Class PresupuestoAdminController extends handleSanitize 
{
    private $conexion;
    private $gestorArchivos;
    
    public function __construct()
    {
        $this->conexion = new MySQLConnection();
        $this->gestorArchivos = new AdministrarArchivos($this->conexion, 'transparencia/presupuesto/saldo-balance/' . date('Y/m/'));
    }

    public function index($metodo)
    {
        switch($metodo){
            case 'registrar-archivos':
                $this->registrarSaldoBalance();
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
        $descripcion = empty($_POST['descripcion']) ? null : htmlspecialchars(ENT_QUOTES, 'utf-8');
        $fecha = date('Y-m-d');
        $tipoDoc = htmlspecialchars($_POST['tipoDoc'], ENT_QUOTES, 'utf-8');
        $pathFullFile = [];
        foreach ($nuevosArchivos as $index => $datosArchivo) {
            $pathFullFile []= ['nameFile' => $this->gestorArchivos->guardarFichero($datosArchivo, 'documento-adjunto')];
        }
        ParticipacionModel::saveFormParticipacion($titulo,$descripcion,$tipoDoc, json_encode($pathFullFile));
        echo (json_encode(['status'=>'success', 'message'=>'Registro guardado.']));
    }
}