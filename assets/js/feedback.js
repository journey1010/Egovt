$(document).ready(function() {
    $(".btn-feedback").click(function(event) {
        event.preventDefault(); 

        var formData = {
            user_name: $('input[name="user_name"]').val(),
            email: $('input[type="email"]').val(),
            phone: $('input[name="phone"]').val(),
            experience: $('select[name="experience"]').val(),
            com_design: $('textarea[name="com_design"]').val(),
            com_content: $('textarea[name="com_content"]').val(),
            com_funtionallity: $('textarea[name="com_funtionallity"]').val(),
            com_ease_use: $('textarea[name="com_ease_use"]').val(),
            com_suggest: $('textarea[name="com_suggest"]').val()
        }; 

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
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        var errorMessage = '';
                        var messageObject = xhr.responseJSON.message;
                        
                        for (var key in messageObject) {
                            if (messageObject.hasOwnProperty(key)) {
                                errorMessage += messageObject[key] + '\n';
                            }
                        }
        
                        Swal.fire({
                            title: 'Error',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Error de validación no especificado.',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
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
