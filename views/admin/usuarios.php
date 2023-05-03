<?php 

require_once ( _ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once ( _ROOT_MODEL . 'conexion.php');

class usuarios extends handleSanitize {

    private $rutaAssets;

    public function __construct()
    {
        $this->rutaAssets = _ROOT_ASSETS_ADMIN;
    }

    public function RegistrarUsuarios() 
    {
        try {
            $ruta = $this->rutaAssets . 'js/usuarios.js';
            $selectOficinas = $this->getOficinas();
            $html = <<<Html
            <div class="card card-danger mt-3 mx-auto w-100">
                <div class="card-header">
                <h3 class="card-title">Registrar usuario</h3>
                </div>
                <form id="registrarUsuario">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="buscarDNI">DNI *</label>
                            <input type="number" class="form-control" id="dni" placeholder="Ingresar DNI..." required>
                        </div>
                        <button type="button" class="btn btn-secondary" id="searchDNI" >Buscar</button>
                        <div class="form-group">
                            <label for="labelUsuario">Usuario *</label>
                            <input type="text" class="form-control" id="nombre_usuario" placeholder="Ingrese nombre de usuario ...">
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="labelUsuario">Nombre *</label>
                                    <input type="text" class="form-control" id="nombre" placeholder="Ingrese su nombre">
                                </div>
                                <div class="col-md-4">
                                    <label for="apellidoPaterno">Apellido paterno *</label>
                                    <input type="text" class="form-control" id="apellido_paterno" placeholder="Ingrese su apellido paterno">
                                </div>
                                <div class="col-md-4">
                                    <label for="apellidoMaterno">Apellido materno *</label>
                                    <input aria-label="apellido materno" type="text" class="form-control" id="apellido_materno" placeholder="Ingrese su apellido materno">
                                </div>
                                <div class="col-md-4">
                                    <label for="contraseña">Contraseña *</label>
                                    <input type="password" class="form-control" id="contrasena" placeholder="Ingrese su contraseña" autocomplete="on">
                                </div>
                                <div class="col-md-4">
                                    <label for="numberTelefono">Número de teléfono</label>
                                    <input type="text" class="form-control" id="numero_telefono" placeholder="Ingrese su teléfono">
                                </div>
                                <div class="col-md-4">
                                    <label>Tipo de usuario *</label>
                                    <div class="form-group">
                                        <select id="tipoUsuario"aria-label="tiposUsuarios"class="form-control select2 select2-danger"  style="width: 100%;">
                                            <option selected="selected" value="admin">Super Administrador</option>
                                            <option value="subadmin">Administrador</option>
                                            <option value="visitor">Visitas</option>
                                            <option value="noticias">Noticias</option>
                                            <option value="obras">Obras</option>
                                            <option value="funcionarios">Funcionarios</option>
                                            <option value="rrhhasistencia">RRHH asistencia</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <label>Oficina</label>
                                <div class="form-group">
                                    <select id="oficinaUsuario"aria-label="oficinaUsuario"class="form-control select2 select2-danger"  style="width: 100%;">
                                        $selectOficinas
                                    </select>
                                </div>
                            </div>
                            </div>                    
                        </div>
    
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
            <script  type ="module" src="$ruta"></script>
            Html;
            return $html;
        } catch (Throwable $e ) {
            $this->handlerError($e);
        }
    }

    public function ActualizarUsuarios()
    {
        try { 
            $ruta = $this->rutaAssets . 'js/usuarios.js';
            $html = <<<Html
            <script  type ="module" src="$ruta"></script>
            Html;
            return $html;
        } catch (Throwable $e) {
            $this->handlerError($e);
        }
    }   

    private function getOficinas()
    {
        $conexion = new MySQLConnection();
        $sql = "SELECT id, CONCAT(nombre, ' ', sigla) AS nombre FROM oficinas";
        $stmt = $conexion->query($sql, '', '', false);
        $resultado = $stmt->fetchAll();
        
        $options= '';
        foreach($resultado as $row) {
            $id = $row['id'];
            $nombre = $row['nombre'];
            $options .="<option value='$id'>$nombre</option>";
        }
        return $options;
    }
}