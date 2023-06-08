<?php

require_once(_ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once(_ROOT_MODEL . 'conexion.php');

class visitas extends handleSanitize {

    private $rutaAssets;

    public function __construct()
    {
        $this->rutaAssets = _ROOT_ASSETS_ADMIN;
    }

    public function RegistrarVisitas()
    {
        $ruta = $this->rutaAssets  . 'js/visitas.js?v=2';
        $ruta2 = $this->rutaAssets . 'js/moment.min.js';
        $hora = new DateTime('', new DateTimeZone('UTC'));
        $hora->setTimezone(new DateTimeZone('America/Bogota'));
        $dateTimeNow = $hora->format('Y-m-d H:i:s');

        $conexion = new MySQLConnection();
        $select = $this->getSelect($conexion);
        $selectFuncionario = $this->getSelectFuncionario($conexion);
        $html = <<<Html
        <div class="card card-primary mt-3 mx-auto">
            <div class="card-header">
                <h3 class="card-title">Registrar visitas</h3>
            </div>
            <form id="registrarVisitas">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tipoDoc">Tipo de documento (obligatorio)</label>
                            <select id="tipoDoc" class="form-control select2 select2-hidden-accessible" data-placeholder="" style="width: 100%; 
                                height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true">
                                <option value="DNI">DNI</option>
                                <option value="CARNET DE EXTRANJERIA">CARNET DE EXTRANJERIA</option>
                                <option value="PASAPORTE">PASAPORTE</option>
                                <option value="PART-NACIMIENTO-IDENTIDAD">PART. DE NACIMIENTO-IDENTIDAD</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="buscarDNI">Número de documento(obligatorio)</label>
                            <input type="text" class="form-control" id="dniVisita" placeholder="Ingresar Número de documento..." required>
                        </div>
                        <button type="submit" class="btn btn-secondary" id="BuscarDNIVisita">Buscar DNI</button>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="labelNombreCompleto">Nombre completo (obligatorio)</label>
                                <input type="text" class="form-control" id="apellidos_nombres" placeholder="Ingrese su nombre completo">
                            </div>
                            <div class="col-md-5">
                                <label for="InstitucionVisitante">Institución del visitante (obligatorio)</label>
                                <input type="text" class="form-control" id="InstitucionVisitante" placeholder="">
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Oficina (obligatorio)</label>
                                    <select id="oficina" class="form-control select2 select2-hidden-accessible" data-placeholder="Selecciona una oficina" style="width: 100%; 
                                        height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true">
                                        $select
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="quien_autoriza">¿Quién autoriza? *</label>
                                    <select id="quien_autoriza" class="form-control select2 select2-hidden-accessible" data-placeholder="" style="width: 100%; 
                                        height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true">
                                        $selectFuncionario
                                    </select>
                                </div>
                                
                            </div>
                            <div class="col-md-3">
                                <label for="HoraIngreso">Hora de ingreso</label>
                                <input type="text" class="form-control" id="hora_de_ingreso" value="$dateTimeNow" disabled>
                            </div>
                            <div class="col-md-5">
                                <label for="persona_a_visitar">¿A quién visita?</label>
                                <input type="text" class="form-control" id="persona_a_visitar" placeholder="">
                            </div>
                            <div class="col-md-7">
                                <label for="motivo">Motivo de la visita</label>
                                <textarea type="text" class="form-control text-content" id="motivo" placeholder="Descripción del motivo de visita"  style="min-height: 100px;
                                max-width: 100%"></textarea>
                            </div>
                        </div>
                    </div>
                <div class="card-footer mt-3">
                    <button id="btnGuardar" type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
        <script type ="module" src="$ruta"></script>
        <script src="$ruta2"></script>
        <script>
            function updateDateTime() {
                let fechTime = moment().utcOffset('America/Phoenix').format('YYYY-MM-DD HH:mm:ss');
                $('#hora_de_ingreso').val(fechTime);
            }
            updateDateTime();
            setInterval(updateDateTime, 1000);
        </script>
        Html;
        return $html;
    }

    private function getSelect(MySQLConnection $conexion): string
    {
        $sql = "SELECT CONCAT(id,'-', grupo ) AS id_ofi ,CONCAT(nombre, ' ', sigla) AS nombreCompleto FROM oficinas";
        $smt = $conexion->query($sql, '', '', false);
        $resultado = $smt->fetchAll();
        $options = '';
        foreach ($resultado as $row) {
            $id = $row['id_ofi'];
            $nombreCompleto = $row['nombreCompleto'];
            $options .= "<option value=\"$id\">$nombreCompleto</option>";
        }
        $conexion->close();
        return $options;
    }

    public function ActualizarVisitas()
    {
        $ruta = $this->rutaAssets  . 'js/visitas.js?v=2';
        $ruta2 = $this->rutaAssets . 'js/moment.min.js';
        $conexion = new MySQLConnection();
        $tablaRow = $this->getTablaRow($conexion);
        $html = <<<Html
        <div class="card card-primary mt-3" style="width: 100% !important;">
            <div class="card-header">
                <h3 class="card-title">Actualizar visitas</h3>
            </div>
            <div class="card-body table-responsive p-2" style="width:100% !important">
                <table class="table table-hover table-md" style="font-size: 14px">
                    <thead class="table-bordered" >
                        <tr>
                            <th class="text-center">id</th>
                            <th class="text-center">Documento</th>
                            <th class="text-center">Nombre completo</th>
                            <th class="text-center">Hora de ingreso</th>
                            <th style="text-center">Hora de salida</th>
                            <th class="text-center">Motivo u Observación</th>
                            <th style="width: 80px" class="text-center">Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        $tablaRow
                    </tbody>
                </table>  
            </div>
        </div>
        <script src="$ruta2"></script>
        <script type ="module" src="$ruta"></script>
        Html;
        return $html;
    }

    public function RegularizarVisitas()
    {
        $ruta = $this->rutaAssets  . 'js/visitas.js?v=2';
        $conexion = new MySQLConnection();
        $select = $this->getSelect($conexion);
        $selectFuncionario = $this->getSelectFuncionario($conexion);
        $html = <<<Html
        <div class="card card-primary mt-3 mx-auto">
            <div class="card-header">
                <h3 class="card-title">Regularizar visitas</h3>
            </div>
            <form id="regularizarVisitas">
                    <div class="card-body">
                        <div class="form-group">
                        <label for="buscarDNI">DNI (obligatorio)</label>
                        <input type="number" class="form-control" id="dniVisita" placeholder="Ingresar DNI..." required>
                    </div>
                    <button type="submit" class="btn btn-secondary" id="BuscarDNIVisita">Buscar</button>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="labelNombreCompleto">Nombre completo (obligatorio)</label>
                            <input type="text" class="form-control" id="apellidos_nombres" placeholder="Ingrese su nombre completo">
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Oficina (obligatorio)</label>
                                <select id="oficina" class="form-control select2 select2-hidden-accessible" data-placeholder="Selecciona una oficina" style="width: 100%; 
                                    height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true">
                                    $select
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="quien_autoriza">¿Quién autoriza?</label>
                                <select id="quien_autoriza" class="form-control select2 select2-hidden-accessible" data-placeholder="Selecciona una oficina" style="width: 100%; 
                                    height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true">
                                    $selectFuncionario
                                </select>
                            </div>
                            
                        </div>
                        <div class="col-md-3">
                            <label for="institucionVisitanteR">Institución visitante(obligatorio)</label>
                            <input type="text" class="form-control" id="institucionVisitanteR" value="">
                        </div>
                        <div class="col-md-3">
                            <label for="HoraIngreso">Hora de ingreso(obligatorio)</label>
                            <input type="datetime-local" class="form-control" id="hora_de_ingresoR" value="">
                        </div>
                        <div class="col-md-5">
                            <label for="HoraIngreso">Hora de salida</label>
                            <input type="datetime-local" class="form-control" id="hora_de_salidaR" value="">
                        </div>
                        <div class="col-md-5">
                            <label for="persona_a_visitar">¿A quién visita? </label>
                            <input type="text" class="form-control" id="persona_a_visitar" placeholder="">
                        </div>
                        <div class="col-md-12">
                            <label for="motivo">Motivo de la visita</label>
                            <textarea type="text" class="form-control text-content" id="motivo" placeholder="Descripción del motivo de visita"  style="min-height: 100px;
                            max-width: 100%"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-3">
                    <button id="btnRegularizar" type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
        <script type ="module" src="$ruta"></script>
        Html;
        return $html;
    }

    public function ExportarVisitas()
    {
        $ruta = $this->rutaAssets  . 'js/visitas.js?v=2';
        $html = <<<Html
        <div class="card card-primary mt-3 mx-auto w-100">
            <div class="card-header">
                <h3 class="card-title">Exportar visitas</h3>
            </div>
            <div class="container-fluid">
                <form action="exportarVisitas">
                    <div class="row">
                        <div class="col-lg">
                            <div class="row bg-light mt-2">
                                <div class="col-md-3 col-sm-6 ml-4">
                                    <div class="form-group">
                                        <label>Fecha Desde:</label>
                                        <input type="datetime-local" class="form-control" id="fechaVistDesde" value="">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 ml-4">
                                    <div class="form-group">
                                        <label>Fecha Hasta:</label>
                                        <input type="datetime-local" class="form-control" id="fechaVisitHasta" value="">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 ml-4">
                                    <label class="text-light">a</label>
                                    <div class="form-group align-self-end d-flex">
                                        <button type="button" class="form-control btn btn-primary mr-2" id="generarReportVisit">Aplicar filtros</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2" id="reporteVisitas">
                                <label>Generando Reporte de visitas</label>
                                <div class="progress">
                                    <div class="progress-bar active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; border-radius: 10px;">
                                        0%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body table-responsive p-2 mt-3 mx-auto" id="respuestaReportVisitas">     
            </div>
        </div>
        <script  type ="module" src="$ruta"></script>
        Html;
        return $html;
    }

    private function getTablaRow(MySQLConnection $conexion): string
    {
        $sql = "SELECT id, dni, apellidos_nombres, hora_de_ingreso, hora_de_salida, motivo  FROM visitas WHERE hora_de_salida IS NULL ";
        $smt = $conexion->query($sql, '', '', false);
        $resultado = $smt->fetchAll();
        $tablaRow = '';
        foreach ($resultado as $row) {
            $id = $row['id'];
            $dni = $row['dni'];
            $apellidoNombre = $row['apellidos_nombres'];
            $horaIngreso = $row['hora_de_ingreso'];
            $horaSalida = $row['hora_de_salida'];
            $motivo = $row['motivo'];
            $tablaRow .= "<tr>";
            $tablaRow .= "<td class=\"text-center\">$id</td>";
            $tablaRow .= "<td class=\"text-center\">$dni</td>";
            $tablaRow .= "<td class=\"text-center\">$apellidoNombre</td>";
            $tablaRow .= "<td class=\"text-center\">$horaIngreso</td>";
            $tablaRow .= "<td class=\"text-center\">$horaSalida</td>";
            $tablaRow .= "<td class=\"text-center\" style=\"max-width: 300px;\" contenteditable=\"false\">$motivo</td>";
            $tablaRow .= '
                <td class="text-center align-middle">
                    <i class="fa fa-edit mr-2 edit-icon" style="color:#9c74dd !important"></i>
                    <i class="fa fa-times mr-2 cancel-icon" style="color:#d90a0a !important; display:none;"></i>
                    <i class="fa fa-check save-icon" style="color:#acc90e !important; display:none;"></i>
                </td>
            ';
            $tablaRow .= "</tr>";
        }
        $conexion->close();
        return $tablaRow;
    }

    private function getSelectFuncionario (MySQLConnection $conexion)
    {
        
        $sql = "SELECT f.nombre_completo AS nombre FROM funcionarios AS f INNER JOIN oficinas as o ON f.id_oficina = o.id WHERE f.id_oficina =  1 AND f.estado = 1  AND f.nivel = 1 AND f.grupo_oficina = 1";
        $stmt = $conexion->query($sql, '', '', false);
        $resultado = $stmt->fetchAll();

        $options =  '<option value="">Seleccionar</option>';
        foreach($resultado as $row) {
            $funcionario = $row['nombre'];
            $options .= "<option value=\"$funcionario\">$funcionario</option>";
        }
        return $options;
    }
}