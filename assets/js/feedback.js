$(document).ready(function() {
    $(".btn-feedback").click(function(event) {
        event.preventDefault(); 

        let formData = {};
        $(".commentForm").find("input, select, textarea").each(function() {
            if (this.name && this.value) {
                formData[this.name] = this.value;
            }
        });

        $.ajax({
            type: "POST",
            url: "https://utilities.regionloreto.gob.pe/api/feedback", 
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.status="success"){
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Datos enviados con éxito',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    });
                } else {
                    Swal.fire({
                        title: '¡A ocurrido un problema :(!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }

            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessages = Object.values(errors).map(function(errorArray) {
                        return errorArray.join('\n');
                    }).join('\n');
        
                    Swal.fire({
                        title: 'Error',
                        text: errorMessages,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un problema al enviar los datos',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            }
        });
    });
});
