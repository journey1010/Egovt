<link rel="stylesheet" href="<?= $link ?>">
<main>
    <div class="container pt-8 pb-0">
        <h3 class="text-blue mb-2 text-center">CONVOCATORIA DE TRABAJOS DEL GOREL</h3>
        <strong class="d-block text-secondary mb-xl-8 mb-lg-8 mb-md-8 text-center">Trabaja con nosotros</strong>
        <div class="ifbFilterHead col-12 bg-light px-4 pt-4 pb-3 px-lg-4 pt-lg-4 pb-lg-1 mw-100 mb-7">
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
                <button id="buscarAgenda" type="button" class="btn btnTheme ml-lg-3 mt-4 mt-lg-0 ml-auto mr-auto mr-lg-0 font-weight-bold btnMinSm text-capitalize position-relative border-0 p-0" data-hover="Buscar">
                    <span class="d-block btnText">Buscar</span>
                </button>
            </div>
        </div>
    </div>
    <section class="ItemfullBlock pt-3 pb-7 pt-md-0 pb-md-9 pt-lg-0 pb-lg-13 pt-xl-0 pb-xl-0">
        <div class="container convocatorias">
                <article class="ueEveColumn__list bg-light mt-3 position-relative px-4 py-3 px-lg-8 py-lg-6">
                    <div class="d-lg-flex align-items-md-center">
                        <div class="imgHolder overflow-hidden flex-shrink-0 mr-4 mr-lg-10 mb-1 mb-md-0">
                            <img src="<?php echo _ROOT_ASSETS . 'images/oficinas/logo_gorel.webp' ?>" class="img-fluid" alt="image description">
                        </div>
                        <div class="d-md-flex align-items-md-center flex-grow-1">
                            <div class="descrWrap flex-grow-1">
                                <strong class="tagTitle d-block text-secondary fwSemiBold mb-2">Gobierno Regional de Loreto</strong>
                                <h3 class="fwMedium">
                                    Concesión del CAFETÍN de la sede del Gobierno Regional de Loreto 2023-2024.
                                </h3>
                                <strong class="tagTitle d-block text-black fwSemiBold mb-2">
                                    Bases del Procedimiento de Selección para Concesión del CAFETÍN de la sede del Gobierno Regional de San Martín 2023-2024.
                                </strong>
                                <ul class="list-unstyled ueScheduleList mb-0">
                                    <li>
                                        <a href="eventSingle.html" target="_blank">
                                            <i class="fal fa-arrow-square-down icn position-absolute"><span class="sr-only">icon</span></i>
                                            Bases
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a href="eventSingle.html" class="btn btnCustomLightOutline bdrWidthAlter btn-sm text-capitalize position-relative border-1 p-0 flex-shrink-0 ml-md-4" style="border-color: #06163a" data-hover="Postular" target="_blank">
                                <span class="d-block btnText">Abierto</span>
                            </a>
                        </div>
                    </div>
                </article>
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
<script defer>
    $(document).on('click', '#buscarConvocatoria', BuscarConvocatoria);

    function BuscarConvocatoria() {
        let formData = {
            fechaDesde: $('#dp4').val(),
            fechaHasta: $('#dp1').val(),
            palabra: $('#palabra').val()
        };
        $.ajax({
            url: '/transparencia/convocatoria/buscar',
            method: 'POST',
            data: formData,
            beforeSend: function() {
                $('#spinner').hide();
            },
            success: function(response) {
                let resp = JSON.parse(response);
                if (resp.status === 'success') {
                    $('.convocatorias').html('<div class="row datos"></div>');
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
            pageSize: 10,
            ulClassName: 'pagination justify-content-center pt-2',
            callback: function(data, pagination) {
                $('.datos').append(data.join(''));
                $('.paginationjs li').addClass('page-item');
                $('.paginationjs a').addClass('page-link');
            },

        });
    }
</script>