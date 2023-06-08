<?php 

require_once ( _ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once ( _ROOT_MODEL . 'conexion.php');

class convocatorias extends handleSanitize 
{
    private $rutaAssets;
    private $conexion;

    public function __construct()
    {
        $this->rutaAssets = _ROOT_ASSETS_ADMIN;
        $this->conexion = new MySQLConnection();
    }

    public function RegistrarConvocatoria(): string
    {
        $ruta = $this->rutaAssets . 'js/convocatoria.js';
        $optionsDependencias = $this->getDependencias();
        $html = <<<Html
        <div class="card card-success mt-3 mx-auto w-100">
            <div class="card-header">
                <h3 class="card-title">Registrar convocatoria</h3>
            </div>
            <form id="registrarConvocatoria" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="titulo">Título (obligatorio)</label>
                            <input type="text" class="form-control" id="tituloConvocatoria" placeholder="Ingrese el título ..." maxlength="300">
                        </div>
                        <div class="col-md-6">
                            <label for="fechaInicioConvocatoria">Fecha Inicio (obligatorio)</label>
                            <input type="date" class="form-control" id="fechaInicioConvocatoria" value="">
                        </div>
                        <div class="col-md-6">
                            <label for="fechaLimiteConvocatoria">Fecha Limite de convocatoria (obligatorio)</label>
                            <input type="date" class="form-control" id="fechaLimiteConvocatoria" value="">
                        </div>
                        <div class="col-md-6">
                            <label for="fechaFinalConvocatoria">Fecha de finalización de convocatoria (obligatorio)</label>
                            <input type="date" class="form-control" id="fechaFinalConvocatoria" value="">
                        </div>
                        <div class="col-md-6">
                            <label for="tipo de obra">Dependencia (obligatorio)</label>
                            <select class="form-control select2 select2-hidden-accessible" data-placeholder="Seleccione una dependencia" style="width: 100%; 
                                height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true">
                                $optionsDependencias
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Seleccione uno o más archivos (Obligatorio)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="archivosConvocatorias" multiple onchange="
                                if (this.files.length > 0) {
                                    document.querySelector('.custom-file-label').innerHTML = this.files.length + ' archivos seleccionados';    
                                } else {
                                    document.querySelector('.custom-file-label').innerHTML = 'Seleccione un archivo'
                                }">
                                <label class="custom-file-label" for="archivosConvocatorias" data-browse="Elegir archivo">Elegir archivo</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="descripcion">Descripción *</label>
                            <textarea type="text" class="form-control text-content" id="descripcionConvocatoria" placeholder="Por favor ingrese una descripción..." style="min-height: 100px; max-width: 100%"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-3">
                    <div class="progress">
                        <div class="progress-bar active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; border-radius: 10px;">
                            0%
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2" id="guadarConvocatoria">Guardar</button>
                </div>
            </form>
        </div>
        <script type ="module" src="$ruta" defer></script>
        Html;
        return $html; 
    }

    public function ActualizarConvocatorias(): string 
    {
        $ruta = $this->rutaAssets . 'js/convocatoria.js';
        $html = <<<Html
        <div class="container">

        </div>

        Html;
        return $html;
    }

    private function getDependencias(): string 
    {
        $sql = "SELECT id, nombre, sigla FROM oficinas";
        $stmt = $this->conexion->query($sql, '', '', false);
        $resultado = $stmt->fetchAll();
        $optionSelect = '';
        foreach($resultado  as $row){
            $optionSelect .= "<option value='{$row['id']}'>{$row['nombre']} - {$row['sigla']}</option>";
        }
        return $optionSelect;
    }
}