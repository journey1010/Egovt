<?php 

require_once ( _ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once ( _ROOT_MODEL . 'conexion.php');

class Oficinas extends handleSanitize {

    private $rutaAssets;

    public function __construct()
    {
        $this->rutaAssets = _ROOT_ASSETS_ADMIN;
    }
    
    public function Oficinas()
    {
        $ruta = $this->rutaAssets .  'js/oficinas.js';
        $conexion = new MySQLConnection();
        $select = $this->getSelect($conexion);
        $table = $this->getTable($conexion);

        $html = <<<Html
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"/>
        <section class="container-fluid mt-3">
            <div class="card card-danger">
                <div class="card-header">
                <h3 class="card-title">Registrar oficina</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                <div class="card-body">
                    <form id="registrarOficina">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="tipoOrgano">Jerarquía</label>
                            <select id="tipoOrgano" class="form-control select2 select2-hidden-accessible" data-placeholder="Select a State" style="width: 100%; height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true" required>
                                $select
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="nombreOfi">Nombre</label>
                            <input aria-label="Nombre" type="text" class="form-control" id="nombreOfi" placeholder="Nombre de oficina" required>
                        </div>
                        <div class="col-md-4">
                            <label for="sigla">Sigla</label>
                            <input aria-label="sigla" type="text" class="form-control" id="sigla" placehoder="Ingrese sigla ..." required>
                        </div>
                        <div class="col-md-4 mt-2">
                            <button aria-label="botón guardar" type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="container-fluid mt-3">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Administrar oficinas</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                        <i class="fas fa-expand"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-header">
                        <h3 class="card-title text-center">Registro de oficinas</h3>
                    </div>
                    <div class="card-body table-responsive p-0 mt-2">
                    <table class="table table-hover table-sm" id="actualizarOficinas">
                        <thead class="bg-warning">
                            <th class="text-center">id</th>
                            <th class="text-center" contenteditable="false">Nombre</th>
                            <th class="text-center">jerarquia</th>
                            <th style="text-center" contenteditable="false">sigla</th>
                            <th style="width: 80px" class="text-center">Editar</th>
                        </thead>
                        <tbody>
                            $table
                        </tbody>
                    </table>
                    </div>  
                </div>
            </div>
        </section>
        <script type="module" src="$ruta"></script>
        <script defer>
            $(document).ready(function (){
                $.getScript('https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js', function (){
                   $('#actualizarOficinas').DataTable({
                        language: {
                            url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
                        }
                    });
                });
            })
        </script>
        Html;

        $conexion->close();
        return $html;
    }

    private function getSelect(MySQLConnection $conexion): string 
    {
        $sql = "SELECT DISTINCT jerarquia FROM oficinas";
        $smt = $conexion->query($sql, '', '', false);
        $resultado = $smt->fetchAll();
        $options  = '';
        foreach ($resultado as $row) {
            $jerarquia = $row['jerarquia'];
            $options .= "<option value='$jerarquia'>$jerarquia</options>";
        }
        return $options;
    }

    private function getTable (MySQLConnection $conexion): string 
    {
        $sql = "SELECT * FROM oficinas";
        $stmt =  $conexion->query($sql, '', '', false);
        $resultados = $stmt->fetchAll();

        $rows = '';
        foreach ($resultados  as $elementos) {
            $id = $elementos['id'];
            $nombre = $elementos['nombre'];
            $sigla = $elementos['sigla'];
            $jerarquia = $elementos['jerarquia'];
            $rows .= "<tr>";
            $rows .= "<td class=\"text-center\"style=\"max-width: 300px;\"  contenteditable=\"false\">$id</td>";
            $rows .= "<td class=\"text-center\"style=\"max-width: 300px;\" style=\"max-width: 300px;\" contenteditable=\"false\">$nombre</td>";
            $rows .= "<td class=\"text-center\"style=\"max-width: 300px;\" style=\"max-width: 300px;\" contenteditable=\"false\">$sigla</td>";
            $rows .= "<td class=\"text-center\"style=\"max-width: 300px;\" style=\"max-width: 300px;\" contenteditable=\"false\">$jerarquia</td>";
            $rows .= '
                <td class="text-center align-middle">
                    <i class="fa fa-edit mr-2 edit-icon" style="color:#9c74dd !important"></i>
                    <i class="fa fa-times mr-2 cancel-icon" style="color:#d90a0a !important; display:none;"></i>
                    <i class="fa fa-check save-icon" style="color:#acc90e !important; display:none;"></i>
                </td>
            ';
            $rows .= "</tr>";
        }

        return $rows;
    }
}