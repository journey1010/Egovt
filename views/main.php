<style>
      #my-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: none;
        justify-content: center;
        align-items: center;
      }

      #my-modal img {
        max-width: 80%;
        max-height: 80%;
      }

      #my-modal.show {
        display: flex;
      }

      #close-modal {
        position: absolute;
        top: 10px;
        right: 10px;
        color: #fff;
        font-size: 24px;
        cursor: pointer;
        background-color: rgba(0,0,0,0.5);
        border-radius: 50%;
        padding: 10px;
        border: none;
      }
</style>
<div id="my-modal">
	<img id="myImage" src="<?= _ROOT_ASSETS . 'images/modalinicio.png' ?>">
    <button id="close-modal" onclick="hideModal()" aria-label="Cerrar">&times;</button>
</div>
<main>
	<div class="introBlock ibSlider">
		<div>
			<article class="d-flex w-100 position-relative ibColumn text-white overflow-hidden">
				<div class="alignHolder d-flex align-items-center w-100">
					<div class="align w-100 pt-20 pb-20 pt-md-40 pb-md-30 px-md-17">
						<div class="container position-relative">
							<div class="row">
								<div class="col-12 col-md-9 col-xl-7 fzMedium">
									<h1 class="text-white mb-4 h1Large">Bienvenidos al portal local del Gobierno regiónal de Loreto</h1>
									<p>La más extensa guía para conocer lo que se está trabajando en nuestro departamento.</p>
									<a href="/enconstruccion" class="btn btnTheme font-weight-bold btnMinSm text-capitalize position-relative border-0 p-0 mt-6" data-hover="Descubre más">
										<span class="d-block btnText">Descubre más</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<span class="ibBgImage bgCover position-absolute" style="background-image: url(<?php echo _ROOT_ASSETS . 'images/banners/portada0.jpg' ?>);"></span>
			</article>
		</div>
		<div>
			<article class="d-flex w-100 position-relative ibColumn text-white overflow-hidden">
				<div class="alignHolder d-flex align-items-center w-100">
					<div class="align w-100 pt-20 pb-20 pt-md-40 pb-md-30 px-md-17">
						<div class="container position-relative">
							<div class="row">
								<div class="col-12 col-md-9 col-xl-7 fzMedium">
									<a href="/enconstruccion" class="btn btnTheme font-weight-bold btnMinSm text-capitalize position-relative border-0 p-0 mt-6" data-hover="Descubre más">
										<span class="d-block btnText">Descubre más</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<span class="ibBgImage bgCover position-absolute" style="background-image: url(<?php echo _ROOT_ASSETS . 'images/banners/portada1.jpg' ?>);"></span>
			</article>
		</div>
		<div>
			<article class="d-flex w-100 position-relative ibColumn text-white overflow-hidden">
				<div class="alignHolder d-flex align-items-center w-100">
					<div class="align w-100 pt-20 pb-20 pt-md-40 pb-md-30 px-md-17">
						<div class="container position-relative">
							<div class="row">
								<div class="col-12 col-md-9 col-xl-7 fzMedium">
									<a href="/enconstruccion" class="btn btnTheme font-weight-bold btnMinSm text-capitalize position-relative border-0 p-0 mt-6" data-hover="Descubre más">
										<span class="d-block btnText">Descubre más</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<span class="ibBgImage bgCover position-absolute" style="background-image: url(<?php echo _ROOT_ASSETS . 'images/banners/portada2.jpg' ?>);"></span>
			</article>
		</div>
		<div>
			<article class="d-flex w-100 position-relative ibColumn text-white overflow-hidden">
				<div class="alignHolder d-flex align-items-center w-100">
					<div class="align w-100 pt-20 pb-20 pt-md-40 pb-md-30 px-md-17">
						<div class="container position-relative">
							<div class="row">
								<div class="col-12 col-md-9 col-xl-7 fzMedium">
									<a href="<?php echo _BASE_URL ?> " class="btn btnTheme font-weight-bold btnMinSm text-capitalize position-relative border-0 p-0 mt-6" data-hover="Descubre más">
										<span class="d-block btnText">Descubre más</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<span class="ibBgImage bgCover position-absolute" style="background-image: url(<?php echo _ROOT_ASSETS . 'images/banners/portada3.jpg' ?>);"></span>
			</article>
		</div>
	</div>
	<aside class="featuresAsideBlock position-relative text-white">
		<div class="container">
			<div class="flatpWrap position-relative mt-n8 mt-md-n18">
				<ul class="list-unstyled fabFeaturesList mb-0 d-flex overflow-hidden flex-wrap">
					<li>
						<a href="https://portalanterior.regionloreto.gob.pe/noticias" class="fflColumn d-block w-100 text-center px-2 pt-4 pb-10">
							<span class="icnWrap d-flex align-items-center justify-content-center mx-auto mb-4 rounded-circle">
								<i class="fa fa-newspaper-o"><span class="sr-only">icon</span></i>
							</span>
							<h2 class="mb-0">Noticias</h2>
						</a>
					</li>
					<li>
						<a href="https://facilita.gob.pe/t/641" class="fflColumn d-block w-100 text-center px-2 pt-4 pb-10">
							<span class="icnWrap d-flex align-items-center justify-content-center mx-auto mb-4 rounded-circle">
								<i class="fa fa-tablet"><span class="sr-only">icon</span></i>
							</span>
							<h2 class="mb-0">Mesa <br> de Partes Virtual</h2>
						</a>
					</li>
					<li>
						<a href="https://portalanterior.regionloreto.gob.pe/fideicomiso" class="fflColumn d-block w-100 text-center px-2 pt-4 pb-10">
							<span class="icnWrap d-flex align-items-center justify-content-center mx-auto mb-4 rounded-circle">
								<i class="fa fa-folder-o"></i><span class="sr-only">icon</span></i>
							</span>
							<h2 class="mb-0">Fideicomiso</h2>
						</a>
					</li>
					<li>
						<a href="https://correo.regionloreto.gob.pe/" class="fflColumn d-block w-100 text-center px-2 pt-4 pb-10">
							<span class="icnWrap d-flex align-items-center justify-content-center mx-auto mb-4 rounded-circle">
								<i class="fa fa-envelope-open-o"><span class="sr-only">icon</span></i>
							</span>
							<h2 class="mb-0">Correo Institucional</h2>
						</a>
					</li>
					<li>
						<a href="https://aplicaciones02.regionloreto.gob.pe/" class="fflColumn d-block w-100 text-center px-2 pt-4 pb-10">
							<span class="icnWrap d-flex align-items-center justify-content-center mx-auto mb-4 rounded-circle">
								<i class="fa fa-folder-o"><span class="sr-only">icon</span></i>
							</span>
							<h2 class="mb-0">Resoluciones</h2>
						</a>
					</li>
					<li>
						<a href="https://portalanterior.regionloreto.gob.pe/corcytec/" class="fflColumn d-block w-100 text-center px-2 pt-4 pb-10">
							<span class="icnWrap d-flex align-items-center justify-content-center mx-auto mb-4 rounded-circle">
								<i class="fa fa-android"><span class="sr-only">icon</span></i>
							</span>
							<h2 class="mb-0">CORCYTEC</h2>
						</a>
					</li>
					<li>
						<a href="https://portalanterior.regionloreto.gob.pe/files/plan-operativo-institucional/2020/02/POIM_2020-2022-GORE_LORETO.pdf" class="fflColumn d-block w-100 text-center px-2 pt-4 pb-10">
							<span class="icnWrap d-flex align-items-center justify-content-center mx-auto mb-4 rounded-circle">
								<i class="fa fa-file-text-o"><span class="sr-only">icon</span></i>
							</span>
							<h2 class="mb-0">POI</h2>
						</a>
					</li>
					<li>
						<a href="https://regionloreto.gob.pe/files/plan-estrategico-institucional/2019/PEI_LORETO_2019-2022.pdf" class="fflColumn d-block w-100 text-center px-2 pt-4 pb-10">
							<span class="icnWrap d-flex align-items-center justify-content-center mx-auto mb-4 rounded-circle">
								<i class="fa fa-file-text-o"><span class="sr-only">icon</span></i>
							</span>
							<h2 class="mb-0">PEI</h2>
						</a>
					</li>
					<li>
						<a href="https://consulta.regionloreto.gob.pe/" class="fflColumn d-block w-100 text-center px-2 pt-4 pb-10">
							<span class="icnWrap d-flex align-items-center justify-content-center mx-auto mb-4 rounded-circle">
								<i class="fa fa-envelope-open-o"><span class="sr-only">icon</span></i>
							</span>
							<h2 class="mb-0">Consulta tu<br> Trámite</h2>
						</a>
					</li>
					<li>
						<a href="https://regionloreto.gob.pe/files/reglamento-organizacion-funciones/2018/ROF_GorelMayo2018.pdf" class="fflColumn d-block w-100 text-center px-2 pt-4 pb-10">
							<span class="icnWrap d-flex align-items-center justify-content-center mx-auto mb-4 rounded-circle">
								<i class="fa fa-file-text-o"><span class="sr-only">icon</span></i>
							</span>
							<h2 class="mb-0"> ROF</h2>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="fabBtNoteTextWrap text-center fontAlter fzMedium pt-6 pt-md-10 pb-6 pb-md-10 pb-lg-14">
			<div class="container">
				<div class="d-lg-flex justify-content-center align-items-center">
					<p class="mb-lg-0">La más extensa guía para conocer en lo que se está trabajando en nuestro departamento.</p>
					<a href="/enconstruccion" class="btn btn-dark btnSwitchDark fwMedium position-relative border-0 p-0 btnCustomSmall mt-md-1 mt-lg-0 ml-lg-4" data-hover="Explora más"><span class="d-block btnText fwMedium">Exploremos más</span></a>
				</div>
			</div>
		</div>
	</aside>
	<aside class="counterftAsideBlock position-relative text-center text-white d-flex bg-dark">
		<div class="alignHolder d-flex align-items-center w-100 position-relative">
			<div class="align w-100 pt-9 pb-5">
				<div class="container">
					<ul class="list-unstyled cfbFeatList d-flex flex-wrap mb-0 justify-content-center">
						<li>
							<span class="icnWrap d-flex align-items-center justify-content-center w-100 mb-4">
								<i class="icomoon-ico7" style="color: white;"><span class="sr-only">icon</span></i>
							</span>
							<h3 class="fwSemiBold text-white textCount mb-3"><span>1 </span>M Hab.</h3>
							<h4 class="subtitle mb-0 font-weight-normal">Total de personas <br>en nuestro departamento</h4>
						</li>
						<li>
							<span class="icnWrap d-flex align-items-center justify-content-center w-100 mb-4">
								<i class="icomoon-ico8" style="color: white;"><span class="sr-only">icon</span></i>
							</span>
							<h3 class="fwSemiBold text-white textCount mb-3"><span>368 851</span> &#13218;</h3>
							<h4 class="subtitle mb-0 font-weight-normal">Superficie <br>Total de la región</h4>
						</li>
						<li>
							<span class="icnWrap d-flex align-items-center justify-content-center w-100 mb-4">
								<i class="icomoon-ico9"><span class="sr-only" style="color: white;">icon</span></i>
							</span>
							<h3 class="fwSemiBold text-white textCount mb-3"><span>2 375 </span> K</h3>
							<h4 class="subtitle mb-0 font-weight-normal">Centros <br>Poblados</h4>
						</li>
						<li>
							<span class="icnWrap d-flex align-items-center justify-content-center w-100 mb-4">
								<i class="icomoon-ico10" style="color: white;"><span class="sr-only">icon</span></i>
							</span>
							<h3 class="fwSemiBold text-white textCount mb-3"><span>0,633 </span>Medio</h3>
							<h4 class="subtitle mb-0 font-weight-normal">Índice de desarrollo <br>humano</h4>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<span class="cfbBgWrap bgCover position-absolute h-100 w-100 inaccessible" style="background-image: url(images/bg01.png);"></span>
	</aside>
	<section class="exploreHeightsBlock pt-4 pb-6 pb-md-9 pt-lg-7 pb-lg-14 pt-xl-11 pb-xl-20">
		<div class="container">
			<header class="headingHead text-center mb-12">
				<h2 class="fwSemiBold">Sitios Externos</h2>
			</header>
		</div>
		<div class="row">
			<div class="echSliderWrap overflow-hidden w-100">
				<div class="echSlider mx-auto w-100">
					<div>
						<div class="col-12">
							<div class="echColumn d-block w-100 bgCover position-relative" style="background-image: url('<?php echo _ROOT_ASSETS . 'images/enlaces_externos/Procompite.png' ?>');">
								<div class="echcCaptionWrap position-absolute w-100 text-white px-3 py-2 px-sm-5 py-sm-4">
									<h3 class="mb-0 text-white">
										<strong class="d-block font-weight-normal fontBase echCatTitle mb-1">Gobierno</strong>
										<span class="d-block">PROCOMPITE</span>
									</h3>
									<a href="https://procompite.produce.gob.pe/" class="d-inline-block" title="Procompite"><i class="rounded-circle icomoon-arrowRight d-flex align-items-center justify-content-center bg-white text-dark spanLinkGo"><span class="sr-only">icon</span></i></a>
								</div>
							</div>
						</div>
					</div>
					<div>
						<div class="col-12">
							<div class="echColumn d-block w-100 bgCover position-relative" style="background-image: url('<?php echo _ROOT_ASSETS . 'images/enlaces_externos/sencico.jpg' ?>');">
								<div class="echcCaptionWrap position-absolute w-100 text-white px-3 py-2 px-sm-5 py-sm-4">
									<h3 class="mb-0 text-white">
										<strong class="d-block font-weight-normal fontBase echCatTitle mb-1">Capacitación</strong>
										<span class="d-block">SENCICO</span>
									</h3>
									<a href="https://cursos.sencico.gob.pe/" class="d-inline-block" title="Cursos sencico"><i class="rounded-circle icomoon-arrowRight d-flex align-items-center justify-content-center bg-white text-dark spanLinkGo"><span class="sr-only">icon</span></i></a>
								</div>
							</div>
						</div>
					</div>
					<div>
						<div class="col-12">
							<div class="echColumn d-block w-100 bgCover position-relative" style="background-image: url('<?php echo _ROOT_ASSETS . 'images/enlaces_externos/observatoriodeviolencia.jpg' ?>');">
								<div class="echcCaptionWrap position-absolute w-100 text-white px-3 py-2 px-sm-5 py-sm-4">
									<h3 class="mb-0 text-white">
										<strong class="d-block font-weight-normal fontBase echCatTitle mb-1">Ayuda social</strong>
										<span class="d-block">Observatorio de violencia regional</span>
									</h3>
									<a href="https://www.observatorioviolencia.regionloreto.com/" class="d-inline-block" title="Observatorio regional contra la violencia"><i class="rounded-circle icomoon-arrowRight d-flex align-items-center justify-content-center bg-white text-dark spanLinkGo"><span class="sr-only">icon</span></i></a>
								</div>
							</div>
						</div>
					</div>
					<div>
						<div class="col-12">
							<div class="echColumn d-block w-100 bgCover position-relative" style="background-image: url('<?php echo _ROOT_ASSETS . 'images/enlaces_externos/rutadigital.jpg' ?>');">
								<div class="echcCaptionWrap position-absolute w-100 text-white px-3 py-2 px-sm-5 py-sm-4">
									<h3 class="mb-0 text-white">
										<strong class="d-block font-weight-normal fontBase echCatTitle mb-1">Capacitación digital</strong>
										<span class="d-block">Ruta digital</span>
									</h3>
									<a href="https://rutadigital.produce.gob.pe/home/Inicio" class="d-inline-block" title="ruta digital"><i class="rounded-circle icomoon-arrowRight d-flex align-items-center justify-content-center bg-white text-dark spanLinkGo"><span class="sr-only">icon</span></i></a>
								</div>
							</div>
						</div>
					</div>
					<div>
						<div class="col-12">
							<div class="echColumn d-block w-100 bgCover position-relative" style="background-image: url('<?php echo _ROOT_ASSETS . 'images/enlaces_externos/tuempresa.jpg'  ?>');">
								<div class="echcCaptionWrap position-absolute w-100 text-white px-3 py-2 px-sm-5 py-sm-4">
									<h3 class="mb-0 text-white">
										<strong class="d-block font-weight-normal fontBase echCatTitle mb-1">Capacitación</strong>
										<span class="d-block">Tu empresa</span>
									</h3>
									<a href="https://www.tuempresa.gob.pe/" class="d-inline-block" title="Tu empresa digital"><i class="rounded-circle icomoon-arrowRight d-flex align-items-center justify-content-center bg-white text-dark spanLinkGo"><span class="sr-only">icon</span></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<script>
      window.onload = function() {
        var modal = document.getElementById("my-modal");
        modal.classList.add("show");

        modal.addEventListener("click", function(event) {
          if (event.target === modal) {
            hideModal();
          }
        });
      };

      function hideModal() {
        var modal = document.getElementById("my-modal");
        modal.classList.remove("show");
      }
</script>