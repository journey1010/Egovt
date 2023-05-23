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
        try{
            $camposRequeridos = ['id','fecha', 'hora', 'organizador', 'lugar', 'participantes', 'tema', 'actividad'];
            foreach($camposRequeridos as $campo){
                if(array_key_exists($campo, $_POST)){
                    extract([$campo => $this->SanitizeVarInput($_POST[$campo])]);
                } else {
                    extract([$campo => NULL]);
                }
            }
            if ($this->updateAgenda($id, $fecha, $tema, $hora, $organizador, $lugar, $participantes, $actividad)){
                $respuesta = array ('status' => 'success', 'message'=>'Actualización exitosa.');
                echo (json_encode($respuesta));
            }
        } catch (Throwable $e){
            $this->handlerError($e);
            $respuesta = array ('status' => 'error', 'message'=>'No se pudo procesar la solicitud. Vuelva a intentar o contacte con el administrador del sitio.');
            echo (json_encode($respuesta));
        }
    }

    public function buscar()
    {
        try {
            $fecha = $this->SanitizeVarInput($_POST['fecha']);
            $order = $this->SanitizeVarInput($_POST['order']);
            $sql = "SELECT * FROM agenda WHERE fecha= ?";
            if ($order === 'DESC') {
                $sql .= " ORDER BY hora DESC";
            } elseif ($order == 'ASC') {
                $sql .= " ORDER BY hora ASC";
            }
            $params = [$fecha];
            $stmt = $this->conexion->query($sql, $params, '', false);
            $resultado = $stmt->fetchAll();
            $tabla_respuesta = $this->makeTableForBuscarAgenda($resultado);
            $respuesta = array('status'=>'success', 'data' => $tabla_respuesta);
            echo (json_encode($respuesta));
        } catch (Throwable $e){
            $this->handlerError($e);
            $respuesta = array ('status'=>'error', "message" => "Error al consultar registros.");
            echo (json_encode($respuesta));
        }
    }

    private function makeTableForBuscarAgenda($resultado): string
    {
        $tablaRow = '';
        foreach($resultado as $row){
            $id = $row['id'];
            $fecha = $row['fecha'];            
            $hora = $row['hora'];
            $actividad = $row['actividad'];
            $tema = $row['tema'];
            $organiza = $row['organiza'];
            $lugar = $row['lugar'];
            $participante = $row['participante'];

            $tablaRow .= "<tr>";
            $tablaRow .= "<td class=\"text-center\">$id</td>";
            $tablaRow .= "<td class=\"text-center\">$fecha</td>";
            $tablaRow .= "<td class=\"text-center\">$hora</td>";
            $tablaRow .= "<td class=\"text-center\">$tema</td>";
            $tablaRow .= "<td class=\"text-center\" style=\"max-width: 300px;\" >$actividad</td>";
            $tablaRow .= "<td class=\"text-center\">$organiza</td>";
            $tablaRow .= "<td class=\"text-center\">$lugar</td>";
            $tablaRow .= "<td class=\"text-center\">$participante</td>";
            $tablaRow .= '
                <td class="text-center align-middle">
                    <i class="fa fa-edit mr-2 edit-icon-agenda" style="color:#9c74dd !important"></i>
                </td>
            ';
            $tablaRow .= "</tr>";
        }
        $tabla = <<<Html
        <table class="table table-hover table-md w-100" id="resultadosBusquedaAgenda">
            <thead class="table-bordered" >
                <tr>
                    <th class="text-center">id</th>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Hora</th>
                    <th style="text-center">Tema</th>
                    <th class="text-center">Actividad</th>
                    <th class="text-center">Organizador</th>
                    <th class="text-center">Lugar</th>
                    <th class="text-center">Participante</th>
                    <th style="width: 80px" class="text-center ">Editar</th>
                </tr>
            </thead>
            <tbody>
                $tablaRow
            </tbody>
        </table>  
        Html;  
        return $tabla;
    }

    private function insertInto($fecha, $tema, $hora = NULL, $organizador = NULL, $lugar = NULL, $participantes = NULL, $actividad = NULL)
    {
        $sql = "INSERT INTO agenda (fecha, hora, actividad, tema, organiza, lugar, participante) VALUES (?,?,?,?,?,?,?)";
        if($hora == ''){
            $hora = NULL;
        }
        $params = [$fecha, $hora, $actividad, $tema, $organizador, $lugar, $participantes];
        try {
            $this->conexion->query($sql, $params, '', false);
            return true;
        } catch(Throwable $e){
            throw new Exception($e->getMessage() . ' Error en insertcion de datos de registro de agenda');
            return false;
        }    
    }

    private function updateAgenda($id, $fecha, $tema, $hora = NULL, $organizador = NULL, $lugar = NULL, $participantes = NULL, $actividad = NULL)
    {
        $sql = "UPDATE agenda SET fecha= :fecha, hora=:hora, actividad=:actividad, tema=:tema, organiza=:organiza, lugar=:lugar, participante=:participante  WHERE id = :id";
        $params = [
            ':fecha' => $fecha,
            ':hora' => $hora,
            ':actividad'=> $actividad,
            ':tema'=> $tema,
            ':organiza'=> $organizador,
            ':lugar'=>$lugar,
            ':participante'=>$participantes,
            'id'=>$id
        ];
        try{
            $this->conexion->query($sql, $params, '', false);
            return true;
        } catch (Throwable $e) {
            throw new Exception($e->getMessage() . ' Error en la insercion de datos de actualización de agenda');
            return false;
        }
    }
}