<?php
// Include the essential settings.
require __DIR__ . '/config_with_app.php';

//$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

if($app->session->has(\Anax\User\User::$loginSession)) {
    $app->navbar->configure(ANAX_APP_PATH . 'config/navbar_logout.php');
}

//Sätter titel i headern.
$app->theme->setSiteTitle("Allt om spel");
$app->theme->setSiteTagline("Ett forum för alla");

$app->router->add('setup', function() use ($di) { 
    
    $t2q = new \Anax\Tags\TagToQuestion();
    $q = new \Anax\Questions\Questions();
    $t = new \Anax\Tags\Tags();
    $u = new \Anax\User\User();
    $a = new \Anax\Answers\Answers();
    $c = new \Anax\Comments\Comments();

    $t->setDI($di);
    $q->setDI($di);
    $u->setDI($di);
    $a->setDI($di);
    $c->setDI($di);
    $t2q->setDI($di);

    $t2q->dropTable();
    $t->setup();
    $q->setup();
    $u->setup();
    $a->setup();
    $c->setup();
    $t2q->setup();

    /*$app->TagsController->dropTable();
    $app->UserController->setupAction();
    $app->QuestionsController->setupAction();
    $app->AnswersController->setupAction();
    $app->CommentsController->setupAction();
    $app->TagsController->setupAction();*/
    //$app->QuestionsController->listAction();
});

$app->router->add('', function () use ($app) {
    $app->theme->setTitle("Hem");

    $latestQuestions = $app->QuestionsController->getLatestQuestions(3);
    $popularTags = $app->TagsController->getPopularTags(3);
    $activeUsers = $app->UserController->getMostActiveUsers(3);

    $app->views->add('questions/question', [
        'questions' => $latestQuestions,
    ]);
    $app->views->add('tags/popular', [
        'tags' => $popularTags,
        'title' => 'Populäraste taggarna'
    ], 'sidebar');
    $app->views->add('user/active', [
        'users' => $activeUsers,
        'title' => 'Mest aktiva användare'
    ], 'sidebar');

    $app->theme->setVariable('main', "<div id='textHeader'>Välkommen</div>
                <p>Välkommen till allt om spel. Detta är ett forum för alla tyer av gamers, från den vana PC-gamern till en vardags-gamer. Alla är välkommna!</p>
                ");
});

$app->router->add('login', function() use ($app) {
    
    $form = $app->UserController->loginAction();
    // Prepare the page content
    $app->theme->setVariable('title', "Logga in")
               ->setVariable('pageheader', "<div class='pageheader'><h1>Logga in</h1></div>")
               ->setVariable('main', "
            <h1>Logga in</h1>
            <p>" . $form . "</p>
        "); 
});

// Logout page 
$app->router->add('logout', function() use ($app) {
    
    $app->UserController->logoutAction();
    $form = $app->UserController->loginAction();
    // Prepare the page content
    $app->theme->setVariable('title', "Utloggad")
               ->setVariable('pageheader', "<div class='pageheader'><h1>Utloggad</h1></div>")
               ->setVariable('main', "
            <h1>Logga in</h1>
            <p>" . $form . "</p>
        "); 
});


// Register page 
$app->router->add('register', function() use ($app) {
    
    $form = $app->UserController->registerAction();

    // Prepare the page content
    $app->theme->setVariable('title', "Registrera ny användare")
               ->setVariable('pageheader', "<div class='pageheader'><h1>Registrera ny användare</h1></div>")
               ->setVariable('main', "
            <h1>Register</h1>
            <p>" . $form . "</p>
        ");
 
});

$app->router->add('about', function () use ($app) {
    $app->theme->setTitle("Om");
});

$app->router->handle();
$app->theme->render();