//Enviar datos del login. 
$(document).ready(function(){
    $('form').submit(function(e){
        e.preventDefault();
        var username = $('#inputFirstName').val();
        var password = $('#inputChoosePassword').val();
        var terms = $('#flexSwitchCheckChecked').is(":checked");
        $.ajax({
            url: 'Administrador/login',
            type: 'POST',
            data: {username: username, password: password, terms: terms},
            success: function(response){
                console.log('Mensaje enviado');
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
            }
        });
    });
});

//Fin enviar datos login