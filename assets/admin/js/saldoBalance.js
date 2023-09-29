import { Toast } from "./Toast.js";

$(document).on('submit', '#saldoBalanceForm', function (event) {
    event.preventDefault();

    let enviarDatos = true;
    let archivosSaldoBalance = $('#saldoBalanceFile')[0].files;
    if (archivosSaldoBalance) {
        const extensionesPermitidas = ['docx', 'xlsx', 'xls', 'pdf', 'txt', 'doc'];
        const pesoMaximoArchivos = 50 * 1024 * 1024;

        for (const key in archivosSaldoBalance) {
            if (archivosSaldoBalance.hasOwnProperty(key)) {
                const file = archivosSaldoBalance[key];
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

    if ($('.title-saldoBalance').val() == '') {
        enviarDatos = false;
        Toast.fire({
            icon: 'warning',
            title: 'Falta incluir un título para este registro.'
        });
    }
    if($('.date-saldo-balance').val() == ''){
        enviarDatos = false;
        Toast.fire({
            icon: '',
            title:  'Falta incluir una fecha para el registro.'
        });
    }
    if (!archivosSaldoBalance) {
        Toast.fire({
            icon: 'warning',
            title: 'Falta incluir un archivo para este registro.'
        });
        enviarDatos = false;
    }

    if (enviarDatos) {
        let formData = new FormData();
        formData.append('titulo', $('.title-saldoBalance').val());
        formData.append('fecha', $('.date-saldo-balance').val());
        for (let i = 0; i <= archivosSaldoBalance.length - 1; i++) {
            formData.append('archivosSaldoBalance[' + i + ']', archivosSaldoBalance[i]);
        }

        const progressBar = $('.progress-bar');
        let totalFiles = 0;
        let progresoActual = 0;

        progressBar.css('witdh', '0%').attr('aria-valuenow', 0).text('0%');
        for (let i = 0; i < archivosSaldoBalance.length; i++) {
            totalFiles += archivosSaldoBalance[i].size;
        }

        $.ajax({
            url: '/administrador/prespuesto/saldo-balance/registrar',
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
                $('.btn-saldo-balance').html('Guardar');
                $('.btn-saldo-balance').prop('disabled', false);
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
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.btn-saldo-balance').html('Guardar');
                $('.btn-saldo-balance').prop('disabled', false);
                Toast.fire({
                    icon: 'error',
                    title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown} `
                });
            },
            complete: function () {
                progressBar.css('width', '0%').attr('aria-valuenow', 0).text('0%');
                $('.title-saldoBalance').val('');
                $('.custom-file-label').html('Seleccione un archivo');
            }
        });
    }
});