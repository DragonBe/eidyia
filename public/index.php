<?php
require '../vendor/autoload.php';
require '../src/autoload.php';
use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// homepage
$app->get('/', function () use ($app) {
    return $app['twig']->render('main.twig');
});

// about page
$app->get('/about', function () use ($app) {
    return $app['twig']->render('about.twig');
});

$app->post('/check', function (Request $request) use ($app) {
    $screenName = $request->get('screenName');

    return $app->redirect('/twitter/' . $screenName);
});

// the twitter list page
$app->get('/twitter/{screenName}', function ($screenName) use ($app) {

    $twitter = new Eidyia\Service\Twitter();
    $elements = $twitter->getList($screenName);

    return $app['twig']->render('twitter.twig', array(
        'screenName' => $screenName,
        'elements' => $elements,
    ));
});

$app->run();