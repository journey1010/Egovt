<?php
class sideBarOptions {
    public function principalPage()
    {
        $html = <<<Html
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
            <li class="nav-item">
                <a href="#" class="nav-link" name="sidebarEnlace" data-page="">
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
        </li>
        Html;
        return $html;
    }

    public function visitas()
    {
        $html = <<<Html
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
        </li>
        Html;
        return $html;
    }
    
    public function obras()
    {
        $html = <<<Html
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
        </li>
        Html;
        return $html;
    }

    public function funcionarios()
    {
        $html = <<<Html
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-user-plus" style="color: #35b332;"></i>
            <p>
                Funcionarios
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/administrador/funcionarios/registrar-funcionarios" name="sidebarEnlace" class="nav-link" data-page="funcionarios/registrar-funcionarios">
                <i class="fas fa-book"></i>
                <p>Registrar</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/administrador/funcionarios/actualizar-funcionarios" name="sidebarEnlace" class="nav-link" data-page="funcionarios/actualizar-funcionarios">
                <i class="fas fa-edit"></i>
                <p>Administrar funcionarios</p>
                </a>
            </li>
            </ul>
        </li>
        Html;
        return $html;
    }
}
?>