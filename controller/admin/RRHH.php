<?php
require 'vendor/autoload.php';
require_once(_ROOT_CONTROLLER . 'admin/handleSanitize.php');
require_once(_ROOT_CONTROLLER . 'admin/AdministrarArchivos.php');
require_once(_ROOT_MODEL . 'conexion.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class RRHH extends handleSanitize
{
    private $file;
    private $conexion;

    public function __construct()
    {
        $this->file = _ROOT_FILES . 'asistencia/';
        $this->conexion = new MySQLConnection();
    }

    public function loadFile()
    {
        try {
            $gestorArchivo = new AdministrarArchivos($this->conexion, "asistencia/");
            $archivo = $_FILES["archivo"];
            if ($gestorArchivo->validarArchivo($archivo, ['xls', 'xlsx']) == false) {
                return;
            }

            $this->file = _ROOT_FILES . 'asistencia/' .  $gestorArchivo->guardarFichero($archivo, 'Registro de visitas');
            $respuesta = array("status" => "success", "message" => "Archivo recibido con éxito.", 'archivo' => $this->file);
            echo (json_encode($respuesta));
        } catch (Throwable $e) {
            $respuesta = array('status' => 'error', 'message' => 'Error al recibir archivo');
            echo (json_encode($respuesta));
            $this->handlerError($e);
        }
    }

    public function readExcel()
    {
        try {
            $file = $_POST['file'];
            $sql = "INSERT INTO asistencia (id_empleado, nombres, apellidos, departamento, fecha, hora) VALUES ";
            $spreedsheet = IOFactory::load($file);
            $worksheet = $spreedsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = 'F';

            for ($row = 3; $row <= $highestRow; $row++) {
                $sqlValues = "(";
                for ($col = 'A'; $col <= $highestColumn; $col++) {
                    $cell = $worksheet->getCell($col . $row);
                    $value = $cell->getValue();
                    $sqlValues .= "'" . addslashes($value) . "', ";
                }
                $sqlValues = rtrim($sqlValues, ", ") . ")";
                $sql .= $sqlValues . ", ";
            }
            $sql = rtrim($sql, ", ");
            $this->conexion->query($sql, '', '', false);
            $respuesta = array('status' => 'success', 'message' => 'Registros de marcación registrados.');
            echo (json_encode($respuesta));
        } catch (Throwable $e) {
            $this->handlerError($e);
        }
    }

    public function filtrarExcel()
    {
        try {
            $sql_entrada = "INSERT INTO asistencia_entrada (id_empleado, nombres, apellidos, departamento, fecha, hora) SELECT id_empleado,  nombres, apellidos, departamento, fecha, MIN(hora) AS ingreso FROM asistencia WHERE hora < '15:00:00' GROUP BY id_empleado, nombres,apellidos, fecha, departamento";
            $this->conexion->query($sql_entrada, '', '', false);
            $sql_salida = "INSERT INTO asistencia_salida (id_empleado, nombres,apellidos, departamento, fecha,hora) SELECT id_empleado, nombres, apellidos, departamento, fecha, MAX(hora) AS salida FROM asistencia WHERE hora>='15:00:00' GROUP BY id_empleado, nombres,apellidos, fecha, departamento";
            $this->conexion->query($sql_salida, '', '', false);
            $sql_delete = "DELETE FROM asistencia";
            $this->conexion->query($sql_delete, '', '', false);
            $respuesta = array("status" => "success", "message" => "Filtrado y reasignación de reporte de marcaciones exitoso.");
            echo (json_encode($respuesta));
        } catch (Throwable $e) {
            $respuesta = array('status' => 'error', 'message' => 'Error al recibir archivo');
            echo (json_encode($respuesta));
            $this->handlerError($e);
        }
    }

    public function busqueda()
    {
        try {
            $oficina = $_POST['oficina'];
            $fecha = $_POST['fecha'];
            $ordenar = $_POST['ordenar'];
            $palabra = $_POST['palabra'];
            $tipoMarcacion = $_POST['tipoMarcacion'];
            $this->selectForBusqueda($tipoMarcacion, $oficina, $fecha, $ordenar, $palabra);
        } catch (Throwable $e) {
            $respuesta = array('status' => 'error', 'message' => 'El filtrado de datos ha fallado.');
            echo (json_encode($respuesta));
            $this->handlerError($e);
        }
    }

    private function selectForBusqueda($tipoMarcacion, $oficina = '', $fecha = '', $ordenar = '', $palabra = '')
    {
        try {
            $tabla = ($tipoMarcacion == 'entrada') ? 'asistencia_entrada' : 'asistencia_salida';
            $sql = "SELECT id_empleado, nombres, apellidos, departamento, fecha, hora FROM $tabla  WHERE 1=1";

            if (!empty($oficina)) {
                $sql .= " AND departamento = :departamento";
                $params[':departamento'] = $oficina;
            }

            if (!empty($fecha)) {
                $sql .= " AND fecha = :fecha";
                $params[':fecha'] = $fecha;
            }

            if (!empty($palabra)) {
                $sql .= " AND ( CONCAT(nombres, ' ', apellidos) LIKE :nombress OR id_empleado LIKE :id_empleado)";
                $params[':nombress'] = '%' . $palabra . '%';
                $params[':id_empleado'] = '%' . $palabra . '%';
            }

            if ($ordenar == 'DESC') {
                $sql .= " ORDER BY fecha DESC"; 
            } elseif ($ordenar == 'ASC') {
                $sql .= " ORDER BY fecha";
            } else {
                $sql .= " ORDER BY fecha DESC";
            }

            $stmt = $this->conexion->query($sql, $params, '', false);
            $array = $stmt->fetchAll();
            $resultado = $this->makeExcelForBusqueda($array, $tipoMarcacion);
            return $resultado;
        } catch (Throwable $e) {
            $this->handlerError($e);
        }
    }

    private function  makeExcelForBusqueda($consulta, $tipoMarcacion)
    {
        
        if ($tipoMarcacion == 'entrada') {
            $archivo = $this->asistencia_entrada($consulta, $tipoMarcacion);
        } else {
            $archivo = $this-> asistencia_salida($consulta, $tipoMarcacion);
        }

        $respuesta = array('status' => 'success', 'message' => 'Filtrado y reasignación de reporte de marcaciones exitoso.', 'archivo'=>$archivo);
        echo (json_encode($respuesta));
    }

    private function asistencia_entrada($consulta,$tipoMarcacion) 
    {
        $spreadsheet = new Spreadsheet();
        $hoja_activa = $spreadsheet->getActiveSheet();
        $hoja_activa->setCellValue('A1', 'Reporte de Marcaciones Entrada');
        $hoja_activa->getStyle('A1')->getFont()->setBold(true)->setSize(20);
        $hoja_activa->setCellValue('A2', 'ID EMPLEADO');
        $hoja_activa->getStyle('A2')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $hoja_activa->getStyle('A2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('000000');

        $hoja_activa->setCellValue('B2', 'NOMBRES');
        $hoja_activa->getStyle('B2')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $hoja_activa->getStyle('B2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('000000');

        $hoja_activa->setCellValue('C2', 'APELLIDOS');
        $hoja_activa->getStyle('C2')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $hoja_activa->getStyle('C2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('000000');

        $hoja_activa->setCellValue('D2', 'DEPARTAMENTO');
        $hoja_activa->getStyle('D2')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $hoja_activa->getStyle('D2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('000000');

        $hoja_activa->setCellValue('E2', 'FECHA');
        $hoja_activa->getStyle('E2')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $hoja_activa->getStyle('E2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('000000');

        $hoja_activa->setCellValue('F2', 'HORA');
        $hoja_activa->getStyle('F2')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $hoja_activa->getStyle('F2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('000000');

        $hoja_activa->setCellValue('G2', 'ESTADO');
        $hoja_activa->getStyle('G2')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $hoja_activa->getStyle('G2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('000000');

        // Establecer el color y formato de fuente para cada estado de entrada
        $color_entrada_regular = '00FF00';
        $color_tardanza = 'FFFF00';
        $color_falta = 'FF0000';

        $fuente_negra = new Font();
        $fuente_negra->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));

        // Inicializar el índice de fila en 3 para comenzar a escribir los datos en la tercera fila
        $fila = 3;

        foreach ($consulta as $dato) {
            $hoja_activa->setCellValue('A' . $fila, $dato['id_empleado']);
            $hoja_activa->setCellValue('B' . $fila, $dato['nombres']);
            $hoja_activa->setCellValue('C' . $fila, $dato['apellidos']);
            $hoja_activa->setCellValue('D' . $fila, $dato['departamento']);
            $hoja_activa->setCellValue('E' . $fila, $dato['fecha']);
            $hoja_activa->setCellValue('F' . $fila, $dato['hora']);

            // Determinar el estado de entrada según la hora
            $estado_entrada = '';
            $hora_entrada = DateTime::createFromFormat('H:i:s', $dato['hora']);
            $hora_limite_regular = DateTime::createFromFormat('H:i:s', '07:00:00');
            $hora_limite_tardanza = DateTime::createFromFormat('H:i:s', '07:05:00');
            if ($hora_entrada <= $hora_limite_regular) {
                $estado_entrada = 'Entrada regular';
                $color_estado = $color_entrada_regular;
            } elseif ($hora_entrada <= $hora_limite_tardanza) {
                $estado_entrada = 'Tardanza';
                $color_estado = $color_tardanza;
            } else {
                $estado_entrada = 'Falta';
                $color_estado = $color_falta;
            }

            $hoja_activa->setCellValue('G' . $fila, $estado_entrada);
            $hoja_activa->getStyle('G' . $fila)->getFont()->setBold(true)->setUnderline(false)->setStrikethrough(false);
            $hoja_activa->getStyle('G' . $fila)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
            $hoja_activa->getStyle('G' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($color_estado);
            $fila++;
        }
        $hoja_activa->getColumnDimension('A')->setWidth(20);
        $hoja_activa->getColumnDimension('B')->setWidth(40);
        $hoja_activa->getColumnDimension('C')->setWidth(40);
        $hoja_activa->getColumnDimension('D')->setWidth(50);
        $hoja_activa->getColumnDimension('E')->setWidth(12);
        $hoja_activa->getColumnDimension('F')->setWidth(20);
        $hoja_activa->getColumnDimension('G')->setWidth(20);

        // Establecer el ancho de columna para los encabezados y los datos
        $hoja_activa->getRowDimension('1')->setRowHeight(30);
        $hoja_activa->getRowDimension('2')->setRowHeight(25);
        $hoja_activa->getDefaultRowDimension()->setRowHeight(20);

        $hoja_activa->getStyle('A3:G' . ($fila - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Establecer la alineación vertical y horizontal de la fila
        $hoja_activa->getStyle('A3:G' . ($fila - 1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Establecer el borde alrededor de la tabla completa
        $hoja_activa->getStyle('A3:G' . ($fila - 1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THICK)->getColor()->setRGB('000000');

        $writer = new Xlsx($spreadsheet);
        $pathFullfile = $this->file . 'archivo-generado/Reporte-marcación ' . $tipoMarcacion . ' ' . date('Y-m-d-H-i-s') . '.xlsx';
        $writer->save($pathFullfile);
        $archivo =  _BASE_URL . '/files/asistencia/archivo-generado/' . strstr($pathFullfile, 'Reporte-marcación');
        return $archivo;
    }

    private function asistencia_salida($consulta, $tipoMarcacion)
    {   
        $spreadsheet = new Spreadsheet();
        $hoja_activa = $spreadsheet->getActiveSheet();
        $hoja_activa->setCellValue('A1', 'Reporte de Marcaciones Salida');
        $hoja_activa->getStyle('A1')->getFont()->setBold(true)->setSize(20);
        $hoja_activa->setCellValue('A2', 'ID EMPLEADO');
        $hoja_activa->getStyle('A2')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $hoja_activa->getStyle('A2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('000000');

        $hoja_activa->setCellValue('B2', 'NOMBRES');
        $hoja_activa->getStyle('B2')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $hoja_activa->getStyle('B2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('000000');

        $hoja_activa->setCellValue('C2', 'APELLIDOS');
        $hoja_activa->getStyle('C2')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $hoja_activa->getStyle('C2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('000000');

        $hoja_activa->setCellValue('D2', 'DEPARTAMENTO');
        $hoja_activa->getStyle('D2')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $hoja_activa->getStyle('D2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('000000');

        $hoja_activa->setCellValue('E2', 'FECHA');
        $hoja_activa->getStyle('E2')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $hoja_activa->getStyle('E2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('000000');

        $hoja_activa->setCellValue('F2', 'HORA');
        $hoja_activa->getStyle('F2')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $hoja_activa->getStyle('F2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('000000');

        $fuente_negra = new Font();
        $fuente_negra->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));

        // Inicializar el índice de fila en 3 para comenzar a escribir los datos en la tercera fila
        $fila = 3;

        foreach ($consulta as $dato) {
            $hoja_activa->setCellValue('A' . $fila, $dato['id_empleado']);
            $hoja_activa->setCellValue('B' . $fila, $dato['nombres']);
            $hoja_activa->setCellValue('C' . $fila, $dato['apellidos']);
            $hoja_activa->setCellValue('D' . $fila, $dato['departamento']);
            $hoja_activa->setCellValue('E' . $fila, $dato['fecha']);
            $hoja_activa->setCellValue('F' . $fila, $dato['hora']);
            $fila++;
        }
        $hoja_activa->getColumnDimension('A')->setWidth(20);
        $hoja_activa->getColumnDimension('B')->setWidth(40);
        $hoja_activa->getColumnDimension('C')->setWidth(40);
        $hoja_activa->getColumnDimension('D')->setWidth(50);
        $hoja_activa->getColumnDimension('E')->setWidth(12);
        $hoja_activa->getColumnDimension('F')->setWidth(20);

        $hoja_activa->getRowDimension('1')->setRowHeight(30);
        $hoja_activa->getRowDimension('2')->setRowHeight(25);
        $hoja_activa->getDefaultRowDimension()->setRowHeight(20);

        $hoja_activa->getStyle('A3:F' . ($fila - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $hoja_activa->getStyle('A3:F' . ($fila - 1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $hoja_activa->getStyle('A3:F' . ($fila - 1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THICK)->getColor()->setRGB('000000');

        $writer = new Xlsx($spreadsheet);
        $pathFullfile = $this->file . 'archivo-generado/Reporte-marcación ' . $tipoMarcacion . ' ' . date('Y-m-d-H-i-s') . '.xlsx';
        $writer->save($pathFullfile);

        $archivo =  _BASE_URL . '/files/asistencia/archivo-generado/' . strstr($pathFullfile, 'Reporte-marcación');
        return $archivo;
    }
}