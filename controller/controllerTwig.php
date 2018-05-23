<?php
require_once '../diplom/core/application.php';


// Подключаем Twig
require_once './vendor/autoload.php';
Twig_Autoloader::register();


// Сделаем $twig глобальным
function twig() {
    $loader = new Twig_Loader_Filesystem('../diplom/template');
    $twig = new Twig_Environment($loader, array(
        'cache' => '../diplom/cache',
        'auto_reload' => true,
    ));

    // Объявим глобальные переменные
    if (!empty($_SESSION)) {
        $twig->addGlobal('session', $_SESSION);
    }

    if (!empty($_POST)) {
        $twig->addGlobal('post', $_POST);
    }

    if (!empty($_GET)) {
        $twig->addGlobal('get', $_GET);
    }

    if (!empty($_POST)) {
        $errorLogin = new ControllerAdmin();
        $errLog = $errorLogin->login();
        $twig->addGlobal('errorLogin', $errLog);
    }
    $getQuestions = new ModelQuestions();
    $allQuestions = new ControllerQuestions();
    $twig->addGlobal('allQuestions', $allQuestions);
    $twig->addGlobal('getAdmins', ModelAdmin::admins());
    $twig->addGlobal('getQuestions', $getQuestions);


    return $twig;
}

// Отобразим главный шаблон
Class Twig
{
    function main()
    {
        $templateMain = twig()->loadTemplate('main.twig');
        echo $templateMain->render(array('the' => 'variables', 'go' => 'here'));
    }
}













