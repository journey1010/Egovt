<?php

require_once _ROOT_CONTROLLER . 'admin/handleSanitize.php';
require_once _ROOT_CONTROLLER . 'admin/AdministrarArchivos.php';
require_once _ROOT_MODEL . 'conexion.php';
require_once _ROOT_MODEL . 'PresupuestoModel.php';

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
            case 'registrar':
                $this->registrarSaldoBalance();
            break;
        }
    }

    protected function registrarSaldoBalance()
    {
        if(!isset($_POST['titulo'])){
            echo (json_encode(['status'=>'error', 'message'=>'El campo titulo no debe estar vacío.']));
            return;
        }
        if(!isset($_FILES['archivosSaldoBalance'])){
            echo (json_encode(['status'=>'error', 'message'=>'El campo archivo no debe estar vacío.']));
            return; 
        }

        if(!isset($_POST['fecha'])){
            echo (json_encode(['status'=>'error', 'message'=>'El campo Fecha Saldo de Balance no puede estar vacío.']));
            return;
        }else {
           if (!strtotime($_POST['fecha'])){
            echo (json_encode(['status'=>'error', 'message'=>'El campo Fecha Saldo de Balance tiene un formato invalido.']));
            return;
           } 
        }  

        $extensionPermitidas = ['docx', 'xlsx', 'xls', 'pdf', 'txt', 'doc'];
        $archivos =  $_FILES['archivosSaldoBalance'];
        $nuevosArchivos = $this->reorganizarArchivos($archivos);

        if (!$this->validarArchivos($nuevosArchivos, $extensionPermitidas)) {
            echo (json_encode(['status'=>'error', 'message'=>'Extensión de archivo no permitido.']));
            return;
        }
        $titulo = htmlspecialchars($_POST['titulo']);
        $fecha = filter_var($_POST['fecha'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pathFullFile = [];
        foreach ($nuevosArchivos as $index => $datosArchivo) {
            $pathFullFile []= ['namefile'=> pathinfo($datosArchivo['name'], PATHINFO_FILENAME), 'file' => $this->gestorArchivos->guardarFichero($datosArchivo, 'documento-adjunto')];
        }
        PresupuestoModel::saveFormSaldoBalance($titulo,json_encode($pathFullFile), $fecha);
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
