<?php

define ('_ROOT_PATH', str_replace('\\', '/', dirname(__FILE__)) , false);
define ('_ROOT_CONTROLLER', _ROOT_PATH.'/controller/', false);
define ('_ROOT_MODEL', _ROOT_PATH.'/model/', false);
define ('_ROOT_VIEWS', _ROOT_PATH.'/views/', false);
define('PROTOCOL', (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === 'on' ? 'https' : 'http'), false);
define('_BASE_URL', PROTOCOL . '://' . $_SERVER['HTTP_HOST'], false);
define('_ROOT_ASSETS', _BASE_URL.'/assets/', false);
define('_ROOT_CACHE', _ROOT_PATH. '/resources/cache/', false);


require_once _ROOT_CONTROLLER . 'FrontController.php';



class Router
{   
    private $secure;
    private $routes = [
        '/'=> 'MainpageController',
        'contacto' => 'ContactoCrontroller', 
        'directorio' => 'DirectorioController',
        'Noticias/{id}' => 'NoticiaSingle',
    ];

    public function __construct() {

        if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ){
            $this->secure = true;
        }else{
            $this->secure = false;
        }
    }

    public function route()
    {

        try{

            if($this->secure){

                $url_sanitize = $this->SanitizeURL($_SERVER['REQUEST_URI']);
                list($controller_file, $controller_name ) = $this->SearchUrlinRoutes($url_sanitize);
                if(!file_exists($controller_file) ){
                    throw new Exception ('FIle not found');
                    $controller_file = _ROOT_CONTROLLER . 'NotFoundController.php';
                }
    
            }else{
                header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                exit;
            }

        } catch (Exception $e){
            $this->logError( $e );
        }

        try{
            require_once $controller_file;
            $controller = new $controller_name();
            $controller->template();
        }catch(Exception $e){
            $controller = new $controller_name();
            $controller->template();
            $this->logError( $e );
        }


        
    }

    private function SanitizeURL ($url) {
        $url = trim($url);
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = preg_replace('/[^a-zA-Z0-9\.\-\:\/\=]+/', '', $url);
        return $url;
    }

    private function SearchUrlinRoutes ($url){

        foreach($this->routes as $pattern => $handler){

            $regex = '#^' . str_replace('{id}', '([a-zA-Z0-9\-]+)', $pattern) . '/?$#';
            
            try{   
                if(preg_match($regex, $url, $matches)){
                
                    $filename_controller = _ROOT_CONTROLLER . $handler . '.php';
                    return array($filename_controller, $handler);
                    break;
    
                }else{
                    throw new Exception ('Url not found' . $url);
                } 
            }catch(Exception $e){
                $this->logError($e);
            }

            $filename_controller = _ROOT_CONTROLLER . 'NotFoundController.php';
            return array( $filename_controller, 'NotFoundController');
        }
    }

    public function logError(Exception $e){
        $errorMessage = date('Y-m-d H:i:s') . ': ' . $e->getMessage() . "\n";
        error_log($errorMessage, 3, _ROOT_PATH . '/log/error.log');
    }

}

try{
    $router = new Router();
    $router->route();
}catch (Exception $e){
    $router->logError($e);
}