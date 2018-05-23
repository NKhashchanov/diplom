<?php
require_once '../diplom/core/application.php';


Class ControllerQuestions
{
// Функция добавления вопросов
    function addQuestion()
    {
        $addQuestion = new ModelQuestions();
        $data = [];
        $data['question'] = $_POST['question'];
        $data['userName'] = $_POST['userName'];
        $data['email'] = $_POST['email'];
        $data['selectThemes'] = $_POST['selectThemes'];
        $result = $addQuestion->addQuestions($data);
        if ($result) {
            header('Location: ../diplom/');
        }
    }

// Функция добавления тем
    function addTheme()
    {
        $addTheme = new ModelQuestions();
        $data = [];
        $data['newTheme'] = $_POST['newTheme'];
        $result = $addTheme->addTheme($data);
        if ($result) {
            header('Location: ../diplom/index.php?menu=themes');
        }
    }

// Функция добавления ответа
    function addAnswer()
    {
        $addAnswer = new ModelQuestions();
        $data = [];
        $data['newAnswer'] = $_POST['newAnswer'];
        $data['answerID'] = $_POST['answerID'];
        $data['adminName'] = $_SESSION['login'];
        $data['status'] = $_POST['selectStatus'];
        $result = $addAnswer->addAnswer($data);
        if ($result) {
            header('Location: ../diplom/index.php?menu=themes');
        }
    }

// Функция редактирования вопроса
    function editQuestion()
    {
        $editQuestion = new ModelQuestions();
        $data = [];
        $data['question'] = $_POST['question'];
        $data['questionID'] = $_POST['questionID'];
        $data['theme'] = $_POST['selectTheme'];
        $result = $editQuestion->editQuestion($data);
        if ($result) {
            header('Location: ../diplom/index.php?menu=answer');
        }
    }

// Функция удаления темы
    function deleteTheme()
    {
        $deleteTheme = new ModelQuestions();
        $data = [];
        $data['id'] = (int)$_GET['id'];
        $result = $deleteTheme->deleteTheme($data);
        if ($result) {
            header('Location: ../diplom/index.php?menu=themes');
        }
    }

// Функция удаления вопроса
    function deleteQuestion()
    {
        $deleteAnswer = new ModelQuestions();
        $data = [];
        $data['id'] = (int)$_GET['id'];
        $result = $deleteAnswer->deleteQuestion($data);
        if ($result) {
            if ($_GET['menu'] == 'themes') {
                header('Location: ../diplom/index.php?menu=themes');
            } elseif ($_GET['menu'] == 'answer') {
                header('Location: ../diplom/index.php?menu=answer');
            }
        }
    }

// Функция публикации вопроса
    function publishQuestion()
    {
        $publishTheme = new ModelQuestions();
        $data = [];
        $data['id'] = (int)$_GET['id'];
        $result = $publishTheme->publishQuestion($data);
        if ($result) {
            header('Location: ../diplom/index.php?menu=themes');
        }
    }

// Функция скрытия вопроса
    function hideQuestion()
    {
        $hideTheme = new ModelQuestions();
        $data = [];
        $data['id'] = (int)$_GET['id'];
        $result = $hideTheme->hideQuestion($data);
        if ($result) {
            header('Location: ../diplom/index.php?menu=themes');
        }
    }

// Функция смены темы
    function changeTheme()
    {
        $changeTheme = new ModelQuestions();
        $data = [];
        $data['questionID'] = $_POST['questionID'];
        $data['themeID'] = $_POST['selectTheme'];
        $result = $changeTheme->changeTheme($data);
        if ($result) {
            header('Location: ../diplom/index.php?menu=themes');
        }
    }

// Получим количество вопросов в теме
    static function allQuestionsInTheme()
    {
        $all = ModelQuestions::questions();
        $result = array_count_values(array_column($all, 'theme_id'));
        $data = [];
        end($result);
        for ($i = 1; $i <= key($result); $i++) {
            if (!empty($result[$i])) {
                $data[] = [
                    'id' => $i,
                    'count' => $result[$i]
                ];
            }
        }
        return $data;
    }

// Получим количество вопросов опубликованных в теме
    static function publishedQuestionsInTheme()
    {
        $pub = ModelQuestions::questions();
        $dataTemp = [];
        foreach ($pub as $value) {
            if ($value['status'] == 'Опубликован') {
                $dataTemp[] = [
                    'theme_id' => $value['theme_id'],
                    'q_id' => $value['id']
                ];
            }
        }
        $result = array_count_values(array_column($dataTemp, 'theme_id'));
        $pubT = ModelQuestions::themes();
        $data = [];
        end($result);
        for ($i = 0; $i <= key($result); $i++) {
            if (!empty($result[$i])) {
                foreach ($pubT as $v) {
                    if ($v['id'] == $i) {
                        $data[] = [
                            'id' => $v['id'],
                            'count' => $result[$i]
                        ];
                    }
                }
            }
        }
        return $data;
    }

// Получим количество вопросов без ответов в теме
    static function notQuestionsInTheme()
    {
        $not = ModelQuestions::questions();
        $dataTemp = [];
        foreach ($not as $value) {
            if (empty($value['answer'])) {
                $dataTemp[] = [
                    'theme_id' => $value['theme_id'],
                    'q_id' => $value['id']
                ];
            }
        }
        $result = array_count_values(array_column($dataTemp, 'theme_id'));
        $notT = ModelQuestions::themes();
        $data = [];
        end($result);
        for ($i = 0; $i <= key($result); $i++) {
            if (!empty($result[$i])) {
                foreach ($notT as $v) {
                    if ($v['id'] == $i) {
                        $data[] = [
                            'id' => $v['id'],
                            'count' => $result[$i]
                        ];
                    }
                }
            }
        }
        return $data;
    }
/*
// Получим количество вопросов в теме, сколько опубликовано и сколько без ответа
    function countQuestions()
    {
        $questions = ModelQuestions::questions();
        $theme = ModelQuestions::themes();
        $data = [];
        foreach ($theme as $th) {
            foreach ($questions as $key => $question) {
                if ($th['id'] == $question['theme_id']) {
                    $data['allQuestions'] = $key;
                }
                if ($th['id'] == $question['theme_id'] && $question['status'] == 'Опубликован') {
                    $data['publishedQuestions'] = $key;
                }
                if ($th['id'] == $question['theme_id'] && $question['answer'] == null) {
                    $data['notAnsweredQuestions'] = count($question);
                }
            }
        }
        return $data;
    }
*/
    /*
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

*/
}

