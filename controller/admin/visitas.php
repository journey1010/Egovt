<?php
require_once(_ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once(_ROOT_MODEL . 'conexion.php');
require_once(_ROOT_PATH . '/vendor/autoload.php');


use Dompdf\Dompdf;
use Dompdf\Css\Stylesheet;


class visitas extends handleSanitize
{

    public function RegistrarVisita()
    {
        try {
            $dniVisita = $_POST['dniVisita'];
            $tipoDoc = $_POST['tipoDoc'];
            $apellidosNombres = $_POST['apellidosNombres'];
            $institucionVisitante = $_POST['institucionVisitante'];
            $oficina = $_POST['oficina'];
            $personaAVisitar = $_POST['personaAVisitar'];
            $horaDeIngreso = $_POST['horaDeIngreso'];
            $quienAutoriza = $_POST['quienAutoriza'];
            $motivo = $_POST['motivo'];

            if (
                !empty($dniVisita) &&
                !empty($tipoDoc) &&
                !empty($institucionVisitante) &&
                !empty($apellidosNombres) &&
                !empty($oficina) &&
                !empty($horaDeIngreso)

            ) {
                $dniVisita = $this->strtoupperString($dniVisita);
                $tipoDoc = $this->strtoupperString($tipoDoc);
                $documento = $tipoDoc . ' : ' . $dniVisita;
                $apellidosNombres = $this->strtoupperString($apellidosNombres);
                $institucionVisitante = $this->strtoupperString($institucionVisitante);
                $oficina = $this->strtoupperString($oficina);
                $oficina = explode('-', $oficina);
                $oficina = $oficina[0];
                $personaAVisitar = $this->strtoupperString($personaAVisitar);
                $quienAutoriza = $this->strtoupperString($quienAutoriza);
                $motivo = $this->strtoupperString($motivo);

                $conexion = new MySQLConnection();
                $sqlSentence = 'INSERT INTO visitas (
                    apellidos_nombres,
                    dni,
                    area_que_visita, 
                    persona_a_visitar, 
                    hora_de_ingreso,
                    quien_autoriza, 
                    motivo,
                    institución_visitante
                ) VALUES (
                    ?,?,?,?,?,?,?,?
                )';
                $params = [
                    $apellidosNombres,
                    $documento,
                    $oficina,
                    $personaAVisitar,
                    $horaDeIngreso,
                    $quienAutoriza,
                    $motivo,
                    $institucionVisitante
                ];
                $conexion->query($sqlSentence, $params, '', false);
                $conexion->close();
                $respuesta = array('success' => 'visita registrado con exito');
                print_r(json_encode($respuesta));
            } else {
                $respuesta = array('error' => 'Los datos obligatorios no deben estar vacíos.');
                print_r(json_encode($respuesta));
            }
        } catch (Throwable $e) {
            $this->handlerError($e);
            $respuesta = array('error' => 'Error al guardar datos.');
            print_r(json_encode($respuesta));
        }
        return;
    }

    public function ActualizarVisita()
    {
        try {
            $id = $_POST['id'];
            $horaSalida = $_POST['horaSalida'];
            $motivo = $_POST['motivo'];
            if (!empty($horaSalida)) {
                $motivo = $this->strtoupperString($motivo);

                $conexion = new MySQLConnection();
                $sqlSentence = "UPDATE visitas SET hora_de_salida = ?, motivo = ? WHERE id= ?";
                $params = [$horaSalida, $motivo, $id];
                $conexion->query($sqlSentence, $params, '', false);
                $conexion->close();
                $respuesta = array('success' => 'visita actualizada con exito');
                print_r(json_encode($respuesta));
            } else {
                $respuesta = array('error' => 'Los datos obligatorios no deben estar vacíos.');
                print_r(json_encode($respuesta));
            }
        } catch (Throwable $e) {
            $this->handlerError($e);
            $respuesta = array('error' => 'Error al actualizar datos.');
            print_r(json_encode($respuesta));
        }
    }

    public function RegularizarVisita()
    {
        try {
            $camposRequeridos = ['dniVisita', 'apellidosNombres', 'oficina', 'personaAVisitar', 'institucionVisitante', 'horaDeIngreso', 'quienAutoriza', 'motivo', 'horaDeSalida'];
            foreach ($camposRequeridos as $campo) {
                extract([$campo => $this->SanitizeVarInput($_POST[$campo])]);
            }
            foreach($camposRequeridos as $campo){
                ${$campo} = $this->strtoupperString(${$campo});
            }
            if(empty($horaDeSalida)){
                $horaDeSalida = NULL;
            }
            $oficina = explode('-', $oficina);
            $oficina = $oficina[0];
            $conexion = new MySQLConnection();
            $sqlSentence = 'INSERT INTO visitas (
                apellidos_nombres, 
                dni,
                area_que_visita, 
                persona_a_visitar, 
                hora_de_ingreso,
                quien_autoriza, 
                motivo,
                hora_de_salida,
                institución_visitante
            ) VALUES (
                ?,?,?,?,?,?,?,?,?
            )';
            $params = [
                $apellidosNombres,
                $dniVisita,
                $oficina,
                $personaAVisitar,
                $horaDeIngreso,
                $quienAutoriza,
                $motivo,
                $horaDeSalida,
                $institucionVisitante
            ];
            $conexion->query($sqlSentence, $params, '', false);
            $respuesta = array('status' => 'success', 'message' => 'Registro guardado');
            echo (json_encode($respuesta));
        } catch (Throwable $e) {
            $this->handlerError($e);
            $respuesta = array('status' => 'error', 'message' => 'Algo salió mal!');
            echo (json_encode($respuesta));
        }
    }

    public function Obtenerfuncionarios()
    {
        $conexion = new MySQLConnection();
        $oficinaGrupo = $_POST['oficina'];
        $oficinaGrupo = explode('-', $oficinaGrupo);
        $grupo = $oficinaGrupo[1];
        $sql = "SELECT f.nombre_completo AS nombre FROM funcionarios AS f INNER JOIN oficinas as o ON f.id_oficina = o.id WHERE f.grupo_oficina =  ? AND f.estado = 1 AND f.nivel = 1";
        $param = [$grupo];
        $stmt = $conexion->query($sql, $param, '', false);
        $resultado = $stmt->fetchAll();

        $options =  '<option value="">Seleccionar</option>';
        foreach ($resultado as $row) {
            $funcionario = $row['nombre'];
            $options .= "<option value=\"$funcionario\">$funcionario</option>";
        }
        echo $options;
    }

    public function ExportarVisitas()
    {
        $fechaDesde = $this->SanitizeVarInput($_POST['fechaDesde']);
        $fechaHasta = $this->SanitizeVarInput($_POST['fechaHasta']);

        $conexion = new MySQLConnection();
        $sql = "SELECT v.apellidos_nombres as apn, v.dni as doc, v.institución_visitante as iv, o.nombre as ofi, v.persona_a_visitar as pv, v.hora_de_ingreso as hi, v.hora_de_salida as hs, v.quien_autoriza as qa, v.motivo as m FROM visitas AS v INNER JOIN oficinas AS o ON o.id = v.area_que_visita WHERE v.hora_de_ingreso >= :fechDesde AND (v.hora_de_salida <= :fechHasta OR v.hora_de_salida IS NULL)";
        $params = [':fechDesde' => $fechaDesde, ':fechHasta' => $fechaHasta];
        try {
            $stmt = $conexion->query($sql, $params, '', false);
            $resultado = $stmt->fetchAll();
            $archivo = $this->makeReportVisitas($resultado);
            $respuesta = array('status' => 'success', 'message' => 'Datos Listos.', 'archivo' => $archivo);
            echo (json_encode($respuesta));
        } catch (Throwable $e) {
            $this->handlerError($e);
            $respuesta = array('status' => 'error', 'message' => 'Error critico al generar el reporte.');
            echo (json_encode($respuesta));
        }
    }

    private function makeReportVisitas($resultado)
    {
        $dompdf = new Dompdf(array('enable_remote' => true));

        $tablaRow = '';
        foreach ($resultado as $row) {
            $tablaRow .= <<<Html
            <tr>
                <td>{$row['apn']}</td>
                <td>{$row['doc']}</td>
                <td>{$row['iv']}</td>
                <td>{$row['ofi']}</td>
                <td>{$row['pv']}</td>
                <td>{$row['hi']}</td>
                <td>{$row['hs']}</td>
                <td>{$row['qa']}</td>
                <td>{$row['m']}</td>
            </tr>
            Html;
        }

        $imagePath = _ROOT_PATH . '/assets/images/logoReporte.png';
        $imageData = file_get_contents($imagePath);
        $base64Image = base64_encode($imageData);
        $imageSrc = 'data:image/png;base64,' . $base64Image;
        $fecha = date('d/m/Y');

        $html  = <<<Html
        <html>
        <head>
            <style>
                *, ::after, ::before {
                    box-sizing: border-box;
                }
                @page {
                    size: A4 landscape;
                    margin: 0.5cm;
                }
                body {
                    margin: 0;
                    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans","Liberation Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
                    font-size: 1rem;
                    font-weight: 400;
                    line-height: 1.5;
                    color: #212529;
                    text-align: left;
                    background-color: #fff;
                }
                .w-50 {
                    width: 50%!important;
                }
                .img-fluid {
                    max-width: 100%;
                    height: auto;
                }
                img {
                    width: 100%;
                }
                img {
                    vertical-align: middle;
                    border-style: none;
                }
                .text-center {
                    text-align: center!important;
                }
                @media (min-width: 768px)
                .col-md-8 {
                    -ms-flex: 0 0 66.666667%;
                    flex: 0 0 66.666667%;
                    max-width: 66.666667%;
                }
                .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
                    position: relative;
                    width: 100%;
                    padding-right: 15px;
                    padding-left: 15px;
                }
                .h3, h3 {
                    font-size: 1.75rem;
                }
                .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
                    margin-bottom: .5rem;
                    font-weight: 500;
                    line-height: 1.2;
                }
                h1, h2, h3, h4, h5, h6 {
                    margin-top: 0;
                    margin-bottom: .5rem;
                }
                .h6, h6 {
                    font-size: 1rem;
                }
                .content {
                    padding: 1cm;
                }
                img {
                    width: 100%;
                }
                .line {
                    border-bottom: 3px solid black;
                    margin-top: 10px;
                    margin-bottom: 10px;
                }
                table {
                    table-layout: fixed;
                    width: 100%;
                }
                td {
                    word-wrap: break-word;
                }
                .content {
                    padding: 1cm;
                }
                .justify-content-center {
                    -ms-flex-pack: center!important;
                    justify-content: center!important;
                }
                .d-flex {
                    display: -ms-flexbox!important;
                    display: flex!important;
                }
                .row {
                    display: -ms-flexbox;
                    display: flex;
                    -ms-flex-wrap: wrap;
                    flex-wrap: wrap;
                    margin-right: -15px;
                    margin-left: -15px;
                }
                @media (min-width: 992px)
                .col-lg-12 {
                    -ms-flex: 0 0 100%;
                    flex: 0 0 100%;
                    max-width: 100%;
                }
                .mt-1, .my-1 {
                    margin-top: .25rem!important;
                }
                .table-bordered {
                    border: 1px solid #dee2e6;
                }
                .table {
                    width: 100%;
                    margin-bottom: 1rem;
                    color: #212529;
                }
                table {
                    table-layout: fixed;
                    width: 100%;
                }
                table {
                    border-collapse: collapse;
                }
                table {
                    display: table;
                    border-collapse: separate;
                    box-sizing: border-box;
                    text-indent: initial;
                    border-spacing: 2px;
                    border-color: gray;
                }
                thead {
                    display: table-header-group;
                    vertical-align: middle;
                    border-color: inherit;
                }
                tr {
                    display: table-row;
                    vertical-align: inherit;
                    border-color: inherit;
                }
                .table-bordered thead td, .table-bordered thead th {
                    border-bottom-width: 2px;
                }
                .table thead th {
                    vertical-align: bottom;
                    border-bottom: 2px solid #dee2e6;
                }
                .table-bordered td, .table-bordered th {
                    border: 1px solid #dee2e6;
                }
                div {
                    display: block;
                }
                .table td, .table th {
                    padding: .75rem;
                    vertical-align: top;
                    border-top: 1px solid #dee2e6;
                }
                th {
                    text-align: inherit;
                    text-align: -webkit-match-parent;
                }
                .table {
                    width: 100%;
                    margin-bottom: 1rem;
                    color: #212529;
                }
                .table td, .table th {
                    padding: .75rem;
                    vertical-align: top;
                    border-top: 1px solid #dee2e6;
                }
                .table-bordered td, .table-bordered th {
                    border: 1px solid #dee2e6;
                }
                .table {
                    border-collapse: collapse;
                }
                  
                .table th,
                .table td {
                    border: 1px solid black;
                    padding: 8px;
                }
                  
                .table thead th {
                background-color: lightgray;
                }

                .table-bordered {
                border: 1px solid black;
                }
                  
                .justify-content-between {
                    justify-content: space-between;
                }
                .d-flex {
                    display: -ms-flexbox!important;
                    display: flex!important;
                }

                .mt-4, .my-4 {
                    margin-top: 1.5rem!important;
                }

                .w-25 {
                    width: 25%!important;
                }
                @page :first {
                    footer: {
                        position: running(header_first_footer);
                    }
                }
        
                @page {
                    footer: {
                        position: running(header_footer);
                    }
                }
        
                #footer_content {
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class="content">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-2">
                        <img src="$imageSrc"  style="max-width: 100px; height: auto; float: left;">
                    </div>
                    <div class="col-md-8 text-center" style="padding: 0px; margin-left: auto; margin-right: auto;">
                        <h3 class="text-center">OFICINA DE LOGISTICA Y SERVICIOS GENERALES</h3>
                        <h6 class="text-center">Unidad de Seguridad</h6>
                        <h6 class="text-center">"Año de la unidad, la paz y el desarrollo"</h6>
                    </div>
                    <div class="col-md-8" style="padding: 0px; margin-left: 30px; margin-right: auto;">
                        <h7>UBICACIÓN: SEDE CENTRAL - GOBIERNO REGIONAL DE LORETO</h7>
                        <h7> ||  Reporte de visitas con fecha: $fecha</h7>
                    </div>
                    <div class="col-lg-12 line"></div>
                    <div class="col-lg-12 mt-1">
                        <table class="table table-bordered" style="font-size: 14px">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 15%">Apellidos y Nombres</th>
                                    <th scope="col" style="width: 15%">Documento</th>
                                    <th scope="col" style="width: 15%">Institución del visitante</th>
                                    <th scope="col" style="width: 15%">Área que visita</th>
                                    <th scope="col" style="width: 15%">¿A quién visita?</th>
                                    <th scope="col" style="width: 15%">Ingreso</th>
                                    <th scope="col" style="width: 15%">Salida</th>
                                    <th scope="col" style="width: 15%">Quien Autoriza</th>
                                    <th scope="col" style="width: 15%">Motivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                $tablaRow
                            </tbody>
                        </table>
                        <table style="width: 100%; position: fixed; bottom: 40;">
                            <tr>
                                <td style="text-align: left; width: 50%;">
                                    <hr style="width: 50%;border: none; border-top: 1px solid black;">
                                    <h5 style="text-align: center;">Supervisor de Turno</h5>
                                </td>
                                <td style="text-align: right; width: 50%;">
                                    <hr style="width: 50%; border: none; border-top: 1px solid black;">
                                    <h5 style="text-align: center;">Encargado de Garita N° 1</h5>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </body>
        </html>        
        Html;

        $dompdf->loadHtml($html);
        $dompdf->render();

        $nombreArchivo = 'Reporte_de_visitas.pdf';
        $rutaArchivo = _ROOT_FILES . 'transparencia/visitas/'  . $nombreArchivo;
        file_put_contents($rutaArchivo, $dompdf->output());
        $enlace = _BASE_URL . '/files/transparencia/visitas/' . $nombreArchivo;
        return $enlace;
    }

    private function strtoupperString(string $string)
    {   
        $text = $this->SanitizeVarInput($string);
        $text = mb_strtoupper(mb_convert_case($text, MB_CASE_UPPER, 'UTF-8'), 'UTF-8');
        return $text;
    }
}