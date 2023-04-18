<?php 
require_once(_ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once(_ROOT_MODEL . 'conexion.php');

class funcionarios extends handleSanitize { 
    
    private $rutaAssets;

    public function __construct()
    {
        $this->rutaAssets = _ROOT_ASSETS_ADMIN;
    }

    public function RegistrarFuncionarios()
    {
        $ruta = $this->rutaAssets  . 'js/funcionario.js';
        $conexion = new MySQLConnection();

        $selectOficinas = $this->getOficinas($conexion); 
        
        $html = <<<Html
        <div class="card card-success mt-3 mx-auto w-100">
            <div class="card-header">
                <h3 class="card-title">Registrar de funcionarios</h3>
            </div>
            <form id="registrarFuncionario">
                    <div class="card-body">
                        <div class="form-group">
                        <label for="buscarDNI">DNI *</label>
                        <input type="number" class="form-control" id="dniVisita" placeholder="Ingresar DNI...">
                    </div>
                    <button type="submit" class="btn btn-secondary" id="BuscarDNIVisita">Buscar</button>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="labelNombreCompleto">Nombre completo *</label>
                            <input type="text" class="form-control" id="apellidos_nombres" placeholder="Ingrese su nombre completo">
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Oficina *</label>
                                <select id="oficinaFuncionario" class="form-control select2 select2-hidden-accessible" data-placeholder="Selecciona una oficina" style="width: 100%; 
                                    height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true">
                                    $selectOficinas
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Nivel *</label>
                                <select id="nivelFuncionario" class="form-control select2 select2-hidden-accessible" data-placeholder="Selecciona una oficina" style="width: 100%; 
                                    height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true">
                                   <option value ="1" >Jefe de oficina</option>
                                   <option value ="0" >Personal</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
        <script type ="module" src="$ruta"></script>
        Html;
        return $html;
    }

    public function ActualizarFuncionarios()
    {

    }

    private function getOficinas(MySQLConnection $conexion) 
    {   
        $sql = "SELECT CONCAT(id,'-', grupo ) AS id_ofi ,CONCAT(nombre, ' ', sigla) AS nombreCompleto FROM oficinas";
        $smt = $conexion->query($sql, '', '', false);
        $resultado = $smt->fetchAll();
        $options = '';
        foreach ($resultado as $row) {
            $id = $row['id_ofi'];
            $nombreCompleto = $row['nombreCompleto'];
            $options .= "<option value=\"$id\">$nombreCompleto</option>";
        }
        $conexion->close();
        return $options;
    }
}