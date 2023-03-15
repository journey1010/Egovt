<?php

class Usuarios {
    
    private function verDni( int $dni)
    {
        $dni = (isset($_POST['numeroDNI']) == '' ) ? '' : $_POST['numeroDNI'];
        $dni = $this->SanitizeVarInput($dni);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://apiperu.dev/api/dni/" . $dni . "?api_token=8bb1d335dc684d6c54e94e6ba34654b9b926a7b436cf92046a514b7ee1898992",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
    }

    private function SanitizeVarInput(string $var)
    {
        $varSanitize = filter_var($var, FILTER_SANITIZE_SPECIAL_CHARS);
        $varSanitize = htmlentities($var, ENT_QUOTES);
        return $varSanitize;
    }
}

