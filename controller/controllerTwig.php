<?php
require_once '../diplom/core/application.php';

// Подключаем Twig
require_once './vendor/autoload.php';
Twig_Autoloader::register();

Class Twig
{
    function mainAdmin()
    {
        $core = ['session' => $_SESSION, 'post' => $_POST, 'get' => $_GET];
        $temp = Di::twigFunc();
        echo $temp->render('mainAdmin.twig', [
            'the' => 'variables',
            'go' => 'here',
            'getQuestions' => new ModelQuestions(),
            'getAdmins' => ModelAdmin::admins(),
            'allQuestions' => new ControllerQuestions(),
            'core' => $core
        ]);
    }

    static function mainUser()
    {
        $errorLogin = new ControllerAdmin();
        $errorLogin = $errorLogin->login();
        $temp = Di::twigFunc();
        echo $temp->render('mainUser.twig', [
            'the' => 'variables',
            'go' => 'here',
            'getQuestions' => new ModelQuestions(),
            'errorLogin' => $errorLogin
        ]);
    }

    function adminsPage()
    {
        $page = 'admins';
        $temp = Di::twigFunc();
        $temp->render('mainUser.twig', [
            'page' => $page
        ]);
    }

    function questionsPage()
    {
        $page = 'questions';
        $temp = Di::twigFunc();
        $temp->render('mainUser.twig', [
            'page' => $page
        ]);
    }

    function answerPage()
    {
        $page = 'answer';
        $temp = Di::twigFunc();
        $temp->render('mainUser.twig', [
            'page' => $page
        ]);
    }
}










