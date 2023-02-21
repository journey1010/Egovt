<?php

class MainpageController extends FrontController {

    
    public function template ()
    {  
        $this->renderView('header');
        $this->renderView('main');
        $this->renderView('footer');
        
    }

    protected function scrapingLastNews(){
        $page = file_get_contents('https://www.gob.pe/regionloreto/');
        curl_init($page);


    }
    
}
  