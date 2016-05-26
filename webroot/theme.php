<?php

// Include the essential settings.
require __DIR__ . '/config.php';

// Create services and inject into the app.
$di = new \Anax\DI\CDIFactoryDefault();

$di->set('CommentController', function () use ($di) {
    $controller = new Phpmvc\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

$app = new \Anax\Kernel\CAnax($di);

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_theme.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

$app->router->add('', function () use ($app) {
    $app->theme->setTitle("Om mig");

    $content = $app->fileContent->get('theme.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
        'byline'  => $byline,
    ]);
});

$app->router->add('test', function () use ($app) {

    $app->theme->setTitle("test");

    $content = $app->fileContent->get('../../webroot/css/anax-grid/typography.html');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $app->views->addString($content, 'main')
               ->addString($content, 'sidebar');

});

$app->router->add('regioner', function () use ($app) {
 
    $app->theme->addStylesheet('css/anax-grid/regions_demo.css');
    $app->theme->setTitle("Regioner");
 
    $app->views->addString('flash', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString('main', 'main')
               ->addString('sidebar', 'sidebar')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');
 
});

$app->router->handle();
$app->theme->render();
