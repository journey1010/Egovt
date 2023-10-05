<?php
class sideBarOptions {
    public function principalPage()
    {
        $html = '
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-id-card-alt"></i>
            <p>
                Inicio
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/administrdor/pagina-principal/editar" class="nav-link" name="sidebarEnlace" data-page="pagina-principal/editar">
                <i class="fas fa-book"></i>
                <p>Página principal</p>
                </a>
            </li>
            </ul>
        </li>';
        return $html;
    }

    public function oficinas()
    {
        $html = '
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-table" style="color: #8C92E9;"></i>
            <p>
                Oficinas
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/administrador/app/oficinas" name="sidebarEnlace" class="nav-link" data-page="app/oficinas">
                <i class="fas fa-table"></i>
                <p>Administrar oficinas</p>
                </a>
            </li>
            </ul>
        </li>';
        return $html;
    }

    public function visitas()
    {
        $html = '
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-id-card-alt" style="color: #8A47FF;"></i>
            <p>
                Visitas
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/administrador/visitas/registrar-visitas" name="sidebarEnlace" class="nav-link" data-page="visitas/registrar-visitas">
                <i class="fas fa-book"></i>
                <p>Registrar</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/administrador/visitas/actualizar-visitas" name="sidebarEnlace" class="nav-link"data-page="visitas/actualizar-visitas">
                <i class="fas fa-edit"></i>
                <p>Actualizar</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/administrador/visitas/regularizar-visitas" name="sidebarEnlace" class="nav-link"data-page="visitas/regularizar-visitas">
                <i class="fas fa-edit"></i>
                <p>Regularizar visitas</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/administrador/visitas/exportar-visitas" name="sidebarEnlace" class="nav-link"data-page="visitas/exportar-visitas">
                <i class="fas fa-database"></i>
                <p>Exportar datos</p>
                </a>
            </li>
            </ul>
        </li>';
        return $html;
    }

    public function usuarios()
    {
        $html = '
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-users" style="color: #F21331;"></i>
            <p>
                Usuarios
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/administrador/usuarios/registrar-usuarios" name="sidebarEnlace" class="nav-link" data-page="usuarios/registrar-usuarios">
                <i class="fas fa-book"></i>
                <p>Registrar</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/administrador/usuarios/actualizar-usuarios" name="sidebarEnlace" class="nav-link" data-page="usuarios/actualizar-usuarios">
                <i class="fas fa-edit"></i>
                <p>Administrar usuarios</p>
                </a>
            </li>
            </ul>
        </li>';
        return $html;
    }
    
    public function obras()
    {
        $html = '
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-hard-hat" style="color: #edf019;"></i>
            <p>
                Obras
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/administrador/obras/registrar-obras" name="sidebarEnlace" class="nav-link" data-page="obras/registrar-obras">
                <i class="fas fa-book"></i>
                <p>Registrar</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/administrador/obras/actualizar-obras" name="sidebarEnlace" class="nav-link" data-page="obras/actualizar-obras">
                <i class="fas fa-edit"></i>
                <p>Administrar obras</p>
                </a>
            </li>
            </ul>
        </li>';
        return $html;
    }

    public function adminmainpage()
    {
        $html = '
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-id-card-alt"></i>
            <p>
                Inicio
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/administrdor/pagina-principal/editar" class="nav-link" name="sidebarEnlace" data-page="pagina-principal/editar">
                <i class="fas fa-book"></i>
                <p>Página principal</p>
                </a>
            </li>
            </ul>
        </li>';
        return $html;
    }  
    
    public function agendagobernador()
    {
        $html = '
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fa fa-calendar-alt" style="color:#1291ab;"></i>
            <p>
                 Agenda de gobernación
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/administrador/agenda/registrar-agenda" name="sidebarEnlace" class="nav-link" data-page="agenda/registrar-agenda">
                <i class="fa fa-calendar-plus"></i>
                <p> Registrar Agenda</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/administrador/agenda/actualizar-agenda" name="sidebarEnlace" class="nav-link" data-page="agenda/actualizar-agenda">
                <i class="fa fa-calendar-week"></i>
                <p> Actualizar Agenda</p>
                </a>
            </li>
            </ul>
        </li>';
        return $html;
    }

    public function convocatorias()
    {
        $html = '
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-briefcase" style="color: #39c668;"></i>
            <p>
                 Convocatorias
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/administrador/convocatoria/registrar-convocatoria" name="sidebarEnlace" class="nav-link" data-page="convocatoria/registrar-convocatoria">
                <i class="fa fa-calendar-plus"></i>
                <p> Registrar convocatoria</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/administrador/convocatoria/actualizar-convocatoria" name="sidebarEnlace" class="nav-link" data-page="convocatoria/actualizar-convocatoria">
                <i class="fa fa-calendar-week"></i>
                <p> Actualizar Convocatoria</p>
                </a>
            </li>
            </ul>
        </li>';
        return $html;
    }

    /*
        <li class="nav-item">
            <a href="/administrador/presupuesto/editar-saldo-balance" name="sidebarEnlace" class="nav-link" data-page="presupuesto/editar-saldo-balance">
                <i class="fa fa-calendar-week"></i>
                <p> Editor Saldo de Balance</p>
            </a>
        </li>
    */

    public function PresupuestoSaldoBalance()
    {
        $html = '
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-coins"></i>
            <p>
                Presupuesto
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/administrador/presupuesto/registrar-saldo-balance" name="sidebarEnlace" class="nav-link" data-page="presupuesto/registrar-saldo-balance">
                <i class="fa fa-calendar-plus"></i>
                <p> Registrar Saldo de Balance</p>
                </a>
            </li>
            </ul>
        </li>';
        return $html;
    }   

    public function ParticipacionCiudadana()
    {
        $html = '
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-coins"></i>
            <p>
                Participacion Ciudadana
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/administrador/participacion-ciudadana/registrar-participacion-ciudadana" name="sidebarEnlace" class="nav-link" data-page="participacion-ciudadana/registrar-participacion-ciudadana">
                <i class="fa fa-calendar-plus"></i>
                <p> Registrar archivo</p>
                </a>
            </li>
            </ul>
        </li>';
        return $html;
    }  

    public function Publicaciones()
    {
        $html = '
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-coins"></i>
            <p>
                Publicaciones
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/administrador/publicaciones/registrar-publicacion" name="sidebarEnlace" class="nav-link" data-page="publicaciones/registrar-publicacion">
                <i class="fa fa-calendar-plus"></i>
                <p> Registrar archivo</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/administrador/publicaciones/listar-publicacion" name="sidebarEnlace" class="nav-link" data-page="publicaciones/listar-publicacion">
                    <i class="fa fa-calendar-week"></i>
                    <p>Editar Registro</p>
                </a>
            </li>
            </ul>
        </li>';
        return $html;
    }  
}