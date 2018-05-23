<?php
session_start();

require_once './controller/controllerAdmin.php';
require_once './model/modelAdmin.php';
require_once './controller/controllerQuestions.php';
require_once './model/modelQuestions.php';
require_once './controller/controllerTwig.php';

class Di
{
    static function pdo()
    {
        include 'config.php';
        $pdo = new PDO($link, $user, $password, $options);
        return $pdo;
    }
}


$sqlAdmins = "CREATE TABLE IF NOT EXISTS `admins` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`login` varchar (100) NOT NULL,
`password` varchar (100) NOT NULL,
PRIMARY KEY (`id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;";
Di::pdo()->exec($sqlAdmins);

$sqlThemes = "CREATE TABLE IF NOT EXISTS `themes` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`theme` text NOT NULL,
PRIMARY KEY (`id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;";
Di::pdo()->exec($sqlThemes);

$sqlQuestions = "CREATE TABLE IF NOT EXISTS `questions` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`question` text NOT NULL,
`theme_id` int (11) NOT NULL,
`user` varchar (100) NOT NULL,
`email` varchar (100) NOT NULL,
`date_question` datetime NOT NULL,
`status` enum('Ожидает ответа','Опубликован','Скрыт') NOT NULL,
`answer` text NOT NULL,
`admin` varchar (100) NOT NULL,
`date_answer` datetime NOT NULL,
PRIMARY KEY (`id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;";
Di::pdo()->exec($sqlQuestions);





?>