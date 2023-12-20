<?php

require_once _ROOT_CONTROLLER . 'BaseViewInterfaz.php';

class FeedbackController extends BaseViewInterfaz
{
    public static function mainView()
    {
        $data = [];

        $pathJs = self::$pathJs;
        $moreScript = <<<html
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{$pathJs}feedback.js?v=1.2"></script>
        html;

        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];
        $render = new ViewRenderer();
        $render->setCacheDir(self::$pathCache . 'feedback/');
        $render->setCacheTime(2678400);
        $render->render('header', '', false);
        $render->render('feedback', $data, false);
        $render->render('footer', $dataFooter, false);
    }
}