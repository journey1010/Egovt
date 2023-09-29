<link rel="stylesheet" href="<?= $link ?>">
<main>
    <div class="mt-4 p-4">
        <h1 class="text-monospace ml-3" style="font-size: 40px">Transparencia <i class="fas fa-angle-right"></i>
            <?php 
                switch($tipo){
                    case 'documentos':
                        echo 'Participación ciudadana';
                    break;
                    case 'presupuesto':
                        echo 'Participación ciudadana - Presupuesto Participativo';
                    break;
                    case 'consejo':
                        echo 'Participación ciudadana - Consejo de Coordinación Regional/Local';
                    break; 
                    case 'audiencia':
                        echo 'Participación ciudadana - Audiencia Públicas';
                    break;
                    case 'informacion':
                        echo 'Participación ciudadana - Información Adicional';
                    break;
                }
            ?> 
        </h1>
    </div>
    <article class="dsSingleContent pt-4 pb-2 pt-md-7 pb-md-1 pt-lg-4 pb-lg-10 pt-xl-3 pb-xl-16">
        <div class="container">
            <div class="row">
				<div class="col-12 col-lg-8 col-xl-9 order-lg-2 mb-6">
					<div class="pl-xl-14">
                        <div class="ifbFilterHead col-12 bg-light px-4 pt-4 pb-3 px-lg-4 pt-lg-4 pb-lg-1">
                            <div class="form-row mx-n3 align-items-end">
                                <div class="formCol px-3">
                                    <div class="form-group">
                                        <label class="d-block fwMedium fontAlter text-lDark mb-2 mr-3">Desde </label>
                                        <input type="date" class="datepicker form-control bg-transparent border-dark date-start" data-date-format="yyyy-mm-dd"/>
                                    </div>
                                </div>
                                <div class="formCol px-3">
                                    <div class="form-group">
                                        <label class="d-block fwMedium fontAlter text-lDark mb-2 mr-3">Hasta </label>
                                        <input type="date" class="datepicker form-control bg-transparent border-dark date-end" data-date-format="yyyy-mm-dd"/>
                                    </div>
                                </div>
                                <div class="formCol px-3">
                                    <div class="form-group">
                                        <label class="d-block fwMedium fontAlter text-lDark mb-2">Tipo</label>
                                        <select id="typeDoc" class="custom-select inputHeightMedium inputBdrTransparent shadow">
                                            <option value="all" selected>Todo</option>
                                            <option value="Presupuesto Participativo">Presupuesto Participativo</option>
                                            <option value="Consejo de Coordinación Regional/Local">Consejo de Coordinación Regional/Local</option>
                                            <option value="Audiencia Públicas">Audiencia Públicas</option>
                                            <option value="Información Adicional">Información Adicional</option>
                                        </select>
                                    </div>
                                </div>
                                <button id="searchParticipaciónCiudadana" type="button" class="btn btnTheme ml-lg-3 mt-4 mt-lg-0 ml-auto mr-auto mr-lg-0 font-weight-bold btnMinSm text-capitalize position-relative border-0 p-0" data-hover="Buscar">
                                    <span class="d-block btnText">Buscar</span>
                                </button>
                            </div>
                        </div>
                        <div class="participacion-container">
                            <div class="card-columns mt-2 participacion-ciudadana">
                            <?php foreach ($dataTable as $row): ?>
                                <?php
                                    $fechaFormat = DateTime::createFromFormat('Y-m-d', $row['load_date']);
                                    $formato = new IntlDateFormatter('es_Es', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                                    $fecha = $formato->format($fechaFormat);
                                    $partialPath = $fechaFormat->format('Y/m/');
                                    $files = json_decode($row['files'], true);
                                ?>
                                <div class="card p-0">
                                    <div class="card-body">
                                        <div class="d-flex mb-3">
                                            <div class="descrWrap">
                                                <h5 class="fwSemiBold card-title"><?= $row['title'] ?></h5>
                                                <p class="d-block fileSize text-dark card-text"><?= $fecha ?></p>
                                                <strong class="d-block fileSize font-weight-normal card-text"><?= $row['descriptions'] ?></strong>
                                            </div>
                                        </div>
                                        <div class="d-flex mb-3">
                                            <div class="descrWrap">
                                                <p class="d-block fileSize text-dark card-text mb-1"> <i class="fal fa-file-pdf"></i> Archivos:</p>
                                                <div class="row-cols-1">
                                                    <?php foreach ($files as $file): ?>
                                                        <a href="<?= _BASE_URL ?>/files/transparencia/participacion-ciudadana/<?= $partialPath . $file['file'] ?>" class=""><?= $file['namefile'] ?></a>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                            </div>
                        </div>
					</div>
                    <div class="paginador-participacion-ciudadana">
                        <?= $Paginador ?>
                    </div>
				</div>
				<div class="col-12 col-lg-4 col-xl-3 order-lg-1 mb-6 position-static">
					<aside class="dscSidebar pt-1 mr-xl-n5">
						<nav class="widget mb-6 mb-lg-10 widgetFiltersNav widgetBgLight py-3 py-lg-5 px-2">
							<h3 class="fwSemiBold mb-4 position-relative">Documentos </h3>
							<ul class="list-unstyled pl-0 mx-n2 mb-0 mb-3 isoFiltersList">
                                <li name="panel" class="<?= ($tipo === 'documentos') ? 'active' : ''; ?>">
                                    <a class="enlace" href="/transparencia/participacion-ciudadana/documentos/?page=1">Todos los documentos</a>
                                </li>
                                <li name="panel" class="<?= ($tipo === 'presupuesto') ? 'active' : ''; ?>">
                                    <a class="enlace" href="/transparencia/participacion-ciudadana/presupuesto/presupuesto-participativo/?page=1">Presupuesto participativo</a>
                                </li>
                                <li name="panel" class="<?= ($tipo === 'consejo') ? 'active' : ''; ?>">
                                    <a class="enlace" href="/transparencia/participacion-ciudadana/consejo/consejo-de-coordinacion-regional/?page=1">Consejo de coordinación regional</a>
                                </li>
                                <li name="panel" class="<?= ($tipo === 'audiencia') ? 'active' : ''; ?>">
                                    <a class="enlace" href="/transparencia/participacion-ciudadana/audiencia/audiencia-publica/?page=1">Audiencia Pública</a>
                                </li>
                                <li name="panel" class="<?= ($tipo === 'informacion') ? 'active' : ''; ?>">
                                    <a class="enlace" href="/transparencia/participacion-ciudadana/informacion/información-adicional/?page=1">Información adicional</a>
                                </li>
							</ul>
						</nav>
					</aside>
				</div>
			</div>
        </div>
    </article>
</main>