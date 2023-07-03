<?php

use PhpOffice\PhpSpreadsheet\Helper\Html;

require_once(_ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once(_ROOT_MODEL . 'conexion.php');

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
        $ruta = $this->rutaAssets . 'js/convocatoria.js?ver=1.1';
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
        foreach ($resultado  as $row) {
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
        foreach ($resultado as $row) {
            $tablaRow .= <<<Html
            <tr>
                <td class='text-center'>{$row['id']}</td>
                <td class='text-center'>{$row['titulo']}</td>
                <td class='text-center' style='max-width: 300px;'>{$row['descripcion']}</td>
                <td class='text-center'>{$row['fecha_registro']}</td>
                <td class='text-center'>{$row['fecha_finalizacion']}</td>
                <td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                        <a class="btn btn-outline-primary edit-ico-upconv" title="Editar Convocatoria"><i class="fa fa-edit"></i></a>
                    </div>
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

    /**
     * Vista de edición de convocatorias, contiene una plantilla para recibir los
     * datos generales de una convocatoria en especifico.
     *
     * @return string
     */
    public function viewEditGeneralConvocatoria($id, $titulo, $descripcion, $dependencia, $fechaR, $fechaL, $fechaF): string
    {
        $view = <<<Html
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Datos de convocatoria</h3>
                    </div>
                    <div class="card-body p-3">
                            <div id="datosGenerales" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="row row-cols-3">
                                    <div class="form-group col">
                                        <label for="tituloConvocatoria">Título</label>
                                        <input type="text" class="form-control" id="tituloConvocatoria" placeholder="Ingrese un título" value="$titulo">
                                        <input type="number" id="idConvocatoria" value="$id" style="display: none;">
                                    </div>
                                    <div class="form-group col">
                                        <label for="descripcionConvocatoria">Descripción</label>
                                        <input type="text" class="form-control" id="descripcionConvocatoria" placeholder="Ingrese una descripción" value="$descripcion">
                                    </div>
                                    <div class="form-group col">
                                        <label for="dependenciaConvocatoria">Dependencia</label>
                                        <select id="dependenciaConvocatoria" class="form-control select2 select2-hidden-accessible" style="width: 100%; 
                                        height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true">
                                            $dependencia
                                        </select>
                                    </div>
                                    <div class="form-group col">
                                        <label for="fechaRegistroConvocatoria">Fecha de registro</label>
                                        <input type="date" class="form-control" id="fechaRegistroConvocatoria" value="$fechaR">
                                    </div>
                                    <div class="form-group col">
                                        <label for="fechaLimiteConvocatoria">Fecha Limite</label>
                                        <input type="date" class="form-control" id="fechaLimiteConvocatoria" value="$fechaL">
                                    </div>
                                    <div class="form-group col">
                                        <label for="fechaFinalConvocatoria">Fecha Finalización</label>
                                        <input type="date" class="form-control" id="fechaFinalConvocatoria" value="$fechaF">
                                    </div>
                                </div>
                                <button id="saveGeneralDatos" class="btn btn-primary">Guardar</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        Html;
        return $view;
    }

    /**
     * Vista de edición de los documentos adjunstos de convocatoria, contiene una plantilla 
     * donde estarán todos los adjuntos de una convocatoria en especifico. 
     * @param array $
     * @return string
     */
    public function viewEditAdjuntosConvocatoria(array $adjuntosConvocatoria): string
    {
        $TableRows = '';
        foreach ($adjuntosConvocatoria as $row) {
            $url = _BASE_URL . '/files/transparencia/convocatorias/' . $row['archivo'];
            $TableRows .= <<<Html
            <tr>
                <td>{$row['id']}</td>
                <td class="text-center" contenteditable=false style="max-width:150px">{$row['nombre']}</td>
                <td>
                    <a class="btn btn-outline-dark" alt="documento de convocatoria" href="$url" download style="
                    word-break: break-word;">
                        Descargar <i class="fas fa-file-import"></i>
                    </a>
                </td>
                <td class="text-left">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input imgadjunto" id="docAdjunto{$row['id']}" onchange= "
                            let input = $(this).closest('tr').find('.custom-file-label');
                            if (this.files.length > 0) { 
                                input.html(this.files[0].name);
                            } else {
                                input.html('Seleccione un archivo');
                            }
                        " disabled>
                        <label class="custom-file-label text-left" for="docAdjunto{$row['id']}" data-browse="Archivo"></label>
                    </div>
                </td>
                <td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                        <a class="btn btn-danger edit-adjunto" alt="editar adjunto" title="Editar adjunto"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger cancel-adjunto" alt="cancelar adjunto" title="Cancelar edición adjunto" style="display: none!important"> <i class="fas fa-times"></i></a>
                        <a class="btn btn-danger save-adjunto" alt="Guardar adjunto" title="Guardar cambios" style="display: none!important"><i class="fas fa-save"></i></a>
                    </div>
                </td>
            </tr>
            Html;
        }
        $view = <<<Html
        <div class="row">
            <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Adjuntos de convocatoria</h3>
                </div>
                <div class="card-body p-3">
                    <div id="adjuntosConvocatoria" class="content table-responsive" role="tabpanel" aria-labelledby="logins-part-trigger">
                        <table class="table table-hover table-adjunto table-bordered">
                            <thead>
                                <tr>
                                    <th class= "text-center" style="width: 10px">Id</th>
                                    <th class= "text-center" style="max-width:150px">Nombre</th>
                                    <th class= "text-center" style="width: 160px">Ver Archivo</th>
                                    <th class= "text-center" style="max-width: 200px">Nuevo Archivo</th>
                                    <th class= "text-right py-0 align-middle">
                                        <a class="btn btn-primary btn-sm insert-adjunto" alt="Insertar" title="Insertar adjunto">
                                            <i class="fa fa-plus-circle"></i>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                $TableRows
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        Html;
        return $view;
    }

    /**
     * Une la vista de los documentos adjuntos de convocatoria y de los datos generales de una convotoria.
     * @param  string $viewGeneral, contiene la vista [con datos ] de edición de datos generales de convocatoria.
     * @param  string $viewAdjunto, contiene la vista [con datos] de los adjuntos.  
     * @return string $viweFinal
    */
    public function viewEditFinalConvocatoria(string $viewGeneral, string $viewAdjunto): string
    {
        $ruta = $this->rutaAssets . 'js/convocatoria.js';
        $viewFinal = <<<Html
        <div class="container  container-md">
            <div class="row row-cols-3 d-flex justify-content-between">
                <h4 class="font-weight-bold m-3">Zona Editor <i class="fas fa-angle-right"></i> Convocatorias</h4>
                <a class="btn btn-primary badge badge-dark align-self-center btn-block mr-2" name="sidebarEnlace' data-page="convocatoria/actualizar-convocatoria" href="/administrador/convocatoria/actualizar-convocatoria/" alt="Regresar a listata" title="Volver a lista de convocatorias" style="max-width: 200px">
                    <span class="text-md mr-2">Regresar</span><i class="fas fa-undo"></i>
                </a>
            </div>
            $viewGeneral
            $viewAdjunto
        </div>
        </div>
        <script type ="module" src="$ruta" defer></script>
        Html;
        return $viewFinal;
    }
}
