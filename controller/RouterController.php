<?php

require_once _ROOT_CONTROLLER . 'AbstractController.php';

class Router extends AbstractController{

    public $secure;
    protected $routes = [];

    public function __construct()
    {
        if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ){
            $this->secure = true;
        }else{
            $this->secure = false;
        }
    }

    protected function addRoute ($method, $pattern, $handler)
    {
        $this->routes[] = [$method, $pattern, $handler];
    }

    public function loadRoutesFromJson()
    {       
        try{
            $jsonFile = file_get_contents( _ROOT_MODEL . 'routes.json');
            if(!$jsonFile){
                $this->renderView('ErrorView');
                throw new Exception('Archivo routes.json no existe en el directorio model/');
            }
        }catch(Exception $e){
            $this->errorLog($e);
            die;
        }

        $routes = json_decode($jsonFile, true);

        foreach ($routes['routes'] as $route) {
            $this->addRoute($route['method'], $route['pattern'], $route['handler']);
        }
    }

    public function handleRequest() 
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $url = $this->SanitizeVar($_SERVER['REQUEST_URI']);
        $requestUrl = parse_url($url, PHP_URL_PATH);
        $requestUrl = $requestUrl === '' || $requestUrl === null ? '/' : $requestUrl;

        foreach ($this->routes as [$method, $pattern, $handler]) {
            if ($method !== $requestMethod) {
                continue;
            }
            $matches = [];
            if (preg_match($this->compileRouteRegex($pattern), $requestUrl, $matches)) {
                array_shift($matches); 
                $matches = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                if (is_callable($handler)) {
                    call_user_func_array($handler, $matches);
                    return;
                }

                list($controllerName, $methodName, $operadorAccess) = $this->determineClass($handler);
                require_once _ROOT_CONTROLLER . $controllerName . '.php'; 
                if (strpos($controllerName, 'admin/') !== false) {
                    session_start();
                    if (isset($_SESSION['username']) && isset($_SESSION['tipoUser'])) {
                        $controllerName = str_replace('admin/', '', $controllerName);
                    } else {
                        session_destroy();
                        die;
                    }    
                }
                if ($operadorAccess === '@'){
                    $controller = new $controllerName();
                    $controller->$methodName(...$matches);
                } else {
                    $controllerName::$methodName(...$matches);
                }
                return;
            }
        }
        $this->renderView('ErrorView');
    }

    protected function compileRouteRegex($pattern) {
        $regex = '#^' . preg_replace_callback('#{(\w+)}#', function($matches) {
            return '(?P<' . $matches[1] . '>[^/]+)';
        }, $pattern) . '/?$#';
        return $regex;
    }
      
    protected function determineClass($handler)
    {
        if(strpos($handler, '@')){
            $retorno = explode('@', $handler);
            $retorno[] = '@';
            return $retorno;
        } elseif ( strpos($handler, '::')) {
            $retorno = explode('::', $handler);
            $retorno[] = '::';
            return $retorno;
        }else{
            throw 'formato de $handler en routes.json incorrecto';
        }
    }

    protected function SanitizeVar($var)
    {
        $var = filter_var( $var, FILTER_SANITIZE_URL);
        $var = htmlspecialchars($var, ENT_QUOTES);
        $var = strtolower($var);
        $var = preg_replace('/[^a-zA-Z0-9\/.=~-]/', '', $var);
        return $var;
    }
}