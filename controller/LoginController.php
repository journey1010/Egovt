<?php

require_once _ROOT_CONTROLLER . 'AbstractController.php';
require_once _ROOT_MODEL . 'conexion.php';

class LoginController extends AbstractController
{

    public function showLoginForm()
    {
        if (isset($_COOKIE['user'])) {
            $username = $_COOKIE['user'];
            $conexion = new MySQLConnection();
            $sqlSentences = "SELECT nombre, estado_usuario, tipo_usuario from usuarios where nombre = ? ";
            $arrayParams = [$username];
            $consulta  = $conexion->query($sqlSentences, $arrayParams, '', false);
            $ResultadoConsulta = $consulta->fetchAll();
            foreach ($ResultadoConsulta as $columna) {
                $estadoUsuario = $columna['estado_usuario'];
                $tipoUsuario = $columna['tipo_usuario'];
            }
            if ($estadoUsuario === '0') {
                setcookie("user", "", time() - 3600);
                $conexion->close();
                $this->renderView('admin/login');
                exit;
            }
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['tipoUser'] = $tipoUsuario;
            $conexion->close();
            header('Location: /administrador/app');
        }
        $this->renderView('admin/login');
        return;
    }

    public function processLoginForm()
    {
        $username = $this->SanitizeVar($_POST['username']) ?? '';
        $password = $this->SanitizeVar($_POST['password']) ?? '';

        $conexion = new MySQLConnection();
        $sqlSentences = "SELECT nombre, contrasena, tipo_usuario from usuarios where nombre = ? ";
        $arrayParams = [$username];
        $consulta  = $conexion->query($sqlSentences, $arrayParams, '', false);
        $ResultadoConsulta = $consulta->fetchAll();

        if (count($ResultadoConsulta) == 0) {
            $response = array('error' => 'Puede que no exista el usuario');
            echo json_encode($response);
        } else {
            foreach ($ResultadoConsulta as $columna) {
                $usernameToCompare = $columna['nombre'];
                $passwordToCompare = $columna['contrasena'];
                $userTipo = $columna['tipo_usuario'];
            }
            if (!empty($passwordToCompare) && password_verify($password, $passwordToCompare) &&  $username == $usernameToCompare) {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['tipoUser'] = $userTipo;
                setcookie("user", $username, time() + (90 * 24 * 60 * 60), "/");
                $conexion->close();
                $response = array('success' => true, 'redirect' => '/administrador/app');
                print_r(json_encode($response));
                exit;
            } else {
                $conexion->close();
                $response = array('error' => 'Usuario o contraseña incorrectos');
                print_r(json_encode($response));
            }
        }
    }
    
    protected function SanitizeVar(string $var)
    {
        $var = htmlspecialchars( $var,  ENT_QUOTES);
        $var = preg_replace('/[^a-zA-Z0-9.=+-_@^]/', 'a', $var);
        return $var;
    }
}
