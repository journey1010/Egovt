<?php
  include_once _ROOT_VIEWS. 'admin/constrctviewadmin.php';
  $vistasAdmin = new viewConstruct($userName, $tipoUser, $contenidoPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="Admin GOREL" content="admin region loreto, admin gobierno regional de loreto, administrador gobierno regional de loreto"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administrador | Egovt</title>
  <style>
		@font-face { font-family: 'icomoon'; src: url('fonts/icomoon.ttf') format('truetype'); font-weight: normal; font-style: normal; font-display: swap; }
		@font-face {
		font-family: 'Pacifico';
		font-style: normal;
		font-weight: 400;
		src: local('Pacifico Regular'), local('Pacifico-Regular'),
			url(https://fonts.gstatic.com/s/pacifico/v12/FwZY7-Qmy14u9lezJ-6H6MmBp0u-.woff2)
			format('woff2');
		font-display: swap;
		}
	</style>
  <link rel='icon' type='image/x-icon' href = '<?php echo _ROOT_ASSETS . 'images/gorel_favicon.png'?>'>
  <link rel="preload" href="<?=_ROOT_ASSETS_ADMIN . 'css/all.min.css' ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="<?= _ROOT_ASSETS_ADMIN . 'css/all.min.css' ?>"></noscript>
  <link rel="preload" href="<?= _ROOT_ASSETS_ADMIN . 'css/adminlte.min.css' ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="<?= _ROOT_ASSETS_ADMIN . 'css/adminlte.min.css' ?>"></noscript>
  <link rel="preload" href="<?=_ROOT_ASSETS_ADMIN . 'css/styles.css' ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="<?= _ROOT_ASSETS_ADMIN . 'css/styles.css' ?>"></noscript>
  <link rel="preload" href="<?=_ROOT_ASSETS_ADMIN . 'css/select2.min.css' ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="<?=_ROOT_ASSETS_ADMIN . 'css/select2.min.css' ?>"></noscript>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <script src="<?= _ROOT_ASSETS_ADMIN . 'js/jquery.min.js' ?>"></script>
  <script src="<?= _ROOT_ASSETS_ADMIN . 'js/adminlte.min.js' ?> "></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= _ROOT_ASSETS_ADMIN . 'js/select2.full.min.js'?>"></script>
<body class="hold-transition sidebar-mini">
  <div class="progress-bar-container">
    <div class="progress-bar bg-success"></div>
  </div>
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="/administrador/app/contacto" class="nav-link">Contacto</a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Buscar" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>
        <?= $vistasAdmin->notificaciones($tipoUser) ?>
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown"  title="Ajuste de usuario" href="#">
            <i class="fa fa-cogs"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">Mi cuenta</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" id="change_logo_user">
              <i class="fas fa-user-tie"></i> Cambiar logo de usuario
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" id="change_password_user">
              <i class="fas fa-key"></i> Cambiar contraseña
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" id="cerrar_sesion">
              <i class="fas fa-sign-out-alt"></i> Cerrar Sesíon 
            </a>
          </div>
        </li>
      </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="https://regionloreto.gob.pe" class="brand-link">
        <img src="<?= _ROOT_ASSETS . 'images/circle_logo_gorel.png' ?>" alt="Admin Egovt Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Administrador</span>
      </a>
      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?= $vistasAdmin->logoUser(); ?>" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">
              <?= $userName ?>
            </a>
          </div>
        </div>
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Buscar" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>
        <nav class="mt-2 sidebar-scroll">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <?php echo $vistasAdmin->buildSideBar($tipoUser) ?>
          </ul>
        </nav>
      </div>
    </aside>
    <div class="content-wrapper">
      <div class="content">
        <div class="container-fluid">
          <div class="row" id="contentPage">
          <?= $vistasAdmin->buildContentPage() ?>
          </div>          
        </div>
      </div>
    </div>
    <footer class="main-footer">
      <strong>Derechos reservados @ 2023 <a href="https://regionloreto.gob.pe">Gobierno Regional de Loreto</a>.</strong>
    </footer>
  </div>
  <script src="<?= _ROOT_ASSETS . 'js/ohsnap/ohsnap.js' ?>"></script>
  <script>
    var username = "<?php echo $_SESSION['username']; ?>";
  </script>
  <script src="<?= _ROOT_ASSETS_ADMIN . 'js/main.js?ver=1.2' ?>"></script>
</body>
</html>