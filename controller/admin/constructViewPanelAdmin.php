<?php
require_once _ROOT_MODEL . 'conexion.php';

class viewConstruct{
    private $user;
    private $tipoUser;
    private $contenido;

    public function __construct($user, $tipoUser, $page)
    {
        $this->user = $user;
        $this->tipoUser = $tipoUser;
        $this->contenido = $page;
    }

    //modificar funcion en le futuro para que muestre noticiciones al admin
    public function notificaciones()
    {
        if ($this->tipoUser == '0') {
            $html = <<<Html
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                Html;
            echo $html;
        }
        return;
    }

    public function logoUser()
    {
        try {
            $conexion = new MySQLConnection();
            $sqlSentences = "SELECT user_img from usuarios where nombre = ? ";
            $arrayParams = [$this->user];
            $consulta  = $conexion->query($sqlSentences, $arrayParams, '', false);
            $ResultadoConsulta = $consulta->fetchAll();
            foreach ($ResultadoConsulta as $columna) {
                $rutaImagen = $columna['user_img'];
            }
            $rutaImagen = ($rutaImagen == '') ? 'default.jpg' :  _ROOT_ASSETS_ADMIN . 'img/iconUser/' . $rutaImagen;
            $conexion->close();
            return $rutaImagen;
        }catch (Throwable $e){
            $this->handlerError($e);
            return;
        }
    }

    private function handlerError(Throwable $e)
    {
        $errorMessage = date('Y-m-d H:i:s') . ': Error constructViewPanelAdmin : ' . $e->getMessage() . "\n";
        error_log($errorMessage, 3, _ROOT_PATH . 'logs/error.log' );
    }

}
