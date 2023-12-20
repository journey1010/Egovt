<?php

require_once _ROOT_CONTROLLER . 'BaseViewInterfaz.php';

class FeedbackController extends BaseViewInterfaz
{
    public static function mainView()
    {
        $data = [];

        $pathJs = self::$pathJs;
        $moreScript = <<<html
        <script src="{$pathJs}feedback.js"></script>
        html;

        $dataFooter = [
            'año' => date('Y'),
            'scripts' => $moreScript
        ];
        $render = new ViewRenderer();
        $render->setCacheDir(self::$pathCache . 'feedback/');
        $render->setCacheTime(2678400);
        $render->render('header', '', false);
        $render->render('feedback', $data, true);
        $render->render('footer', $dataFooter, false);
    }
}