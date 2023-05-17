<?php

use JetBrains\PhpStorm\Internal\ReturnTypeContract;

spl_autoload_register( function ($nombreClase) {
    $rutaArchivo = _ROOT_VIEWS . 'admin/' . $nombreClase . '.php';
    if (file_exists($rutaArchivo)) {
        require_once $rutaArchivo;
    }
});

class contentPageOptions {

    public function Dashboard()
    {
        $html = <<<Html
        <div>Hola soy un dashboard</div>
        Html;
        return $html;
    }

    public function Mainpage()
    {
        $Mainpage = new Mainpage();
        $resultado = $Mainpage->AdministrarPaginaPrincipal();
        return $resultado;
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
        $funcionarios = new funcionarios();
        $resultado = $funcionarios->RegistrarFuncionarios();
        return $resultado;
    }

    public function ActualizarFuncionarios()
    {
        $funcionarios = new funcionarios();
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

    public function loadFile() 
    {
        $rrhhAsistencia = new RRHHasistencia();
        $resultado = $rrhhAsistencia->loadFile();
        return $resultado; 
    }

    public function verRegistros()
    {
        $rrhhAsistencia = new RRHHasistencia();
        $resultado =$rrhhAsistencia->verRegistros();
        return $resultado;
    }

    public function RegistrarAgendaGobernador()
    {
        $agendaGobernador = new AgendaGobernador();
        $resultado = $agendaGobernador->RegistrarAgenda();
        return $resultado;
    }

    public function ActualizarAgendaGobernador()
    {
        $agendaGobernador = new AgendaGobernador();
        $resultado = $agendaGobernador->ActualizarAgenda();
        return $resultado;
    }
}