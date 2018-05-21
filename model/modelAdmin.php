<?php
require_once '../diplom/core/application.php';


class ModelAdmin
{
// Логин пользователя
    function login($params)
    {
        global $pdo;
        $login = $params['login'];
        $password = $params['password'];
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE login = :login AND password = :password');
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        foreach ($stmt->fetchAll() as $data) {
             $_SESSION['login'] = $data['login'];
             $_SESSION['id'] = $data['id'];
        }
    }

// Изменить пароль администратора
    function edit($params)
    {
        global $pdo;
        $id = $params['id'];
        $edit = $params['password'];
        $stmt = $pdo->prepare('UPDATE admins SET password = :password WHERE id = :id');
        $stmt->bindParam(':password', $edit);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

// Удалить администратора
    function delete($params)
    {
        global $pdo;
        $id = $params['id'];
        $stmt = $pdo->prepare('DELETE FROM admins WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

// Добавить администратора
    function add($params)
    {
        global $pdo;
        $login = $params['login'];
        $password = $params['password'];
        $id = null;
        $stmt = $pdo->prepare('INSERT INTO admins (id, login, password) VALUES(?, ?, ?)');
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $login);
        $stmt->bindParam(3, $password);
        return $stmt->execute();
    }

// Получаем массив с пользователями
    static function admins()
    {
        global $pdo;
        $stmt = $pdo->query('SELECT * FROM admins');
        $data = $stmt->fetchAll();
        return $data;
    }
}

?>