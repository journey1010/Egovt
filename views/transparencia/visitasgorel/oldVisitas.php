<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<main class="breadcrumb">
    <div class="container-fluid">
        <div class="container bg-white p-3">
            <h3 class="text-blue mb-2 text-center">REGISTRO ANTIGUO DE VISITAS AL GOBIERNO REGIONAL DE LORETO</h3>
            <strong class="d-block text-secondary mb-3 text-center">SEDE CENTRAL</strong>
        </div>
        <div class="container bg-white p-3">
            <div class="table-responsive">
                <table id="tabla" class="border border-danger dataTable  responsive table-hover" style="width:100%">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th class="text-nowrap">#</th>
                            <th class="text-nowrap ">Descripción</th>
                            <th>fecha</th>
                            <th class="text-nowrap">Archivo</th>
                        </tr>
                    </thead>
                    <tbody id="tablaBody">
                        <?= $tablaFila ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script id="rowChildDatatable">
    $(document).ready(function() {
        var table = $('#tabla').DataTable({
            stateSave: true,
            paging: true,
            searching: false,
            ordering: true,
            info: false,
            pagingType: "simple_numbers",
            language: {
                lengthMenu: "Mostrar _MENU_ registros por página",
                zeroRecords: "No se encontraron resultados",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                paginate: {
                    first: 'Primera',
                    last: 'Última',
                    next: 'Siguiente',
                    previous: 'Anterior'
                }
            }
        });
    });
</script>