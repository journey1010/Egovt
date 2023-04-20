import { Toast } from "./Toast.js";

function Gobernador() {
    alert('hola');
    //let camposEdit = ['#titulo', '#mensajeGobernador', '#fraseGobernador'];
    // comprobar.each(camposEdit, function(indice) {
    //     if( $(indice).val() == '') {
    //         Toast.fire({
    //             icon: "warning",
    //             title: "El campo "+indice+" no debe estar vacío"
    //         });
    //         return;
    //     }
    // });
}

$(document).ready(function(){
    let editGobernador = document.getElementById('editGobernador');
    editGobernador.addEventListener('click', function() {
        console.log('hola hola');
    });
    //$("#editGobernador").click(editGobernador, false);

});