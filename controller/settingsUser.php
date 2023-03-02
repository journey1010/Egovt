<?php

require_once _ROOT_CONTROLLER . 'AbstractController.php';
require_once _ROOT_MODEL . 'conexion.php';

class settingsUser extends AbstractController{
    public function changeLogo()
    {
        $userName = $_POST['username'] ?? '';
        $file = $_POST['file'] ?? '';

        $allowedExtension = ['jpg', 'jpg', 'png', 'jpeg', 'tiff', 'jfif'];
        $extensionFile = pathinfo($file, PATHINFO_EXTENSION);
        $coincidence = array_search($extensionFile, $allowedExtension); 
        if ($coincidence == false){
            $respuesta = ["extension" => false];
            echo json_encode($respuesta);
            return;
        }

        try{
            $conexion =  new MySQLConnection();

            $sqlSentence = "select user_img from usuarios where nombre = ?";
            $params = [$userName];
            $resultado = $conexion->query($sqlSentence, $params, '', false);
            $fileToDelete = $resultado->fetchColumn();
            unlink(_ROOT_ASSETS_ADMIN . 'img/iconUser/' . $fileToDelete);

            $filename = pathinfo($file, PATHINFO_FILENAME). $extensionFile;
            $params2 = [$filename, $userName];
            $sqlSentence2 = "update usuarios set user_img = ? where nombre = ?";
            $conexion->query($sqlSentence2, $params2, '', false);
            file_put_contents(_ROOT_ASSETS_ADMIN . 'img/iconUser/'. $filename, $file);

            $conexion->close();
            
            $respuesta =["exito" => true];
            echo json_encode($respuesta);
            return;   
        }catch(Throwable $e){
            $conexion->handleException($e);
            $respuesta = ["fallo" => "No se pudo guardar el archivo. Vuelva a intentarlo"];
            echo json_encode($respuesta);
            return;
        }
    }

    public function changePassword()
    {
        try {
            $userName = $_POST['username'];
            $password = $this->SanitizeVar($_POST['password']);
            
            $conexion = new MySQLConnection();
            $sqlSentence = "Update usuarios set contrasena = ? where nombre = ?";
            $params = [$password, $userName];
            $conexion->query($sqlSentence, $params, '', false);
            $conexion->close();
            $respuesta = ["respuesta" => true ];
            echo json_encode($respuesta);
        }catch( Throwable $e){
            $conexion->handleException($e);
            $respuesta = [ "respuesta" => false ];
            echo json_encode($respuesta); 
        }
        return;
    }

    public function signOut()
    {
        unset($_SESSION['username']);
        unset($_SESSION['tipoUser']);
        setcookie("user", "", time() - 3600);
        session_destroy();
        header('Location: /administrador');
        return;
    }

    protected function SanitizeVar( string $var)
    {
        $var = htmlspecialchars( $var,  ENT_QUOTES);
        $var = preg_replace('/[^a-zA-Z0-9.=+-_@^]/', '', $var);
        return $var;
    }
}