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
        $dateQuestion = date('c');
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
        $dateAnswer = date('c');
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

// Функция глобального редактирования вопроса и ответа
    function edit($params)
    {
        $pdo = Di::pdo();
        $editQ = $params['editQ'];
        $editA = $params['editA'];
        $editU = $params['editU'];
        $selectTheme = $params['selectTheme'];
        $selectStatus = $params['selectStatus'];
        $id = $params['questionID'];
        $stmt = $pdo->prepare('UPDATE questions SET question = :editQ, answer = :editA, user = :editU, status = :status, theme_id = :selectTheme WHERE id = :id');
        $stmt->bindParam(':editQ', $editQ);
        $stmt->bindParam(':editA', $editA);
        $stmt->bindParam(':editU', $editU);
        $stmt->bindParam(':status', $selectStatus);
        $stmt->bindParam(':selectTheme', $selectTheme);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

}

?>