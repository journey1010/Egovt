<?php

class ViewRenderer {

    /**
     * @param $cache_dir, guarda la ubicación de la vista cacheada.
     * @param $cache_time, guarda el tiempo(segundos) de duración de la vista
    */
    private $cache_dir;
    private $cache_time = 3600;
  
    public function render( string $viewName, $data = [], $cache = false) {
        $viewName = ($viewName == 'ErrorCritico') ? 'ErrorCritico' : $viewName;
        $fullpath = _ROOT_VIEWS . $viewName . '.php';

        try {
            $cache_file = $this->cache_dir . '/' . md5($viewName) . '.php';
            if ($cache && file_exists($cache_file) && (time() - filemtime($cache_file) < $this->cache_time)) {
              if (!empty($data)){
                extract($data);
              } 
              include $cache_file;
              return;
            }

            if(!file_exists($fullpath)){
                throw new Exception ('Vista no encontrada ' . $viewName);
            }
            if(pathinfo($fullpath, PATHINFO_EXTENSION)!== 'php'){
                throw new Exception ('Archivo de tipo no permitido' . $viewName);
            }

            ob_start();
            if(!empty($data)){
                extract($data);
            }
            include_once $fullpath;
            $content = ob_get_clean();

            if($cache){
                if (!is_dir($this->cache_dir)){
                    mkdir($this->cache_dir, 0755, true);
                }
                file_put_contents ($cache_file, $content);
            }
            echo $content;
        } catch (Throwable $e) {
            $this->errorLog($e);
        }
    }
    
    public function setCacheDir(string $cache_dir) {
      $this->cache_dir = $cache_dir;
    }
  
    /**
     * set time for cache view 
     *
     * @param integer $cache_time The time is in seconds.
     * @return void
     */
    public function setCacheTime(int $cache_time) {
      $this->cache_time = $cache_time;
    }
  
    public function escape($value) {
      return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    private function errorLog(Exception $e){
        $errorMessage = date("Y-m-d H:i:s") . " : " . $e->getMessage() .  "\n";
        error_log($errorMessage, 3, _ROOT_PATH . '/log/error.log'  );
    }
}  