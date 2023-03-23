let Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timerProgressBar: true,
  customClass: {
    container: 'toast-container'
  }
});

$(document).ready(select2);
  function select2 () {
    $('.select2').select2({
    closeOnSelect: true
    });
  }

//buscar dni
$(document).on('click', '#searchDNI', buscarDNI);
function buscarDNI ( )
{
  let dni = $('#dni').val();
  if (dni == '') {
    Toast.fire({
      background: '#86FFD3',
      icon: 'info',
      title: 'El campo DNI no puede estar vacío'
    });
  } else {
    $.ajax ({
      url: "https://apiperu.dev/api/dni/"+dni,
      method: 'GET',
      headers: {
        Authorization: "Bearer " + "8bb1d335dc684d6c54e94e6ba34654b9b926a7b436cf92046a514b7ee1898992"
      },
      beforeSend: function () {
        $('#searchDNI').html("Buscando ...");
      },
      success: function(data){
        $('#searchDNI').html("Buscar");
        if(data.success == false){
          Toast.fire({
            icon: 'error',
            title: 'Ha ocurrido un error en la solicitud! En este momento no se puede Consultar a la API.'
          });
        }else{
          $('#nombre').val(data.data.nombres);
          $('#apellido_paterno').val(data.data.apellido_paterno);
          $('#apellido_materno').val(data.data.apellido_materno);
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        $('#searchDNI').html("Buscar");
        Toast.fire({
          icon: 'error',
          title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`
        });
      }
    });
  }
}
//registrar usuarios
$(document).on('submit', '#registrarUsuario', registrarUsuario);
function registrarUsuario (e)
{
  e.preventDefault();
  if ($('#dni').val() === '' || $('#nombre_usuario').val() === '' || $('#nombre').val() ==="" ||
      $('#apellido_paterno').val() === '' || $('#apellido_materno').val()=== '' || $('#contrasena').val() === '' || $('#tipoUsuario').val() === '') {
      Toast.fire({
        background: '#E8EC14',
        icon: 'warning',
        iconColor: '#000000',
        title: 'Debe llenar todos los campos obligatorios'
      });
  } else {
    let formData = {
      dni: $('#dni').val(),
      nombre_usuario: $('#nombre_usuario').val(),
      nombre: $('#nombre').val(),
      apellido_paterno: $('#apellido_paterno').val(),
      apellido_materno: $('#apellido_materno').val(),
      contrasena: $('#contrasena').val(),
      numero_telefono: $('#numero_telefono').val(),
      tipo_usuario: $('#tipoUsuario').val()
    }
    $.ajax({
      method:'POST',
      url:'/administrador/resgistrarusuarios',
      data: formData,
      beforeSend: function(){
        $('#btn btn-primary').html('Guardando...');
      },
      success: function(response){
        $('#btn btn-primary').html('Guardar');
        let resp = JSON.parse(response);
        let indice = Object.keys(resp)[0];
        switch (indice) {
          case 'error':
            Toast.fire({
              background: '#E75E15',
              iconColor: '#000000',
              icon: 'error',
              title: resp[indice]
            });
          break;
          case 'success':
            Toast.fire({
              icon: 'success',
              title: resp[indice]
            });
          break;
          case 'user':
            Toast.fire({
              background: '#E8EC14',
              icon: 'warning',
              iconColor: '#000000',
              title: resp[indice]
            });  
          break;
          case 'dni':
            Toast.fire({
              background: '#E8EC14',
              icon: 'warning',
              iconColor: '#000000',
              title: resp[indice]
            });
          break;
        }
      },
      error: function (jqXHR, textStatus, errorThrown){
        Toast.fire({
          icon: 'error',
          title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
          background: '#ff0000'
        });
      }
    });
  }
}

//buscar dni visita
$(document).on('click', '#BuscarDNIVisita', buscarDNIVisita);
function buscarDNIVisita (e)
{
  e.preventDefault();
  let dni = $('#dniVisita').val();
  if (dni == '') {
    Toast.fire({
      background: '#86FFD3',
      icon: 'info',
      title: 'El campo DNI no puede estar vacío'
    });
  } else {
    $.ajax ({
      url: "https://apiperu.dev/api/dni/"+dni,
      method: 'GET',
      headers: {
        Authorization: "Bearer " + "8bb1d335dc684d6c54e94e6ba34654b9b926a7b436cf92046a514b7ee1898992"
      },
      beforeSend: function () {
        $('#BuscarDNIVisita').html("Buscando ...");
      },
      success: function(data){
        $('#BuscarDNIVisita').html("Buscar");
        if(data.success == false){
          Toast.fire({
            icon: 'error',
            title: 'Ha ocurrido un error en la solicitud! En este momento no se puede Consultar a la API.'
          });
        }else{
          $('#apellidos_nombres').val(data.data.nombres + '' + data.data.apellido_paterno + '' + data.data.apellido_materno );
        }
        
      },
      error: function(jqXHR, textStatus, errorThrown){
        $('#BuscarDNIVisita').html("Buscar");
        Toast.fire({
          icon: 'error',
          title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`
        });
      }
    });
  }
}

$(document).on('submit', '#registrarVisitas', function(event) {
  event.preventDefault(); 
  if ($('#dniVisita').val() === '' || $('#apellidos_nombres').val() === '' || $('.select2 option:selected').text() ==="" ||
      $('#hora_de_ingreso').val() === '' ) {
      Toast.fire({
        background: '#E8EC14',
        icon: 'warning',
        iconColor: '#000000',
        title: 'Debe llenar todos los campos obligatorios'
      });
  } else {
    let formData= { 
      dniVisita : $("#dniVisita").val(),
      apellidosNombres : $("#apellidos_nombres").val(),
      oficina : $(".select2 option:selected").val() ,
      personaAVisitar : $("#persona_a_visitar").val(),
      horaDeIngreso : $("#hora_de_ingreso").val(),
      quienAutoriza : $("#quien_autoriza").val(),
      motivo : $("#motivo").val(),
    }
    
    $.ajax({
      url: "/administrador/resgistravisitas",
      method: "POST",
      data: formData,
      beforeSend: function(){
        $('#btn btn-primary').html('Guardando...');
      },
      success: function(response){
        $('#btn btn-primary').html('Guardar');
        let resp = JSON.parse(response);
        let indice = Object.keys(resp)[0];
        switch (indice) {
          case 'error':
            Toast.fire({
              background: '#E75E15',
              iconColor: '#000000',
              icon: 'error',
              title: resp[indice]
            });
          break;
          case 'success':
            $("#dniVisita").val("");
            $("#apellidos_nombres").val("");
            $(".select2").val(null).trigger("change"); // restablecer el select
            $("#persona_a_visitar").val("");
            $("#quien_autoriza").val("");
            $("#motivo").val("");
            Toast.fire({
              icon: 'success',
              title: resp[indice]
            });
          break;
        }
      },
      error: function (jqXHR, textStatus, errorThrown){
        $("#dniVisita").val("");
        $("#apellidos_nombres").val("");
        $(".select2").val(null).trigger("change"); // restablecer el select
        $("#persona_a_visitar").val("");
        $("#quien_autoriza").val("");
        $("#motivo").val("");
        Toast.fire({
          icon: 'error',
          title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
          background: '#ff0000'
        });
      }
    });
  }
});

//Actualizar visitas
//funcionalidad de iconos de la tabla
$(document).on('click', '.edit-icon', edit);
function edit()
{
  let row = $(this).closest('tr');
  row.find('td[contenteditable=false]').prop('contenteditable', true);
  row.find('.edit-icon').hide();
  row.find('.cancel-icon').show();
  row.find('.save-icon').show();

  let fecha = new Date();
  let opciones = {
    year:"numeric",
    month: "2-digit",
    day: "2-digit",
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit", 
    hour12: false,
    timeZone: "America/Bogota"
  };
  let fechaISO = fecha.toISOString();
  let fechaNow = fechaISO.replace("T", " ").replace("Z", "").replace(/\.\d+/, "");
  let horaSalida = row.find('td:eq(3)');
  horaSalida.text(fechaNow);
}

$(document).on('click', '.cancel-icon', cancel);
function cancel()
{
  let row = $(this).closest('tr');
  row.find('td[contenteditable=true]').prop('contenteditable', false);
  row.find('.edit-icon').show();
  row.find('.cancel-icon').hide();
  row.find('.save-icon').hide();
  let horaSalida = row.find('td:eq(3)');
  horaSalida.text('');
}

$(document).on('click', '.save-icon', save);
function save()
{ 
  let row = $(this).closest('tr');
  let formData ={
    id: row.find('td:eq(0)').text(),
    horaSalida: row.find('td:eq(3)').text(),
    motivo: row.find('td:eq(4)').text()
  };
  
  $.ajax({
    url: "/administrador/actualizarvisitas",
    method: "POST", 
    data: formData,    
    success: function(response){
      let resp = JSON.parse(response);
      let indice = Object.keys(resp)[0];
      switch (indice) {
        case 'error':
          Toast.fire({
            background: '#E75E15',
            iconColor: '#000000',
            icon: 'error',
            title: resp[indice]
          });
        break;
        case 'success':
          Toast.fire({
            icon: 'success',
            title: resp[indice]
          });
        break;
      }
    },
    error: function (jqXHR, textStatus, errorThrown){
      Toast.fire({
        icon: 'error',
        title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
        background: '#ff0000'
      });
    }    
  });
}