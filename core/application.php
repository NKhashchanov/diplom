<?php
session_start();
require_once 'config.php';
require_once './controller/controllerAdmin.php';
require_once './model/modelAdmin.php';
require_once './controller/controllerTwig.php';

$pdo = new PDO($link, $user, $password, $options);

$sqlAdmins = "CREATE TABLE IF NOT EXISTS `admins` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`login` varchar (100) NOT NULL,
`password` varchar (100) NOT NULL,
PRIMARY KEY (`id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$pdo->exec($sqlAdmins);

$sqlThemes = "CREATE TABLE IF NOT EXISTS `themes` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`theme` text NOT NULL,
PRIMARY KEY (`id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$pdo->exec($sqlThemes);

$sqlQuestions = "CREATE TABLE IF NOT EXISTS `questions` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`question` text NOT NULL,
`theme_id` int (11) NOT NULL,
`user` varchar (100) NOT NULL,
`date_question` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`status` enum('Ожидает ответа','Опубликован','Скрыт') NOT NULL,
`answer` text NOT NULL,
`admin` varchar (100) NOT NULL,
`date_answer` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$pdo->exec($sqlQuestions);





?>