
$(document).ready(function () {

  //Cambiar logo user
  let change_logo_user = document.getElementById('change_logo_user');
  change_logo_user.addEventListener('click', changeLogo, false);

  function changeLogo() {

    Swal.fire({
      title: 'Ingrese su nuevo avatar',
      html: `
            <form id="upload-form" enctype="multipart/form-data">
              <input type="hidden" name="username" value=" <?php echo $userName ?> " id="username">
              <div class="custom-file">
                  <input type="file" class="custom-file-input" data-browser="Elegir" id="file" name="file">
                  <label class="custom-file-label" for="customFile">Seleccione un archivo</label>
              </div>
            </form>
          `,
      showCancelButton: true,
      confirmButtonText: 'Cambiar logo',
      showLoaderOnConfirm: true,
      preConfirm: () => {
        let form = document.getElementById('upload-form');
        let formData = new FormData(form);
        let fileInput = document.getElementById('file');
        if (!fileInput.value) {
          Swal.showValidationMessage('Debe seleccionar un archivo');
          return false;
        }
        return $.ajax({
          method: "POST",
          url: '/changelogo',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            return JSON.parse(response);
          },
          error: function (response) {
            Swal.showValidationMessage(`Request failed: ${response.statusText}`);
          }
        });
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.isConfirmed) {
        if (result.value.extension === false) {
          Swal.fire({
            title: 'Error',
            text: `La extensión del archivo no es válida`,
            icon: 'error'
          })
        } else if (result.value.exito === true) {
          Swal.fire({
            title: 'Avatar actualizado',
            text: `El avatar ha sido actualizado correctamente para ${$('#username').val()}`,
            icon: 'success'
          })
        } else if (result.value.fallo) {
          Swal.fire({
            title: 'Error',
            text: `${result.value.fallo}`,
            icon: 'error'
          })
        }
      }
    });
  }
  //cambiar contraseñas
  let  change_password = document.getElementById('change_password_user');
  change_password.addEventListener('click', changePassword, false);
  function changePassword() {
    Swal.fire({
      title: 'Ingrese su nueva contraseña',
      html: `
        <form id="upload-form" enctype="multipart/form-data">
        <input type="hidden" name="username" value=" <?php echo $userName ?> " id="username">
        <div class="custom-file">
            <input type="password" class="form-control" id="password" placeholder="Nueva contraseña">
        </div>
        </form>
      `,
      showCancelButton: true, 
      confirmButtonText: 'Cambiar',
      showLoaderOnConfirm: true, 
      preConfirm: () => {
        let form = document.getElementById('upload-form');
        let formData = new formData(form);
        let passwordInput = document.getElementById();
        if (!passwordInput.value){
          Swal.showValidationMessage('Debe ingresar una contraseña');
          return false;
        }
        return $.ajax({
          method: "POST",
          url : "/changePassword", 
          data: formData, 
          processData: false,
          contentType: false, 
          success: function (response){
            return JSON.parse(response);
          }, 
          error: function (response){
            Swal.showValidationMessage(`Request falied: ${response.statusText}`);
          }
        });
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.isConfirmed) {
        if (result.value.respuesta === false) {
          Swal.fire({
            title: 'Error',
            text: `Ha ocurrido un fallo al cambiar la contraseña`,
            icon: 'error'
          })
        } else if (result.value.exito === true) {
          Swal.fire({
            title: 'Contraseña actualizada',
            text:  `La constrasela ha sido actulizada exitosamente para el usuario ${$('#username').val()}`,
            icon:  'success'
          })
        }
      }
    });
  }
  //cerrar sesión 
  let cerrar_sesion = document.getElementById('cerrar_sesion');
  cerrar_sesion.addEventListener('click', cerrarSesion, false);
  function cerrarSesion(){
    Swal.fire({
      title: '¿Estás seguro?',
      text: "Se perderan los datos de sesíon!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, cerrar!',
      preConfirm :() => {
        window.location.href= "/signOut";
      }
    })
  }
});