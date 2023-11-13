let Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timerProgressBar: true,
    timer: 4000,
    customClass: {
        container: 'toast-container'
    }
});

$(document).ready(function() {
    $.getJSON('https://egovt.test/files/ubigeo-peru/ubigeo_peru_2016_departamentos.json', function(departamentos) {
        departamentos.forEach(function(departamento) {
            $('#departamento').append(new Option(departamento.name, departamento.id));
        });
    });

    $('#departamento').change(function() {
        let departamentoId = $(this).val();
        $('#provincia').empty().append(new Option('Seleccione una provincia', ''));
        $('#distrito').empty().append(new Option('Seleccione un distrito', '')).prop('disabled', true);

        if (departamentoId) {
            $('#provincia').prop('disabled', false);

            $.getJSON('https://egovt.test/files/ubigeo-peru/ubigeo_peru_2016_provincias.json', function(provincias) {
                provincias.filter(function(provincia) {
                    return provincia.department_id === departamentoId;
                }).forEach(function(provincia) {
                    $('#provincia').append(new Option(provincia.name, provincia.id));
                });
            });
        } else {
            $('#provincia').prop('disabled', true);
        }
    });
    $('#provincia').change(function() {
        let provinciaId = $(this).val();
        $('#distrito').empty().append(new Option('Seleccione un distrito', ''));

        if (provinciaId) {
            $('#distrito').prop('disabled', false);

            $.getJSON('https://egovt.test/files/ubigeo-peru/ubigeo_peru_2016_distritos.json', function(distritos) {
                distritos.filter(function(distrito) {
                    return distrito.province_id === provinciaId;
                }).forEach(function(distrito) {
                    $('#distrito').append(new Option(distrito.name, distrito.id));
                });
            });
        } else {
            $('#distrito').prop('disabled', true);
        }
    });
});


$(document).on("click", "#BuscarDNI", buscarDNI);
function buscarDNI(e) {
  e.preventDefault();
  let dni = $("#dniVisita").val();
  if (dni == "") {
    Toast.fire({
      icon: "info",
      title: "El campo DNI no puede estar vacío",
    });
  } else {
    $.ajax({
      url: "/administrador/vistias/consultar/"+dni,
      method: "POST",
      dataType: 'json',
      beforeSend: function () {
        $("#BuscarDNI").html("Buscando ...");
      },
      success: function (data) {
        $("#BuscarDNI").html("Buscar");
        if (data.status === 'error') {
          Toast.fire({
            icon: "error",
            title: data.message
          });
        } else {
          $("#nombres").val( data.nombres );
          $("#primer-apellido").val( data.apellidoPaterno );
          $("#segundo-apellido").val( data.apellidoMaterno );
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        $("#BuscarDNI").html("Buscar");
        Toast.fire({
          icon: "error",
          title: `Ha ocurrido un error en la solicitud! Código: Estado: ${textStatus}, Error: ${errorThrown}`,
        });
      },
    });
  }
}

$(document).ready(function() {
    $('#archivo-adjunto').on('change', function() {
        let file = this.files[0];
        let fileType = file.type;
        let match = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

        if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]))) {
            Toast.fire({
                icon: "warning",
                title: 'Lo siento, solo se permiten archivos PDF, DOC o DOCX.'
              });
            $('#archivo-adjunto').val('');
            return false;
        }
    });

    $('.btn-primary').click(function() {
        let camposObligatorios = [
            '#dniVisita', '#nombres', '#primer-apellido', 
            '#segundo-apellido', '#email', '#phone', 
            '#direccion', '#departamento', '#provincia', 
            '#distrito', '#descripcion'
        ];

        let todosLlenos = true;

        $.each(camposObligatorios, function(i, campo) {
            if ($(campo).val() === '') {
                Toast.fire({
                    icon: "info",
                    title: 'Por favor, completa todos los campos obligatorios.'
                  });
                alert('Por favor, completa todos los campos obligatorios.');
                todosLlenos = false;
                return false;
            }
        });

        if (todosLlenos) {
            
        }
    });
});
