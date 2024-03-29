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
        <script src="{$pathJs}access_information.js?v=1.2.1"></script>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
            async defer>
        </script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(select2);
            function select2() {
                $(".select2").select2({
                    closeOnSelect: true,
                });
            }
        </script>
        html;
        $data = [
            'dependencias' => AccessInformationModel::getOficinas()
        ];
        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];

        $render = new ViewRenderer();
        $render->setCacheDir(self::$pathCache . 'transparencia/acceso_a_la_informacion/main/');
        $render->setCacheTime(2678400);
        $render->render('header', '', false);
        $render->render('transparencia/acceso_a_la_informacion/acceso_a_la_informacion', $data, false);
        $render->render('footer', $dataFooter, false);
    }

    public function save()
    {   
        $pathFullFile[0] = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tipoDocumento = htmlspecialchars(filter_input(INPUT_POST, 'tipoDocumento', FILTER_DEFAULT));
            $numeroDocumento = htmlspecialchars(filter_input(INPUT_POST, 'dniVisita', FILTER_DEFAULT));
            $nombres = htmlspecialchars(filter_input(INPUT_POST,  'nombres', FILTER_DEFAULT));
            $primerApellido = htmlspecialchars(filter_input(INPUT_POST, 'primerApellido', FILTER_DEFAULT));
            $segundoApellido = htmlspecialchars(filter_input(INPUT_POST, 'segundoApellido', FILTER_DEFAULT));
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $telefono = htmlspecialchars(filter_input(INPUT_POST, 'telefono', FILTER_DEFAULT));
            $direccion = htmlspecialchars(filter_input(INPUT_POST, 'direccion', FILTER_DEFAULT));
            $departamento = htmlspecialchars(filter_input(INPUT_POST, 'departamento', FILTER_DEFAULT));
            $provincia = htmlspecialchars(filter_input(INPUT_POST, 'provincia', FILTER_DEFAULT));
            $distrito = htmlspecialchars(filter_input(INPUT_POST, 'distrito', FILTER_DEFAULT));
            $descripcion = htmlspecialchars(filter_input(INPUT_POST, 'descripcion', FILTER_DEFAULT));            
            $dependencia = htmlspecialchars(filter_input(INPUT_POST, 'dependencia', FILTER_DEFAULT));
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
            $accessInformationModel = new AccessInformationModel(
                $nombreCompleto,
                $tipoDocumento,
                $numeroDocumento,        
                $email,
                $telefono,
                $direccion,
                $departamento,
                $provincia,
                $distrito,
                $descripcion,
                $dependencia,
                $pathFullFile[0]
            );
            $accessInformationModel->save();
            $localStorage = _ROOT_FILES . 'access-information/' . date('Y/m/');
            $pdf =  "https://regionloreto.gob.pe/files/access-information/" . date('Y/m/') . $accessInformationModel->makepdf($localStorage);

            if($this->sendMail($descripcion,  $pathFullFile[0],$tipoDocumento, $numeroDocumento, $nombreCompleto,  $email, $pdf )) {
                echo json_encode(['status' => 'success', 'message' => 'Se ha enviado su solicitud con exito.']);
                return;
            }
            echo json_encode(['status' => 'error', 'message' => 'No se ha enviado su solicitud']);
            
        } else {
            echo json_encode(['status'=>'error', 'message'=>'Tipo de solicitud no valida.']);
            return; 
        }
    }

    private function sendMail($descripcion, $archivo, $tipoDocumento, $numeroDocumento, $nombreCompleto, $correo, $pdf )
    {
        $mail = new PHPMailer(true);

        if(!empty($archivo)){
            $mensaje = "Adjunto: https://regionloreto.gob.pe/files/". "access-information/" . date('Y/m/')."$archivo";
        }{
            $mensaje = 'Sin archivos adjuntos';
        }

        try {
            $mail->isMail();                                     
            $mail->setFrom('_mainaccount@regionloreto.gob.pe', 'SOLICITO - Acceso a la informaciíon');
            $mail->addAddress('ginopaflo001608@gmail.com', 'Mesa de partes');    
            $mail->isHTML(true);                                  
            $mail->Subject = 'Solicitud de acceso a la informacion - Portal de Transparencia';
            $mail->Body = " Solicitante: $nombreCompleto <br>
                            Tipo de Documento: $tipoDocumento<br>
                            Número de Documento: $numeroDocumento<br>
                            Correo Electrónico: $correo<br>
                            Descripción: $descripcion<br>
                            Solicitud de accesso en PDF: $pdf<br>
                            Archivos adicionales que se adjuntan: $mensaje
            ";
            $mail->AltBody = "Solicitante: $nombreCompleto\n";
            $mail->AltBody .= "Tipo de Documento: $tipoDocumento\n";
            $mail->AltBody .= "Número de Documento: $numeroDocumento\n";
            $mail->AltBody .= "Correo Electrónico: $correo\n";
            $mail->AltBody .= "Descripción: $descripcion\n";
            $mail->AltBody .= "Solicitud de accesso en PDF: $pdf\n";
            $mail->AltBody .= "Archivos adicionales que se adjuntan: $mensaje\n";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}