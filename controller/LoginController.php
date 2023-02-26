<?php

require_once _ROOT_CONTROLLER . 'AbstractController.php';
require_once _ROOT_MODEL . 'conexion.php';

class LoginController extends AbstractController {

    public function showLoginForm()
    {   
        $this->renderView('admin/login');
    }

    public function processLoginForm()
    {   

        $username = $this->SanitizeVar($_POST['username']) ?? '';
        $password = $this->SanitizeVar($_POST['password']) ?? '';

        $conexion = new MySQLConnection();
        $sqlSentences = "SELECT nombre, contrasena, estado_usuario from usuarios where usuario = ? and contrasena = ? ";
        $arrayParams = [':usuario' => $username, ':contrasena' => $password];
        $consulta  = $conexion->query($sqlSentences, $arrayParams, '', false );
        $ResultadoConsulta = $consulta->fetchAll();;
        foreach ($ResultadoConsulta as $columna){
            $usernameToCompare = $columna['nombre'];
            $passwordToCompare = $columna['contrasena'];
            $userEstado = $columna['estado_usuario'];
        }

        ##Comprobar estado de session y crear sessiones para los usuarios 
        ##Redirigir a la /admnistrador/@me si el usuario a iniciado sessión correctamente
        ##/administrador/@me comprueba la existencia de la cookie phpsessid de lo contrario redirige al login
        ##Mejorar fonde de login. 
        if( isset($_SESSION['username']) ){
            $existeSession = false ; 
        } else {
             $existeSession = true; 
        }
        switch($existeSession){
            case true:  
                $url = _BASE_URL . '/administrador/@me';
                header("Location: $url");

            break;
            case false:

            break;
        }


        if($username === $usernameToCompare && $password === $passwordToCompare){
            if($userEstado == 1){

            }else{

            }
        }else{

        }

        ##Fin Comprobar estado de session y crear sessiones para los usuarios 

        // Aquí iría la lógica de autenticación del usuario, por ejemplo:
        /*if ($username === 'admin' && $password === 'admin') {
            $_SESSION['user'] = $username;
            header('Location: /');
            exit();
        } else {
            $_SESSION['error_message'] = 'Nombre de usuario o contraseña incorrectos.';
            header('Location: /login');
            exit();
        }*/
    }

    protected function SanitizeVar(string $var)
    {
        $var = filter_var($var , FILTER_SANITIZE_SPECIAL_CHARS);
        $var = htmlspecialchars($var, ENT_QUOTES);
        $var = preg_match('/[^a-zA-Z0-9.+*-@]/', '', $var) ;
        return $var; 
    }
}