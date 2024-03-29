<?php

class Helper
{
    public static function handlerError (Throwable $e, $infoAdd = null): void
    {
        $errorMessage = date("Y-m-d H:i:s") . " : " . $e->getMessage() .  ', info:' . $infoAdd . "\n";
        error_log($errorMessage, 3, _ROOT_PATH . '/log/error.log' );
        return;
    }

    public static function SanitizeVarInput (string $var ): string
    {
        $varSanitize = filter_var($var, FILTER_SANITIZE_SPECIAL_CHARS);
        $varSanitize = htmlspecialchars($var, ENT_QUOTES, "UTF-8");
        return $varSanitize;
    }

    public static function strtoupperString(string $string): string
    {   
        $text = self::SanitizeVarInput($string);
        $text = mb_strtoupper(mb_convert_case($text, MB_CASE_UPPER, 'UTF-8'), 'UTF-8');
        return $text;
    }
}