<?php
require_once (_ROOT_MODEL . 'transparencia.php');
$visitas = new transparencia();
?>
<main class="breadcrumb">
    <div class="container-fluid">
        <div class="containe">
            <h3 class="text-blue mb-2 text-center">REGISTRO DE VISITAS AL GOBIERNO REGIONAL DE LORETO</h3>
            <strong class="d-block text-secondary mb-3 text-center">SEDE CENTRAL</strong>
        </div>
        <div class="coupenEnterWrap d-flex justify-content-center align-items-center">
            <div class="form-group row">
                <div class="col-md-12">
                    <div class="input-group p-0">
                        <input type="text" class="datepicker form-control bg-transparent border-dark" value="" id="dp4" />
                        <button class="btn btnTheme btnNoOver d-flex align-items-center justify-content-center" type="button">
                            <i class="icomoon-search"><span class="sr-only">Buscar</span></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container bg-white p-5">
            <table id="ocultar" class="display nowrap" style="width:100%">
                <thead>
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
                    <?php $visitas->tableViews(); ?>
                </tbody>
            </table>
        </div>
    </div>
</main>


    <script src="<?php echo _ROOT_ASSETS . 'js/bootstrap-datepicker.js' ?>"></script>
	<script src="<?php echo _ROOT_ASSETS . 'js/material-kit.js' ?>"></script>
	<script src="<?php echo _ROOT_ASSETS . 'js/jquery.dataTables.min.js' ?>"></script>
	<script src="<?php echo _ROOT_ASSETS . 'js/dataTables.responsive.min.js' ?>"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#ocultar').DataTable({
				responsive: true
			});
		});
	</script>