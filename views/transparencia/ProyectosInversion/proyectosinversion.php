<link rel="stylesheet" href="<?= $dataTableCss?>">
<main>
	<article class="dsSingleContent pt-4 pb-2 pt-md-4 pb-md-1 pt-lg-4 pb-lg-10 pt-xl-4 pb-xl-16">
		<div class="container position-relative hasFilterPositioned">
			<div class="row">
				<div class="col-12 col-lg-8 col-xl-9 order-lg-2 mb-6">
					<div class="pl-xl-14">
						<div class="row">
							<div class="ifbFilterHead col-12 bg-light px-4 pt-4 pb-3 px-lg-4 pt-lg-4 pb-lg-1">
								<div class="form-row mx-n3 align-items-end">
									<div class="formCol px-3">
										<div class="form-group">
											<label class="d-block fwMedium fontAlter text-lDark mb-2">Año</label>
											<select id="año" class="custom-select inputHeightMedium inputBdrTransparent shadow">
												<?php
												$current_year = date('Y');
												$end_year = 2008;
												for ($year = $current_year; $year >= $end_year; $year--) {
													echo '<option value="' . $year . '">' . $year . '</option>';
												}
												?>
											</select>
										</div>
									</div>
									<div class="formCol px-3">
										<div class="form-group">
											<label class="d-block fwMedium fontAlter text-lDark mb-2">Tipo</label>
											<select id="tipo" class="custom-select inputHeightMedium inputBdrTransparent shadow">
												<option value="Adicionales de obra">Adicionales de obra</option>
												<option value="Liquidacíon de obras">Liquidacíon de obras</option>
												<option value="Supervisión de contrataciones">Supervisión de contrataciones</option>
												<option value="Historico">Historico</option>
												<option value="Información Adicional">Información adicional</option>
											</select>
										</div>
									</div>

									<div class="formCol px-3">
										<div class="form-group">
											<label class="d-block fwMedium fontAlter text-lDark mb-2">Palabra clave</label>
											<input id="palabra" type="text" class="form-control inputHeightMedium inputBdrTransparent d-block w- shadow">
										</div>
									</div>
									<button id="buscar" type="button" class="btn btnTheme ml-lg-3 mt-4 mt-lg-0 ml-auto mr-auto mr-lg-0 font-weight-bold btnMinSm text-capitalize position-relative border-0 p-0" data-hover="Buscar">
										<span class="d-block btnText">Buscar</span>
									</button>
								</div>
							</div>
							<div id="resultados" class="col-12 p-1">
								<?= $tablaFila ?>
								<?= $paginadorHtml ?>
							</div>
							<div id="spinner" class="mt-1" style="display:none;">
								<i class="fa fa-spinner fa-spin"></i> Cargando...
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 col-xl-3 order-lg-1 mb-6 position-static">
					<aside class="dscSidebar pt-1 mr-xl-n5">
						<nav class="widget mb-6 mb-lg-10 widgetFiltersNav widgetBgLight py-3 py-lg-5 px-2">
							<h3 class="fwSemiBold mb-4 position-relative">Documentos </h3>
							<ul class="list-unstyled pl-0 mx-n2 mb-0 mb-3 isoFiltersList">
								<li name="panel">
									<a class="enlace" href="/transparencia/proyecto-de-inversion-publica">Todos los documentos</a>
								</li>
								<li name="panel">
									<a class="enlace" href="/transparencia/proyecto-de-inversion-publica/adicionales-de-obra">Adicionales de obra</a>
								</li>
								<li name="panel">
									<a class="enlace" href="/transparencia/proyecto-de-inversion-publica/liquidacion-de-obras">Liquidación de obras</a>
								</li>
								<li name="panel">
									<a class="enlace" href="/transparencia/proyecto-de-inversion-publica/supervision-de-obras">Supervisión de contrataciones</a>
								</li>
								<li name="panel">
									<a class="enlace" href="/transparencia/proyecto-de-inversion-publica/historico">Historico</a>
								</li>
								<li name="panel">
									<a class="enlace" href="/transparencia/proyecto-de-inversion-publica/informacion-adicional">Información adicional</a>
								</li>
							</ul>
						</nav>
					</aside>
				</div>
			</div>
		</div>
	</article>
</main>
