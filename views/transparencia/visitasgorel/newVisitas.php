<link rel="stylesheet" href="<?= $link ?>">
<link rel="stylesheet" href="<?= $dataTableCss?>">
<style>
    .details-control {
        display: inline-block;
        padding: 0.1em 0.3em;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #f1f1f1;
        cursor: pointer;
    }
    .details-control .fa {
        margin-right: 0.5em;
    }
</style>
<main class="mt-3">
    <div class="container-fluid">
        <div class="container bg-white p-1">
            <h3 class="text-blue mb-2 text-center">REGISTRO DE VISITAS AL GOBIERNO REGIONAL DE LORETO</h3>
            <strong class="d-block text-secondary mb-3 text-center">SEDE CENTRAL</strong>
        </div>
        <div class="container bg-white p-1">
            <div class="coupenEnterWrap d-flex justify-content-center align-items-center">
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group p-0">
                            <input type="text" class="datepicker form-control bg-transparent border-dark date-visita" value="<?= date('Y-m-d') ?>"data-date-format="yyyy-mm-dd"/>
                            <button id="btnFecha" class="btn btnTheme btnNoOver d-flex align-items-center justify-content-center" type="button">
                                <i class="icomoon-search"><span class="sr-only">Buscar</span></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tabla" class="border border-danger  responsive table-hover" style="width:100%; font-size: 16px">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>Nombre del Visitante</th>
                            <th>Documento</th>
                            <th>Institución</th>
                            <th>Área</th>
                            <th>¿A quién visita?</th>
                            <th>Ingreso</th>
                            <th>Salida</th>
                            <th>Motivo</th>
                        </tr>
                    </thead>
                    <tbody id="tablaBody">
                        <?= $tablaFila ?>
                    </tbody>
                </table>
                <?= $paginadorHtml ?>
            </div>
        </div>
    </div>
</main>