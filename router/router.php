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

if (!empty($_POST)) {
    if (!empty($_POST['question']) && !empty($_POST['selectThemes']) && !empty($_POST['email']) && !empty($_POST['userName'])) {
        $controllerUser = new ControllerQuestions();
        $controllerUser->addQuestion();
    }
}

if (!empty($_POST)) {
    if (!empty($_POST['newTheme']) && !empty($_POST['addTheme'])) {
        $controllerNewTheme = new ControllerQuestions();
        $controllerNewTheme->addTheme();
    }
}

if (!empty($_POST)) {
    if (!empty($_POST['questionID']) && !empty($_POST['selectTheme']) && !empty($_POST['changeTheme'])) {
        $controllerChangeTheme = new ControllerQuestions();
        $controllerChangeTheme->changeTheme();
    }
}

if (!empty($_POST)) {
    if (!empty($_POST['question']) && !empty($_POST['questionID']) && !empty($_POST['selectTheme']) && !empty($_POST['editQuestion']) && !empty($_POST['user']) && !empty($_POST['answer'])) {
        $controllerChangeTheme = new ControllerQuestions();
        $controllerChangeTheme->editQuestion();
    }
}

if (!empty($_GET)) {
    if (!empty($_GET['action']) && !empty($_GET['id'])) {
        if ($_GET['action'] == 'deleteQ') {
            $controller = new ControllerQuestions();
            $controller->deleteTheme();
        } else if ($_GET['action'] == 'deleteA') {
            $controller = new ControllerQuestions();
            $controller->deleteQuestion();
        } else if ($_GET['action'] == 'publish') {
            $controller = new ControllerQuestions();
            $controller->publishQuestion();
        } else if ($_GET['action'] == 'hide') {
            $controller = new ControllerQuestions();
            $controller->hideQuestion();
        }
    }
}

if (!empty($_POST)) {
    if (!empty($_POST['newAnswer']) && !empty($_POST['answerID']) && !empty($_SESSION['login']) && !empty($_POST['addAnswer']) && !empty($_POST['selectStatus'])) {
        $controllerNewAnswer = new ControllerQuestions();
        $controllerNewAnswer->addAnswer();
    }
}

if (!empty($_POST)) {
    if (!empty($_POST['editQ']) && !empty($_POST['editA']) && !empty($_POST['editU']) && !empty($_POST['selectTheme']) && !empty($_POST['selectStatus']) && !empty($_POST['questionID'])) {
        $controllerNewAnswer = new ControllerQuestions();
        $controllerNewAnswer->edit();
    }
}










// Отобразим основную страницу
// ДОЛЖНО БЫТЬ ВСЕГДА В КОНЦЕ !!!!!!!!
if (!empty($_SESSION['login'])) {
    $logined = Twig::mainAdmin();
} else {
    $notLogined = Twig::mainUser();
}

