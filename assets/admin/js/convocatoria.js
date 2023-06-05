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