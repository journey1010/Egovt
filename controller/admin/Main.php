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
            $gestorArchivo = new AdministrarArchivos($conexion, '');
            $gestorArchivo->setRuta(_ROOT_PATH . '/assets/images/');

            $titulo = $this->SanitizeVarInput($_POST["titulo"]);
            $mensaje = $this->SanitizeVarInput($_POST["mensaje"]);
            $frase = $this->SanitizeVarInput($_POST["frase"]);
            $entrada = $this->SanitizeVarInput($_POST["entrada"]);
            $enlaceVideo = $this->SanitizeVarInput($_POST["enlaceVideo"]);

            $archivo = $_FILES["imgGobernador"] ?? null;

            if ($gestorArchivo->validarArchivo($archivo, ['webp', 'jpg', 'gif']) == true) {
                $sql = "SELECT img FROM gobernador LIMIT 1";
                $gestorArchivo->borrarArchivo($sql, '');
                $newPathFile = $gestorArchivo->guardarFichero($archivo, $titulo);
                $this->UpdateSetBd($conexion, $titulo, $mensaje, $frase, $entrada, $enlaceVideo, $newPathFile);
                return;
            }
            $this->UpdateSetBd($conexion, $titulo, $mensaje, $frase, $entrada, $enlaceVideo);
        } catch (Throwable $e) {
            $this->handlerError($e);
        }
    }  

    private function UpdateSetBd(MySQLConnection $conexion, $titulo, $mensaje, $frase, $entrada, $enlaceVideo, $newPathFile = null)
    {
        $sql = "UPDATE gobernador_paginaprincipal SET titulo = :titulo, mensaje = :mensaje , entrada = :entrada, frase = :frase, $enlaceVideo = :enlace_video";
        $params[":titulo"] = $titulo;
        $params[":mensaje"] = $mensaje;
        $params[":entrada"] = $entrada;
        $params[":frase"] = $frase;
        $params[":enlace_video"] = $enlaceVideo;
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
        $campoRequerido = ['id', 'titulo', 'descripcion']; 
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
            $titulo = $this->SanitizeVarInput($_POST['titulo']);
            $descripcion = $this->SanitizeVarInput($_POST['descripcion']);

            $archivo = $_FILES["archivo"] ?? null;
            if ($gestorArchivo->validarArchivo($archivo, ['jpg', 'webp', 'jpeg']) == true) {
                $sql = "SELECT banner FROM banners WHERE id_page_principal = :id";
                $params["id"] = $id;
                $gestorArchivo->borrarArchivo($sql, $params);
                $newPathFile = $gestorArchivo->guardarFichero($archivo, $id);
                $this->updateBanner($conexion, $id,$titulo, $descripcion, $newPathFile);
                return;
            }
            $this->updateBanner($conexion, $id, $titulo, $descripcion);
        } catch (Throwable $e) {
            $this->handlerError($e);
        }
    }    

    private function updateBanner ($conexion, $id, $titulo, $descripcion, $newPathFile = null) 
    {   
        $sql = "UPDATE banners_paginaprincipal SET titulo_banner = :titulo, descripcion_banner = :descripcion";
        $params[":titulo"] = $titulo;
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
            if ($gestorArchivo->validarArchivo($archivo, ['jpg', 'gif', 'webp', 'jpeg']) == true) {
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
                $sql .= ", $campo = :$campo";
                $params[":$campo"] = $$campo;
            }

            if ($newPathFile !== '') {
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

    public function insertModal()
    {
        try {
            $conexion = new MySQLConnection();
            $gestorArchivo = new AdministrarArchivos($conexion, '');
            $gestorArchivo->setRuta( _ROOT_PATH . '/assets/images/modal/');

            $descripcion = $this->SanitizeVarInput($_POST['descripcion']);
            $archivo = $_FILES['archivo'] ?? null; 
            if($gestorArchivo->validarArchivo($archivo, ['webp', 'jpg', 'gif', 'jpeg']) == true){
                $sql = "INSERT INTO modal_paginaprincipal (img, descripcion) VALUES (?,?)";
                $newPathFile = $gestorArchivo->guardarFichero($archivo, 'Modal');
                $params = [$newPathFile, $descripcion];
                $conexion->query($sql, $params);
                $respuesta = array ('status'=>'success', 'message'=>'Registro guardado con éxito.');
                echo (json_encode($respuesta));
            }
        } catch(Throwable $e) {
            $this->handlerError($e);
        }
    }

    public function datosModal()
    {
        try {
            $conexion = new MySQLConnection ();
            $gestorArchivo = new AdministrarArchivos($conexion, '');
            $gestorArchivo->setRuta( _ROOT_PATH . '/assets/images/modal/');
            
            $id = $this->SanitizeVarInput($_POST['id']); 
            $descripcion = $this->SanitizeVarInput($_POST['descripcion']);
            $archivo = $_FILES['archivo'] ?? null;
            if ($gestorArchivo->validarArchivo($archivo, ['jpg', 'gif', 'webp', 'jpeg']) !== true) {
             return;
            }
            $sql = "SELECT img FROM modal_paginaprincipal WHERE id_modal = ?";
            $params = [$id];
            $gestorArchivo->borrarArchivo($sql, $params, '', false);
            $newPathFile = $gestorArchivo->guardarFichero($archivo, 'Modal');
            $this->updateModal($conexion, $id, $descripcion, $newPathFile);
        } catch (Throwable $e) {
            $this->handlerError($e);
        }
    }

    private function updateModal(MySQLConnection $conexion, $id, $descripcion, $img)
    {
        $sqlUpdate = "UPDATE modal_paginaprincipal SET descripcion = :descripcion";
        $params[':descripcion'] = $descripcion;
        if ($img !== ''){
            $sqlUpdate .= ", img= :img";
            $params[':img'] = $img;
        }
        $sqlUpdate .= " WHERE id_modal = :id_modal";
        $params[':id_modal'] = $id;
        try {
            $conexion->query($sqlUpdate, $params, '', false);
            $respuesta = array ('status'=>'success', 'message'=>'Registro actualizado con éxito.');
            echo (json_encode($respuesta));
        } catch (Throwable $e) {
            $this->SanitizeVarInput($e);
            echo (json_encode(['status'=>'error', 'message'=>'No se pudo actualizar el modal']));
        }
    }

    public function elimarModal()
    {
        try{
            $id = (empty($_POST['id'])) ? '' : $_POST['id'];
            $conexion = new MySQLConnection();
            $gestorArchivo = new AdministrarArchivos($conexion, '');
            $gestorArchivo->setRuta( _ROOT_PATH . '/assets/images/modal/');
            $sql = "SELECT img FROM modal_paginaprincipal WHERE id_modal = ?";
            $params = [$id];
            $stmt = $conexion->query($sql, $params, '', false); 
            $resultado = $stmt->fetchColumn();
            if ($resultado === false){
                $respuesta = array("status"=>"error", "message"=>"El modal que pretende eliminar no existe.");
                echo (json_encode($respuesta));
                return;
            }
            $gestorArchivo->borrarArchivo($sql, $params, '', false);
            $deleteSql = "DELETE FROM modal_paginaprincipal WHERE id_modal = ?";
            $deleteParams = [$id];
            $conexion->query($deleteSql, $deleteParams,  '', false);
            $respuesta = array("status" => "success", "message" => "Modal borrado de manera exitosa");
            echo(json_encode($respuesta));
        } catch (Throwable $e) {
            $this->handlerError($e);
            $respuesta = array ("status" =>"error", ""=>"En este momento el servicio no esta disponible. Consulte con el administrador del sitio web.");
            echo (json_encode($respuesta));
        }
    }
}