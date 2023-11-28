<?php
require_once _ROOT_PATH . '/vendor/autoload.php';
require_once _ROOT_MODEL . 'conexion.php';
require_once _ROOT_MODEL . '/FormAccessInformation.php';

class AccessInformationModel 
{
    public $nombreCompleto;
    public $tipoDocumento;
    public $numeroDocumento;        
    public $email;
    public $telefono;
    public $direccion;
    public $departamento;
    public $provincia;
    public $distrito;
    public $descripcion;
    public $dependencia;
    public $archivo = null;

    public function __construct(
        $nombreCompleto,
        $tipoDocumento,
        $numeroDocumento,        
        $email,
        $telefono,
        $direccion,
        $departamento,
        $provincia,
        $distrito,
        $descripcion,
        $dependencia,
        $archivo = null
    )
    {
        $this->nombreCompleto = $nombreCompleto;
        $this->tipoDocumento = $tipoDocumento ;
        $this->numeroDocumento =  $numeroDocumento;        
        $this->email = $email;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->departamento = $departamento;
        $this->provincia = $provincia;
        $this->distrito = $distrito;
        $this->descripcion = $descripcion;
        $this->dependencia = $dependencia;
        $this->archivo = $archivo;
    }


    public function save()
    {
        $conexion = new MySQLConnection();
        $sql = "INSERT INTO access_to_information (full_name, type_doc, doc_number, email, phone, address, departamento, provincia, distrito, descriptions, file, date_register, dependencia)
                values  (:nombreCompleto, :tipoDocumento, :numeroDocumento, :email, :telefono, :direccion, :departamento, :provincia, :distrito, :descripcion, :archivo, :date_register,:dependencia) ";
        $params = [
            ':nombreCompleto'=> $this->nombreCompleto,  
            ':tipoDocumento'=> $this->tipoDocumento,
            ':numeroDocumento'=> $this->numeroDocumento,           
            ':email'=> $this->email, 
            ':telefono'=> $this->telefono, 
            ':direccion'=> $this->direccion, 
            ':departamento'=> $this->departamento, 
            ':provincia' => $this->provincia,
            ':distrito'=> $this->distrito, 
            ':descripcion'=> $this->descripcion,
            ':archivo'=> $this->archivo,
            ':date_register' => date('Y-m-d'),
            ':dependencia' => $this->dependencia,
        ];
        $stmt = $conexion->query($sql, $params, '', false);
        return  true;
    }

    public static function getOficinas()
    {
        $conexion = new MySQLConnection();
        $sql = "SELECT * FROM oficinas";
        $params = [];
        $stmt = $conexion->query($sql, $params, '', false);
        $repuesta = $stmt->fetchAll();
        return $repuesta;
    }

    public function makepdf($localStorage)
    {
        $pdf = new CustomPDF();
        $pdf->head();
        $pdf->responsibleOfficial();
        $pdf->personalData(
            $this->nombreCompleto, 
            $this->tipoDocumento, 
            $this->numeroDocumento, 
            $this->direccion, 
            $this->departamento, 
            $this->provincia, 
            $this->distrito, 
            $this->email, 
            $this->telefono
        );
        $pdf->infoRequired($this->descripcion, $this->dependencia);
        $pdf->additionalData();
        $document = $pdf->outputPDF($localStorage);
        return $document;
    }
    
}