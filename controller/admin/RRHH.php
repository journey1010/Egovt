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

            ##comprobar que el archivo cargado tenga el formato requerido en los encabezados
            $encabezados_requeridos = array('Id del Empleado', 'Nombres', 'Apellidos', 'Departamento', 'Fecha', 'Hora', 'Tipo de Marcación', 'Fuente de Datos');
            $encabezados_hoja = array();
            $cellIterator = $worksheet->getRowIterator(2)->current()->getCellIterator();            
            foreach ($cellIterator as $cell) {
                $encabezados_hoja[] = $cell->getValue();
            } 
            if ($encabezados_hoja !== $encabezados_requeridos) {
                $respuesta = array('status' => 'error', 'message'=>'El archivo no cuenta con el formato requerido.');
                echo (json_encode($respuesta));
                return;
            }
            ##Fin comprobación 

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
            $sql = "INSERT INTO asistencia_filtrada (id_empleado, nombres, apellidos, departamento, fecha, hora_entrada, hora_salida) SELECT id_empleado, nombres, apellidos, departamento, fecha,IF(MIN(hora)<'15:00:00',MIN(hora), null ) AS entrada, IF(MAX(hora)>='15:00:00',MAX(hora),null) AS salida 
            FROM asistencia 
            GROUP BY id_empleado, nombres, apellidos, departamento, fecha";
            $this->conexion->query($sql, '', '', false);
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
            $fechaDesde = $_POST['fechaDesde'];
            $fechaHasta = $_POST['fechaHasta'];
            $ordenar = $_POST['ordenar'];
            $palabra = $_POST['palabra'];
            $this->selectForBusqueda( $oficina, $fechaDesde, $fechaHasta, $ordenar, $palabra);
        } catch (Throwable $e) {
            $respuesta = array('status' => 'error', 'message' => 'El filtrado de datos ha fallado.');
            echo (json_encode($respuesta));
            $this->handlerError($e);
        }
    }

    private function selectForBusqueda($oficina = '', $fechaDesde = '', $fechaHasta='', $ordenar = '', $palabra = '')
    {
        try {
            $sql = "SELECT id_empleado, nombres, apellidos, departamento, fecha, hora_entrada, hora_salida FROM asistencia_filtrada WHERE 1=1";

            if (!empty($oficina)) {
                $sql .= " AND departamento = :departamento";
                $params[':departamento'] = $oficina;
            }
            if(!empty($fechaDesde) && !empty($fechaHasta)) {
                $sql .= " AND fecha BETWEEN :fecha_desde AND :fecha_hasta ";
                $params[':fecha_desde'] = $fechaDesde;
                $params[':fecha_hasta'] = $fechaHasta;
            }
            elseif(!empty($fechaDesde)) {
                $sql .= " AND fecha >= :fecha_desde ";
                $params[':fecha_desde'] = $fechaDesde;
            }
            elseif(!empty($fechaHasta)) {
                $sql .= " AND fecha <= :fecha_hasta  ";
                $params[':fecha_hasta'] = $fechaHasta;
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

            if(empty($params)) 
            {
                $params ='';
            }

            $stmt = $this->conexion->query($sql, $params, '', false);
            $array = $stmt->fetchAll();
            $resultado = $this->makeExcelForBusqueda($array);
            return $resultado;
        } catch (Throwable $e) {
            $this->handlerError($e);
        }
    }

    private function makeExcelForBusqueda($consulta)
    {
        $archivo = $this->asistencia_filtrada($consulta);
        $respuesta = array('status' => 'success', 'message' => 'Filtrado y reasignación de reporte de marcaciones exitoso.', 'archivo'=>$archivo);
        echo (json_encode($respuesta));
    }

    private function asistencia_filtrada($consulta) 
    {
        $spreadsheet = new Spreadsheet();
        $hoja_activa = $spreadsheet->getActiveSheet();

        $hoja_activa->setCellValue('A1', 'REPORTE DE MARCACIONES');
        $hoja_activa->getStyle('A1')->getFont()->setBold(true)->setSize(20);

        $cabeceras = 
            [
                'A2'=>'REPORTE DE MARCACIONES',
                'B2'=>'NOMBRES',
                'C2'=>'APELLIDOS',
                'D2'=>'DEPARTAMENTO',
                'E2'=>'FECHA',
                'F2'=>'HORA ENTRADA',
                'G2'=>'ESTADO',
                'H2'=>'HORA SALIDA'
            ];
        foreach ($cabeceras as $indice => $valor){
            $hoja_activa->setCellValue($indice, $valor);
            $hoja_activa->getStyle($indice)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
            $hoja_activa->getStyle($indice)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
        }

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
            $hoja_activa->setCellValue('F' . $fila, $dato['hora_entrada']);
            $hoja_activa->setCellValue('H' . $fila, $dato['hora_salida']);

            // Determinar el estado de entrada según la hora
            $estado_entrada = '';
            if ($dato['hora_entrada'] === null) {
                $hora_entrada = null;
            } else {
                $hora_entrada = DateTime::createFromFormat('H:i:s', $dato['hora_entrada']);
            }
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
        $hoja_activa->getColumnDimension('H')->setWidth(20);

        // Establecer el ancho de columna para los encabezados y los datos
        $hoja_activa->getRowDimension('1')->setRowHeight(30);
        $hoja_activa->getRowDimension('2')->setRowHeight(25);
        $hoja_activa->getDefaultRowDimension()->setRowHeight(20);

        $hoja_activa->getStyle('A3:H' . ($fila - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Establecer la alineación vertical y horizontal de la fila
        $hoja_activa->getStyle('A3:H' . ($fila - 1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Establecer el borde alrededor de la tabla completa
        $hoja_activa->getStyle('A3:H' . ($fila - 1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THICK)->getColor()->setRGB('000000');

        $writer = new Xlsx($spreadsheet);
        $pathFullfile = $this->file . 'archivo-generado/Reporte-marcación ' . date('Y-m-d-H-i-s') . '.xlsx';
        $writer->save($pathFullfile);
        $archivo =  _BASE_URL . '/files/asistencia/archivo-generado/' . strstr($pathFullfile, 'Reporte-marcación');
        return $archivo;
    }
}