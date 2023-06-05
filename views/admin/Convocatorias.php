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

    public function RegistrarConvocatoria()
    {
        $ruta = $this->rutaAssets . 'js/convocatorias.js';
        $optionsDependencias = $this->getDependencias();
        $html = <<<Html
        <div class="card card-success mt-3 mx-auto w-100">
            <div class="card-header">
                <h3 class="card-title">Registrar convocatoria/h3>
            </div>
            <form id="registrarConvocatoria" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="titulo">Título (obligatorio)</label>
                            <input type="text" class="form-control" id="tituloConvocatoria" placeholder="Ingrese el título ..." maxlength="300">
                        </div>
                        <div class="col-md-6">
                            <label for="descripcion">Descripción (obligatorio)</label>
                            <input type="date" class="form-control" id="fechaObra" value="">
                        </div>
                        <div class="col-md-6">
                            <label for="tipo de obra">Dependencia (obligatorio)</label>
                            <select class="form-control select2 select2-hidden-accessible" data-placeholder="Seleccione una dependencia" style="width: 100%; 
                                height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true">
                                $optionsDependencias
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="archivoObra">Seleccione un archivo *</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="archivoObra" onchange="
                                    if (this.files.length > 0) {
                                        document.querySelector('.custom-file-label').innerHTML = this.files[0].name
                                    } else {
                                            document.querySelector('.custom-file-label').innerHTML = 'Seleccione un archivo'
                                    }
                                ">
                                <label class="custom-file-label" for="archivoObra" data-browse="Elegir archivo">Elegir archivo</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="HoraIngreso">Fecha de documento *</label>
                            <input type="date" class="form-control" id="fechaObra" value="">
                        </div>
                        <div class="col-md-12">
                            <label for="descripcion">Descripción *</label>
                            <textarea type="text" class="form-control text-content" id="descripcionObra" placeholder="Por favor ingrese una descripción..." style="min-height: 100px; max-width: 100%"></textarea>
                            <div id="contadorPalabras" style="color: red;"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-3">
                    <div class="progress">
                        <div class="progress-bar active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; border-radius: 10px;">
                            0%
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Guardar</button>
                </div>
        </form>
        </div>
        <script type ="module" src="$ruta" defer></script>
        Html;
        return $html; 
    }

    public function ActualizarConvocatorias()
    {

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