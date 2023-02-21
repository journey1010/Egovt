<?php
class AdminController
{
    private $viewPath;

    public function __construct($viewPath)
    {
        $this->viewPath = $viewPath;
    }

    public static function template()
    {
        self::render('header');
        self::render('main');
        self::render('footer');
    }

    public function render($viewName)
    {
        if(!file_exists($this->viewPath. $viewName. '.php')){
            throw new Exception('view not found');
        }
        ob_start();
        include_once $this->viewPath. $viewName . '.php'; 
        return ob_get_clean();
    }

    public function renderCas ($viewName)
    {
        if(!file_exists($this->viewPath . $viewName . '.php')){
            throw new Exception('View not found');
        }
        if(pathinfo($this->viewPath . $viewName . '.php' , PATHINFO_EXTENSION) !== 'php'){
            throw new Exception('Invalid type extension');
        }
    }
}  

