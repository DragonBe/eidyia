<?php
require '../vendor/autoload.php';

use Eidyia\Service;

$app = new Silex\Application();

$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello '.$app->escape($name);
});
$app['autoloader']->registerNamespace('Eidyia','../src');

$app->run();