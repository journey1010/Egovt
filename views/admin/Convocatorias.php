<?php

use PhpOffice\PhpSpreadsheet\Helper\Html;

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
                            <input type="date" class="form-control" id="fechaLimiteConvocatoria" value="" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="fechaFinalConvocatoria">Fecha de finalización de convocatoria (obligatorio)</label>
                            <input type="date" class="form-control" id="fechaFinalConvocatoria" value="" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="tipo de obra">Dependencia (obligatorio)</label>
                            <select id="dependenciaConvocatoria"class="form-control select2 select2-hidden-accessible" data-placeholder="Seleccione una dependencia" style="width: 100%; 
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
                            <label for="descripcion">Descripción (Obligatorio)</label>
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
                    <button type="submit" class="btn btn-primary mt-2" id="guardarConvocatoria">Guardar</button>
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
        $tabla = $this->listadoConvocatorias();
        $html = <<<Html
        <div class="card card-success mt-3 mx-auto w-100">
            <div class="card-header">
                <h3 class="card-title">Actualizar Registros</h3>
            </div>
            <div class="card-body table-responsive p-2 mt-3 mx-auto">
                $tabla
            </div>
        </div>
        <script  type ="module" src="$ruta"></script>
        Html;
        return $html;
    }

    /**
     * Obtiene la lista de oficinas disponibles, para
     * usarse en el registro de convocatorias
     * @return string
    */

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

    
    private function listadoConvocatorias(): string
    {
        $sql = "SELECT id, titulo, descripcion, fecha_registro, fecha_finalizacion FROM convocatorias WHERE estado IN (1,2)";
        $stmt = $this->conexion->query($sql, '', '', false);
        $resultado = $this->makeTblForConvocatoria($stmt->fetchAll());
        return $resultado;
    }

    /**
     * Crea una tabla con las convocatorias disponibles 
     * y que estan habilitadas para editarse
     * @param array $resultado 
     * @return string 
    */  

    private function makeTblForConvocatoria($resultado): string 
    {
        $tablaRow = '';
        foreach ($resultado as $row ) {         
            $tablaRow .= <<<Html
            <tr>
                <td class='text-center'>{$row['id']}</td>
                <td class='text-center'>{$row['titulo']}</td>
                <td class='text-center' style='max-width: 300px;'>{$row['descripcion']}</td>
                <td class='text-center'>{$row['fecha_registro']}</td>
                <td class='text-center'>{$row['fecha_finalizacion']}</td>
                <td class="text-center align-middle">
                    <i class="fa fa-edit mr-2 edit-ico-upconv" style="color:#9c74dd !important"></i>
                    <i class="fa fa-window-close fa-lg cancel-ico-upconv" style="color: #b40404; --fa-secondary-color: #c7fbff; display:none;"></i>
                </td>
            </tr>
            Html;
        }

        $tabla = <<<Html
        <table class="table table-hover table-md w-100" id="resultadosBusquedaObras">
            <thead class="table-bordered" >
                <tr>
                    <th class="text-center">N#</th>
                    <th class="text-center">Titulo</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Inicio</th>
                    <th class="text-center">Finalización</th>
                    <th style="width: 80px" class="text-center ">Editar</th>
                </tr>
            </thead>
            <tbody>
                $tablaRow
            </tbody>
        </table>  
        Html;  
        return $tabla;
    }
}