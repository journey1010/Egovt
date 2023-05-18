<?php 
require_once (_ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once (_ROOT_MODEL . 'conexion.php');

class AgendaGobernador extends handleSanitize
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = new MySQLConnection();
    }

    public function registrar()
    {
        try{
            $camposRequeridos = ['fecha', 'hora', 'organizador', 'lugar', 'participantes', 'tema', 'actividad'];
            foreach($camposRequeridos as $campo){
                if(array_key_exists($campo, $_POST)){
                    extract([$campo => $this->SanitizeVarInput($_POST[$campo])]);
                } else {
                    extract([$campo => NULL]);
                }
            }
            if ($this->insertInto($fecha, $tema, $hora, $organizador, $lugar, $participantes, $actividad)){
                $respuesta = array ('status' => 'success', 'message'=>'Agenda Registrada con éxito');
                echo (json_encode($respuesta));
            }
        } catch (Throwable $e){
            $this->handlerError($e);
            $respuesta = array ('status' => 'error', 'message'=>'No se pudo procesar la solicitud. Vuelva a intentar o contacte con el administrador del sitio.');
            echo (json_encode($respuesta));
        }
    }

    public function actualizar()
    {

    }

    public function buscar()
    {
        
    }

    private function insertInto($fecha, $tema, $hora = NULL, $organizador = NULL, $lugar = NULL, $participantes = NULL, $actividad = NULL)
    {
        $sql = "INSERT INTO agenda (fecha, hora, actividad, tema, organiza, lugar, participante) VALUES (?,?,?,?,?,?,?)";
        $params = [$fecha, $hora, $actividad, $tema, $organizador, $lugar, $participantes];
        try {
            $this->conexion->query($sql, $params, '', false);
            return true;
        } catch(Throwable $e){
            throw new Exception($e->getMessage() . 'Error en insertcion de datos de registro de agenda');
            return false;
        }    
    }
}