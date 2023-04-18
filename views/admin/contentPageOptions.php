<?php

require_once(_ROOT_MODEL . 'conexion.php');
require_once(_ROOT_VIEWS . 'admin/usuarios.php');
require_once(_ROOT_VIEWS . 'admin/oficinas.php');
require_once(_ROOT_VIEWS . 'admin/visitas.php');
require_once(_ROOT_VIEWS . 'admin/obras.php');
require(_ROOT_VIEWS . 'admin/funcionarios.php');

class contentPageOptions {

    public function Dashboard()
    {
        $html = <<<Html
        <div>Hola soy un dashboard</div>
        Html;
        return $html;
    }

    public function RegistrarUsuarios()
    {
        $usuarios = new usuarios();
        $resultado  = $usuarios->RegistrarUsuarios();
        return $resultado;    
    }

    public function ActualizarUsuarios()
    {
        $usuarios = new usuarios();
        $resultado  = $usuarios->ActualizarUsuarios();
        return $resultado;
    }

    public function Oficinas()
    {
        $oficinas = new oficinas();
        $resultado = $oficinas->Oficinas();
        return $resultado;
    }

    public function RegistrarVisitas()
    {
        $visitas = new visitas();
        $resultado = $visitas->RegistrarVisitas();
        return $resultado;
    }

    public function ActualizarVisitas()
    {
        $visitas =  new visitas ();
        $resultado = $visitas->ActualizarVisitas();
        return $resultado;
    }

    public function RegistrarObras()
    {
        $obras = new obras();
        $resultado = $obras->RegistrarObras();
        return $resultado;
    }

    public function ActualizarObras()
    {
        $obras = new obras ();
        $resultado = $obras->ActualizarObras();
        return $resultado; 
    }

    public function RegistrarFuncionarios() 
    {
        $funcionarios = new funcionarios ();
        $resultado = $funcionarios->RegistrarFuncionarios();
        return $resultado;
    }

    public function ActualizarFuncionarios()
    {
        $funcionarios = new funcionarios ();
        $resultado = $funcionarios->ActualizarFuncionarios();
        return $resultado;
    }   

    public function Contacto()
    {
        $html = <<<Html
        <div>hola</div>
        Html;
        return $html;
    }
}