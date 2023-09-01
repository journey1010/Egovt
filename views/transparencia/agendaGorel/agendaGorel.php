<link rel="stylesheet" href="<?= $link ?>">
<main>
    <section class="ItemfullBlock p-3">
        <div class="container p-3">
            <h3 class="text-blue mb-2 text-center">AGENDA DEL GOBERNADOR REGIONAL DE LORETO</h3>
            <strong class="d-block text-secondary mb-3 text-center">SEDE CENTRAL</strong>
            <div class="ifbFilterHead col-12 bg-light px-4 pt-4 pb-3 px-lg-4 pt-lg-4 pb-lg-1 mw-100 mb-7">
                <div class="form-row mx-n3 align-items-end">
                    <div class="formCol px-4">
                        <div class="form-group">
                            <label class="d-block fwMedium fontAlter text-lDark mb-2">Desde</label>
                            <input type="text" class="datepicker form-control border-dark date-agenda1" value="<?= date('Y-m-d') ?>" data-date-format="yyyy-mm-dd" />
                        </div>
                    </div>
                    <div class="formCol px-4">
                        <div class="form-group">
                            <label class="d-block fwMedium fontAlter text-lDark mb-2" >Hasta</label>
                            <input type="text" class="datepicker form-control bg-white border-dark date-agenda2" value="<?= date('Y-m-d') ?>" data-date-format="yyyy-mm-dd"/>
                        </div>
                    </div>
                    <div class="formCol px-4">
                        <div class="form-group">
                            <label class="d-block fwMedium fontAlter text-lDark mb-2">Palabra clave</label>
                            <input id="palabra" type="text" class="form-control border-dark">
                        </div>
                    </div>
                    <button id="buscarAgenda" type="button" class="btn btnTheme ml-lg-3 mt-4 mt-lg-0 ml-auto mr-auto mr-lg-0 font-weight-bold btnMinSm text-capitalize position-relative border-0 p-0" data-hover="Buscar">
                        <span class="d-block btnText">Buscar</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="container agendas">
            <div class="row">
                <?= $tablaFila ?>
            </div>
            <?= $paginadorHtml ?>
        </div>
        <div  class="d-flex justify-content-center" >
            <div id="spinner" class="spinner-border text-success" role="status" style="display:none">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </section>
</main>