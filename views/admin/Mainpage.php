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
        
        $conexion = new MySQLConnection();
        list($titulo, $mensaje, $frase) = $this->getInfoGobernador($conexion);
        $tablaBanner = $this->getInfoBanners($conexion);
        $tablaDirectorio = $this->getInfoDirector($conexion);

        $html = <<<Html
            <div class="row w-100 mt-2">
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Gobernador</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>                        
                        <div class="card-body">
                            <div class="form-group">
                                <label for="titulo">Título</label>
                                <input type="text" id="titulo" class="form-control" value="$titulo">
                            </div>
                            <div class="form-group">
                                <label for="mensajeGobernador">Mensaje</label>
                                <textarea id="mensajeGobernador" class="form-control" rows="4">$mensaje</textarea>
                            </div>
                            <div class="form-group">
                                <label for="fraseGobernador">Frase</label>
                                <input type="text" id="fraseGobernador" class="form-control" value="$frase">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button id="editGobernador" type="button" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-info table-responsive">
                        <div class="card-header">
                            <h3 class="card-title">Banners</h3>         
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0 table-responsive">
                            <table class="table table-hover ">
                                <thead>
                                    <tr>
                                        <th style ="width: 8px">Id</th>
                                        <th style ="width: 300px">Nombre</th>
                                        <th>Descripcion</th>
                                        <th style = "width: 10px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    $tablaBanner
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Directorio</h3>         
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
                                        <th style="width: 10px">Id</th>
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
                                    $tablaDirectorio
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>      
        Html;
        return $html;
    }

    private function getInfoGobernador(MySQLConnection $conexion): array 
    {
        $sql = "SELECT titulo, mensaje, frase FROM gobernador LIMIT 1";
        $stmt = $conexion->query($sql, '', '', false);
        $row = $stmt->fetch();
        return [$row['titulo'], $row['mensaje'], $row['frase']];
    }

    private function getInfoBanners(MySQLConnection $conexion): string 
    {
        $sql = "SELECT * FROM banners";
        $stmt = $conexion->query($sql, '', '', false);
        $resultado = $stmt->fetchAll();
        $tablaRow = '';
        foreach ($resultado as $row) {
            $id = $row['id_page_principal'];
            $descripcion = $row['descripcion_banner'];
            $fileName = $row['banner'];
            $tablaRow .= <<<html
            <tr>           
                <td class="text-center">$id</td>
                <td class="text-center" style="max-width: 300px;">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="imgBanner" onchange= "
                            if (this.files.length > 0) {
                                document.querySelector('.custom-file-label').innerHTML = this.files[0].name
                            } else {
                                document.querySelector('.custom-file-label').innerHTML = 'Seleccione un archivo'
                            }
                        ">
                        <label class="custom-file-label text-left" for="imgBanner" data-browse="Elegir archivo">$fileName</label>
                    </div>
                </td>
                <td class="text-center" style="max-width: 300px;" contenteditable="false">$descripcion</td>
                <td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                        <a id="verImage" href="#" class="btn btn-info" alt="verImagen"><i class="fas fa-eye"></i></a>
                        <a id="editarBanner"href="#" class="btn btn-danger" alt="editar banner"><i class="fas fa-edit"></i></a>
                    </div>
                </td>
            </tr>            
            html;
        }
        return $tablaRow;
    }

    private function getInfoDirector(MySQLConnection $conexion): string 
    {   
        $sql = "SELECT * FROM directorio_paginaprincipal";
        $stmt = $conexion->query($sql, '', '', false);
        $resultado = $stmt->fetchAll();
        $tablaRow = '';
        foreach ($resultado  as $row) {
            $tablaRow .= <<<html
            <tr>
                <td>{$row['id_directorio']}</td>
                <td class="text-left" contenteditable="false" style="max-width: 200px">{$row['nombre']}</td>
                <td class="text-left" contenteditable="false" style="max-width: 200px">{$row['cargo']}</td>
                <td class="text-left">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="imgDirectorio" onchange= "
                            if (this.files.length > 0) {
                                document.querySelector('.custom-file-label').innerHTML = this.files[0].name
                            } else {
                                document.querySelector('.custom-file-label').innerHTML = 'Seleccione un archivo'
                            }
                        ">
                        <label class="custom-file-label text-left" for="imgBanner" data-browse="Elegir archivo">{$row['imagen']}</label>
                    </div>
                </td>
                <td class="text-left" contenteditable="false" style="max-width: 200px">{$row['telefono']}</td>
                <td class="text-left" contenteditable="false" style="max-width: 200px">{$row['correo']}</td>
                <td class="text-left" contenteditable="false" style="max-width: 200px">{$row['facebook']}</td>
                <td class="text-left" contenteditable="false" style="max-width: 200px">{$row['twitter']}</td>
                <td class="text-left" contenteditable="false" style="max-width: 200px">{$row['linkedin']}</td>
                <td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                        <a id="editarBanner"href="#" class="btn btn-danger" alt="editar banner"><i class="fas fa-edit"></i></a>
                    </div>
                </td>
            </tr>
            html;
        }
        return $tablaRow;
    }  
}