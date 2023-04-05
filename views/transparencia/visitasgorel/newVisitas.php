<link rel="stylesheet" href="<?= $link ?>">
<main class="breadcrumb">
    <div class="container-fluid">
        <div class="container bg-white p-3">
            <h3 class="text-blue mb-2 text-center">REGISTRO DE VISITAS AL GOBIERNO REGIONAL DE LORETO</h3>
            <strong class="d-block text-secondary mb-3 text-center">SEDE CENTRAL</strong>
        </div>
        <div class="container bg-white p-3">
            <div class="coupenEnterWrap d-flex justify-content-center align-items-center">
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group p-0">
                            <input type="text" class="datepicker form-control bg-transparent border-dark" value="" id="dp4" />
                            <button class="btn btnTheme btnNoOver d-flex align-items-center justify-content-center" type="button">
                                <i class="icomoon-search\"><span class="sr-only">Buscar</span></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="ocultar" class="border border-danger display nowrap" style="width:100%">
                    <thead class="bg-danger text-white responsive">
                        <tr>
                            <th>Nombres del Visitante</th>
                            <th>Documento</th>
                            <th>Área</th>
                            <th>Visitado</th>
                            <th>Ingreso</th>
                            <th>Salida</th>
                            <th>Autorización</th>
                            <th>Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script src="<?= $jsDatapicker ?>"></script>
<script src="<?= $jsMaterialkit ?>"></script>