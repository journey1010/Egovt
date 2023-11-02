import { Toast } from "./Toast.js";

$(document).ready(select2);
function select2() {
  $(".select2").select2({
    closeOnSelect: true,
  });
}

$(document).on("click", "#BuscarDNIVisita", buscarDNIVisita);
function buscarDNIVisita(e) {
  e.preventDefault();
  let dni = $("#dniVisita").val();
  if (dni == "") {
    Toast.fire({
      background: "#86FFD3",
      icon: "info",
      title: "El campo DNI no puede estar vacío",
    });
  } else {
    $.ajax({
      url: "/administrador/vistias/consultar/"+dni,
      method: "POST",
      dataType: 'json',
      beforeSend: function () {
        $("#BuscarDNIVisita").html("Buscando ...");
      },
      success: function (data) {
        $("#BuscarDNIVisita").html("Buscar");
        if (data.status === 'error') {
          Toast.fire({
            icon: "error",
            title: data.message
          });
        } else {
          $("#full-name").val(
            data.nombres +
            " " +
            data.apellidoPaterno +
            " " +
            data.apellidoMaterno
          );
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        $("#BuscarDNIVisita").html("Buscar");
        Toast.fire({
          icon: "error",
          title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
        });
      },
    });
  }
}

// $(document).on('change', '#oficina', listarFuncionarios);
// function listarFuncionarios() {
//   let oficina  = $("#oficina option:selected").val();

//   $.ajax({    
//     url: '/administrador/visitas/listarfuncionarios',
//     method: 'POST',
//     data: {
//       oficina : oficina
//     },
//     beforeSend: function() {
//       $('#quien_autoriza').prop('disabled', true);
//     },
//     success: function(data){
//       $('#quien_autoriza').empty();
//       $('#quien_autoriza').append(data);
//       $('#quien_autoriza').prop('disabled', false);
//     },
//     error: function (jqXHR, textStatus, errorThrown) {
//       $("#oficina").val(null).trigger("change"); // restablecer el select
//       Toast.fire({
//         icon: "error",
//         title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
//         background: "#ff0000",
//       });
//     }
//   });
// }

$(document).on("submit", "#registrarVisitas", function (event) {
  event.preventDefault();
  if (
    $("#dniVisita").val() === "" ||
    $("#apellidos_nombres").val() === "" ||
    $("#oficina option:selected").text() === "" ||
    $("#hora_de_ingreso").val() === "" ||
    $("#tipoDoc").val() === "" ||
    $("#InstitucionVisitante").val() === "" ||
    $("#motivo").val() === ""
  ) {
    Toast.fire({
      background: "#E8EC14",
      icon: "warning",
      iconColor: "#000000",
      title: "Debe llenar todos los campos obligatorios",
    });
  } else {
    let formData = {
      tipoDoc:  $("#tipoDoc").val(),
      numeroDoc: $("#dniVisita").val(),
      apellidosNombres: $("#apellidos_nombres").val(),
      institucionVisitante: $("#InstitucionVisitante").val(),
      oficina: $("#oficina option:selected").val(),
      personaAVisitar: $("#persona_a_visitar").val(),
      horaDeIngreso: $("#hora_de_ingreso").val(),
      motivo: $("#motivo").val()
    };

    $.ajax({
      url: "/administrador/resgistravisitas",
      method: "POST",
      data: formData,
      dataType: 'json',
      beforeSend: function () {
        $("#btnGuardar").html("Guardando...");
        $("#btnGuardar").prop('disabled', true);
      },
      success: function (response) {
        $("#btnGuardar").html("Guardar");
        $("#btnGuardar").prop('disabled', false);
        if(response.status==='success'){
          $("#dniVisita").val("");
          $("#apellidos_nombres").val("");
          $("#motivo").val("");
          Toast.fire({
            icon: "success",
            title: response.message
          });
        } else {
          Toast.fire({
            icon: "error",
            title: response.message,
          });
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        $("#btnGuardar").html("Guardar");
        $("#btnGuardar").prop('disabled', false);
        $("#dniVisita").val("");
        $("#apellidos_nombres").val("");
        $("#oficina").val(null).trigger("change");
        $("#persona_a_visitar").val("");
        $("#motivo").val("");
        Toast.fire({
          icon: "error",
          title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
        });
      }
    });
  }
});

$(document).on("submit", "#regularizarVisitas", function (event){
  event.preventDefault();
  if(
    $("#dniVisita").val() === "" ||
    $("#apellidos_nombres").val() === "" ||
    $("#oficina option:selected").text() === "" ||
    $("#hora_de_ingresoR").val() === "" ||
    $("#institucionVisitanteR").val() === ''
  ) {
    Toast.fire({
      background: "#E8EC14",
      icon: "warning",
      iconColor: "#000000",
      title: "Debe llenar todos los campos obligatorios",
    });
  } else {
    let formData = {
      tipoDoc:  $("#tipoDoc").val(),
      numeroDoc: $("#dniVisita").val(),
      apellidosNombres: $("#apellidos_nombres").val(),
      oficina: $("#oficina option:selected").val(),
      personaAVisitar: $("#persona_a_visitar").val(),
      horaDeIngreso: $("#hora_de_ingresoR").val(),
      motivo: $("#motivo").val(),
      horaDeSalida: $("#hora_de_salidaR").val(),
      institucionVisitante: $("#institucionVisitanteR").val()
    };

    $.ajax({
      url: '/administrador/regularizar-visitas',
      method: 'POST',
      data: formData,
      dataType: 'json',
      beforeSend: function () {
        $("#btnRegularizar").html("Guardar");
        $("#btnRegularizar").prop('disabled', false);
      },
      success: function (resp) {
        $("#btnRegularizar").html("Guardar");
        $("#btnRegularizar").prop('disabled', false);
        if(resp.status === 'success'){
          Toast.fire({
            icon: "success",
            title: resp.message,
          });
        } else{
          Toast.fire({
            icon: "error",
            title: resp.message,
          });
        }
        $("#dniVisita").val("");
        $("#apellidos_nombres").val("");
        $("#motivo").val("");
        $("#hora_de_ingresoR").val("");
        $("#hora_de_salidaR").val("");
        $("#institucionVisitanteR").val("");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        $("#btnRegularizar").html("Guardar");
        $("#btnRegularizar").prop('disabled', false);

        $("#dniVisita").val("");
        $("#apellidos_nombres").val("");
        $("#oficina").val(null).trigger("change");
        $("#persona_a_visitar").val("");
        $("#motivo").val("");
        $("#institucionVisitanteR").val("");
        Toast.fire({
          icon: "error",
          title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
          background: "#ff0000",
        });
      }
    });
  }
});

//Actualizar visitas, funcionalidad de iconos de la tabla
$(document).on("click", ".edit-icon", edit);
function edit() {
  let row = $(this).closest("tr");
  row.find("td[contenteditable=false]").prop("contenteditable", true);
  row.find(".edit-icon").hide();
  row.find(".cancel-icon").show();
  row.find(".save-icon").show();

  let hora = moment().utcOffset('America/Phoenix').format('YYYY-MM-DD HH:mm:ss');
  let horaSalida = row.find("td:eq(4)");
  horaSalida.text(hora);
}

$(document).on("click", ".cancel-icon", cancel);
function cancel() {
  let row = $(this).closest("tr");
  row.find("td[contenteditable=true]").prop("contenteditable", false);
  row.find(".edit-icon").show();
  row.find(".cancel-icon").hide();
  row.find(".save-icon").hide();
  let horaSalida = row.find("td:eq(4)");
  horaSalida.text("");
}

$(document).on("click", ".save-icon", save);
function save() {
  let row = $(this).closest("tr");
  row.find("td[contenteditable=true]").prop("contenteditable", false);
  row.find(".edit-icon").show();
  row.find(".cancel-icon").hide();
  row.find(".save-icon").hide();
  let formData = {
    id: row.find("td:eq(0)").text(),
    horaSalida: row.find("td:eq(4)").text(),
    motivo: row.find("td:eq(5)").text(),
  };

  $.ajax({
    url: "/administrador/actualizarvisitas",
    method: "POST",
    data: formData,
    dataType: 'json',
    success: function (response) {
      if(response.status ==='success'){
        row.remove();
        Toast.fire({
          icon: "success",
          title: response.message,
        });
      }else {
        Toast.fire({
          icon: "error",
          title: response.message,
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      Toast.fire({
        icon: "error",
        title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
        background: "#ff0000",
      });
    },
  });
}

$(document).on("click", "#generarReportVisit", function(){
  if($('#fechaVistDesde').val() === '' || $('#fechaVisitHasta').val()===''){
    Toast.fire({
      icon: "warning",
      title: 'Por favor, ingrese un rango de fechas.',
    });
  } else {
    let formData = {
      fechaDesde: $('#fechaVistDesde').val(),
      fechaHasta: $('#fechaVisitHasta').val()
    };

    let progressBar = $('#reporteVisitas .progress-bar');
    $('#reporteVisitas').show();
    let maxProgress = Math.floor(Math.random() * 10) + 60; 
    let currentProgress = 0;
    let progressInterval = setInterval(function () {
      if (currentProgress < maxProgress) {
        currentProgress++;
        progressBar.css('width', currentProgress + '%');
        progressBar.text(currentProgress + '%');
      } else {
        clearInterval(progressInterval);
      }
    }, 50);
  
    $.ajax({
      url: '/administrador/exportar-visitas',
      method: 'POST',
      data: formData,
      dataType: 'json',
      beforeSend: function(){
        $('#generarReportVisit').prop('disabled', true);
        if ($('#respuestaReportVisitas').is(':visible')) {
          $('#respuestaReportVisitas').hide();
        }
      },
      success: function(response){
        if (response.status ==='success') {
          Toast.fire({
            icon: "success",
            title: response.message,
          });
          clearInterval(progressInterval);
          progressBar.css('width', '100%');
          progressBar.text('100%');

          $('#respuestaReportVisitas').show();
          $('#respuestaReportVisitas').html('<a href="' + response.archivo +'" download><button type="button" class="btn btn-block btn-outline-success"><i class="fa fa-download"></i> DESCARGAR REPORTE DE VISITAS</button></a>');
        } else {
          Toast.fire({
            icon: "error",
            title: response.message,
          });
        }
        $('#generarReportVisit').prop('disabled', false);
    },
      error: function (jqXHR, textStatus, errorThrown) {
        $('#generarReportVisit').prop('disabled', false);
        $('#fechaVistDesde').val('');
        $('#fechaVisitHasta').val('');
        Toast.fire({
          icon: "error",
          title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`
        });
      }
    });
  }
});