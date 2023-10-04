<?php

require_once _ROOT_CONTROLLER . 'admin/handleSanitize.php';
require_once _ROOT_CONTROLLER . 'GestorArchivos.php';
require_once _ROOT_MODEL . 'PublicacionesModel.php';

Class PublicacionesAdminController extends handleSanitize 
{
    private $conexion;
    private $gestorArchivos;
    
    public function __construct()
    {
        $this->gestorArchivos = new GestorArchivos('publicaciones/' . date('Y/m/'));
    }

    public function index($metodo)
    {
        switch($metodo){
            case 'registrar-archivos':
                $this->registrarPublicacion();
            break;
        }
    }

    protected function registrarPublicacion()
    {
        if(!isset($_POST['titulo'])){
            echo (json_encode(['status'=>'error', 'message'=>'El campo titulo no debe estar vacío.']));
            return;
        }
        if(!isset($_POST['tipoDoc'])){
            echo (json_encode(['status'=>'error', 'message'=>'El campo tipo de documento no debe estar vacío.']));
            return;
        }
        if(!isset($_POST['descripcion'])){
            echo (json_encode(['status'=>'error', 'message'=>'El campo descripcion no debe estar vacío.']));
            return;
        }
        if(!isset($_POST['dateDoc'])){
            echo (json_encode(['status'=>'error', 'message' => 'El campo fecha no debe estar vacío.']));
            return;
        }
        if(!isset($_FILES['archivosPublicaciones'])){
            echo (json_encode(['status'=>'error', 'message'=>'El campo archivo no debe estar vacío.']));
            return; 
        }

        $extensionPermitidas = ['docx', 'xlsx', 'xls', 'pdf', 'txt', 'doc', 'ppt', 'pptx'];
        $archivos =  $_FILES['archivosPublicaciones'];
        if (!$this->gestorArchivos->validarArchivos($archivos, $extensionPermitidas)) {
            echo (json_encode(['status'=>'error', 'message'=>'Extensión de archivo no permitido.']));
            return;
        }

        $titulo = htmlspecialchars($_POST['titulo'], ENT_QUOTES, 'utf-8');
        $descripcion = htmlspecialchars($_POST['descripcion'], ENT_QUOTES, 'utf-8');
        $tipoDoc = htmlspecialchars($_POST['tipoDoc'], ENT_QUOTES, 'utf-8');
        $fechaDoc = $_POST['dateDoc'];

        if(!$pathFullFile = $this->gestorArchivos->saveFileFormatJson($archivos, 'publicaciones')){
            echo (json_encode(['status'=>'error', 'message'=>'No se pudo guardar registro.']));
            return;
        }
        PublicacionesModel::saveFormPublicaciones($titulo,$descripcion,$tipoDoc, json_encode($pathFullFile), $fechaDoc);
        echo (json_encode(['status'=>'success', 'message'=>'Registro guardado.']));
    }
}