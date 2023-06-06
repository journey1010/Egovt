import { Toast } from "./Toast.js";

$(document).ready(select2);
function select2() {
  $(".select2").select2({
    closeOnSelect: true,
  });
}


//buscar dni visita
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
      url: "https://dniruc.apisperu.com/api/v1/dni/" + dni + "?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Imdpbm9fcGFyZWRlc0BvdXRsb29rLmNvbS5wZSJ9.1rXghi0JQb2I-COt_4J7juPDkIgCBZZbHcixnwGF0mI",
      method: "GET",
      beforeSend: function () {
        $("#BuscarDNIVisita").html("Buscando ...");
      },
      success: function (data) {
        $("#BuscarDNIVisita").html("Buscar");
        if (data.success == false) {
          Toast.fire({
            icon: "error",
            title:
              "Ha ocurrido un error en la solicitud! En este momento no se puede Consultar a la API.",
          });
        } else {
          $("#apellidos_nombres").val(
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

$(document).on('change', '#oficina', listarFuncionarios);
function listarFuncionarios() {
  let oficina  = $("#oficina option:selected").val();

  $.ajax({    
    url: '/administrador/visitas/listarfuncionarios',
    method: 'POST',
    data: {
      oficina : oficina
    },
    beforeSend: function() {
      $('#quien_autoriza').prop('disabled', true);
    },
    success: function(data){
      $('#quien_autoriza').empty();
      $('#quien_autoriza').append(data);
      $('#quien_autoriza').prop('disabled', false);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $("#oficina").val(null).trigger("change"); // restablecer el select
      Toast.fire({
        icon: "error",
        title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
        background: "#ff0000",
      });
    }
  });
}

$(document).on("submit", "#registrarVisitas", function (event) {
  event.preventDefault();
  if (
    $("#dniVisita").val() === "" ||
    $("#apellidos_nombres").val() === "" ||
    $("#oficina option:selected").text() === "" ||
    $("#quien_autoriza option:selected").text() === "" ||
    $("#hora_de_ingreso").val() === "" ||
    $("#tipoDoc").val() === "" ||
    $("#InstitucionVisitante").val() === ""
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
      dniVisita: $("#dniVisita").val(),
      apellidosNombres: $("#apellidos_nombres").val(),
      institucionVisitante: $("#InstitucionVisitante").val(),
      oficina: $("#oficina option:selected").val(),
      personaAVisitar: $("#persona_a_visitar").val(),
      horaDeIngreso: $("#hora_de_ingreso").val(),
      quienAutoriza: $("#quien_autoriza option:selected").val(),
      motivo: $("#motivo").val()
    };

    $.ajax({
      url: "/administrador/resgistravisitas",
      method: "POST",
      data: formData,
      beforeSend: function () {
        $("#btnGuardar").html("Guardando...");
        $("#btnGuardar").prop('disabled', true);
      },
      success: function (response) {
        $("#btnGuardar").html("Guardar");
        $("#btnGuardar").prop('disabled', false);
        let resp = JSON.parse(response);
        let indice = Object.keys(resp)[0];
        switch (indice) {
          case "error":
            Toast.fire({
              background: "#E75E15",
              iconColor: "#000000",
              icon: "error",
              title: resp[indice],
            });
            break;
          case "success":
            $("#dniVisita").val("");
            $("#apellidos_nombres").val("");
            $("#quien_autoriza").val("");
            $("#motivo").val("");
            Toast.fire({
              icon: "success",
              title: resp[indice],
            });
            break;
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        $("#btnGuardar").html("Guardar");
        $("#btnGuardar").prop('disabled', false);

        $("#dniVisita").val("");
        $("#apellidos_nombres").val("");
        $("#oficina").val(null).trigger("change"); // restablecer el select
        $("#persona_a_visitar").val("");
        $("#quien_autoriza").val("");
        $("#motivo").val("");
        Toast.fire({
          icon: "error",
          title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
          background: "#ff0000",
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
    $("#quien_autoriza option:selected").text() === "" ||
    $("#hora_de_ingreso").val() === "" ||
    $("#hora_de_salida").val() === ""
  ) {
    Toast.fire({
      background: "#E8EC14",
      icon: "warning",
      iconColor: "#000000",
      title: "Debe llenar todos los campos obligatorios",
    });
  } else {
    let formData = {
      dniVisita: $("#dniVisita").val(),
      apellidosNombres: $("#apellidos_nombres").val(),
      oficina: $("#oficina option:selected").val(),
      personaAVisitar: $("#persona_a_visitar").val(),
      horaDeIngreso: $("#hora_de_ingreso").val(),
      quienAutoriza: $("#quien_autoriza option:selected").val(),
      motivo: $("#motivo").val(),
      horaDeSalida: $("#hora_de_salida").val()
    };

    $.ajax({
      url: '/administrador/regularizar-visitas',
      method: 'POST',
      data: formData,
      beforeSend: function () {
        $("#btnRegularizar").html("Guardar");
        $("#btnRegularizar").prop('disabled', false);
      },
      success: function (response) {
        $("#btnRegularizar").html("Guardar");
        $("#btnRegularizar").prop('disabled', false);
        let resp = JSON.parse(response);
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
        $("#quien_autoriza").val("");
        $("#motivo").val("");
        $("#hora_de_ingreso").val("");
        $("#hora_de_salida").val("");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        $("#btnRegularizar").html("Guardar");
        $("#btnRegularizar").prop('disabled', false);

        $("#dniVisita").val("");
        $("#apellidos_nombres").val("");
        $("#oficina").val(null).trigger("change"); // restablecer el select
        $("#persona_a_visitar").val("");
        $("#quien_autoriza").val("");
        $("#motivo").val("");
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
  let horaSalida = row.find("td:eq(3)");
  horaSalida.text(hora);
}

$(document).on("click", ".cancel-icon", cancel);
function cancel() {
  let row = $(this).closest("tr");
  row.find("td[contenteditable=true]").prop("contenteditable", false);
  row.find(".edit-icon").show();
  row.find(".cancel-icon").hide();
  row.find(".save-icon").hide();
  let horaSalida = row.find("td:eq(3)");
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
    horaSalida: row.find("td:eq(3)").text(),
    motivo: row.find("td:eq(4)").text(),
  };

  $.ajax({
    url: "/administrador/actualizarvisitas",
    method: "POST",
    data: formData,
    success: function (response) {
      let resp = JSON.parse(response);
      let indice = Object.keys(resp)[0];
      switch (indice) {
        case "error":
          Toast.fire({
            background: "#E75E15",
            iconColor: "#000000",
            icon: "error",
            title: resp[indice],
          });
          break;
        case "success":
          row.hide();
          Toast.fire({
            icon: "success",
            title: resp[indice],
          });
          break;
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
    let maxProgress = Math.floor(Math.random() * 59) + 2; 
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
      beforeSend: function(){
        if ($('#respuestaReportVisitas').is(':visible')) {
          $('#respuestaReportVisitas').hide();
        }
      },
      success: function(response){
        let resp = JSON.parse(response);
        if (resp.status ==='success') {
          Toast.fire({
            icon: "success",
            title: resp.message,
          });
          clearInterval(progressInterval);
          progressBar.css('width', '100%');
          progressBar.text('100%');

          $('#respuestaReportVisitas').show();
          $('#respuestaReportVisitas').html('<a href="' + resp.archivo +'" download><button type="button" class="btn btn-block btn-outline-success"><i class="fa fa-download"></i> DESCARGAR REPORTE DE VISITAS</button></a>');
        } else {
          Toast.fire({
            icon: "error",
            title: resp.message,
          });
        }
    },
      error: function (jqXHR, textStatus, errorThrown) {
        $('#fechaVistDesde').val('');
        $('#fechaVisitHasta').val('');
        Toast.fire({
          icon: "error",
          title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
          background: "#ff0000",
        });
      }
    });
  }
});