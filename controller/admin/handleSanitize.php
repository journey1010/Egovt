<?php 

class handleSanitize {

    protected function handlerError (Throwable $e, $infoAdd = null): void
    {
        $errorMessage = date("Y-m-d H:i:s") . " : " . $e->getMessage() .  ', info:' . $infoAdd . "\n";
        error_log($errorMessage, 3, _ROOT_PATH . '/log/error.log' );
        return;
    }

    protected function SanitizeVarInput (string $var ): string
    {
        $varSanitize = filter_var($var, FILTER_SANITIZE_SPECIAL_CHARS);
        $varSanitize = htmlspecialchars($var, ENT_QUOTES, "UTF-8");
        return $varSanitize;
    }

    protected function strtoupperString(string $string): string
    {   
        $text = $this->SanitizeVarInput($string);
        $text = mb_strtoupper(mb_convert_case($text, MB_CASE_UPPER, 'UTF-8'), 'UTF-8');
        return $text;
    }
    
    public static function validateDate($date)
    {
        $date = $date == null ? 'im not date' : $date;
        $format  = 'Y-m-d';
        $dateFormat = DateTime::createFromFormat($format, $date);
        if($dateFormat !== false){
            return true;
        }
        return false;
    }  
}