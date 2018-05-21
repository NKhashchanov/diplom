<?php
require_once '../diplom/core/application.php';

if (!empty($_POST['signIn']) && !empty($_POST['login']) && !empty($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $controllerLogin = new ControllerAdmin();
    $controllerLogin->login();
}

if (!empty($_POST)) {
    if (!empty($_POST['password']) && !empty($_POST['adminID'])) {
        $controllerAdmin = new ControllerAdmin();
        if (!empty($_POST['delete'])) {
            $controllerAdmin->delete();
        }
        if (!empty($_POST['editPass'])) {
            $controllerAdmin->edit();
        }
    }
}

if (!empty($_POST)) {
    if (!empty($_POST['password']) && !empty($_POST['login'])) {
        $controllerAdmin = new ControllerAdmin();
        if (!empty($_POST['add'])) {
            $controllerAdmin->add();
        }
    }
}


// Отобразим основную страницу
// ДОЛЖНО БЫТЬ ВСЕГДА В КОНЦЕ !!!!!!!!
$main = new Twig();
$main->main();

