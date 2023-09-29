<?php

require_once(_ROOT_MODEL . 'conexion.php');

class Participacion {

    public static function viewRegistrar()
    {
        $ruta = _ROOT_ASSETS_ADMIN .  'js/participacionCiudadana.js';
        $html = '
            <style>
            hr.style-two {
                border: 0;
                height: 1px;
                background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
            }
            </style>
            <div class="container card mt-4 px-4 mb-4">
                <form id="participacionCiudadanaForm" enctype="multipart/form-data">
                    <div class="card-body row">
                        <div class=" col-12 mt-3 mb-">
                            <h3 class="text-monospace">Participación Ciudadana <i class="fas fa-angle-right"></i> Registrar</h3>
                            <hr class="style-two">
                        </div>
                        <div class="col-md-5 col-sm-12 form-group">
                            <label class="form-label">Título</label>
                            <input type="text" class="form-control title-participacion" maxlength="355" required>
                        </div>
                        <div class="col-md-5 col-sm-12 form-group">
                            <label class="form-label" for="participacionFile">Archivo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="participacionFile" onchange="
                                if (this.files.length > 0) {
                                    document.querySelector(`.custom-file-label`).innerHTML = this.files.length + ` archivos seleccionados`;    
                                } else {
                                    document.querySelector(`.custom-file-label`).innerHTML =  `Seleccione un archivo`
                                } " multiple>
                                <label class="custom-file-label" for="participacionFile" data-browse="Elegir archivo">Elegir archivo(s)</label>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12 form-group">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control descripcion-participacion" placeholder="Ingresar una descripcion"></textarea>
                        </div>
                        <div class="col-md-5 col-sm-12 form-group">
                            <label class="form-label">Tipo</label>
                            <select id="tipo-participacion" aria-label="tipos de documentos" class="form-control select2"  style="width: 100%;">
                                <option selected="selected" value="Presupuesto Participativo">Presupuesto Participativo</option>
                                <option value="Audiencia Públicas">Audiencia Públicas</option>
                                <option value="Consejo de Coordinación Regional/Local">Consejo de Coordinación Regional/Local</option>
                                <option value="Información Adicional">Información Adicional</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6 form-group">
                            <label class="form-label" style="color: white;"> boton</label>
                            <button type="submit" class="btn btn-dark form-control btn-participacion-ciudadana">Guardar</button>
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
                if (!window.saldoBalanceCargado) {
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
}