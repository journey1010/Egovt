<?php

require_once  (_ROOT_MODEL . 'conexion.php');

class visitas {
    
    public function RegistrarVisita()
    {   
        try{         
            $dniVisita = $_POST['dniVisita']; 
            $apellidosNombres = $_POST['apellidosNombres']; 
            $oficina = $_POST['oficina']; 
            $personaAVisitar = $_POST['personaAVisitar']; 
            $horaDeIngreso = $_POST['horaDeIngreso']; 
            $quienAutoriza = $_POST['quienAutoriza']; 
            $motivo = $_POST['motivo']; 

            if (
                !empty($dniVisita) &&
                !empty($apellidosNombres) &&
                !empty($oficina) &&
                !empty($horaDeIngreso)

            ) {
                $dniVisita = $this->SanitizeVarInput($dniVisita);
                $apellidosNombres = $this->SanitizeVarInput( $apellidosNombres);
                $oficina = $this->SanitizeVarInput($oficina);
                $personaAVisitar = $this->SanitizeVarInput($personaAVisitar);
                $quienAutoriza = $this->SanitizeVarInput($quienAutoriza);
                $motivo = $this->SanitizeVarInput($motivo);

                $conexion = new MySQLConnection();
                $sqlSentence = 'INSERT INTO visitas (
                    apellidos_nombres, 
                    dni,
                    area_que_visita, 
                    persona_a_visitar, 
                    hora_de_ingreso,
                    quien_autoriza, 
                    motivo
                ) VALUES (
                    ?,?,?,?,?,?,?
                )';
                $params = [
                    $apellidosNombres, 
                    $dniVisita, 
                    $oficina, 
                    $personaAVisitar, 
                    $horaDeIngreso, 
                    $quienAutoriza, 
                    $motivo
                ];
                $conexion->query($sqlSentence, $params, '', false);
                $conexion->close();
                $respuesta = array('success' => 'visita registrado con exito');
                print_r(json_encode($respuesta));
            } else {
                $respuesta = array('error' => 'Los datos obligatorios no deben estar vacíos.');
                print_r(json_encode($respuesta));
            }
        }catch (Throwable $e) {
            $this->handleError($e);
            $respuesta = array('error' => 'Error al guardar datos.');
            print_r(json_encode($respuesta));
        }
        return;
    }

    public function ActualizarVisita()
    {
        try{
            $id = $_POST['id'];            
            $horaSalida = $_POST['horaSalida'];
            $motivo = $_POST['motivo'];
            if ( !empty ($horaSalida)) {
                $motivo = $this->SanitizeVarInput($motivo);

                $conexion = new MySQLConnection();
                $sqlSentence = "UPDATE visitas SET hora_de_salida = ?, motivo = ? WHERE id= ?";
                $params = [$horaSalida, $motivo, $id];
                $conexion->query($sqlSentence, $params, '', false);
                $conexion->close();
                $respuesta = array('success' => 'visita actualizada con exito');
                print_r(json_encode($respuesta));
            } else {
                $respuesta = array('error' => 'Los datos obligatorios no deben estar vacíos.');
                print_r(json_encode($respuesta));
            }

        } catch (Throwable $e) {
            $this->handleError($e);
            $respuesta = array('error' => 'Error al actualizar datos.');
            print_r(json_encode($respuesta));
        }
    }

    private function handleError(Throwable $e)
    {   
        $errorMessage = date('Y-m-d H:i:s') . ' : ' . $e->getMessage() . "\n"; 
        error_log($errorMessage, 3, _ROOT_PATH . '/log/error.log');
    }

    private function SanitizeVarInput(string $var)
    {
        $varSanitize = filter_var($var, FILTER_SANITIZE_SPECIAL_CHARS);
        $varSanitize = htmlentities($var, ENT_QUOTES);
        return $varSanitize;
    }
}