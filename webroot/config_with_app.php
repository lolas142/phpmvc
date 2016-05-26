<?php
/**
 * Config file for pagecontrollers, creating an instance of $app.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config.php'; 

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryDefault();
$app = new \Anax\Kernel\CAnax($di);

$di->set('CommentController', function () use ($di) {
    $controller = new Phpmvc\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

$di->set('UserController', function () use ($di) {
    $controller = new \Anax\User\UserController();
    $controller->setDI($di);
    return $controller;
});

// Add UserController to framework
$di->set('UserController', function() use ($di) {
    $controller = new \Anax\User\UserController();
    $controller->setDI($di);
    return $controller;
});

// Add QuestionsController to framework
$di->set('QuestionsController', function() use ($di) {
    $controller = new \Anax\Questions\QuestionsController();
    $controller->setDI($di);
    $controller->setup();
    return $controller;
});

// Add AnswersController to framework
$di->set('AnswersController', function() use ($di) {
    $controller = new \Anax\Answers\AnswersController();
    $controller->setDI($di);
    $controller->setup();
    return $controller;
});


// Add CommentsController to framework
$di->set('CommentsController', function() use ($di) {
    $controller = new \Anax\Comments\CommentsController();
    $controller->setDI($di);
    $controller->setup();
    return $controller;
});


// Add TagsController to framework
$di->set('TagsController', function() use ($di) {
    $controller = new \Anax\Tags\TagsController();
    $controller->setDI($di);
    $controller->setup();
    return $controller;
});

$di->setShared('db', function () {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/database_mysql.php');
    $db->connect();
    return $db;
});

$di->setShared('logger', function () {
    $logger = new \Mcknubb\Log\CLogController();
    return $logger;
});
