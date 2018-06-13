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
        $data['user'] = $_POST['user'];
        $data['answer'] = $_POST['answer'];
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

// Функция глобального редактирования вопроса и ответа
    function edit()
    {
        $edit = new ModelQuestions();
        $data = [];
        $data['editQ'] = $_POST['editQ'];
        $data['editA'] = $_POST['editA'];
        $data['editU'] = $_POST['editU'];
        $data['selectTheme'] = $_POST['selectTheme'];
        $data['selectStatus'] = $_POST['selectStatus'];
        $data['questionID'] = $_POST['questionID'];
        return $data;
        $result = $edit->edit($data);
        if ($result) {
            header('Location: ../diplom/index.php?menu=themes');
        }
    }
}

