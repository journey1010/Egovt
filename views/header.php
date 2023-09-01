<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="google-site-verification" content="CRBa-m87jge17xNggnxw6Pi5UOWrmuUHaax2D2hrp6o"/>
	<link rel="canonical" href="https://regionloreto.gob.pe">
    <meta name="description" content="El portal web del gobierno regional de loreto es una herramienta de comunicación que permite informar a la ciudadanía sobre las actividades, proyectos y servicios que realiza el gobierno regional. En este portal se puede encontrar información sobre las autoridades, las direcciones regionales, los planes y programas, las noticias y eventos, los trámites y consultas, y los canales de participación ciudadana. El portal web del gobierno regional de loreto busca ser un espacio de transparencia, rendición de cuentas y diálogo con la población.">
    <meta name="keywords" content="Portal web, Pagina web, gorel, Gobierno reginal de loreto, Loreto, estado peruano, ">
    <meta name="autor" content="Journii">
	<title>GOREL - Portal Web del Gobierno Regional de Loreto</title>
	<style>
		@font-face {
			font-family: 'Pacifico';
			font-style: normal;
			font-weight: 400;
			src: local('Pacifico Regular'), local('Pacifico-Regular'),
				url(https://fonts.gstatic.com/s/pacifico/v12/FwZY7-Qmy14u9lezJ-6H6MmBp0u-.woff2)
				format('woff2');
			font-display: swap;
		}
		@font-face {
			font-family: 'Roboto';
			src: url('https://regionloreto.gob.pe/assets/fonts/icomoon.woff') format('woff'),
				 url('https://regionloreto.gob.pe/assets/fonts/icomoon.ttf') format('ttf');
			font-display: swap;
		}
		.img-size {
			height: 100%;
			width: 100%;
			object-fit: cover;
		}

		.modal-dialog {
			max-width: 700px;
		}

		.carousel-control-prev-icon,
		.carousel-control-next-icon {
			width: 30px;
			height: 30px;
			background-size: 100% 100%;
			background-repeat: no-repeat;
		}

		.carousel-control-prev-icon {
			background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3e%3cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3e%3c/svg%3e");
		}

		.carousel-control-next-icon {
			background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3e%3cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3e%3c/svg%3e");
		}

	</style>
	<style type="text/css"">@font-face{font-family:'Nunito Sans';font-style:italic;font-weight:300;src:url(https://fonts.gstatic.com/s/nunitosans/v15/pe1kMImSLYBIv1o4X1M8cce4OdVisMz5nZRqy6cmmmU3t2FQWEAEOvV9wNvrwlNstMKW3Y6K5WMwXeVy3GboJ0kTHmrR91Ug.ttf) format('truetype')}@font-face{font-family:'Nunito Sans';font-style:italic;font-weight:400;src:url(https://fonts.gstatic.com/s/nunitosans/v15/pe1kMImSLYBIv1o4X1M8cce4OdVisMz5nZRqy6cmmmU3t2FQWEAEOvV9wNvrwlNstMKW3Y6K5WMwXeVy3GboJ0kTHmqP91Ug.ttf) format('truetype')}@font-face{font-family:'Nunito Sans';font-style:italic;font-weight:600;src:url(https://fonts.gstatic.com/s/nunitosans/v15/pe1kMImSLYBIv1o4X1M8cce4OdVisMz5nZRqy6cmmmU3t2FQWEAEOvV9wNvrwlNstMKW3Y6K5WMwXeVy3GboJ0kTHmpR8FUg.ttf) format('truetype')}@font-face{font-family:'Nunito Sans';font-style:italic;font-weight:700;src:url(https://fonts.gstatic.com/s/nunitosans/v15/pe1kMImSLYBIv1o4X1M8cce4OdVisMz5nZRqy6cmmmU3t2FQWEAEOvV9wNvrwlNstMKW3Y6K5WMwXeVy3GboJ0kTHmpo8FUg.ttf) format('truetype')}@font-face{font-family:'Nunito Sans';font-style:normal;font-weight:300;src:url(https://fonts.gstatic.com/s/nunitosans/v15/pe1mMImSLYBIv1o4X1M8ce2xCx3yop4tQpF_MeTm0lfGWVpNn64CL7U8upHZIbMV51Q42ptCp5F5bxqqtQ1yiU4GiClntA.ttf) format('truetype')}@font-face{font-family:'Nunito Sans';font-style:normal;font-weight:400;src:url(https://fonts.gstatic.com/s/nunitosans/v15/pe1mMImSLYBIv1o4X1M8ce2xCx3yop4tQpF_MeTm0lfGWVpNn64CL7U8upHZIbMV51Q42ptCp5F5bxqqtQ1yiU4G1ilntA.ttf) format('truetype')}@font-face{font-family:'Nunito Sans';font-style:normal;font-weight:600;src:url(https://fonts.gstatic.com/s/nunitosans/v15/pe1mMImSLYBIv1o4X1M8ce2xCx3yop4tQpF_MeTm0lfGWVpNn64CL7U8upHZIbMV51Q42ptCp5F5bxqqtQ1yiU4GCC5ntA.ttf) format('truetype')}@font-face{font-family:'Nunito Sans';font-style:normal;font-weight:700;src:url(https://fonts.gstatic.com/s/nunitosans/v15/pe1mMImSLYBIv1o4X1M8ce2xCx3yop4tQpF_MeTm0lfGWVpNn64CL7U8upHZIbMV51Q42ptCp5F5bxqqtQ1yiU4GMS5ntA.ttf) format('truetype')}*,::before,::after{box-sizing:border-box}html{font-family:sans-serif;line-height:1.15}article,aside,header,main,nav{display:block}body{margin:0;font-family:'Nunito Sans',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,'Noto Sans',sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol','Noto Color Emoji';font-size:1.0625rem;font-weight:400;line-height:1.5294117647;color:rgb(98,113,141);text-align:left;background-color:rgb(233,236,239)}h1,h2{margin-top:0;margin-bottom:15px}p{margin-top:0;margin-bottom:1rem}ol,ul{margin-top:0;margin-bottom:1rem}ul ul{margin-bottom:0}a{color:rgb(0,103,218);text-decoration:none;background-color:transparent}img{vertical-align:middle;border-style:none}button{border-top-left-radius:0;border-top-right-radius:0;border-bottom-right-radius:0;border-bottom-left-radius:0}button{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button{overflow:visible}button{text-transform:none}button,[type="button"]{-webkit-appearance:button}*::-webkit-file-upload-button{font-family:inherit;font-size:inherit;font-style:inherit;font-variant:inherit;font-weight:inherit;line-height:inherit;-webkit-appearance:button}h1,h2{margin-bottom:15px;font-family:Cabin,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,'Noto Sans',sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol','Noto Color Emoji';font-weight:700;line-height:1.2;color:rgb(32,43,93)}h1{font-size:2.0625rem}h2{font-size:1.5625rem}.list-unstyled{padding-left:0;list-style:none}.img-fluid{max-width:100%;height:auto}.container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}@media (min-width:576px){.container{max-width:540px}}.row{display:-webkit-box;margin-right:-15px;margin-left:-15px}.col-12,.col-md-4,.col-md-8,.col-md-9,.col-xl-7{position:relative;width:100%;padding-right:15px;padding-left:15px}.col-12{-webkit-box-flex:0;max-width:100%}.btn{display:inline-block;font-family:Cabin,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,'Noto Sans',sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol','Noto Color Emoji';font-weight:400;color:rgb(98,113,141);text-align:center;vertical-align:middle;background-color:transparent;border:1px solid transparent;padding:.626rem 1.1875rem;font-size:1.125rem;line-height:1.5;border-top-left-radius:0;border-top-right-radius:0;border-bottom-right-radius:0;border-bottom-left-radius:0}@media not all{}.fade:not(.show){opacity:0}.collapse:not(.show){display:none}.dropdown{position:relative}.dropdown-toggle{white-space:nowrap}.dropdown-menu{position:absolute;top:100%;left:0;z-index:1000;display:none;float:left;min-width:10rem;padding:.5rem 0;margin:.125rem 0 0;font-size:1rem;color:rgb(98,113,141);text-align:left;list-style:none;background-color:rgb(255,255,255);background-clip:padding-box;border:1px solid rgb(229,229,229);border-top-left-radius:0;border-top-right-radius:0;border-bottom-right-radius:0;border-bottom-left-radius:0;box-shadow:rgba(6,22,58,.0980392) 0 10px 40px}.dropdown-menu-right{right:0;left:auto}.dropdown-item{display:block;width:100%;padding:.25rem 1.5rem;clear:both;font-weight:400;color:rgb(98,113,141);text-align:inherit;white-space:nowrap;background-color:transparent;border:0}.dropdown-item.active{color:rgb(255,255,255);text-decoration:none;background-color:rgb(0,103,218)}.nav-link{display:block;padding:.5rem 1rem}.navbar{position:relative;display:-webkit-box;-webkit-box-align:center;-webkit-box-pack:justify;padding:.5rem 1rem}.navbar-nav{display:-webkit-box;-webkit-box-orient:vertical;-webkit-box-direction:normal;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-nav .dropdown-menu{position:static;float:none}.navbar-collapse{-webkit-box-flex:1;-webkit-box-align:center}.navbar-toggler{padding:0;font-size:1.0625rem;line-height:1;background-color:transparent;border:1px solid transparent;border-top-left-radius:0;border-top-right-radius:0;border-bottom-right-radius:0;border-bottom-left-radius:0}.navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;vertical-align:middle;content:'';background-size:100%;background-position:50% 50%;background-repeat:no-repeat no-repeat}.navbar-light .navbar-nav .nav-link{color:rgb(32,43,93)}.navbar-light .navbar-toggler{color:rgb(32,43,93);border-color:rgb(0,103,218)}.navbar-light .navbar-toggler-icon{background-image:url('data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'30\' height=\'30\' viewBox=\'0 0 30 30\'%3e%3cpath stroke=\'%23202b5d\' stroke-linecap=\'round\' stroke-miterlimit=\'10\' stroke-width=\'2\' d=\'M4 7h22M4 15h22M4 23h22\'/%3e%3c/svg%3e')}.modal{position:fixed;top:0;left:0;z-index:1050;display:none;width:100%;height:100%;overflow:hidden;outline:rgb(0,0,0)}.modal-dialog{position:relative;width:auto;margin:.5rem}.modal.fade .modal-dialog{-webkit-transform:translate(0,-50px)}.modal-content{position:relative;display:-webkit-box;-webkit-box-orient:vertical;-webkit-box-direction:normal;width:100%;background-color:rgb(255,255,255);background-clip:padding-box;border:1px solid rgba(0,0,0,.2);border-top-left-radius:.3rem;border-top-right-radius:.3rem;border-bottom-right-radius:.3rem;border-bottom-left-radius:.3rem;box-shadow:rgba(0,0,0,.498039) 0 .25rem .5rem;outline:rgb(0,0,0)}.modal-body{position:relative;-webkit-box-flex:1;padding:1rem}.modal-footer{display:-webkit-box;-webkit-box-align:center;-webkit-box-pack:end;padding:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:rgb(222,226,230);border-bottom-right-radius:calc(.3rem - 1px);border-bottom-left-radius:calc(.3rem - 1px)}.modal-footer>*{margin:.25rem}@media (min-width:576px){.modal-dialog{max-width:500px;margin:1.75rem auto}.modal-content{box-shadow:rgba(0,0,0,.498039) 0 .5rem 1rem}}.carousel{position:relative}.carousel-inner{position:relative;width:100%;overflow:hidden}.carousel-inner::after{display:block;clear:both;content:''}.carousel-item{position:relative;display:none;float:left;width:100%;margin-right:-100%;-webkit-backface-visibility:hidden}.carousel-item.active{display:block}.carousel-indicators{position:absolute;right:0;bottom:0;left:0;z-index:15;display:-webkit-box;-webkit-box-pack:center;padding-left:0;margin-right:15%;margin-left:15%;list-style:none}.carousel-indicators li{box-sizing:content-box;-webkit-box-flex:0;width:30px;height:3px;margin-right:3px;margin-left:3px;text-indent:-999px;background-color:rgb(255,255,255);background-clip:padding-box;border-top-width:10px;border-top-style:solid;border-top-color:transparent;border-bottom-width:10px;border-bottom-style:solid;border-bottom-color:transparent;opacity:.5}.carousel-indicators .active{opacity:1}.carousel-caption{position:absolute;right:15%;bottom:20px;left:15%;z-index:10;padding-top:20px;padding-bottom:20px;color:rgb(255,255,255);text-align:center}.align-top{vertical-align:top!important}.align-middle{vertical-align:middle!important}.bg-dark{background-color:rgb(6,22,58)!important}.bg-white{background-color:rgb(255,255,255)!important}.border-0{border:0px!important}.rounded-lg{border-top-left-radius:0.5rem!important;border-top-right-radius:0.5rem!important;border-bottom-right-radius:0.5rem!important;border-bottom-left-radius:0.5rem!important}.rounded-circle{border-top-left-radius:50%!important;border-top-right-radius:50%!important;border-bottom-right-radius:50%!important;border-bottom-left-radius:50%!important}.d-none{display:none!important}.d-inline-block{display:inline-block!important}.d-block{display:block!important}.d-flex{display:-webkit-box!important}.flex-grow-1{-webkit-box-flex:1!important}.justify-content-end{-webkit-box-pack:end!important}.justify-content-center{-webkit-box-pack:center!important}.align-items-center{-webkit-box-align:center!important}.overflow-hidden{overflow:hidden!important}.position-relative{position:relative!important}.position-absolute{position:absolute!important}.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap;border:0}.w-100{width:100%!important}.mb-0{margin-bottom:0px!important}.mt-2{margin-top:10px!important}.mb-2{margin-bottom:10px!important}.ml-2{margin-left:10px!important}.mr-3{margin-right:16px!important}.mb-4{margin-bottom:20px!important}.mt-6{margin-top:30px!important}.p-0{padding:0px!important}.py-2{padding-top:10px!important}.px-2{padding-right:10px!important}.py-2{padding-bottom:10px!important}.px-2{padding-left:10px!important}.pt-4{padding-top:20px!important}.pb-10{padding-bottom:50px!important}.pt-20{padding-top:100px!important}.pb-20{padding-bottom:100px!important}.mt-n8{margin-top:-40px!important}.mx-auto{margin-right:auto!important}.mx-auto{margin-left:auto!important}.stretched-link::after{position:absolute;top:0;right:0;bottom:0;left:0;z-index:1;content:'';background-color:rgba(0,0,0,0)}.text-center{text-align:center!important}.text-capitalize{text-transform:capitalize!important}.font-weight-bold{font-weight:700!important}.text-white{color:rgb(255,255,255)!important}@font-face{font-family:icomoon;src:url(../css/fonts/icomoon.ttf) format('truetype'),url(../css/fonts/icomoon.woff) format('woff'),url(../css/fonts/icomoon.svg) format('svg');font-weight:400;font-style:normal}[class^="icomoon-"]{speak:none;font-style:normal;font-weight:400;font-variant:normal;text-transform:none;line-height:1;-webkit-font-smoothing:antialiased;font-family:icomoon!important}.icomoon-clock::before{content:'\e909'}.icomoon-ico1::before{content:'\e90a'}.icomoon-ico2::before{content:'\e90b'}img{max-width:100%;height:auto}.btn::before{content:'';position:absolute;top:0;right:0;bottom:0;left:0}.btn::before{content:attr(data-hover);-webkit-transform:translateY(50%) rotateX(90deg);opacity:0;border-width:1px;border-style:solid;-webkit-transform-origin:100% 50% 0;-webkit-transform-style:preserve-3d;padding:.626rem 1.1875rem}body{min-width:320px}.h1large{font-size:38px;line-height:1.0714285714}.logo{max-width:95px}</style>
	<link rel="preconnect" href="https://fonts.googleapis.com/css2">
	<link rel="preload" href="<?= _ROOT_ASSETS . 'css/bootstrap.css'?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="<?= _ROOT_ASSETS . 'css/bootstrap.css'?>"></noscript>
	<link rel="preload" href="<?= _ROOT_ASSETS . 'css/style.css?ver=1.1'?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="<?= _ROOT_ASSETS . 'css/style.css?ver=1.1'?>"></noscript>
	<link rel="preload" href="<?= _ROOT_ASSETS . 'css/colors.css'?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="<?= _ROOT_ASSETS . 'css/colors.css'?>"></noscript>
	<link rel="preload" href="<?= _ROOT_ASSETS . 'css/responsive.css'?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="<?= _ROOT_ASSETS . 'css/responsive.css'?>"></noscript>
	<link rel="preload" href="<?= _ROOT_ASSETS . 'fontawesome-5/css/all.min.css'?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="<?= _ROOT_ASSETS . 'fontawesome-5/css/all.min.css' ?>"></noscript>
	<link rel='icon' type='image/x-icon' href='<?= _ROOT_ASSETS . 'images/gorel_favicon.ico' ?>'>
	<style>
		@media(max-width: 700px) {
			.navbar-collapse {
				position: fixed;
				top: 56px;
				left: 0;
				z-index: 9999;
				display: block !important;
				background-color: #f8f9fa;
				overflow-y: auto;
			}
		}
		.ibBgImage {
			opacity: 0;
			visibility: hidden;
		}
	</style>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
	<script>
		const observer = lozad('.lozad');
		observer.observe();
	</script>
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
										<a href="tel:065-266969" alt="telefono gorel">
											<i class="icomoon-telRcv align-middle icn" style="color: white !important"><span class="sr-only">icon</span></i>
											Llamar a : 065-266969 o 065-267010
										</a>
									</li>
									<li>
										<time datetime="2011-01-12">
											<i class="icomoon-clock align-middle icn" style="color: white !important"><span class="sr-only">icon</span></i>
											Horario de Atención: Lun - Vier 7:00 - 15:00
										</time>
									</li>
								</ul>
							</div>
							<div class="col-md-4 text-center text-md-right">
								<ul class="list-unstyled hdAlterLinksList mb-0 d-flex justify-content-center justify-content-md-end">
									<li class="mb-2 mb-md-0" style="margin-top: 3%">
										<a href="https://www.gob.pe/institucion/regionloreto/funcionarios" alt="Directorio de funcionarios" target="_blank">
											Directorio
										</a>
									</li>
									<li class="mb-2 mb-md-0">
										<a href="https://www.gob.pe/regionloreto" alt="enlace al portal gob.pe" target="_blank">
											<img src="<?= _ROOT_ASSETS . 'images/gob_pe_white.svg'?>" width="103" height="30.39" title="GORE-LORETO">
										</a>
									</li>
									<li class="mb-2 mb-md-0">
										<a href="https://www.transparencia.gob.pe/reportes_directos/pte_transparencia_reg_visitas.aspx?id_entidad=10152&ver=&id_tema=500" alt="enlace portal de transparencia" target="_blank">
											<img src="<?= _ROOT_ASSETS . 'images/logo_portal_transparencia.png' ?>">
										</a>
									</li>
									<li>
										<a href="https://www.gob.pe/institucion/minjus/campa%C3%B1as/4200-libro-de-reclamaciones" alt="enlace libro de reclamaciones" target="_blank">
											<img src="<?= _ROOT_ASSETS . 'images/logo_libro_reclamaciones.png'  ?>">
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
								<a href="/" alt="pagina principal">
									<img src="<?= _ROOT_ASSETS . 'images/circle_logo_gorel.png' ?>" class="img-fluid" alt="Gobierno regional de loreto Logo" width="80" height="60">
								</a>
							</div>
							<div class="hdNavWrap flex-grow-1 d-flex align-items-center justify-content-end justify-content-lg-start">
								<div class="collapse navbar-collapse pageMainNavCollapse mt-2 mt-md-0" id="pageMainNavCollapse">
									<ul class="navbar-nav mainNavigation">
										<li class="nav-item dropdown ddohOpener">
											<a class="nav-link dropdown-toggle dropIcn" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Gobierno</a>
											<div class="dropdown-menu hdMainDropdown desktopDropOnHover">
												<ul class="list-unstyled mb-0 hdDropdownList">
													<li><a class="dropdown-item" href="https://www.gob.pe/institucion/regionloreto/institucional" alt="Acerca de nosotros">Acerca de Nosotros</a></li>
													<li><a class="dropdown-item" href="https://www.gob.pe/institucion/regionloreto/normas-legales/tipos" alt="Normatividad">Normatividad</a></li>
													<li><a class="dropdown-item" href="https://www.gob.pe/rails/active_storage/blobs/redirect/eyJfcmFpbHMiOnsibWVzc2FnZSI6IkJBaHBBNnNyQVE9PSIsImV4cCI6bnVsbCwicHVyIjoiYmxvYl9pZCJ9fQ==--f2d4872d6933ba651163a9e889f9934ed198ae21/ordenanza_regional_010.pdf" alt="Organigrama">Organigrama</a></li>
													<li><a class="dropdown-item" href="https://www.gob.pe/institucion/regionloreto/funcionarios" alt="Directorio de funcionarios">Directorio</a></li>
												</ul>
											</div>
										</li>
										<li class="nav-item dropdown ddohOpener">
											<a class="nav-link dropdown-toggle dropIcn" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Noticias y Eventos</a>
											<div class="dropdown-menu hdMainDropdown desktopDropOnHover">
												<ul class="list-unstyled mb-0 hdDropdownList">
													<li><a class="dropdown-item" href="https://www.gob.pe/institucion/regionloreto/noticias" alt="Noticias">Noticias</a></li>
													<li><a class="dropdown-item" href="https://www.gob.pe/institucion/regionloreto/campa%C3%B1as" alt="Proximos eventos">Próximos eventos</a></li>
													<li><a class="dropdown-item" href="https://www.gob.pe/institucion/regionloreto/normas-legales/tipos" alt="Normas legales">Normas Legales</a></li>
													<li><a class="dropdown-item" href="https://www.gob.pe/institucion/regionloreto/informes-publicaciones" alt="Informes y publicaciones">Informes y publicaciones</a></li>
												</ul>
											</div>
										</li>
										<li class="nav-item dropdown ddohOpener">
											<a class="nav-link dropdown-toggle dropIcn" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Servicios</a>
											<div class="dropdown-menu hdMainDropdown desktopDropOnHover">
												<ul class="list-unstyled mb-0 hdDropdownList">
													<li><a class="dropdown-item" href="https://correo.regionloreto.gob.pe/" alt="correo institucional">Correo Institucional</a></li>
													<li><a class="dropdown-item" href="https://consulta.regionloreto.gob.pe/" alt="consulta tu tramite">Consulta tu tramite</a></li>
													<li><a class="dropdown-item" href="https://facilita.gob.pe/t/641" alt="Mesa de partes virtuales ">Mesa de partes virtuales</a></li>
													<li><a class="dropdown-item" href="/enconstruccion" alt="Formularios y procedimientos">Formularios y procedimientos</a></li>
													<li><a class="dropdown-item" href="/servicios/menu-aplicaciones">Aplicaciones</a></li>
												</ul>
											</div>
										</li>
										<li class="nav-item dropdown ddohOpener">
											<a class="nav-link dropdown-toggle dropIcn" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Transparencia</a>
											<div class="dropdown-menu hdMainDropdown desktopDropOnHover">
												<ul class="list-unstyled mb-0 hdDropdownList">
													<li><a class="dropdown-item" href="/transparencia/visitas" alt="Visitas">Visitas</a></li>
													<li><a class="dropdown-item" href="/transparencia/proyecto-de-inversion-publica" alt="Proyectos de inversión publica ">Proyectos de Inversión Pública</a></li>
													<li><a class="dropdown-item" href="/transparencia/actividades-oficiales" alt="Actividades oficiales">Actividades Oficiales</a></li>
													<li><a class="dropdown-item" href="/transparencia/convocatorias-de-trabajo" alt="Convocatorias de trabajo">Convocatorias de trabajo</a></li>
												</ul>
											</div>
										</li>
										<li class="nav-item dropdown ddohOpener">
											<a class="nav-link dropdown-toggle dropIcn" alt="Entidades relacionadas" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Entidades Relacionadas</a>
											<div class="dropdown-menu hdMainDropdown desktopDropOnHover">
												<ul class="list-unstyled mb-0 hdDropdownList">
													<li><a class="dropdown-item" href="https://antiguo.regionloreto.gob.pe/corcytec/" alt="Corcytec loreto">Corcytec</a></li>
													<li><a class="dropdown-item" href="/enconstruccion" alt="consejo regional">Consejo Regional</a></li>
													<li><a class="dropdown-item" href="/enconstruccion" alt="Ordenamiento territorial">Ordenamiento territorial</a></li>
													<li><a class="dropdown-item" href="/enconstruccion" alt="Gerencias y subgerencias">Gerencias y subgerencias</a></li>
													<li><a class="dropdown-item" href="/enconstruccion" alt="Ordenamiento territorial">Ordenamiento territorial</a></li>
												</ul>
											</div>
										</li>
										<li class="nav-item dropdown ddohOpener">
											<a class="nav-link dropdown-toggle " href="https://www.gob.pe/institucion/regionloreto/contacto-y-numeros-de-emergencias" alt="contacto" aria-haspopup="true" aria-expanded="false">Contacto</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="hdRighterWrap d-flex align-items-center justify-content-end">
								<div class="dropdown hdLangDropdown ddohOpener d-none d-lg-block">
									<a class="d-inline-block align-top dropdown-toggle dropIcn" href="javascript:void(0);" role="button" id="hdLanguagedropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Esp</a>
									<div class="dropdown-menu dropdown-menu-right rounded-lg overflow-hidden desktopDropOnHover p-0 w-100" aria-labelledby="hdLanguagedropdown">
										<a class="dropdown-item text-center active" href="javascript:void(0);" alt="idioma">Esp</a>
										<a class="dropdown-item text-center" href="javascript:void(0);" alt="idioma">Eng</a>
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