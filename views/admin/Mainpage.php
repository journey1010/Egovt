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
        $ruta = $this->rutaAssets . 'js/Mainpage.js';
        
        $conexion = new MySQLConnection();
        list($titulo, $mensaje, $frase, $entrada) = $this->getInfoGobernador($conexion);
        $tablaBanner = $this->getInfoBanners($conexion);
        $tablaDirectorio = $this->getInfoDirector($conexion);
        $tablaModal = $this->getInfoModal($conexion);

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
                            <label for="entradaGobernador">Entrada</label>
                            <textarea id="entradaGobernador" class="form-control" rows="4">$entrada</textarea>
                        </div>
                        <div class="form-group">
                            <label for="mensajeGobernador">Mensaje</label>
                            <textarea id="mensajeGobernador" class="form-control" rows="4">$mensaje</textarea>
                        </div>
                        <div class="form-group">
                            <label for="fraseGobernador">Frase</label>
                            <input type="text" id="fraseGobernador" class="form-control" value="$frase">
                        </div>
                        <div class="form-group">
                            <label for="imgGobernador">Imagen Gobernador</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="imgGobernador" onchange= "
                                    if (this.files.length > 0) {
                                        document.querySelector('.custom-file-label').innerHTML = this.files[0].name
                                    } else {
                                        document.querySelector('.custom-file-label').innerHTML = 'Seleccione un archivo'
                                    }
                                ">
                                <label class="custom-file-label text-left" for="imgGobernador" data-browse="Elegir archivo">Elegir archivo</label>
                            </div>
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
                                    <th style="min-width:300px">Imagen</th>
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
            <div class="col-md-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Modal de página principal</h3>         
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover table-modal">
                            <thead>
                                <tr>
                                    <th class= "text-center" style="width: 10px">Id</th>
                                    <th class= "text-center" style="min-width:300px">Imagen</th>
                                    <th class= "text-center">Descripcion</th>
                                    <th class= "text-center"><a class="btn btn-primary btn-sm insert-modal" alt="Insertar" title="Insertar modal"><i class="fa fa-plus-circle"></i></a></th>
                                </tr>
                            </thead>
                            <tbody>
                                $tablaModal
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>            
        </div>
        <script type ="module" src="$ruta"></script>      
        Html;
        return $html;
    }

    private function getInfoGobernador(MySQLConnection $conexion): array 
    {
        $sql = "SELECT titulo, mensaje, entrada, frase FROM gobernador_paginaprincipal LIMIT 1";
        $stmt = $conexion->query($sql, '', '', false);
        $row = $stmt->fetch();
        return [$row['titulo'], $row['mensaje'], $row['frase'], $row['entrada']];
    }

    private function getInfoBanners(MySQLConnection $conexion): string 
    {
        $sql = "SELECT * FROM banners_paginaprincipal";
        $stmt = $conexion->query($sql, '', '', false);
        $resultado = $stmt->fetchAll();
        $tablaRow = '';
        foreach ($resultado as $row) {
            $id = $row['id_page_principal'];
            $descripcion = $row['descripcion_banner'];
            $fileName = $row['banner'];
            $filePath = _BASE_URL . '/assets/images/banners/' .  $row['banner'];
            $tablaRow .= <<<html
            <tr>           
                <td class="text-center">$id</td>
                <td class="text-center" style="max-width: 300px;">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input imgBanner" id="imgBanner$id" onchange= "
                            let input = $(this).closest('tr').find('.custom-file-label');
                            if (this.files.length > 0) { 
                                input.html(this.files[0].name);
                            } else {
                                input.html('Seleccione un archivo');
                            }
                        ">
                        <label class="custom-file-label text-left" for="imgBanner$id" data-browse="Elegir archivo">$fileName</label>
                    </div>
                </td>
                <td class="text-center" style="max-width: 300px;" contenteditable="false">$descripcion</td>
                <td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                        <a href="#" class="btn btn-info imagen-link" alt="verImagen"><i class="fas fa-eye"></i></a>
                        <div class="modal imagen-modal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Banner</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img class="img-fluid" src="$filePath" alt="Imagen del modal">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                            </div>
                        </div>                      
                        <a class="btn btn-danger edit-link" alt="editar banner"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger cancel-link" alt="editar banner" style="display: none!important"> <i class="fas fa-times"></i></a>
                        <a class="btn btn-danger save-link" alt="editar banner" style="display: none!important"><i class="fas fa-save"></i></a>
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
                <td class="text-left" contenteditable="false" style="min-width: 200px">{$row['nombre']}</td>
                <td class="text-left" contenteditable="false" style="min-width: 200px">{$row['cargo']}</td>
                <td class="text-left">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input imgDirectorio" id="imgDirectorio{$row['id_directorio']}" onchange= "
                            let input = $(this).closest('tr').find('.custom-file-label');
                            if (this.files.length > 0) { 
                                input.html(this.files[0].name);
                            } else {
                                input.html('Seleccione un archivo');
                            }
                        ">
                        <label class="custom-file-label text-left" for="imgDirectorio{$row['id_directorio']}" data-browse="Archivo">{$row['imagen']}</label>
                    </div>
                </td>
                <td class="text-left" contenteditable="false" style="color: blue">{$row['telefono']}</td>
                <td class="text-left" contenteditable="false" style="color: blue">{$row['correo']}</td>
                <td class="text-left" contenteditable="false" style="color: blue">{$row['facebook']}</td>
                <td class="text-left" contenteditable="false" style="color: blue">{$row['twitter']}</td>
                <td class="text-left" contenteditable="false" style="color: blue">{$row['linkedin']}</td>
                <td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                        <a class="btn btn-danger edit-directorio" alt="editar directorio" tittle=""><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger cancel-directorio" alt="editar directorio" style="display: none!important"> <i class="fas fa-times"></i></a>
                        <a class="btn btn-danger save-directorio" alt="editar directorio" style="display: none!important"><i class="fas fa-save"></i></a>
                    </div>
                </td>
            </tr>
            html;
        }
        return $tablaRow;
    }  

    private function getInfoModal(MySQLConnection $conexion): String
    {   
        $sql = "SELECT * FROM modal_paginaprincipal";
        $stmt = $conexion->query($sql, '', '', false);
        $resultado = $stmt->fetchAll();
        $tablaRow = '';
        foreach ($resultado  as $row) {
            $tablaRow .= <<<html
            <tr>
                <td>{$row['id_modal']}</td>
                <td class="text-left">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input imgModal" id="imgModal{$row['id_modal']}" onchange= "
                            let input = $(this).closest('tr').find('.custom-file-label');
                            if (this.files.length > 0) { 
                                input.html(this.files[0].name);
                            } else {
                                input.html('Seleccione un archivo');
                            }
                        ">
                        <label class="custom-file-label text-left" for="imgModal{$row['id_modal']}" data-browse="Archivo">{$row['img']}</label>
                    </div>
                </td>
                <td class="text-center" contenteditable="false">{$row['descripcion']}</td>
                <td class="text-right py-0 align-middle">
                    <div class="btn-group btn-group-sm">
                        <a class="btn btn-danger edit-modal" alt="editar modal" title="Editar Modal"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-danger cancel-modal" alt="cancelar modal" title="Cancelar edición Modal" style="display: none!important"> <i class="fas fa-times"></i></a>
                        <a class="btn btn-danger save-modal" alt="Guardar modal" title="Guardar cambios" style="display: none!important"><i class="fas fa-save"></i></a>
                        <a class="btn btn-danger delete-modal" alt="eliminar modal" title="Eliminar Modal" style="display: none!important"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </td>
            </tr>
            html;
        }
        return $tablaRow;
    }  
}