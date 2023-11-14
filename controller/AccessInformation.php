<?php 

require_once _ROOT_CONTROLLER . 'BaseViewInterfaz.php';
require_once _ROOT_CONTROLLER . 'GestorArchivos.php';
require_once _ROOT_MODEL . 'AccessInformationModel.php';

require _ROOT_PATH . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AccessInformation extends BaseViewInterfaz
{
    private $gestorArchivos;

    public function __construct()
    {
        $this->gestorArchivos = new GestorArchivos('access-information/' . date('Y/m/'));
    }

    public function showView()
    {
        $pathJs = self::$pathJs;
        $moreScript = <<<html
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{$pathJs}access_information.js?v=1.1.3"></script>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
            async defer>
        </script>
        html;
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(self::$pathCache . 'transparencia/acceso_a_la_informacion/main/');
        $render->setCacheTime(2678400);
        $render->render('header', '', false);
        $render->render('transparencia/acceso_a_la_informacion/acceso_a_la_informacion', '', false);
        $render->render('footer', $dataFooter, false);
    }

    public function save()
    {   
        $pathFullFile[0] = null;
        if(!$this->reCaptcha()){
            echo json_encode(['status'=>'error', 'message'=> 'Solicitud no enviada.']);
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $personaEdad = filter_input(INPUT_POST, 'personaEdad', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $tipoDocumento = filter_input(INPUT_POST, 'tipoDocumento', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $numeroDocumento = filter_input(INPUT_POST, 'dniVisita', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $nombres = filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $primerApellido = filter_input(INPUT_POST, 'primerApellido', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $segundoApellido = filter_input(INPUT_POST, 'segundoApellido', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $departamento = filter_input(INPUT_POST, 'departamento', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $provincia = filter_input(INPUT_POST, 'provincia', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $distrito = filter_input(INPUT_POST, 'distrito', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['status'=>'error', 'message'=>'Correo electrónico no es valido']);
                return;
            }

            $nombreCompleto = $nombres . ' ' . $primerApellido . ' ' .$segundoApellido;
        
            if (isset($_FILES['archivos'])) {
                $archivos = $_FILES['archivos'];
                $extensionPermitidas = ['docx', 'pdf', 'doc'];
                if (!$this->gestorArchivos->validarArchivos($archivos, $extensionPermitidas)) {
                    echo (json_encode(['status'=>'error', 'message'=>'Extensión de archivo no permitido.']));
                    return;
                }

                if(!$pathFullFile = $this->gestorArchivos->guardarArchivos($archivos, 'archivos')){
                    echo (json_encode(['status'=>'error', 'message'=>'No se pudo guardar registro.']));
                    return;
                }
            } 

            AccessInformationModel::save(
                $nombreCompleto,
                $tipoDocumento,
                $numeroDocumento,
                $personaEdad,         
                $email,
                $telefono,
                $direccion,
                $departamento,
                $provincia,
                $distrito,
                $descripcion,
                $pathFullFile[0]
            );

            $this->sendMail($descripcion,  $pathFullFile[0],$tipoDocumento, $numeroDocumento, $nombreCompleto,  $email);
            echo json_encode(['status' => 'success', 'message' => 'Se ha enviado su solicitud con exito.']);
            return;
            
        } else {
            echo json_encode(['status'=>'error', 'message'=>'Tipo de solicitud no valida.']);
            return; 
        }
    }

    private function sendMail($descripcion, $archivo, $tipoDocumento, $numeroDocumento, $nombreCompleto, $correo )
    {
        $mensaje = "Adjunto: https://regionloreto.gob.pe/files/". "access-information/" . date('Y/m/')."$descripcion";
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 2;                                       
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.gmail.com';                       
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'regionloreto.gob.pe@gmail.com';                    
            $mail->Password   = 'kgluckjsonrpghkt';               
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
            $mail->Port       = 587;                                    

            $mail->setFrom('regionloreto.gob.pe@gmail.com', 'Acceso a la informaciíon');
            $mail->addAddress('journii167@gmail.com', 'Mesa de partes');    
            $mail->isHTML(true);                                  
            $mail->Subject = 'Solicitud de acceso a la informacion - Portal de Transparencia';
            $mail->Body = " Solicitante: $nombreCompleto <br>
                            Tipo de Documento: $tipoDocumento<br>
                            Número de Documento: $numeroDocumento<br>
                            Correo Electrónico: $correo<br>
                            Descripción: $descripcion<br>
                            Archivo adjunto: $mensaje
            ";
            $mail->AltBody = "Solicitante: $nombreCompleto\n";
            $mail->AltBody .= "Tipo de Documento: $tipoDocumento\n";
            $mail->AltBody .= "Número de Documento: $numeroDocumento\n";
            $mail->AltBody .= "Correo Electrónico: $correo\n";
            $mail->AltBody .= "Descripción: $descripcion\n";
            $mail->AltBody .= "Archivo adjunto: $mensaje\n";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function reCaptcha()
    {
        $secretKey = "6LeMRQ4pAAAAACZCB9qLkJO-IaDPVdPnrEmxIhNG";
        $responseKey = $_POST['g-recaptcha-response'];
        $userIP = $_SERVER['REM
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
        $response = file_get_contents($url);
        $response = json_decode($response);
        if ($response->success) {
            return true;
        } else {
            return false;
        }
    }
}