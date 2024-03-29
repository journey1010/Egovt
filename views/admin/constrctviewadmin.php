<?php
require_once _ROOT_MODEL . 'conexion.php';
require_once _ROOT_VIEWS . 'admin/sideBarOptions.php';
require_once _ROOT_VIEWS . 'admin/contentPageOptions.php';

class viewConstruct{
    
    private $user;
    private $tipoUser;
    private $contenido;

    public function __construct($user, $tipoUser, $contenido)
    {
        $this->user = $user;
        $this->tipoUser = $tipoUser;
        $this->contenido = $contenido;
    }

    //modificar funcion en le futuro para que muestre noticiciones al admin
    public function notificaciones()
    {
        if ($this->tipoUser == 'admin') {
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
            $sqlSentences = "SELECT user_img from usuarios where nombre_usuario = ? ";
            $arrayParams = [$this->user];
            $consulta  = $conexion->query($sqlSentences, $arrayParams, '', false);
            $ResultadoConsulta = $consulta->fetchColumn();
            $conexion->close();
            $ImageName = (!empty($ResultadoConsulta)) ? $ResultadoConsulta : 'journii.jpg';
            $rutaImagen = _ROOT_ASSETS_ADMIN . 'img/iconUser/' . $ImageName;
            return $rutaImagen;
        }catch (Throwable $e){
            $this->handlerError($e);
            return;
        }
    }
    
    public function  buildSideBar($tipoUser)
    {
        $sideBarOptions = new sideBarOptions ();
        try {
            switch($tipoUser){
                case 'admin':
                    $opciones = array ('principalPage', 'usuarios', 'oficinas', 'visitas', 'obras', 'agendagobernador', 'convocatorias', 'PresupuestoSaldoBalance', 'ParticipacionCiudadana', 'Publicaciones');
                break;
                case 'visitor':
                    $opciones = array ('visitas');
                break;
                case 'obras':
                    $opciones = array ( 'obras' );
                break; 
                case 'adminmainpage':
                    $opciones = array ('adminmainpage');
                break;
                case 'agendagobernador':
                    $opciones = array ('agendagobernador');
                break;
                case 'convocatorias':
                    $opciones = array ('convocatorias');
                break;
                case 'saldo-balance':
                    $opciones = array('PresupuestoSaldoBalance');    
                break;
                case  'participacion-ciudadana';
                    $opciones = array('ParticipacionCiudadana');
                break;
                default:
                    throw new Exception('Clase de usuario no valido');
                break;
            }

            $sideBarHtml = '';
            foreach ($opciones as $opcion ){
                $sideBarHtml .= $sideBarOptions->$opcion();
            }
            return $sideBarHtml;

        }catch(Exception $e){
            $this->handlerError($e);
        }
    }

    public function buildContentPage()
    {
        try {
            $contentPage = new contentPageOptions();

            # Array para administrar los permisos para mostrar los diferentes contenidos de pagina por opciones 
            # del sidebar
            $opcionesMenu = [
                'admin' => [
                    '' => $contentPage->Dashboard(),
                    'editar' => $contentPage->Mainpage(), 
                    'oficinas' => $contentPage->Oficinas(),
                    'registrar-usuarios' => $contentPage->RegistrarUsuarios(),
                    'actualizar-usuarios' => $contentPage->ActualizarUsuarios(),
                    'registrar-visitas' => $contentPage->RegistrarVisitas(),
                    'actualizar-visitas' => $contentPage->ActualizarVisitas(),
                    'regularizar-visitas' => $contentPage->RegularizarVisitas(),
                    'registrar-obras' => $contentPage->RegistrarObras(),
                    'actualizar-obras' => $contentPage->ActualizarObras(),
                    'registrar-agenda' => $contentPage->RegistrarAgendaGobernador(),
                    'actualizar-agenda' => $contentPage->ActualizarAgendaGobernador(),
                    'exportar-visitas' => $contentPage->ExportarVisitas(),
                    'registrar-convocatoria' => $contentPage->RegistrarConvocatoria(),
                    'actualizar-convocatoria' => $contentPage->ActualizarConvocatoria(),
                    'registrar-saldo-balance' => $contentPage->registrarSaldoBalance(),
                    'editar-saldo-balance' => $contentPage->editarSaldoBalance(),
                    'registrar-participacion-ciudadana' => $contentPage->registrarParticipacionCiudadana(),
                    'registrar-publicacion' => $contentPage->registrarPublicacion()
                ],

                'visitor' =>[
                    '' => $contentPage->RegistrarVisitas(),
                    'registrar-visitas' => $contentPage->RegistrarVisitas(),
                    'actualizar-visitas' => $contentPage->ActualizarVisitas(),
                    'regularizar-visitas' => $contentPage->RegularizarVisitas(),
                    'exportar-visitas' => $contentPage->ExportarVisitas(),
                    'contacto' => $contentPage->Contacto()
                ],
                
                'obras' =>[
                    '' => $contentPage->RegistrarObras(),
                    'registrar-obras' => $contentPage->RegistrarObras(),
                    'actualizar-obras' => $contentPage->ActualizarObras(),
                    'contacto' => $contentPage->Contacto()
                ],

                'agendagobernador' => [
                    '' => $contentPage->RegistrarAgendaGobernador(),
                    'registrar-agenda' => $contentPage->RegistrarAgendaGobernador(),
                    'actualizar-agenda' => $contentPage->ActualizarAgendaGobernador()
                ],
                'adminmainpage' => [
                    '' => $contentPage->Mainpage(), 
                    'editar' => $contentPage->Mainpage()
                ],
                'convocatorias' =>  [
                    '' => $contentPage->RegistrarConvocatoria(),
                    'registrar-convocatoria' => $contentPage->RegistrarConvocatoria(),
                    'actualizar-convocatoria' => $contentPage->ActualizarConvocatoria()
                ],

                'saldo-balance' => [
                    '' => $contentPage->registrarSaldoBalance(),
                    'registrar-saldo-balance' => $contentPage->registrarSaldoBalance(),
                    'editar-saldo-balance' => $contentPage->editarSaldoBalance()
                ],

                'participacion-ciudadana' => [
                    '' => $contentPage->registrarParticipacionCiudadana(),
                    'registrar-participacion-ciudadana' => $contentPage->registrarParticipacionCiudadana()
                ]
            ];

            # Si el usuario es de tipo "X" y el contenido solicitado no está disponible, muestra la pagina por
            # defecto.
            if ($opcionesMenu[$this->tipoUser] && !array_key_exists($this->contenido, $opcionesMenu[$this->tipoUser])){
                $contenido = $opcionesMenu[$this->tipoUser][''];
            }else {
                $contenido = $opcionesMenu[$this->tipoUser][$this->contenido];
            }
            return $contenido;
        }catch (Throwable $e){
            $this->handlerError($e);
        }
    }

    private function handlerError(Throwable $e)
    {
        $errorMessage = date('Y-m-d H:i:s') . ': Error constructViewPanelAdmin : ' . $e->getMessage() . "\n";
        error_log($errorMessage, 3, _ROOT_PATH . '/log/error.log' );
    }
}
?>