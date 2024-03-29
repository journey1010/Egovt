<?php

require_once _ROOT_CONTROLLER . 'AbstractController.php';
require_once _ROOT_MODEL . 'conexion.php';

class settingsUser extends AbstractController{
    public function changeLogo()
    {
        try{
            if (!isset($_FILES['file']) || $_FILES['file']['error'] != UPLOAD_ERR_OK) {
                $respuesta = ["error" => $_FILES['file']['error']];
                echo json_encode($respuesta);
                return;
            }
            $userName = $_POST['username'] ?? '';
            $file = $_FILES['file']['tmp_name'];

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'tiff', 'jfif'];
            $extensionFile = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        
            if (!in_array($extensionFile, $allowedExtensions)) {
                $respuesta = ["extension" => false];
                echo json_encode($respuesta);
                return;
            }

            $conexion =  new MySQLConnection();

            $sqlSentence = "select user_img from usuarios where nombre_usuario = ?";
            $params = [$userName];
            $resultado = $conexion->query($sqlSentence, $params, '', false);
            $fileToDelete = $resultado->fetchColumn();
            unlink(_ROOT_PATH  . '/assets/admin/img/iconUser/' . $fileToDelete);

            $filename = pathinfo($file, PATHINFO_FILENAME). '.'. $extensionFile;
            $params2 = [$filename, $userName];
            $sqlSentence2 = "update usuarios set user_img = ? where nombre_usuario = ?";
            $conexion->query($sqlSentence2, $params2, '', false);
            $conexion->close();

            $destination = _ROOT_PATH  . '/assets/admin/img/iconUser/' . $filename;
            move_uploaded_file($file, $destination);
            $this->RedimencionarImg($destination);
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
            if (!isset ($_POST['username']) && isset($_POST['password']) ){
                $respuesta = ["respuesta" => "Error de datos"];
                echo json_encode($respuesta);
                return;
            }
            $userName = $_POST['username'] ?? '';
            $password = $this->SanitizeVar($_POST['password']);
            $password = password_hash($password, PASSWORD_ARGON2I, 
                [
                    'cost' => 8, 
                    'memory_cost' => 1<<10,
                    'time_cost' => 2, 
                    'threads' => 2
                ]
            );
            
            $conexion = new MySQLConnection();
            $sqlSentence = "Update usuarios set contrasena = ? where nombre_usuario = ?";
            $params = [$password, $userName];
            $conexion->query($sqlSentence, $params, '', false);
            $conexion->close();
            $respuesta = ["respuesta" => true ];
            echo json_encode($respuesta);
            return;
        }catch( Throwable $e){
            $conexion->handleException($e);
            $respuesta = [ "respuesta" => false ];
            echo json_encode($respuesta); 
            return;
        }
        
    }

    public function signOut()
    {
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['tipoUser']);
        setcookie("user", "", time() - 3600);
        setcookie("PHPSESSID", "", time() - 3600);
        session_destroy();
        header('Location: /administrador');
        return;
    }

    private function RedimencionarImg($imagen_original)
    {
        $imagen = imagecreatefromjpeg($imagen_original);
        $nueva_imagen = imagescale($imagen, 256, 256);
        imagejpeg($nueva_imagen, $imagen_original);
        imagedestroy($imagen);
        imagedestroy($nueva_imagen);
    }

    //usar esto para las contraseñas
    protected function SanitizeVar( string $var)
    {
        $var = htmlspecialchars( $var,  ENT_QUOTES);
        $var = preg_replace('/[^a-zA-Z0-9.=+-_@^]/', 'a', $var);
        return $var;
    }
}