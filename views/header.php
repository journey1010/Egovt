<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>GOREL - Gobierno regiónal de Loreto</title>
	<link rel="preconnect" href="https://fonts.googleapis.com/css2">
	<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400;0,500;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"> <!-- include the site bootstrap stylesheet -->
	<link rel="stylesheet" href="<?php echo _ROOT_ASSETS . 'css/bootstrap.css' ?>">
	<link rel="stylesheet" href="<?php echo _ROOT_ASSETS . 'css/style.css' ?>">
	<link rel="stylesheet" href="<?php echo _ROOT_ASSETS . 'css/colors.css' ?>">
	<link rel="stylesheet" href="<?php echo _ROOT_ASSETS . 'css/responsive.css' ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo _ROOT_ASSETS . 'fonts/icomoon.ttf' ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo _ROOT_ASSETS . 'fonts/icomoon.woff' ?>">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
	<link rel='icon' type='image/x-icon' href='<?php echo _ROOT_ASSETS . 'images/gorel_favicon.png' ?>'>
	<script src="<?php echo _ROOT_ASSETS . 'js/jquery-3.4.1.min.js' ?>"></script>
	<script src="<?php echo _ROOT_ASSETS . 'js/jqueryCustom.js' ?>"></script>
	<script src="<?php echo _ROOT_ASSETS . 'js/plugins.js' ?>"></script>
	<style>
		@media(max-width: 1180px){
			.navbar-collapse{
				position: fixed;
				top: 56px;
				left: 0;
				z-index: 9999;
				display: block !important;
				background-color: #f8f9fa;
				overflow-y: auto;
			} 
		}
	</style>
