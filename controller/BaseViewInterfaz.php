<?php

require_once _ROOT_CONTROLLER .  'viewsRender.php';
require_once _ROOT_CONTROLLER . 'Helper.php'; 

class BaseViewInterfaz 
{
    public static $pathJs =  _ROOT_ASSETS . 'js/';
    public static $pathImg = _ROOT_ASSETS . 'images/';
    public static $pathCss = _ROOT_ASSETS . 'css/';
    public static $pathCache = _ROOT_CACHE;
 
    /**
     * @return boolean true if $pagina  is numeric  or false if it's not numeric.
     */
    protected static function isNumeric($pagina)
    {
        if (!is_numeric($pagina)) {
            return false;
        }
        return true; 
    }

    public static function viewForNotNumericPage()
    {
        $render = new ViewRenderer();
        $render->setCacheDir(_ROOT_CACHE . 'Error/');
        $render->setCacheTime(1);
        $render->render('ErrorView', '', true);
    }

    /**
     * @param string $date
     * @return bool it is true if date's format of $date is equal that $dateExample
     */
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