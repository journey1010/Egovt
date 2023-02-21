<?php

class cacheController{
    private $cacheExpiration; 
    private $cachePath;

    public function __construct( int $cacheExpiration, string $cachePath = _ROOT_CACHE ){
        $this->cacheExpiration = $cacheExpiration;
        $this->cachePath = $cachePath;
    }

    public function getCache($viewName){
        
        $viewName = $this->sanitizeVar($viewName);
        $cacheFile = $this->cachePath . $viewName. '.html';

        if(file_exists( $cacheFile) && ( time() - filemtime($cacheFile)) < $this->cacheExpiration ){
            return file_get_contents($cacheFile);
        }

        return false;

    }

    public function saveCacheView( $viewName, $viewContent){
        $viewName = $this->sanitizeVar($viewName);
        $cacheFile = $this->cachePath . $viewName . '.html';

        file_put_contents( $cacheFile, $viewContent );

    }

    private function sanitizeVar($value){

        $value = trim($value);
        $value = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $value = preg_replace('/[^a-zA-Z0-9\-\_]/', '', $value);
        return $value;

    }

}
