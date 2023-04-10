<link rel="stylesheet" href="<?= $link ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
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
                            <button id="btnFecha" class="btn btnTheme btnNoOver d-flex align-items-center justify-content-center" type="button">
                                <i class="icomoon-search"><span class="sr-only">Buscar</span></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tabla" class="border border-danger  responsive table-hover" style="width:100%">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th class="text-nowrap ">Nombres del Visitante</th>
                            <th>Documento</th>
                            <th>Área</th>
                            <th class="text-nowrap">¿A quién visita?</th>
                            <th>Ingreso</th>
                            <th>Salida</th>
                            <th>Autorización</th>
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
<script src="<?= $jsDatapicker ?>"></script>
<script src="<?= $jsMaterialkit ?>"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script id="rowChildDatatable">
    $(document).ready(function() {
        var table = $('#tabla').DataTable({
            stateSave: true,
            paging: false,
            searching: false,
            ordering: false,
            info: false
        });
        table.columns([6, 7]).visible(false);

        $('#tabla tbody').on('click', '.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });

        function format(rowData) {
            data = `
                <div style>
                    <p style=" margin-bottom: 0px; overflow-wrap: anywhere"><strong>Autorización:</strong> <br> ${rowData[6]}</p> 
                    <p style=" margin-bottom: 0px; overflow-wrap: anywhere"><strong>Motivo:</strong> <br> ${rowData[7]}</p>
                </div>
                `;
            return data;
        }
    });
</script>
<script>
    $(document).on('click', '#btnFecha', function() {
        fecha = $('#dp4').val();
        if (fecha !== '') {
            $.ajax({
                url: '/transparencia/visitas-nuevas/post',
                method: 'POST',
                data: {
                    fecha: fecha
                },
                success: function(data) {
                    try {
                        let jsonData = JSON.parse(data);
                        $('#rowChildDatatable').html();
                        $('.table-responsive').html(jsonData.error);
                    } catch (e) {
                        $('#rowChildDatatable').html();
                        $('.table-responsive').html(data);
                        filaSecundaria();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(`Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`);
                }
            });
        }

        function filaSecundaria() {
            var table = $('#tabla').DataTable({
                lengthChange: false,
                stateSave: true,
                searching: false,
                ordering: false,
                info: false,
                pagingType: "simple_numbers",
                language: {
                    paginate: {
                        first: 'Primera',
                        last: 'Última',
                        next: 'Siguiente',
                        previous: 'Anterior'
                    }
                }
            });
            table.columns([6, 7]).visible(false);

            $('#tabla tbody').on('click', '.details-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });

            function format(rowData) {
                data = `
                <div>
                    <p style=" margin-bottom: 0px; overflow-wrap: anywhere"><strong>Autorización:</strong> <br> ${rowData[6]}</p> 
                    <p style=" margin-bottom: 0px; overflow-wrap: anywhere"><strong>Motivo:</strong> <br> ${rowData[7]}</p>
                </div>
                `;
                return data;
            }
        }
    });
</script>