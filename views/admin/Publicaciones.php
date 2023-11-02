<?php

require_once(_ROOT_MODEL . 'conexion.php');

class Publicaciones
{

    public static function viewRegistrar()
    {
        $ruta = _ROOT_ASSETS_ADMIN .  'js/publicaciones.js';
        $html = '
            <style>
            hr.style-two {
                border: 0;
                height: 1px;
                background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
            }
            </style>
            <div class="container card mt-4 px-4 mb-4">
                <form id="publicacionesForm" enctype="multipart/form-data">
                    <div class="card-body row">
                        <div class=" col-12 mt-3 mb-">
                            <h3 class="text-monospace">Publicaciones <i class="fas fa-angle-right"></i> Registrar</h3>
                            <hr class="style-two">
                        </div>
                        <div class="col-md-4 col-sm-12 form-group">
                            <label class="form-label">Título</label>
                            <input type="text" class="form-control title-publicacion" maxlength="355" required>
                        </div>
                        <div class="col-md-4 col-sm-12 form-group">
                            <label class="form-label" for="publicacionFile">Archivos</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="publicacionFile" onchange="
                                if (this.files.length > 0) {
                                    document.querySelector(`.custom-file-label`).innerHTML = this.files.length + ` archivos seleccionados`;    
                                } else {
                                    document.querySelector(`.custom-file-label`).innerHTML =  `Seleccione un archivo`
                                } " multiple>
                                <label class="custom-file-label" for="publicacionFile" data-browse="Elegir archivo">Elegir archivo(s)</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 form-group">
                            <label class="form-label">Fecha Documentos</label>
                            <input type="date" class="form-control date-publicacion" maxlength="355" required>
                        </div>
                        <div class="col-md-5 col-sm-12 form-group">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control descripcion-publicacion" placeholder="Ingresar una descripcion"></textarea>
                        </div>
                        <div class="col-md-5 col-sm-12 form-group">
                            <label class="form-label">Tipo</label>
                            <select id="tipo-publicacion" aria-label="tipos de documentos" class="form-control select2"  style="width: 100%;">
                                <option value="Acta">Acta</option>
                                <option value="Acta de Sesión de Directorio">Acta de Sesión de Directorio</option>
                                <option value="Acta de Sesión Ordinaria">Acta de Sesión Ordinaria</option>
                                <option value="Acta de Sesión Ordinaria del Consejo Regional">Acta de Sesión Ordinaria del Consejo Regional</option>
                                <option value="Archivo">Archivo</option>
                                <option value="Artículo">Artículo</option>
                                <option value="Concurso público">Concurso público</option>
                                <option value="Convenio">Convenio</option>
                                <option value="Convocatorias de trabajo">Convocatorias de trabajo</option>
                                <option value="Cronograma">Cronograma</option>
                                <option value="Directorio">Directorio</option>
                                <option value="Documento de Gestión">Documento de Gestión</option>
                                <option value="Ficha">Ficha</option>
                                <option value="Formato">Formato</option>
                                <option value="Informe">Informe</option>
                                <option value="Informe Técnico Previo de Evaluación de Software">Informe Técnico Previo de Evaluación de Software</option>
                                <option value="Listado">Listado</option>
                                <option value="Manual">Manual</option>
                                <option value="Memorando">Memorando</option>
                                <option value="Oficio">Oficio</option>
                                <option value="Oficio múltiple">Oficio múltiple</option>
                                <option value="Plan">Plan</option>
                                <option value="Pronunciamiento">Pronunciamiento</option>
                                <option value="Proyecto">Proyecto</option>
                                <option value="TUPA">TUPA</option>
                                <option value="TUSNE">TUSNE</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6 form-group">
                            <label class="form-label" style="color: white;"> boton</label>
                            <button type="submit" class="btn btn-dark form-control btn-publicacion">Guardar</button>
                        </div>
                    </div>
                </form>
                <div class="progress mt-2 mb-3">
                    <div class="progress-bar active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; border-radius: 10px;">
                        0%
                    </div>
                </div>
            </div>
            <script>
                if (!window.publicacionesCargado) {
                    const script = document.createElement("script");
                    script.src = "'.$ruta.'";
                    script.type = "module";
                    document.body.appendChild(script);
                    window.saldoBalanceCargado = true;
                }    
            </script>
        ';
        return $html;
    }

