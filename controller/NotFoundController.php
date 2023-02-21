<?php

class NotFoundController extends FrontController{

    public function template()
    {
        $this->renderView('header');
        $this->renderView('ErrorView');
        $this->renderView('footer');
         
    }

}