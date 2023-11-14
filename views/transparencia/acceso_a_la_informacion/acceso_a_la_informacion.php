
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<main>
    <div class="mt-4 p-4">
        <h1 class="text-monospace ml-3" style="font-size: 40px">Transparencia <i class="fas fa-angle-right"></i>
            Solicitud de Acceso  a la Información
        </h1>
        <h4 class="ml-3">Puede Solicitar InformaciónPuedes solicitar y recibir información pública de las instituciones del Estado, de acuerdo al Texto Único Ordenado de la Ley Nº 27806.</h4>
    </div>
    <article class="dsSingleContent pt-4 pb-2 pt-md-7 pb-md-1 pt-lg-4 pb-lg-10 pt-xl-3 pb-xl-16">
        <div class="container card">
            <div class="row mt-3 mb-3">
                <div class="col-12">
                    <label class="form-label">Descargar Formulario en Formato pdf: </label>
                    <a  class="form-label alert-link" href="https://cdn.www.gob.pe/uploads/document/file/2686056/SDTact.pdf.pdf.pdf?v=1678810064">DESCARGAR</a>
                </div>
                <div class="col-12">
                    <label class="form-label">1. Persona que solicita </label>
                </div>
                <div class="col-md-4 col-sm-6">
                    <label class="form-label">Persona</label>
                    <select id="persona-edad" class="form-control">
                        <option value="mayor">Mayor de Edad</option>
                        <option value="menor">Menor de Edad</option>
                    </select>
                </div>
                <div class="col-md-4 col-sm-6">
                    <label class="form-label">Tipo de documento</label>
                    <select id="type-document" class="form-control">
                        <option value="DNI">DNI</option>
                        <option value="PASAPORTE">PASAPORTE</option>
                        <option value="CARNET-EXTRANJERIA">CARNET DE EXTRANJERÍA</option>
                    </select>
                </div>
                <div class="col-md-4 col-sm-6">
                    <label for="buscarDNI">Número de documento(obligatorio)</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button class="btn btn-secondary" type="button" id="BuscarDNI">Buscar DNI</button>
                        </div>
                        <input type="text" id="dniVisita" class="form-control" placeholder="Número de documento..." aria-label="Guardar número de documento" aria-describedby="Campo dni"required>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <label class="form-label">Nombres</label>
                    <input id="nombres" type="text" class="form-control">
                </div>
                <div class="col-md-4 col-sm-6">
                    <label class="form-label">Primer Apellido</label>
                    <input id="primer-apellido" type="text" class="form-control">
                </div>
                <div class="col-md-4 col-sm-6">
                    <label class="form-label">Segundo Apellido</label>
                    <input id="segundo-apellido" type="text" class="form-control">
                </div>
                <div class="col-md-4 col-sm-6">
                    <label class="form-label">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control">
                </div>
                <div class="col-md-4 col-sm-6">
                    <label class="form-label">N° de celular/Teléfono</label>
                    <input id="phone" type="phone" class="form-control">
                </div>
                <div class="col-md-4 col-sm-6">
                    <label class="form-label">Dirección actual</label>
                    <input id="direccion" type="text" class="form-control">
                </div>
                <div class="col-md-4 col-sm-6">
                    <label class="form-label">Departamento</label>
                    <select id="departamento" class="form-control">
                    </select>
                </div>
                <div class="col-md-4 col-sm-6">
                    <label class="form-label">Provincia</label>
                    <select id="provincia" class="form-control"></select>
                </div>
                <div class="col-md-4 col-sm-6">
                    <label class="form-label">Distrito</label>
                    <select id="distrito" class="form-control"></select>
                </div>
                <div class="col-md-12 col-sm-12">
                    <label class="form-label">2. Información solicitada</label>
                </div>
                <div class="col-md-12 col-sm-12">
                    <label class="form-label">Descripción de la solicitud (máximo 500 caracteres)</label>
                    <textarea id="descripcion" class="form-control" maxlength="500"></textarea>
                    <label class="form-label">Adjuntar información complementaria a la solicitud que permita facilitar la evaluación por parte de la entidad. (Opcional).</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="archivo-adjunto" onchange="
                        if (this.files.length > 0) {
                            document.querySelector(`.custom-file-label`).innerHTML = this.files.length + ` archivo seleccionado`;    
                        } else {
                            document.querySelector(`.custom-file-label`).innerHTML =  `Seleccione un archivo`
                        } ">
                        <label class="custom-file-label" for="archivo-adjunto" data-browse="Elegir archivo">Elegir archivo</label>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 pt-2">
                    <button type="button" class="btn btn-primary form-control">Guardar</button>
                </div>
			</div>
        </div>
        <div class="g-recaptcha" data-sitekey="6LeMRQ4pAAAAALnrP6RFulOt77vQkT48PXV5nZQ_"></div>
    </article>
    <div class="g-recaptcha" data-sitekey="6LeMRQ4pAAAAALnrP6RFulOt77vQkT48PXV5nZQ_"></div>
</main>