<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gobierno Regional de Loreto</title>
    <meta name="google-site-verification" content="CRBa-m87jge17xNggnxw6Pi5UOWrmuUHaax2D2hrp6o"/>
	<link rel="canonical" href="https://regionloreto.gob.pe">
    <meta name="autor" content="Journii">
    <link rel='icon' type='image/x-icon' href='<?= _ROOT_ASSETS . 'images/gorel_favicon.ico' ?>'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container card border-dark mt-4 p-0 mb-3">
        <img src="<?= _ROOT_ASSETS . 'images/banners/portada1.webp'?>" class="card-img-top" alt="Banner los colores de la amazonia" height="300">
        <form id="funcionarios" enctype="multipart/form-data">
            <div class="card-body text-dark d-flex justify-content-center">
                <h4 class="card-title">Registro de datos para Funcionarios</h4>
            </div>
            <div class="card-body text-dark row row-cols-2">
                <div class="col">
                    <label class="form-label"></label>
                    <div class="input-group mb-3">
                        <button class="btn btn-outline-secondary" type="button" id="BuscarDNI">Buscar DNI</button>
                        <input id="number-dni" type="text" class="form-control" placeholder="" aria-label="numero de dni" aria-describedby="buscar-dni">
                    </div>
                </div>
                <div class="col">
                    <label class="form-label">Nombre Completo</label>
                    <input id="full-name" class="form-control" type="text" aria-label="full-name">
                </div>
                <div class="col">
                    <label for="number-phone" class="form-label">Número de teléfono (opcional)</label>
                    <input id="number-phone" type="number" class="form-control" aria-label="number-phone">
                </div>
                <div class="col">
                    <label for="email" class="form-label">Correo Electronico</label>
                    <input type="email" id="email" class="form-control" aria-label="email">
                </div>
                <div class="col">
                    <label for="oficina" class="form-label">Oficina</label>
                    <select name="oficina" id="oficina" class="form-control">
                        <?php foreach ($oficinas as $option): ?>
                            <option value="<?= htmlspecialchars($option['id']) ?>"><?= htmlspecialchars($option['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col">
                    <label for="foto" class="form-label">Foto</label>
                    <div class="mb-3">
                        <input class="form-control" type="file" id="foto">
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <button type="button" class="btn btn-dark">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#oficina').select2();
    });
    $(document).on("click", "#BuscarDNI", buscarDNIVisita);
    function buscarDNIVisita(e) {
        e.preventDefault();
        let dni = $("#number-dni").val();
        if (dni == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'El campo DNI no puede estar vacío!',
            })
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'El campo DNI no puede estar vacío!',
                        })
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
                    $("#BuscarDNI").html("Buscar");
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
                    })
                }
            });
        }
    }
</script>
</html>