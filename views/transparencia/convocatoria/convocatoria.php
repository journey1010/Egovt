<link rel="stylesheet" href="<?= $link ?>">
<main>
    <div class="container pt-8 pb-0">
        <h3 class="text-blue mb-2 text-center">CONVOCATORIA DE TRABAJOS DEL GOBIERNO REGIONAL DE LORETO</h3>
        <strong class="d-block text-secondary mb-xl-8 mb-lg-8 mb-md-8 text-center">Trabaja con nosotros</strong>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Nota importante!</strong> En esta sección, tendrás acceso a una lista completa de oportunidades laborales disponibles. 
                    Además, te brindamos la posibilidad de realizar búsquedas más específicas según tus preferencias. Puedes filtrar las ofertas 
                    laborales por año, título o descripción.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="ifbFilterHead col-12 bg-light px-4 pt-4 pb-3 px-lg-4 pt-lg-4 pb-lg-1 mw-100 mb-7 ">
            <div class="form-row mx-n3 align-items-end">
                <div class="formCol px-4">
                    <div class="form-group">
                        <label class="d-block fwMedium fontAlter text-lDark mb-2">Desde</label>
                        <input type="text" class="datepicker form-control border-dark" value="" id="dp4" />
                    </div>
                </div>
                <div class="formCol px-4">
                    <div class="form-group">
                        <label class="d-block fwMedium fontAlter text-lDark mb-2">Hasta</label>
                        <input type="text" class="datepicker form-control bg-white border-dark" value="<?= date('d/m/Y') ?>" id="dp1" />
                    </div>
                </div>
                <div class="formCol px-4">
                    <div class="form-group">
                        <label class="d-block fwMedium fontAlter text-lDark mb-2">Palabra clave</label>
                        <input id="palabra" type="text" class="border border-info form-control inputHeightMedium inputBdrTransparent d-block w- shadow">
                    </div>
                </div>
                <button id="buscarConvocatoria" type="button" class="btn btnTheme ml-lg-3 mt-4 mt-lg-0 ml-auto mr-auto mr-lg-0 font-weight-bold btnMinSm text-capitalize position-relative border-0 p-0" data-hover="Buscar">
                    <span class="d-block btnText">Buscar</span>
                </button>
            </div>
        </div>
    </div>
    <section class="ItemfullBlock pt-3 pb-7 pt-md-0 pb-md-9 pt-lg-0 pb-lg-13 pt-xl-0 pb-xl-0 mb-3">
        <div class="container convocatorias">
            <?= $lista?>
            <?= $paginador ?>
        </div>
        <div  class="d-flex justify-content-center" >
            <div id="spinner" class="spinner-border text-success" role="status" style="display:none">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </section>
</main>
<script src="<?= $jsDatapicker ?>"></script>
<script src="<?= $jsMaterialkit ?>"></script>
<script src="<?= $paginator ?>"></script>
<script>
    $(document).on('click', '#buscarConvocatoria', BuscarConvocatoria);

    function BuscarConvocatoria() {
        let formData = {
            fechaDesde: $('#dp4').val(),
            fechaHasta: $('#dp1').val(),
            palabra: $('#palabra').val()
        };
        $.ajax({
            url: '/transparencia/convocatorias-de-trabajo/buscar',
            method: 'POST',
            data: formData,
            beforeSend: function() {
                $('#spinner').show();
            },
            success: function(response) {
                $('#spinner').hide();
                let resp = JSON.parse(response);
                if (resp.status === 'success') {
                    $('.convocatorias').html('<div class="datos"></div>');
                    if (resp.data !== null) {
                        generarElementosPaginados(resp.data);
                    }
                } else {
                    $('.convocatorias').html('');
                }
            }
        });
    }

    function generarElementosPaginados(data) {
        $('.convocatorias').pagination({
            dataSource: data,
            pageSize: 12,
            ulClassName: 'pagination justify-content-center pt-2',
            callback: function(data, pagination) {
                $('.datos').html(data);
                $('.paginationjs li').addClass('page-item');
                $('.paginationjs a').addClass('page-link');
            },

        });
    }
</script>