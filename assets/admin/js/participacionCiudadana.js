import { Toast } from "./Toast.js";

$(document).on('submit', '#participacionCiudadanaForm', function (event) {
    event.preventDefault();

    let enviarDatos = true;
    let archivosParticipacion = $('#participacionFile')[0].files;
    if (archivosParticipacion) {
        const extensionesPermitidas = ['docx', 'xlsx', 'xls', 'pdf', 'txt', 'doc', 'pptx', 'ppt', ];
        const pesoMaximoArchivos = 50 * 1024 * 1024;

        for (const key in archivosParticipacion) {
            if (archivosParticipacion.hasOwnProperty(key)) {
                const file = archivosParticipacion[key];
                const archivoNombre = file.name;
                const fileExtension = archivoNombre.split('.').pop().toLowerCase();

                if (!extensionesPermitidas.includes(fileExtension)) {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Extensión no permitida. Solo se permiten archivos de tipo: docx, xlsx, xls, pdf, txt, doc'
                    });
                    enviarDatos = false;
                    return;
                }

                if (file.size > pesoMaximoArchivos) {
                    Toast.fire({
                        icon: 'warning',
                        title: 'El archivo no debe superar los 50 MB'
                    });
                    enviarDatos = false;
                    return;
                }
            }
        }
    }

    if ($('.title-participacion').val() == '') {
        enviarDatos = false;
        Toast.fire({
            icon: 'warning',
            title: 'Falta incluir un título para este registro.'
        });
    }
    
    if ($('#tipo-partiticipacion').val() == '') {
        enviarDatos = false;
        Toast.fire({
            icon: 'warning',
            title: 'Falta incluir un tipo de documento para este registro.'
        });
    }
    if ($('#tipo-participacion').val() == '') {
        enviarDatos = false;
        Toast.fire({
            icon: 'warning',
            title: 'Falta incluir un tipo de documento para este registro.'
        });
    }

    if (!archivosParticipacion) {
        Toast.fire({
            icon: 'warning',
            title: 'Falta incluir un archivo para este registro.'
        });
        enviarDatos = false;
    }

    if (enviarDatos) {
        let formData = new FormData();
        formData.append('titulo', $('.title-participacion').val());
        formData.append('descripcion', $('.descripcion-participacion').val());
        formData.append('tipoDoc', $('#tipo-participacion').val());
        for (let i = 0; i <= archivosParticipacion.length - 1; i++) {
            formData.append('archivosParticipacion[' + i + ']', archivosParticipacion[i]);
        }

        const progressBar = $('.progress-bar');
        let totalFiles = 0;
        let progresoActual = 0;

        progressBar.css('witdh', '0%').attr('aria-valuenow', 0).text('0%');
        for (let i = 0; i < archivosParticipacion.length; i++) {
            totalFiles += archivosParticipacion[i].size;
        }

        $.ajax({
            url: '/administrador/participacion/admin/registrar-archivos',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('.btn-saldo-balance').html('Guardando');
                $('.btn-saldo-balance').prop('disabled', true);
            },
            xhr: function () {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        let porcentaje = Math.round((e.loaded / totalFiles) * 100);
                        progressBar.css('width', porcentaje + '%').attr('aria-valuenow', porcentaje).text(porcentaje + '%');
                        progresoActual = porcentaje;
                    }
                }, false);
                return xhr;
            },
            success: function (response) {
                $('.btn-participacion-ciudadana').html('Guardar');
                $('.btn-participacion-ciudadana').prop('disabled', false);
                let resp = JSON.parse(response);
                if (resp.status === 'success') {
                    Toast.fire({
                        icon: 'success',
                        title: resp.message
                    });
                } else {
                    Toast.fire({
                        icon: 'warning',
                        title: resp.message
                    });
                }
                $('.title-participacion').val('');
                $('#tipo-partiticipacion').prop('selectedIndex', 0);
                $('#participacionFile').val('');
                $('.descripcion-participacion').val('');
                $('.custom-file-label').html('Seleccione un archivo');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.btn-participacion-ciudadana').html('Guardar');
                $('.btn-participacion-ciudadana').prop('disabled', false);
                Toast.fire({
                    icon: 'error',
                    title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown} `
                });
            },
            complete: function () {
                progressBar.css('width', '0%').attr('aria-valuenow', 0).text('0%');
            }
        });
    }
});