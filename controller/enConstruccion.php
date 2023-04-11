<?php
require_once (_ROOT_CONTROLLER . 'viewsRender.php');

class enConstruccion extends ViewRenderer {

    public function main()
    {
        $this->render('inConstruccion', '', false);
    }
}
