<?php
require '../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/', function () {
    echo 'Comming soon';
});

$app->run();