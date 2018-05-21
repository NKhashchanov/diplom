<?php
require_once '../diplom/core/application.php';


Class ControllerAdmin
{
// Редирект
    static function redirect($page)
    {
        header("Location: $page.php");
        die;
    }

// Логаут
    function logout()
    {
        session_destroy();
        header('Location: index.php');
    }

// Логин пользователя
    function login()
    {
        $user = new ModelAdmin();
        if (!empty($_POST['signIn'])) {
            if (count(array_filter(ModelAdmin::admins(), function ($value) {
                    return $value["login"] == $_POST['login'];
                })) == 0) {
                return 'Пользователь не найден';
            } elseif (count(array_filter(ModelAdmin::admins(), function ($value) {
                    return $value["password"] == $_POST['password'];
                })) == 0) {
                return 'Пароль не верный';
            } else {
                $data = [];
                if (!empty($_POST['login'])) {
                    $data['login'] = $_POST['login'];
                }
                if (!empty($_POST['password'])) {
                    $data['password'] = $_POST['password'];
                }
                $result = $user->login($data);
                if ($result) {
                    header('Location: ../diplom/');
                }
            }
        }
    }

// Изменить пароль администратора
    function edit()
    {
        $edit = new ModelAdmin();
        $data = [];
        $data['id'] = (int)$_POST['adminID'];
        $data['password'] = $_POST['password'];
        $result = $edit->edit($data);
        if ($result) {
            header('Location: ../diplom/index.php?menu=admins');
        }
    }

// Удалить администратора
    function delete()
    {
        $delete = new ModelAdmin();
        $data = [];
        $data['id'] = (int)$_POST['adminID'];
        $result = $delete->delete($data);
        if ($result) {
            header('Location: ../diplom/index.php?menu=admins');
        }
    }

// Добавить администратора
    function add()
    {
        $add = new ModelAdmin();
        $data = [];
        $data['login'] = $_POST['login'];
        $data['password'] = $_POST['password'];
        $result = $add->add($data);
        if ($result) {
            header('Location: ../diplom/index.php?menu=admins');
        }
    }


}

