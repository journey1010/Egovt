<?php
class sideBarOptions {
    public function principalPage ()
    {
        $html = <<<Html
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-id-card-alt"></i>
            <p>
                Pagina principal
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="fas fa-book"></i>
                <p></p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="fas fa-edit"></i>
                <p>---</p>
                </a>
            </li>
            </ul>
        </li>
        Html;
        return $html;
    }

    public function oficinas()
    {
        $html = <<<Html
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-table"></i>
            <p>
                Oficinas
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/administrador/app/oficinas" class="nav-link">
                <i class="fas fa-table"></i>
                <p>Administrar oficinas</p>
                </a>
            </li>
            </ul>
        </li>
        Html;
        return $html;
    }

    public function visitas()
    {
        
        $html = <<<Html
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-id-card-alt"></i>
            <p>
                Visitas
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/administrador/visitas/registrar-visitas" class="nav-link">
                <i class="fas fa-book"></i>
                <p>Registrar</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/administrador/visitas/actualizar-visitas" class="nav-link">
                <i class="fas fa-edit"></i>
                <p>Actualizar</p>
                </a>
            </li>
            </ul>
        </li>
        Html;
        return $html;
    }

    public function usuarios()
    {
        $html = <<<Html
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-users"></i>
            <p>
                Usuarios
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/administrador/usuarios/registrar-usuarios" class="nav-link">
                <i class="fas fa-book"></i>
                <p>Registrar</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/administrador/usuarios/actualizar-usuarios" class="nav-link">
                <i class="fas fa-edit"></i>
                <p>Administrar usuarios</p>
                </a>
            </li>
            </ul>
        </li>
        Html;
        return $html;
    }
    
}
?>