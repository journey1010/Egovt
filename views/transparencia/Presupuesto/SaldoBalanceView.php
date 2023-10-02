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
                        <?php $cont = date ('Y'); ?>
                        <select id="typeDoc" class="custom-select inputHeightMedium inputBdrTransparent shadow">
                            <?php while ($cont >= 2000) { ?>
                            <option value="<?= ($cont); ?>"><?= ($cont); ?></option>
                            <?php $cont = ($cont-1); } ?>
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
					<div class="pt-3 pb-3 pt-lg-3 pb-lg-9 pt-xl-7 pb-xl-12">
						<article class="ueEveColumn__list position-relative px-4 py-3 px-lg-8 py-lg-6">
							<div class="d-lg-flex align-items-md-center">
								<time datetime="2011-01-12" class="uecTime text-lDark fontAlter text-uppercase flex-shrink-0 mr-4 mr-lg-6 d-block mb-2 mb-lg-0">
									<span class="textLarge">01</span> October
									<span class="d-block textDay fwMedium pt-1">WEDNESDAY</span>
								</time>
								<div class="d-md-flex align-items-md-center flex-grow-1">
									<div class="imgHolder rounded-circle overflow-hidden flex-shrink-0 mr-4 mr-lg-10 mb-1 mb-md-0">
										<img src="images/img67.jpg" class="img-fluid rounded-circle" alt="image description">
									</div>
									<div class="descrWrap flex-grow-1">
										<strong class="tagTitle d-block text-secondary fwSemiBold mb-2">Entertainement</strong>
										<h3 class="fwMedium">
											<a href="eventSingle.html">Organizing City Photography Contest-2022</a>
										</h3>
										<ul class="list-unstyled ueScheduleList mb-0">
											<li>
												<i class="icomoon-clock icn position-absolute"><span class="sr-only">icon</span></i>
												9:30am - 1:00pm
											</li>
											<li>
												<i class="icomoon-location icn position-absolute"><span class="sr-only">icon</span></i>
												Mayor Office, Texas city
											</li>
										</ul>
									</div>
									<a href="eventSingle.html" class="btn btnCustomLightOutline bdrWidthAlter btn-sm text-capitalize position-relative border-0 p-0 flex-shrink-0 ml-md-4" data-hover="More Details">
										<span class="d-block btnText">More Details</span>
									</a>
								</div>
							</div>
						</article>
					</div>
				</div>
			</section>
            <div class="paginador-saldo-balance">
                <?= $Paginidaor ?>
            </div>
        </div>
    </article>
</main>