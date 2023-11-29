<?php
require_once _ROOT_PATH . '/vendor/autoload.php';

class CustomPDF {
    private $pdf;
    private $alturaTotal;
    private $totalWidth;

    public function __construct() {
        $this->pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $this->setupPDF();
        $this->alturaTotal = 24.7 + 13.3;
        $this->totalWidth = 161.8;
    }

    private function setupPDF() {
        $this->pdf->SetMargins(25, 25, 25);
        $this->pdf->SetAutoPageBreak(TRUE, 25);
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
        $this->pdf->AddPage();
        $this->pdf->SetFont('times', '', 9);
    }

    public function head() {

        $primeraColumnaAncho = 30.0; 
        $segundaColumnaAncho = 101.7; 
        $terceraColumnaAncho = 30.1; 
        $primeraFilaAltura = 24.7; 
        $segundaFilaAltura = 13.3; 
        $terceraFilaAltura = 21.0; 
        $cuartaFilaAltura = 17.0; 
        $alturaTotal = $primeraFilaAltura + $segundaFilaAltura;

        $logoPath = 'a.jpg'; 

        $this->pdf->Image($logoPath, $this->pdf->GetX()+8.1, $this->pdf->GetY(), 15.7, 19.1, 'JPG', '', '', true, 300, '', false, false, 0, false, false, false);

        $this->pdf->Cell($primeraColumnaAncho, $primeraFilaAltura, '', 1, 0, 'C', false);

        $this->pdf->Ln($primeraFilaAltura);

        $this->pdf->setCellPaddings(0, 1, 0, 0);
        $this->pdf->SetFont('times', '', 10);
        $this->pdf->MultiCell($primeraColumnaAncho, $segundaFilaAltura, "Formulario \nNo. 5030", 1,'C', false);

        $this->alturaTotal = $alturaTotal + 25;
        $this->pdf->SetXY(25 + $primeraColumnaAncho, 25); 
        $this->pdf->setCellPaddings(0, 3, 0, 0);
        $textoLegal = "SOLICITUD DE ACCESO A LA INFORMACIÓN PÚBLICA\nLEY No. 27806 modificada por la Ley Nº 27927, con Decreto Supremo Nº 072-2003-PCM, modificado con Decreto Supremo Nº 070-2013-PCM, publicado en el diario oficial El Peruano el 14 de Junio del 2013.";
        $this->pdf->setFont('times', 'B', 10);
        $this->pdf->MultiCell($segundaColumnaAncho, $alturaTotal, $textoLegal, 'TB', 'C', false);

        $this->pdf->SetXY(25 + $primeraColumnaAncho + $segundaColumnaAncho, 25); 
        $this->pdf->setFont('times', '', 9);
        $this->pdf->Cell($terceraColumnaAncho, $terceraFilaAltura, 'N° DE REGISTRO', 1, 2, 'C', false);
        $this->pdf->Cell($terceraColumnaAncho, $cuartaFilaAltura, '', 1, 1, 'C', false);

        $this->pdf->SetXY(25 + $primeraColumnaAncho + $segundaColumnaAncho, 25);
    }

    public function responsibleOfficial()
    {
        $this->alturaTotal = $this->alturaTotal +8;
        $this->pdf->setCellPaddings(0, 0, 0, 0);
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->setFont('times', '', 7);
        $this->pdf->Cell($this->totalWidth, 1,  'I.       FUNCIONARIO RESPONSABLE DE ENTREGAR LA INFORMACIÓN:', 'LTR', 0, 'C', false);
        $this->alturaTotal = $this->alturaTotal+3;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->setFont('times', '', 8);
        $this->pdf->Cell($this->totalWidth, 1,  'Abog.: Marlo Javier Torres Ruiz', 1, 0, 'C', false);
    }

