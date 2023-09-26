<main>
    <div class="mt-4 mb-3 p-4">
        <h2 class="text-monospace ml-3">Transparencia <i class="fas fa-angle-right"></i> Saldos de balance</h2>
    </div>
    <article class="dsSingleContent pt-4 pb-2 pt-md-7 pb-md-1 pt-lg-8 pb-lg-10 pt-xl-11 pb-xl-16">
        <div class="container position-relative">
            <div class="card-columns">
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
                        $div .= '<a href="https://regionloreto.gob.pe/files/presupuesto/'.$row['pathfile'].'" class="card-title">'. $row['title'].'</a><h5>';
                        $div .= '<strong class="d-block fileSize font-weight-normal card-text">' . $fecha . '</strong></div>';
                        $div .= '</div><a class="btn btn-outline light btnAlerDark btnNoOver btn-sm">Ver Documento</a></div></div>';
                        echo $div;
                    }
                ?>
            </div>
        </div>
        <?= $Paginidaor ?>
    </article>
</main>

