<?php
require_once (_ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once (_ROOT_CONTROLLER . 'admin/AdministrarArchivos.php'); 
require_once  (_ROOT_MODEL . 'conexion.php');

class Main extends handleSanitize {

    public function datosGobernador() 
    {
        $campoRequerido = ['titulo', 'mensaje', 'mensaje', 'frase', 'entrada']; 
        foreach ($campoRequerido as $campo) {
            if (empty ($_POST[$campo])) {
                $respuesta = array  ("status" =>"error", "message" => "Si ha borrado algún campo del formulario de actualización, debe rellenarlo de nuevo antes de enviarlo. Los campos vacíos pueden causar errores o retrasos en el proceso de actualización.");
                echo (json_encode($respuesta));
                return;
            }
        }

        try {    
            $conexion = new MySQLConnection();
            $gestorArchivo = new AdministrarArchivos($conexion, 'pagina-principal/');

            $titulo = $this->SanitizeVarInput($_POST["titulo"]);
            $mensaje = $this->SanitizeVarInput($_POST["mensaje"]);
            $frase = $this->SanitizeVarInput($_POST["frase"]);
            $entrada = $this->SanitizeVarInput($_POST["entrada"]);

            $archivo = $_FILES["imgGobernador"] ?? null;

            if ($gestorArchivo->validarArchivo($archivo, ['jpg', 'webp', 'jpeg', 'gif']) == true) {
                $sql = "SELECT img FROM gobernador LIMIT 1";
                $gestorArchivo->borrarArchivo($sql, '');
                $newPathFile = $gestorArchivo->guardarFichero($archivo, $titulo);
                $this->UpdateSetBd($conexion, $titulo, $mensaje, $frase, $entrada, $newPathFile);
                return;
            }
            $this->UpdateSetBd($conexion, $titulo, $mensaje, $frase, $entrada);
        } catch (Throwable $e) {
            $this->handlerError($e);
        }
    }  

    private function UpdateSetBd(MySQLConnection $conexion, $titulo, $mensaje, $frase, $entrada, $newPathFile = null)
    {
        $sql = "UPDATE gobernador SET titulo = :titulo, mensaje = :mensaje , entrada = :entrada, frase = :frase";
        $params[":titulo"] = $titulo;
        $params[":mensaje"] = $mensaje;
        $params[":entrada"] = $entrada;
        $params[":frase"] = $frase;
        try {
            if ($newPathFile !==null) {
                $sql .= ", img = :img";
                $params[":img"] = $newPathFile;
            }
            $sql .= " WHERE id_gobernador = 1";
            $conexion->query($sql, $params, '', false);
            $conexion->close();
            $respuesta = array ("status" => "success" , "message" => "Registro actualizado exitosamente.");
            echo (json_encode($respuesta));

        } catch (Throwable $e) {
            $respuesta = array ("status"=>"error", "message" => "La actualizacion ha fallado.");
            echo (json_encode($respuesta));
            $this->handlerError($e);
        }
    }

    public function datosBanner()
    {
        $campoRequerido = ['id', 'descripcion']; 
        foreach ($campoRequerido as $campo) {
            if (empty ($_POST[$campo])) {
                $respuesta = array  ("status" =>"error", "message" => "Si ha borrado algún campo del formulario de actualización, debe rellenarlo de nuevo antes de enviarlo. Los campos vacíos pueden causar errores o retrasos en el proceso de actualización.");
                echo (json_encode($respuesta));
                return;
            }
        }

        try {
            $conexion = new MySQLConnection();
            $gestorArchivo = new AdministrarArchivos($conexion, '');
            $gestorArchivo->setRuta(_ROOT_PATH . '/assets/images/banners/');

            $id = $this->SanitizeVarInput($_POST['id']);
            $descripcion = $this->SanitizeVarInput($_POST['descripcion']);

            $archivo = $_FILES["archivo"] ?? null;
            if ($gestorArchivo->validarArchivo($archivo, ['jpg', 'gif', 'webp', 'jpeg']) == true) {
                $sql = "SELECT banner FROM banners WHERE id_page_principal = :id";
                $params["id"] = $id;
                $gestorArchivo->borrarArchivo($sql, $params);
                $newPathFile = $gestorArchivo->guardarFichero($archivo, $id);
                $this->updateBanner($conexion, $id, $descripcion, $newPathFile);
                return;
            }
            $this->updateBanner($conexion, $id, $descripcion);
        } catch (Throwable $e) {
            $this->handlerError($e);
        }
    }    

    private function updateBanner ($conexion, $id, $descripcion, $newPathFile = null) 
    {   
        $sql = "UPDATE banners SET descripcion_banner = :descripcion";
        $params[":descripcion"] = $descripcion;
        try {
            if ($newPathFile !==null) {
                $sql .= ", banner = :banner";
                $params[":banner"] = $newPathFile;
            }
            $sql .= " WHERE id_page_principal = :id";
            $params[":id"] = $id;
            $conexion->query($sql, $params, '', false);
            $conexion->close();
            $respuesta = array ("status" => "success" , "message" => "Registro actualizado exitosamente.");
            echo (json_encode($respuesta));
        } catch (Throwable $e) {
            $respuesta = array ("status"=>"error", "message" => "La actualizacion ha fallado.");
            echo (json_encode($respuesta));
            $this->handlerError($e);
        }
    }

    public function datosDirectorio()
    {
        $campoRequerido = ['id', 'nombre', 'cargo'];
        foreach ($campoRequerido as $campo) {
            if ( empty ($_POST[$campo])) {
                $respuesta = array ("status" => "error", "message" => "El campo $campo no puede estar vacío." ); 
                echo (json_encode($respuesta));
                return;
            }
        }

        try {
            $conexion = new MySQLConnection ();
            $gestorArchivo = new AdministrarArchivos($conexion, '');
            $gestorArchivo->setRuta( _ROOT_PATH . '/assets/images/directorio/');

            $camposEnviados = ['id', 'nombre', 'cargo', 'telefono', 'correo', 'facebook', 'twitter', 'linkedin'];
            foreach ($camposEnviados as $campo) {
                extract([$campo => $this->SanitizeVarInput($_POST[$campo])]);
            }

            $archivo = $_FILES['archivo'] ?? null;
            if ( $gestorArchivo->validarArchivo($archivo, ['jpg', 'gif', 'webp', 'jpeg']) == true) {
                $sql = "SELECT imagen FROM directorio_paginaprincipal WHERE id_directorio = :id";
                $params[':id'] = $id;
                $gestorArchivo->borrarArchivo($sql, $params);
                $newPathFile = $gestorArchivo->guardarFichero($archivo, $id);
                $this->updateDirectorio($conexion, $id, $nombre, $cargo, $telefono, $correo, $facebook, $twitter, $linkedin, $newPathFile);
                return;
            }
            $this->updateDirectorio($conexion, $id, $nombre, $cargo, $telefono, $correo, $facebook, $twitter, $linkedin);
        } catch (Throwable $e) {
            $this->handlerError($e);
        }
    }

    private function updateDirectorio(
        $conexion, 
        $id, 
        $nombre,
        $cargo, 
        $telefono = '', 
        $correo = '', 
        $facebook = '', 
        $twitter = '', 
        $linkedin = '', 
        $newPathFile = ''
    ) {
        $sql = "UPDATE directorio_paginaprincipal set nombre = :nombre, cargo = :cargo";
        $params[':nombre'] = $nombre;
        $params[':cargo'] = $cargo;

        try {
            $camposOpcionales = ['telefono', 'correo', 'facebook', 'twitter', 'linkedin'];
            foreach ($camposOpcionales as $campo) {
                if ( $$campo !== '') {
                    $sql .= ", $campo = :$campo";
                    $params[":$campo"] = $$campo;
                }
            }

            if ($newPathFile !== null) {
                $sql .= ", imagen = :imagen";
                $params[":imagen"] = $newPathFile;
            }
            $sql .= ", id_directorio = :id";
            $params[':id'] = $id;
            $conexion->query($sql, $params, '', false);
            $respuesta = array ('status'=>'success', 'message'=>'Registro actualizado exitosamente.');
            echo (json_encode($respuesta));
        } catch (Throwable $e) {
            $respuesta = array('status' => 'error', 'message' => 'La actualización ha fallado exitosamente.');
            echo (json_encode($respuesta));
            $this->handlerError($e);
        }  
    }

    public function datosModal()
    {

    }

    private function updateModal()
    {
        
    }
}