    public function personalData($fullName, $typeDoc, $numberDoc, $address, $departamento, $provincia, $distrito, $email, $phone)
    {
        
        $this->alturaTotal = $this->alturaTotal +10;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->setFont('times', '', 7);
        $this->pdf->Cell($this->totalWidth, 1, 'II. DATOS DEL SOLICITANTE:', 'LTR', 0 , 'L', false);
        
        $this->alturaTotal = $this->alturaTotal+3;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->SetFont('helvetica', '', 7);
        $this->pdf->Cell(80.9, 2, ' APELLIDOS Y NOMBRES / RAZÓN SOCIAL', 'LTBR', 0, 'L', false);
        $postionColumn2 = 25+80.9;
        $this->pdf->setX($postionColumn2);
        $this->pdf->Cell(80.9, 2, ' '. $fullName, 'TBR', 0, 'L', false);

        $this->alturaTotal = $this->alturaTotal+3;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->SetFont('helvetica', '', 7);
        $this->pdf->Cell(80.9, 2, ' DOCUMENTO DE IDENTIDAD D.N.I./L.M./RUC/C.E./OTRO', 'LBR', 0, 'L', false);
        $postionColumn2 = 25+80.9;
        $this->pdf->setX($postionColumn2);
        $this->pdf->Cell(80.9, 2, ' '. $typeDoc . ': ' . $numberDoc, 'BR', 0, 'L', false);
        
        $this->alturaTotal = $this->alturaTotal+3;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->setFont('times', '', 7);
        $this->pdf->Cell($this->totalWidth, 1, 'DOMICILIO', 'LBR', 0 , 'C', false);

        $this->alturaTotal = $this->alturaTotal+3;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->SetFont('helvetica', '', 7);
        $this->pdf->Cell(80.9, 2, ' AV/CALLE/JR/PSJ.', 'LBR', 0, 'L', false);
        $postionColumn2 = 25+80.9;
        $this->pdf->setX($postionColumn2);
        $this->pdf->Cell(80.9, 2, ' '. $address, 'BR', 0, 'L', false);

        $this->alturaTotal = $this->alturaTotal+3;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->Cell(80.9, 2, ' N°/DPTO./INT.', 'LBR', 0, 'L', false);
        $postionColumn2 = 25+80.9;
        $this->pdf->setX($postionColumn2);
        $this->pdf->Cell(80.9, 2, '', 'BR', 0, 'L', false);

        $this->alturaTotal = $this->alturaTotal+3;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->Cell(80.9, 2, ' DISTRITO', 'LBR', 0, 'L', false);
        $postionColumn2 = 25+80.9;
        $this->pdf->setX($postionColumn2);
        $this->pdf->Cell(80.9, 2, ' '. $distrito, 'BR', 0, 'L', false);

        $this->alturaTotal = $this->alturaTotal+3;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->Cell(80.9, 2, ' URBANIZACIÓN', 'LBR', 0, 'L', false);
        $postionColumn2 = 25+80.9;
        $this->pdf->setX($postionColumn2);
        $this->pdf->Cell(80.9, 2, '', 'BR', 0, 'L', false);

        $this->alturaTotal = $this->alturaTotal+3;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->Cell(80.9, 2, ' PROVINCIA', 'LBR', 0, 'L', false);
        $postionColumn2 = 25+80.9;
        $this->pdf->setX($postionColumn2);
        $this->pdf->Cell(80.9, 2, ' '. $provincia, 'BR', 0, 'L', false);

        $this->alturaTotal = $this->alturaTotal+3;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->Cell(80.9, 2, ' DEPARTAMENTO', 'LBR', 0, 'L', false);
        $postionColumn2 = 25+80.9;
        $this->pdf->setX($postionColumn2);
        $this->pdf->Cell(80.9, 2, ' '. $departamento, 'BR', 0, 'L', false);


        $this->alturaTotal = $this->alturaTotal+3;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->Cell(80.9, 2, ' CORREO ELECTRÓNICO', 'LBR', 0, 'L', false);
        $postionColumn2 = 25+80.9;
        $this->pdf->setX($postionColumn2);
        $this->pdf->Cell(80.9, 2, ' '. $email, 'BR', 0, 'L', false);

        $this->alturaTotal = $this->alturaTotal+3;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->Cell(80.9, 2, ' TELÉFONO', 'LBR', 0, 'L', false);
        $postionColumn2 = 25+80.9;
        $this->pdf->setX($postionColumn2);
        $this->pdf->Cell(80.9, 2, ' '. $phone, 'BR', 0, 'L', false);       
    }

