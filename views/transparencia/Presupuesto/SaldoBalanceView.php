<link rel="stylesheet" href="<?= $link ?>">
<main>
    <div class="mt-4 p-4">
        <h2 class="text-monospace ml-3">Transparencia <i class="fas fa-angle-right"></i> Saldos de balance</h2>
    </div>
    <article class="dsSingleContent pt-4 pb-2 pt-md-7 pb-md-1 pt-lg-4 pb-lg-10 pt-xl-3 pb-xl-16">
        <div class="container saldo-container">
            <div class="ifbFilterHead col-12 bg-light px-4 pb-3 px-lg-4 pb-lg-1 mb-2 d-flex justify-content-center pb-2 mb-3">
                <div class="form-inline mx-n3 align-items-center mt-3 px-4">
                    <div class="col-12">
                        <h4 class="text-center">Buscador de Saldos de Balance</h4>
                    </div>
                    <div class="form-group col-sm-12 col-md-4">
                        <label class="d-block fwMedium fontAlter text-lDark mb-2 mr-3">Desde  </label>
                        <input type="date" class="datepicker form-control bg-transparent border-dark date-start" data-date-format="yyyy-mm-dd" value=""/>
                    </div>
                    <div class="form-group col-sm-12 col-md-4">
                        <label class="d-block fwMedium fontAlter text-lDark mb-2 mr-3 ml-3">Hasta  </label>
                        <input type="date" class="datepicker form-control bg-transparent border-dark date-end" data-date-format="yyyy-mm-dd"/>
                    </div>
                    <div class="form-group col-sm-12 col-md-4">
                        <label class="d-block fwMedium fontAlter text-lDark mb-2 mr-3"></label>
                        <button id="searchSaldoBalance" type="button" class="btn btnTheme btnNoOver d-flex align-items-center justify-content-center" data-hover="Buscar">
                            <i class="icomoon-search"><span class="sr-only">Buscar</span></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-columns saldo-balance">
                <?php 
                    foreach ($dataTable as $row) {
                        $fechaFormat = DateTime::createFromFormat('Y-m-d', $row['load_date']);
                        $formato = new IntlDateFormatter('es_Es', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                        $fecha = $formato->format($fechaFormat); 
                        $div =  '<div class="card p-3">
                                    <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <span class="icnWrap pt-1 mr-3" style="font-size: 20px">
                                            <i class="fas fa-book"></i>
                                        </span>
                                        <div class="descrWrap">
                                        <h5 class="fwSemiBold">
                        ';
                        $div .= '<a href="https://regionloreto.gob.pe/files/transparencia/presupuesto/saldo-balance/'.$row['pathfile'].'" class="card-title" download>'. $row['title'].'</a><h5>';
                        $div .= '<strong class="d-block fileSize font-weight-normal card-text">' . $fecha . '</strong></div>';
                        $div .= '</div><a class="btn btn-outline light btnAlerDark btnNoOver btn-sm" "https://regionloreto.gob.pe/files/transparencia/presupuesto/saldo-balance/'.$row['pathfile'].'" download>Ver Documento</a></div></div>';
                        echo $div;
                    }
                ?>
            </div>
            <div class="paginador-saldo-balance">
                <?= $Paginidaor ?>
            </div>
        </div>
    </article>
</main>