    public static function viewEdit()
    {
        $ruta = _ROOT_ASSETS_ADMIN . 'js/publicaciones.js';
        $html = '
        <link rel="stylesheet" href=" '._ROOT_ASSETS_ADMIN . 'datatables-bs4/css/dataTables.bootstrao4.min.css' .'"
        <style>
            hr.style-two {
                border: 0;
                height: 1px;
                background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
            }
        </style>
        <div class="container card mt-4 px-4">
            <div class="card-body row">
                <div class="col-12 mt-3">
                    <h3 class="text-monospace">Publicaciones <i class="fas fa-angle-right"></i> Lista de publicaciones</h3>
                    <hr class="style-two">
                </div>
                <div class="row col-12">
                    <div class="col-12 mt-1">
                        <h3 class="text-monospace text-center"> Buscador </h3>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <label class="form-label">Título</label>
                        <input type="text" class="form-control title-post" maxlength="355" placeholder="Título">
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <label class="form-label">Palabra clave</label>
                        <input type="text" class="form-control description-post" maxlength="455" placeholder="Palabra clave">
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <label class="form-label">Tipo</label>
                        <select aria-label="tipos de documentos" class="form-control select2 type-post" style="width: 100%;">
                            <option value="Acta">Acta</option>
                            <option value="Acta de Sesión de Directorio">Acta de Sesión de Directorio</option>
                            <option value="Acta de Sesión Ordinaria">Acta de Sesión Ordinaria</option>
                            <option value="Acta de Sesión Ordinaria del Consejo Regional">Acta de Sesión Ordinaria del Consejo Regional</option>
                            <option value="Archivo">Archivo</option>
                            <option value="Artículo">Artículo</option>
                            <option value="Concurso público">Concurso público</option>
                            <option value="Convenio">Convenio</option>
                            <option value="Convocatorias de trabajo">Convocatorias de trabajo</option>
                            <option value="Cronograma">Cronograma</option>
                            <option value="Directorio">Directorio</option>
                            <option value="Documento de Gestión">Documento de Gestión</option>
                            <option value="Ficha">Ficha</option>
                            <option value="Formato">Formato</option>
                            <option value="Informe">Informe</option>
                            <option value="Informe Técnico Previo de Evaluación de Software">Informe Técnico Previo de Evaluación de Software</option>
                            <option value="Listado">Listado</option>
                            <option value="Manual">Manual</option>
                            <option value="Memorando">Memorando</option>
                            <option value="Oficio">Oficio</option>
                            <option value="Oficio múltiple">Oficio múltiple</option>
                            <option value="Plan">Plan</option>
                            <option value="Pronunciamiento">Pronunciamiento</option>
                            <option value="Proyecto">Proyecto</option>
                            <option value="TUPA">TUPA</option>
                            <option value="TUSNE">TUSNE</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <label class="form-label">Fecha de Publicación</label>
                        <input type="date" class="form-control date-post">
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <label class="form-label" style="color:white;">.</label>
                        <button type="submit" class="btn btn-primary btn-block form-control"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container card mt-4 px-4 mb-4">
            <div class="card-body row">
                <table id="list-public" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Título</th>
                            <th>Tipo de documento</th>
                            <th>Fecha Doc</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>a</td>
                            <td>a</td>
                            <td>a</td>
                            <td>a</td>
                            <td>a</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            if (!window.publicacionesCargado) {
                const script = document.createElement("script");
                script.src = "'.$ruta.'";
                script.type = "module";
                document.body.appendChild(script);
                window.publicacionesCargado = true;
            }    
        </script>
        <script>
            $(document).ready(function(){
                if(typeof tablePubli !== "undefined"){
                    const tablePubli = new DataTable("#list-public");
                }
            })
        </script>
        ';
        return $html;
    }
}