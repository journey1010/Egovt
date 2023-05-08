<?php

require_once(_ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once(_ROOT_MODEL . 'conexion.php');

class RRHHasistencia extends  handleSanitize 
{
    private $rutaAssets;

    public function __construct()
    {
        $this->rutaAssets = _ROOT_ASSETS_ADMIN;
    }

    public function loadFile() 
    {
        $ruta = $this->rutaAssets . 'js/asistencia.js';
        $html = <<<Html
        <div class="card card-warning mt-3 mx-auto w-100">
            <div class="card-header">
                <h3 class="card-title">Cargar registro de asistencias</h3>
            </div>
            <form id="registrarArchivoAsistencias" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="archivoObra">Seleccione un archivo *</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="archivoAsistencias" onchange="
                                    if (this.files.length > 0) {
                                        document.querySelector('.custom-file-label').innerHTML = this.files[0].name
                                    } else {
                                            document.querySelector('.custom-file-label').innerHTML = 'Seleccione un archivo'
                                    }
                                ">
                                <label class="custom-file-label" for="archivoAsistencias" data-browse="Elegir archivo">Elegir archivo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-3">
                    <label>Carga de archivo</label>
                    <div class="progress">
                        <div class="progress-bar active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; border-radius: 10px;">
                            0%
                        </div>
                    </div>
                    <div id ="registro-marcacion" style="display: none">
                        <label>Subiendo registros de marcación</label>
                        <div class="progress">
                            <div class="progress-bar active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; border-radius: 10px;">
                                0%
                            </div>
                        </div>
                    </div>
                    <div id ="reasignacion-registros-marcacion" style="display: none">
                        <label>Filtrando y reasignando registros de marcación</label>
                        <div class="progress">
                            <div class="progress-bar active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; border-radius: 10px;">
                                0%
                            </div>
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

    public function verRegistros()
    {
        $ruta = $this->rutaAssets . 'js/asistencia.js';
        $oficinas = $this->getOficinas();
        $inputHasta = date('Y-m-d');
        $html = <<<Html
        <div class="card card-warning mt-3 mx-auto w-100">
            <div class="card-header">
                <h3 class="card-title">Visualizar registros</h3>
            </div>
            <div class="container-fluid">
                <form action="verRegistroAsistencia">
                    <div class="row">
                        <div class="col-lg">
                            <div class="row bg-light">
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Oficina :</label>
                                        <select class="select2" style="width: 100%;" id="oficinaAsistencia">
                                            <option value="" selected>Seleccionar oficina</option>
                                            $oficinas
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Fecha Desde:</label>
                                        <input type="date" class="form-control" id="fechaAsistenciaDesde" value="$inputHasta">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Fecha Hasta:</label>
                                        <input type="date" class="form-control" id="fechaAsistenciaHasta" value="$inputHasta">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Ordenar:</label>
                                        <select class="select2" style="width: 100%;" id="orderByAsistencia">
                                            <option value="" selected>Seleccionar</option>
                                            <option value="DESC">DESC</option>
                                            <option value="ASC">ASC</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-6">
                                    <label class="text-light">a</label>
                                    <div class="form-group align-self-end d-flex">
                                        <button type="button" class="form-control btn btn-primary mr-2" id="aplicarFiltroAsistencia">Aplicar filtros</button>
                                        <button type="button" class="form-control btn btn-secondary" id="limpiarFiltroAsistencia">Limpiar filtros</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div class="input-group input-group-lg">
                                    <input type="search" class="form-control form-control-lg" placeholder="Filtrar por codigo de trabajador" id="palabraClaveAsistencia" value="">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-lg btn-default" id="buscarIdEmpleado">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2" id ="reporte-marcacion">
                                <label>Generando reporte de marcación</label>
                                <div class="progress">
                                    <div class="progress-bar active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; border-radius: 10px;">
                                        0%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body p-2 mt-3 mx-auto" id="respuestaBusquedaAsistencias" style="display:none">     
            </div>
        </div>
        <script  type ="module" src="$ruta"></script>
        Html;
        return $html;
    }

    private function getOficinas()
    {
        $oficinas = array (
            "OFICINA DE ADMINISRACION DEL COMITE DE SEGURIDAD Y SALUD EN EL TRABAJO",
            "OFICINA EJECUTIVA DE LOGISTICA", 
            "OFICINA EJECUTIVA DE MAQUINARIA", 
            "OFICINA EJECUTIVA DE TESORERIA", 
            "OFICINA DE PARTICIPACION CUIDADANA", 
            "RECURSOS HUMANOS", 
            "SUB GERENCIA REGIONAL DE CONSERVACION Y DIVERSIDAD BIOLOGICA", 
            "OFICINA EJECUTIVA DE SISTEMA DE PRESUPUESTO", 
            "OFICINA REGIONAL DE IMAGEN", 
            "GERENCIA REGIONAL DEL AMBIENTE", 
            "ORGANO DE CONTROL INSTITUCIONAL", 
            "OFICINA EJECUTIVA DE CONTABILIDAD", 
            "OFICINA EJECUTIVA DE GESTION DOCUMENTAL Y ANTENCION AL CIUDADANO", 
            "PROCURADURIA", 
            "OFICINA EJECUTIVA DE DESARROLLO INSTITUCIONAL Y PROCESOS", 
            "GOBERNACION", 
            "GERENCIA REGIONAL DE DESARROLLO SOCIAL", 
            "SUB GERENCIA REGIONAL DE GESTION AMBIENTAL", 
            "OFICINA EJECUTIVA DE PROGRAMACION MULTIANUAL DE INVERSIONES", 
            "GERENCIA REGIONAL DE DESARROLLO FORESTAL Y DE FAUNA SILVESTRE", 
            "SUB GERENCIA REGIONAL DE PROGRAMAS SOCIALES", 
            "REPRESETANTE DE TRABAJADORES - CAFAE - GOREL", 
            "SUB GERENCIA REGIONAL DE SUPERVICION Y CONTROL DE OBRAS", 
            "OFICINA EJECUTIVA DE INFRAESTRUCTURA TECNOLOGICA", 
            "OFICINA EJECUTIVA DE PLANEAMIENTO Y ESTADISTICAS", 
            "GERENCIA REGIONAL DE PLANEAMIENTO, PRESUPUESTO E INVERSION PUBLICA", 
            "VICE GOBERNACION", 
            "PROGRAMA REGIONAL DE CREDITO", 
            "OFICINA EJECUTIVA DE CONTROL PATRIMONIAL", 
            "UNIDAD FORMULADORA - CEDE CENTRAL",
            "SUB GERENCIA REGIONAL DE PROMOCION DE INVERSIONES", 
            "SUB GERENCIA REGIONAL DE OBRAS", 
            "GERENCIA REGIONAL DE DESARROLLO ECONOMICO", 
            "OFICINA EJECUTIVA DE COBRANZA COACTIVA", 
            "GERENCIA GENERAL", 
            "GERENCIA DE ADMINISTRACION", 
            "GERENCIA REGIONAL DE TECNOLOGIA DE LA INFORMACION", 
            "TRANSPARENCIA", 
            "OFICINA EJECUTIVA DE ACONDICIONAMIENTO TERRITORIAL Y DESARROLLO FRONTERIZO", 
            "SUB GERENCIA REGIONAL DE PROMOCION CULTURAL Y DEPORTE", 
            "SUB GERENCIA REGIONAL DE PROMOCION COMERCIAL", 
            "ASESORIA JURIDICA", 
            "OFICINA REGIONAL DE DIALOGO, PREVENCION Y GESTION DE CONFLICTOS SOCIALES", 
            "SECRETARIO GENERAL DEL SINDICATO UNICO DE TRABAJADORES DE LA CEDE CENTRAL Y SUB REGIONALES", 
            "GERENCIA REGIONAL DE INFRAESTRUCTURA", 
            "DIRECCION REGIONAL DE DESARROLLO E INCLUSION SOCIAL", 
            "SUB GERENCIA REGIONAL DE ESTUDIO Y PROYECTOS", 
            "GERTIT", 
            "SUB GERENCIA REGIONAL DE SUPERVISION , FISCALIZACION Y CONTROL FORESTAL Y DE FUANA SILVESTRE", 
            "OFICINA EJECUTIVA DE SISTEMA DE INFORMACION", 
            "SUB GERENCIA REGIONAL DE ORDENAMIENTO TERRITORIAL Y DATOS ESPACIALES"
        );
        $options= '';
        foreach($oficinas as $row) {
            $nombre = $row;
            $options .="<option value='$nombre'>$nombre</option>";
        }
        return $options;
    }
}