    public function infoRequired($infoRequired, $dependencia)
    {
        $this->alturaTotal = $this->alturaTotal + 10;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->setFont('times', '', 7);
        $this->pdf->Cell($this->totalWidth, 4, 'III. INFORMACIÓN SOLICITADA:', 'LTR', 1, 'L', false);
        
        $this->alturaTotal = $this->alturaTotal + 4;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->setCellPaddings(1, 2, 1, 1);
        $this->pdf->MultiCell($this->totalWidth, 5, $infoRequired, 'LTBR', 'J', false);
    
        $this->alturaTotal = $this->alturaTotal + 12;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->setFont('times', '', 7);
        $this->pdf->Cell($this->totalWidth, 4, 'IV. DEPENDENCIA DE LA CUAL REQUIERE INFORMACIÓN', 'LTR', 1, 'L', false);
        
        $this->alturaTotal = $this->alturaTotal + 5;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->setCellPaddings(1, 2, 1, 1);
        $this->pdf->MultiCell($this->totalWidth, 5, $dependencia, 'LTBR', 'J', false);

        $this->alturaTotal = $this->alturaTotal + 7;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->setFont('times', '', 7);
        $this->pdf->Cell($this->totalWidth, 4, 'V. FORMA DE ENTREGA DE LA INFORMACIÓN (marcar con una “X”)', 'LTR', 1, 'L', false);
        

        $this->alturaTotal = $this->alturaTotal + 5;
        $this->pdf->setCellPaddings(1, 0, 0, 0);
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->MultiCell(20, 4, " COPIA \nSIMPLE", 'LTBR','J', false);
        $this->pdf->SetXY(45, $this->alturaTotal);
        $this->pdf->MultiCell(12.36, 6.4, "", 'LTBR','J', false);
        $this->pdf->SetXY(57.36, $this->alturaTotal);
        $this->pdf->MultiCell(20, 4, "COPIA\nFEDATEADA", 'LTBR','J', false);
        $this->pdf->SetXY(77.36, $this->alturaTotal);
        $this->pdf->MultiCell(12.36, 6.4, "", 'LTBR','J', false);
        $this->pdf->SetXY(89.72, $this->alturaTotal);
        $this->pdf->MultiCell(20, 4, "CD\nDISCO", 'LTBR','J', false);
        $this->pdf->SetXY(109.72, $this->alturaTotal);
        $this->pdf->MultiCell(12.36, 6.4, "", 'LTBR','J', false);
        $this->pdf->SetXY(122.08, $this->alturaTotal);
        $this->pdf->MultiCell(20, 4, "CORREO\nELECTRÓNICO", 'LTBR','J', false);
        $this->pdf->SetXY(142.08, $this->alturaTotal);
        $this->pdf->setFont('times', 'B', 10);
        $this->pdf->MultiCell(12.36, 6.4, "X", 'LTBR','C', false);
        $this->pdf->SetXY(154.44, $this->alturaTotal);
        $this->pdf->SetFont('helvetica', '', 7);
        $this->pdf->MultiCell(20, 4, "OTRO\nMEDIO", 'LTBR','J', false);
        $this->pdf->SetXY(174.5, $this->alturaTotal);
        $this->pdf->MultiCell(12.36, 6.4, "", 'TBR','J', false);
    }

    public function additionalData()
    {
        $this->alturaTotal +=15;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->setFont('times', '', 7);
        $this->pdf->Cell($this->totalWidth/2, 1, 'APELLIDOS Y NOMBRES', 'LTR', 0 , 'L', false);
        $this->pdf->SetXY(25+$this->totalWidth/2, $this->alturaTotal);
        $this->pdf->Cell($this->totalWidth/2, 1, 'FECHA Y HORA DE RECEPCIÓN', 'TR', 0 , 'L', false);
        

        date_default_timezone_set('America/Lima'); 
        $fechaOriginal = date('Y-m-d H:i'); 
        $fecha = new DateTime($fechaOriginal); 
        $formatter = new IntlDateFormatter(
            'es_ES', 
            IntlDateFormatter::FULL, 
            IntlDateFormatter::SHORT,
            'America/Lima', 
            IntlDateFormatter::GREGORIAN,
            'EEEE, d \'de\' MMMM \'de\' y, HH:mm' 
        );
        
        $fecha = $formatter->format($fecha); 

        $this->alturaTotal +=1;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->setFont('times', '', 7);
        $this->pdf->Cell($this->totalWidth/2, 20, '', 'LBR', 0 , 'L', false);
        $this->pdf->SetXY(25+$this->totalWidth/2, $this->alturaTotal);
        $this->pdf->SetFont('helvetica', 'B', 10);
        $this->pdf->Cell($this->totalWidth/2, 20, $fecha, 'BR', 0 , 'C', false);
        $this->pdf->SetFont('helvetica', '', 7);

        $this->alturaTotal +=42;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->setFont('times', 'BI', 8);
        $this->pdf->MultiCell($this->totalWidth, 3, 'OBSERVACIONES . ..............................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................', 0, 'J', false);
        $this->alturaTotal +=5;
        $this->pdf->SetXY(25, $this->alturaTotal);
        $this->pdf->Cell($this->totalWidth, 40, 'Email del funcionario responsable:transparecia@regionloreto.gob.pe', 0, 0 , 'L', false);

    }

    public function outputPDF($localStorage) {
        $filename = date('doc-form-Ymdhis').'.pdf';
        $path= $localStorage . $filename;
        $this->pdf->Output($path, 'F');
        return $localStorage.$filename;
    }
}