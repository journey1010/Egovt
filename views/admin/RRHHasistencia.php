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

    public function verRegistros()
    {
        $ruta = $this->rutaAssets . 'js/asistencia.js';
        $oficinas = $this->getOficinas();
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
                                            $oficinas
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Fecha :</label>
                                        <input type="date" class="form-control" id="fechaObraActualizar" value="">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Ordenar:</label>
                                        <select class="select2" style="width: 100%;" id="orderBy">
                                            <option value="" selected>Seleccionar</option>
                                            <option value="DESC">DESC</option>
                                            <option value="ASC">ASC</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label class="text-light">a</label>
                                    <div class="form-group align-self-end d-flex">
                                        <button type="button" class="form-control btn btn-primary mr-2" id="aplicarFiltro">Aplicar filtros</button>
                                        <button type="button" class="form-control btn btn-secondary" id="limpiarFiltro">Limpiar filtros</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div class="input-group input-group-lg">
                                    <input type="search" class="form-control form-control-lg" placeholder="Filtrar por palabra clave" id="palabraClave" value="">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-lg btn-default" id="buscarPalabra">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="spinner" class="mt-1" style="display:none;">
                                    <i class="fa fa-spinner fa-spin"></i> Cargando...
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body table-responsive p-2 mt-3 mx-auto" id="respuestaBusquedaAsistencias">     
            </div>
        </div>
        <script  type ="module" src="$ruta"></script>
        Html;
        return $html;
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