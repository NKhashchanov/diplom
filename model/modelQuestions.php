<?php
require_once '../diplom/core/application.php';


class ModelQuestions
{
// Получаем массив с темами
    static function themes()
    {
        $pdo = Di::pdo();
        $stmt = $pdo->query('SELECT * FROM themes');
        $data = $stmt->fetchAll();
        return $data;
    }

// Функция добавления вопросов
    function addQuestions($params)
    {
        $pdo = Di::pdo();
        $question = $params['question'];
        $userName = $params['userName'];
        $email = $params['email'];
        $selectThemes = $params['selectThemes'];
        $status = 'Ожидает ответа';
        $dateQuestion = date(c);
        $stmt = $pdo->prepare('INSERT INTO questions (question, theme_id, user, email, date_question, status) VALUES(?, ?, ?, ?, ?, ?)');
        $stmt->bindParam(1, $question);
        $stmt->bindParam(2, $selectThemes);
        $stmt->bindParam(3, $userName);
        $stmt->bindParam(4, $email);
        $stmt->bindParam(5, $dateQuestion);
        $stmt->bindParam(6, $status);
        return $stmt->execute();
    }

// Получаем массив с вопросами
    static function questions()
    {
        $pdo = Di::pdo();
        $stmt = $pdo->query('SELECT * FROM questions ORDER BY date_question');
        $data = $stmt->fetchAll();
        return $data;
    }

// Получим массив с вопросами по темам
    static function questionTheme()
    {
        $pdo = Di::pdo();
        $stmt = $pdo->query('SELECT * FROM themes LEFT JOIN questions ON themes.id = questions.theme_id');
        $data = $stmt->fetchAll();
        return $data;
    }

// Функция добавления тем
    function addTheme($params)
    {
        $pdo = Di::pdo();
        $newTheme = $params['newTheme'];
        $stmt = $pdo->prepare('INSERT INTO themes (theme) VALUES(?)');
        $stmt->bindParam(1, $newTheme);
        return $stmt->execute();
    }

// Функция удаления темы со всеми вопросами
    function deleteTheme($params)
    {
        $pdo = Di::pdo();
        $id = $params['id'];
        $stmt = $pdo->prepare('DELETE themes, questions FROM themes LEFT JOIN questions ON themes.id = questions.theme_id WHERE themes.id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

// Функция удаления вопроса
    function deleteQuestion($params)
    {
        $pdo = Di::pdo();
        $id = $params['id'];
        $stmt = $pdo->prepare('DELETE FROM questions WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

// Функция добавления ответа
    function addAnswer($params)
    {
        $pdo = Di::pdo();
        $answer = $params['newAnswer'];
        $id = $params['answerID'];
        $adminName = $params['adminName'];
        $status = $params['status'];
        $dateAnswer = date(c);
        $stmt = $pdo->prepare('UPDATE questions SET answer = :answer, admin = :adminName, status = :status, date_answer = :dateAnswer WHERE id = :id');
        $stmt->bindParam(':answer', $answer);
        $stmt->bindParam(':adminName', $adminName);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':dateAnswer', $dateAnswer);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

// Функция редактирования вопроса
    function editQuestion($params)
    {
        $pdo = Di::pdo();
        $question = $params['question'];
        $id = $params['questionID'];
        $theme = $params['theme'];
        $stmt = $pdo->prepare('UPDATE questions SET question = :question, theme_id = :theme WHERE id = :id');
        $stmt->bindParam(':question', $question);
        $stmt->bindParam(':theme', $theme);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

// Функция публикации вопроса
    function publishQuestion($params)
    {
        $pdo = Di::pdo();
        $id = $params['id'];
        $status = 'Опубликован';
        $stmt = $pdo->prepare('UPDATE questions SET status = :status WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

// Функция скрытия вопроса
    function hideQuestion($params)
    {
        $pdo = Di::pdo();
        $id = $params['id'];
        $status = 'Скрыт';
        $stmt = $pdo->prepare('UPDATE questions SET status = :status WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

// Получим список статуса
    static function status()
    {
        $pdo = Di::pdo();
        $stmt = $pdo->query('SHOW COLUMNS FROM questions');
        $data = $stmt->fetchAll();
        foreach ($data as $v) {
            if ($v['Field'] == 'status'){
                $result = $v['Type'];
            }
        }
        return explode(",",str_replace(array("'",")"),"",substr($result,5)));
    }

// Функция смены темы
    function changeTheme($params)
    {
        $pdo = Di::pdo();
        $questionID = $params['questionID'];
        $themeID = $params['themeID'];
        $stmt = $pdo->prepare('UPDATE questions SET theme_id = :themeID WHERE id = :id');
        $stmt->bindParam(':id', $questionID);
        $stmt->bindParam(':themeID', $themeID);
        return $stmt->execute();
    }
    /*
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

*/
}

?>