<?php

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
        <div></div>
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

    public function ExportarVisitas()
    {
        $visitas = new visitas();
        $resultado = $visitas->ExportarVisitas();
        return $resultado;
    }

    public function RegularizarVisitas()
    {
        $visitas =  new visitas ();
        $resultado = $visitas->RegularizarVisitas();
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

    public function Contacto()
    {
        $html = <<<Html
        <div></div>
        Html;
        return $html;
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

    public function RegistrarConvocatoria()
    {
        $convocatorias = new Convocatorias();
        $resultado = $convocatorias->RegistrarConvocatoria();
        return $resultado; 
    }

    public function ActualizarConvocatoria()
    {
        $convocatorias = new Convocatorias();
        $resultado = $convocatorias->ActualizarConvocatorias();
        return $resultado; 
    }
    
    public function registrarSaldoBalance()
    {
        $presupuesto = Presupuesto::viewRegistrarSaldoBalance();
        return $presupuesto;
    }

    public function editarSaldoBalance()
    {
        $presupuesto = Presupuesto::viewEditarSaldoBalance();
        return $presupuesto;
    }

    public function registrarParticipacionCiudadana()
    {
        $participacion = Participacion::viewRegistrar();
        return $participacion;
    }

    public function registrarPublicacion(){
        $publicacion = Publicaciones::viewRegistrar();
        return $publicacion;
    }

    public function listarPublicacion(){
        $publicacion = Publicaciones::viewEdit();
        return $publicacion;
    }
}