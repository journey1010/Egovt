<?php 

class ConsultaDni 
{
    protected static $tokens = [];
    protected static $apiUrl = '';

    public static function searchDni($dni)
    {
        if(strlen($dni) != 8 || !is_numeric($dni)){
            echo (json_encode(['status'=>'error', 'message'=>'El número ingresado no es valido.']));
            return;
        }
        self::$apiUrl = 'https://dniruc.apisperu.com/api/v1/dni/'.$dni;
        self::$tokens = json_decode(file_get_contents(_ROOT_MODEL .'VisitasToken.json'), true); 
        $response = self::curlOpertions(self::$tokens, self::$apiUrl);  
        if(!$response){
            echo (json_encode(['status'=>'error', 'message'=>'Servicio no disponible en este momento.']));  
            return;
        }
        echo $response;
    }   

    protected static function curlOpertions($arrayTokens, $datum)
    {
        
        $firstValue = 0;
        $keyValueChange  = 0;
        $valueChange = 0;

        foreach($arrayTokens as $indice => $token){
            $ch = curl_init($datum);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '. $token]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $httpCodeStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if($httpCodeStatus == '200'){
                if($indice === 0){
                    return $response;
                }
                $firstValue = $arrayTokens[0];
                $keyValueChange = $indice - 1;
                $valueChange = $token;
                array_shift($arrayTokens);
                $arrayTokens[4] = $firstValue;
                $arrayTokens[$keyValueChange] = $arrayTokens[0];
                $arrayTokens[0] = $valueChange;
                self::makeJsonTokens($arrayTokens);
                return $response;
            }
        }
        return false;
    }
    
    private static function makeJsonTokens($array)
    {   
        $pathFile = _ROOT_MODEL .'VisitasToken.json';
        file_put_contents($pathFile, json_encode($array));
        chmod($pathFile, 0644);
    }
}