</head>
<body>
	<div id="pageWrapper">
		<div class="phStickyWrap">
			<header id="pageHeader" class="bg-white">
				<div class="d-none d-md-block">
					<div class="hdTopBar py-2 py-xl-3 bg-dark">
						<div class="row align-items-center">
							<div class="col-md-8 align-items-center">
								<ul class="list-unstyled hdScheduleList mb-0 text-center text-md-left d-flex" style="margin-left: 3%;">
									<li class="mb-2 mb-md-0">
										<a href="tel:18001234567">
											<i class="icomoon-telRcv align-middle icn" style="color: white !important"><span class="sr-only">icon</span></i>
											Llamar a : cambiar número
										</a>
									</li>
									<li>
										<time datetime="2011-01-12">
											<i class="icomoon-clock align-middle icn" style="color: white !important"><span class="sr-only">icon</span></i>
											Horario de atención: Lun - Vier 7:00 - 15:00
										</time>
									</li>
								</ul>
							</div>
							<div class="col-md-4 text-center text-md-right">
								<ul class="list-unstyled hdAlterLinksList mb-0 d-flex justify-content-center justify-content-md-end">
									<li class="mb-2 mb-md-0" style="margin-top: 3%">
										<a href="/directorio" target="_blank">
											Directorio
										</a>
									</li>
									<li class="mb-2 mb-md-0">
										<a href="https://www.transparencia.gob.pe/" alt="enlace portal de transparencia" target="_blank">
											<img src="<?php echo _ROOT_ASSETS . 'images/logo_portal_transparencia.png' ?>">
										</a>
									</li>
									<li>
										<a href="https://www.gob.pe/institucion/minjus/campa%C3%B1as/4200-libro-de-reclamaciones" alt="enlace libro de reclamaciones" target="_blank">
											<img src="<?php echo _ROOT_ASSETS . 'images/logo_libro_reclamaciones.png'  ?>">
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="hdFixerWrap py-2 py-md-3 py-xl-5 sSticky bg-white">
					<div class="container">
						<nav class="navbar navbar-expand-md navbar-light p-0">
							<div class="logo flex-shrink-0 mr-3 mr-xl-8 mr-xlwd-16">
								<a href="home.php">
									<img src="<?php echo _ROOT_ASSETS . 'images/circle_logo_gorel.png' ?>" class="img-fluid" alt="Gobierno regional de loreto Logo">
								</a>
							</div>
							<div class="hdNavWrap flex-grow-1 d-flex align-items-center justify-content-end justify-content-lg-start">
								<div class="collapse navbar-collapse pageMainNavCollapse mt-2 mt-md-0" id="pageMainNavCollapse">
									<ul class="navbar-nav mainNavigation">
										<li class="nav-item dropdown ddohOpener">
											<a class="nav-link dropdown-toggle dropIcn" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Gobierno</a>
											<div class="dropdown-menu hdMainDropdown desktopDropOnHover">
												<ul class="list-unstyled mb-0 hdDropdownList">
													<li><a class="dropdown-item" href="#">Acerca de nosotros</a></li>
													<li><a class="dropdown-item" href="#">Normatividad</a></li>
													<li><a class="dropdown-item" href="#">Organigrama</a></li>
													<li><a class="dropdown-item" href="#">Directorio</a></li>
												</ul>
											</div>
										</li>
										<li class="nav-item dropdown ddohOpener">
											<a class="nav-link dropdown-toggle dropIcn" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Noticias y eventos</a>
											<div class="dropdown-menu hdMainDropdown desktopDropOnHover">
												<ul class="list-unstyled mb-0 hdDropdownList">
													<li><a class="dropdown-item" href="#">Noticias</a></li>
													<li><a class="dropdown-item" href="#">Próximos eventos</a></li>
													<li><a class="dropdown-item" href="#">Comunicados</a></li>
													<li><a class="dropdown-item" href="#">Informes y publicaciones</a></li>
												</ul>
											</div>
										</li>
										<li class="nav-item dropdown ddohOpener">
											<a class="nav-link dropdown-toggle dropIcn" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Servicios</a>
											<div class="dropdown-menu hdMainDropdown desktopDropOnHover">
												<ul class="list-unstyled mb-0 hdDropdownList">
													<li><a class="dropdown-item" href="#">Correo Institucional</a></li>
													<li><a class="dropdown-item" href="#">Consulta tu tramite</a></li>
													<li><a class="dropdown-item" href="#">Mesa de partes virtuales</a></li>
													<li><a class="dropdown-item" href="#">Formularios y procedimientos</a></li>
												</ul>
											</div>
										</li>
										<li class="nav-item dropdown ddohOpener">
											<a class="nav-link dropdown-toggle dropIcn" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Transparencia</a>
											<div class="dropdown-menu hdMainDropdown desktopDropOnHover">
												<ul class="list-unstyled mb-0 hdDropdownList">
													<li><a class=\"dropdown-item" href="/transparencia/visitas">Visitas</a></li>
												</ul>
											</div>
										</li>
										<li class="nav-item dropdown ddohOpener">
											<a class="nav-link dropdown-toggle dropIcn" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Entidades relacionadas</a>
											<div class="dropdown-menu hdMainDropdown desktopDropOnHover">
												<ul class="list-unstyled mb-0 hdDropdownList">
													<li><a class="dropdown-item" href="#">Corcytec</a></li>
													<li><a class="dropdown-item" href="#">Consejo Regional</a></li>
													<li><a class="dropdown-item" href="#">Ordenamiento territorial</a></li>
													<li><a class="dropdown-item" href="#">Gerencias y subgerencias</a></li>
													<li><a class="dropdown-item" href="#">Ordenamiento territorial</a></li>
												</ul>
											</div>
										</li>
										<li class="nav-item dropdown ddohOpener">
											<a class="nav-link dropdown-toggle " href="contact-1.php" aria-haspopup="true" aria-expanded="false">Contacto</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="hdRighterWrap d-flex align-items-center justify-content-end">
								<div class="dropdown hdLangDropdown ddohOpener d-none d-lg-block">
									<a class="d-inline-block align-top dropdown-toggle dropIcn" href="javascript:void(0);" role="button" id="hdLanguagedropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Esp</a>
									<div class="dropdown-menu dropdown-menu-right rounded-lg overflow-hidden desktopDropOnHover p-0 w-100" aria-labelledby="hdLanguagedropdown">
										<a class="dropdown-item text-center active" href="javascript:void(0);">Esp</a>
										<a class="dropdown-item text-center" href="javascript:void(0);">Eng</a>
										<a class="dropdown-item text-center" href="javascript:void(0);">Quech</a>
									</div>
								</div>
								<button class="navbar-toggler pgNavOpener ml-2 bdrWidthAlter position-relative" type="button" data-toggle="collapse" data-target="#pageMainNavCollapse" aria-controls="pageMainNavCollapse" aria-expanded="false" aria-label="Toggle navigation">
									<span class="navbar-toggler-icon"></span>
								</button>
							</div>
						</nav>
					</div>
				</div>
			</header>
		</div>