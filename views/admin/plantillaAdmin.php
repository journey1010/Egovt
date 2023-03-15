<?php
include_once _ROOT_VIEWS. 'admin/constructViewPanelAdmin.php';
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
  <link rel='icon' type='image/x-icon' href = '<?php echo _ROOT_ASSETS . 'images/gorel_favicon.png'?>'>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo _ROOT_ASSETS_ADMIN . 'css/all.min.css' ?> ">
  <link rel="stylesheet" href="<?php echo _ROOT_ASSETS_ADMIN . 'css/adminlte.min.css' ?> ">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="/administrador/app/contacto" class="nav-link">Contacto</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
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
        <!-- Notifications Dropdown Menu -->
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
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="https://regionloreto.gob.pe" class="brand-link">
        <img src="<?= _ROOT_ASSETS . 'images/circle_logo_gorel.png' ?>" alt="Admin Egovt Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Administrador</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
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
        <!-- SidebarSearch Form -->
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

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <?php echo $vistasAdmin->buildSideBar($tipoUser) ?>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
          <?php echo $vistasAdmin->buildContentPage() ?>
          </div>          
        </div>
      </div>
    </div>
    <!-- /.content-wrapper -->


    <footer class="main-footer">
      <strong>Derechos reservados @ 2023 <a href="https://regionloreto.gob.pe">Gobierno Regional de Loreto</a>.</strong>
    </footer>
  </div>


  <script src="<?= _ROOT_ASSETS_ADMIN . 'js/jquery.min.js' ?>"></script>
  <script src="<?= _ROOT_ASSETS_ADMIN . 'js/bootstrap.bundle.min.js' ?> "></script>
  <script src="<?= _ROOT_ASSETS_ADMIN . 'js/adminlte.min.js' ?> "></script>
  <script src="<?= _ROOT_ASSETS . 'js/ohsnap/ohsnap.js' ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    var username = "<?php echo $_SESSION['username']; ?>";
  </script>
  <script src="<?= _ROOT_ASSETS_ADMIN . 'js/main.js' ?>"></script>
  <!--<script src="<?= _ROOT_ASSETS_ADMIN . 'js/forms.js' ?>" async></script>-->
</body>
</html>