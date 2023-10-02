<link rel="stylesheet" href="<?= $link ?>">
<main>
    <div class="mt-4 p-4">
        <h1 class="text-monospace ml-3" style="font-size: 40px">Transparencia <i class="fas fa-angle-right"></i> Saldos de balance</h1>
    </div>
    <article class="dsSingleContent pt-4 pb-2 pt-md-7 pb-md-1 pt-lg-4 pb-lg-10 pt-xl-3 pb-xl-16 bg-white">
        <div class="container saldo-container">
            <div class="ifbFilterHead col-12 bg-light px-4 pb-3 px-lg-4 pb-lg-1 mb-2 d-flex justify-content-center pb-2 mb-3">
                <div class="form-inline mx-n3 mt-3 px-4 justify-content-center">
                    <div class="col-12">
                        <h4 class="text-center">Buscador de Saldos de Balance</h4>
                    </div>
                    <div class="form-group col-sm-12 col-md-4">
                        <label class="d-block fwMedium fontAlter text-lDark mb-2 mr-3">Año</label>
                        <?php $cont = date('Y'); ?>
                        <select class="custom-select inputHeightMedium inputBdrTransparent shadow date-start">
                            <?php while ($cont >= 2000) { ?>
                                <option value="<?= ($cont); ?>"><?= ($cont); ?></option>
                            <?php $cont = ($cont - 1);
                            } ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-12 col-md-4">
                        <label class="d-block fwMedium fontAlter text-lDark mb-2 mr-3"></label>
                        <button id="searchSaldoBalance" type="button" class="btn btnTheme btnNoOver d-flex align-items-center justify-content-center" data-hover="Buscar">
                            <i class="icomoon-search"><span class="sr-only">Buscar</span></i>
                        </button>
                    </div>
                </div>
            </div>
            <section class="ItemfullBlock pb-md-9 pb-lg-13 pb-xl-19">
                <div class="container">
                    <div class="pt-3 pb-3 pt-lg-3 pb-lg-9 pt-xl-7 pb-xl-12 saldo-balance">
                        <?php
                        foreach ($dataTable as $data) :
                            $fechaFormat = DateTime::createFromFormat('Y-m-d', $data['docs_date']);
                            $fechaFormatLoad = DateTime::createFromFormat('Y-m-d', $data['load_date']);
                            $formato = new IntlDateFormatter('es_Es', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                            $fecha = explode(' ', $formato->format($fechaFormat));
                            $partialPath = $fechaFormatLoad->format('Y/m/');
                            $files = json_decode($data['files'], true);
                            $id = $data['id'];
                        ?>
                            <article class="ueEveColumn__list position-relative px-4 py-3 px-lg-8 py-lg-6">
                                <div class="d-lg-flex align-items-md-center">
                                    <span class="flex-shrink-0 mr-4 mr-lg-6 d-block mb-2 mb-lg-0">Corresponde al : </span>
                                    <time class="uecTime text-lDark fontAlter text-uppercase flex-shrink-0 mr-4 mr-lg-6 d-block mb-2 mb-lg-0">
                                        <span class="textLarge"><?= $fecha[0] ?></span> <?= $fecha[2] ?>
                                        <span class="d-block textDay fwMedium pt-1"><?= $fecha[4] ?></span>
                                    </time>
                                    <div class="d-md-flex align-items-md-center flex-grow-1">
                                        <div class="imgHolder rounded-circle overflow-hidden flex-shrink-0 mr-4 mr-lg-10 mb-1 mb-md-0">
                                            <img src="<?= _BASE_URL . '/assets/images/saldosdebalance.webp' ?>" class="img-fluid rounded-circle lozad" alt="icono saldo balance" width="200" height="200">
                                        </div>
                                        <div class="descrWrap flex-grow-1">
                                            <strong class="tagTitle d-block text-secondary fwSemiBold mb-2">Saldo de Balance</strong>
                                            <h3 class="fwMedium">
                                                <p><?= $data['title']; ?></p>
                                            </h3>
                                            <ul class="list-unstyled ueScheduleList mb-0">
                                                <li>
                                                    <i class="icomoon-clock icn position-absolute"><span class="sr-only">icon</span></i>
                                                    Subido : <?= $data['load_date']; ?>
                                                </li>
                                            </ul>
                                        </div>
                                        <a href="javascript:void(0);" class="btn btnCustomLightOutline bdrWidthAlter btn-sm text-capitalize position-relative border-0 p-0 flex-shrink-0 ml-md-4" data-hover="Más detalles" data-toggle="collapse" data-target="#data-<?= $id ?>">
                                            <span class="d-block btnText">Ver documentos</span>
                                        </a>
                                    </div>
                                </div>
                                <div id="data-<?= $id ?>" class="collapse" aria-label="Archivos adjuntos">
                                    <div class="descrWrap mt-3">
                                        <p class="d-block fileSize text-dark card-text mb-1"> <i class="fal fa-file-pdf"></i> Archivos:</p>
                                        <div class="row row-cols-3 p-3">
                                            <?php foreach ($files as $file) : ?>
                                                <a href="<?= _BASE_URL ?>/files/transparencia/presupuesto/saldo-balance/<?= $partialPath . $file['file'] ?>" class=""><?= $file['namefile'] ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <div class="paginador-saldo-balance">
                <?= $Paginador ?>
            </div>
        </div>
    </article>
</main>