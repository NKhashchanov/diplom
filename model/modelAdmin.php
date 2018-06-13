<?php
require_once '../diplom/core/application.php';


class ModelAdmin
{
// Логин пользователя
    function login($params)
    {
        $pdo = Di::pdo();
        $login = $params['login'];
        $password = $params['password'];
        $stmt = $pdo->prepare('SELECT id, login, password FROM admins WHERE login = :login AND password = :password');
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $data= $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['login'] = $data['login'];
        $_SESSION['id'] = $data['id'];
    }

// Изменить пароль администратора
    function edit($params)
    {
        $pdo = Di::pdo();
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
        $pdo = Di::pdo();
        $id = $params['id'];
        $stmt = $pdo->prepare('DELETE FROM admins WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

// Добавить администратора
    function add($params)
    {
        $pdo = Di::pdo();
        $login = $params['login'];
        $password = $params['password'];
        $stmt = $pdo->prepare('INSERT INTO admins (login, password) VALUES(:login, :password)');
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    }

// Получаем массив с пользователями
    static function admins()
    {
        $pdo = Di::pdo();
        $stmt = $pdo->query('SELECT login, password FROM admins');
        $data = $stmt->fetchAll();
        return $data;
    }
}

?>