<?php
require_once ( _ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once ( _ROOT_MODEL . 'conexion.php');

class Mainpage extends  handleSanitize {

    private $rutaAssets;

    public function __construct()
    {
        $this->rutaAssets = _ROOT_ASSETS_ADMIN;
    }

    public function AdministrarPaginaPrincipal() 
    {
        $ruta = $this->rutaAssets . 'js/Inicio.js';

        $html = <<<Html
            <div class="row w-100 mt-2">
                <div class="col-md-5">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Gobernador</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <form id="gobernador">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="titulo">Título</label>
                                    <input type="text" id="titulo" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label for="mensajeGobernador">Mensaje</label>
                                    <textarea id="mensajeGobernador" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="fraseGobernador">Frase</label>
                                    <input type="text" id="fraseGobernador" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label for="inputProjectLeader">Project Leader</label>
                                    <input type="text" id="inputProjectLeader" class="form-control" value="">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card card-info table-responsive">
                        <div class="card-header">
                            <h3 class="card-title">Banners</h3>         
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right py-0 align-middle">
                                            <div class="btn-group btn-group-sm">
                                                <a id="verImage" href="#" class="btn btn-info" alt="verImagen"><i class="fas fa-eye"></i></a>
                                                <a id="editarBanner"href="#" class="btn btn-danger" alt="editar banner"><i class="fas fa-edit"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Banners</h3>         
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0 table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Cargo</th>
                                        <th>Imagen</th>
                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th>Facebook</th>
                                        <th>Twitter</th>
                                        <th>Linkedin</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right py-0 align-middle">
                                            <div class="btn-group btn-group-sm">
                                                <a id="editarBanner"href="#" class="btn btn-danger" alt="editar banner"><i class="fas fa-edit"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>      
        Html;
        return $html;
    }
    
}