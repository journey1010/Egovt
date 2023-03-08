<?php
require_once _ROOT_MODEL . 'conexion.php';

class admiVistasController
{
    private $userName;
    private $tipoUser;
    private $contenidoPage;

    public function __construct($userName, $tipoUser, $contenidoPage)
    {
        $this->tipoUser = $tipoUser;
        $this->userName = $userName;
        $this->contenidoPage = $contenidoPage;
    }

    public function logoUser()
    {
        $conexion = new MySQLConnection();
        $sqlSentences = "SELECT user_img from usuarios where nombre = ? ";
        $arrayParams = [$this->userName];
        $consulta  = $conexion->query($sqlSentences, $arrayParams, '', false);
        $ResultadoConsulta = $consulta->fetchAll();
        foreach ($ResultadoConsulta as $columna) {
            $rutaImagen = $columna['user_img'];
        }
        $rutaImagen = ($rutaImagen == '') ? 'default.jpg' :  _ROOT_ASSETS_ADMIN . 'img/iconUser/' . $rutaImagen;
        $conexion->close();
        return $rutaImagen;
    }

    public function sideBarConstruct()
    {
        switch ($this->tipoUser) {
            case '0':
                echo $this->rosterSideBar( 1, $this->tipoUser);
                break;
            case '1':
                break;

            case '2':

                break;
        }
    }

    private function rosterSideBar($opcion, $tipoUser)
    {
        switch ($tipoUser){
            case '0':
                $menuOpen = 'menu-open';
            break;
        }
        switch ($opcion) {
            case 'visitas':
                $html = <<<Html
                <li class="nav-item menu-open">
                    <a href="" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Pagina principal
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Inactive Page</p>
                        </a>
                    </li>
                    </ul>
                </li>
                Html;
            break;

            default:
                $html =<<<Html
                <li class="nav-item $menuOpen">
                    <a href="/administrador/app" class="nav-link active">
                    <i class="fal fa-globe"></i>
                    <p>
                        Página principal
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/administrador/dashboard" class="nav-link active">
                            <i class="fal fa-chart-line"></i>
                            <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/administrador/sitos-externos" class="nav-link">
                            <i class="fal fa-external-link-square-alt"></i>
                            <p>Sitios externos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/administrador/informacion-departamental" class="nav-link">
                            <i class="fal fa-info"></i>
                            <p>Información departamental</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/administrador/info-gobernador" class="nav-link">
                            <i class="fal fa-info"></i>
                            <p>Info Gobernador</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/administrador/banners" class="nav-link">
                            <i class="fal fa-image"></i>
                            <p>Baners</p>
                            </a>
                        </li>                                                
                    </ul>
                </li>
                Html;
                return $html;
            break;
        }
    }

    public function contenido()
    {
        switch ($this->contenidoPage) {
            case '':
                break;
            case '':
                break;
        }
    }

    private function handleError(Throwable $e)
    {
        $errorMessage = date('Y-m-d H:i:s') . ' : Error AdminMainpage' . $e->getMessage() . "\n";
        error_log($errorMessage, 3, _ROOT_PATH . 'log/error.log');
    }
}
