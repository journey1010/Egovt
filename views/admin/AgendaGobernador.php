<?php

require_once(_ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once(_ROOT_MODEL . 'conexion.php');

class AgendaGobernador extends handleSanitize 
{
    private $rutaAssets;

    public function __construct()
    {
        $this->rutaAssets = _ROOT_ASSETS_ADMIN;
    }

    public function RegistrarAgenda()
    {
        $ruta = $this->rutaAssets . 'js/agendaGobernador.js';
        $html = <<<Html
        <div class="card mt-3 mx-auto w-100">
            <div class="card-header text-white" style="background-color:#1291ab;">
                <h3 class="card-title">Registrar Agenda de Gobernación</h3>
            </div>
            <div class="mt-2 mr-2 d-flex justify-content-end">
                <a class="btn btn-primary btn-sm insert-agenda" alt="Insertar" title="Agregar nuevo formulario"><i class="fa fa-plus-circle"></i></a>
            </div>
            <div class="contenedorFormularios">
                <form class="registrarAgenda form-agenda bg-light mt-3">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-4 campoOpcional">
                                <label for="temaAgenda">Tema de Agenda (Obligatorio)</label>
                                <input type="text" class="form-control" name="temaAgenda" value="">
                            </div>
                            <div class="col-md-4">
                                <label for="fechaAgenga">Fecha de Agenda (Obligatorio)</label>
                                <input type="date" class="form-control" name="fechaAgenda" value="">
                            </div>
                            <div class="col-md-4 campoOpcional">
                                <label for="horaAgenda">Hora de Agenda</label>
                                <input type="time" class="form-control" name="horaAgenda" value="">
                            </div>
                            <div class="col-md-4 campoOpcional">
                                <label for="organizaAgenda">Organizador</label>
                                <input type="text" class="form-control" name="organizaAgenda" placeholder="¿Quién organiza?" value="">
                            </div>
                            <div class="col-md-4 campoOpcional">
                                <label for="lugarAgenda">Lugar</label>
                                <input type="text" class="form-control" name="lugarAgenda" placeholder="¿Dónde se realizará?" value="">
                            </div>
                            <div class="col-md-4 campoOpcional">
                                <label for="participantesAgenda">Participantes</label>
                                <input type="text" class="form-control" name="participantesAgenda"  placeholder="¿Quién o Quiénes participan?" value=""> 
                            </div>
                            <div class="col-md-12 campoOpcional">
                                <label for="descripcion">Actividad de Agenda</label>
                                <textarea type="text" class="form-control text-content" name="descripcionAgenda" placeholder="Por favor, ingrese una descripción más detallada con respecto al tema de la agenda." style="min-height: 100px; max-width: 100%"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer mt-3">
                <button type="button" id="enviarForm" class="btn btn-primary mt-2">Guardar Agenda</button>
            </div>
        </div>
        <script type ="module" src="$ruta" defer></script>
        Html;
        return $html;
    }

    public function ActualizarAgenda()
    {
        $ruta = $this->rutaAssets . 'js/agendaGobernador.js';
        
        $html = <<<Html
        <div class="card card-warning mt-3 mx-auto w-100">
            <div class="card-header" style="background-color:#1291ab;">
                <h3 class="card-title text-white">Editar Agenda</h3>
            </div>
            <div class="container-fluid">
                <form action="actualizarObras">
                    <div class="row">
                        <div class="col-lg">
                            <div class="row bg-light d-flex justify-content-center">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>Fecha :</label>
                                        <input type="date" class="form-control" id="fechaAgendaActualizar" value="">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>Ordenar por fecha:</label>
                                        <select id="orderByAgenda" class="select2" style="width: 100%;">
                                            <option value="DESC" selected>Seleccionar</option>
                                            <option value="DESC">DESC</option>
                                            <option value="ASC">ASC</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <label class="text-light">a</label>
                                    <div class="form-group align-self-end d-flex">
                                        <button type="button" class="form-control btn btn-primary mr-2" id="aplicarFiltroAgenda">Aplicar filtros</button>
                                        <button type="button" class="form-control btn btn-secondary" id="limpiarAgendaFiltro">Limpiar filtros</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div id="spinnerAgenda" class="mt-1" style="display:none;">
                                    <i class="fa fa-spinner fa-spin"></i> Cargando...
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body table-responsive p-2 mt-3 mx-auto" id="respuestaAgenda">     
            </div>
        </div>
        <script  type ="module" src="$ruta"></script>
        Html;
        return $html;
    }
}