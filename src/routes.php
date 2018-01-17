<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->post('/login', function (Request $request, Response $response, array $args) {

    // Render index view
    return 'login';
});

$app->post('/register', function (Request $request, Response $response, array $args) {

    // Render index view
    return 'register';
});

$app->post('/forgotPasswd', function (Request $request, Response $response, array $args) {

    // Render index view
    return 'forgot';
});

$app->post('/checkUser', function (Request $request, Response $response, array $args) {

    // Render index view
    return 'checkUser';
});

$app->post('/getKey', function (Request $request, Response $response, array $args) {

    // Render index view
    return 'getKey';
});

$app->post('/setKey', function (Request $request, Response $response, array $args) {

    // Render index view
    return 'setKey';
});

$app->post('/updatePasswd', function (Request $request, Response $response, array $args) {

    // Render index view
    return 'updatePasswd';
});

$app->post('/updateInfo', function (Request $request, Response $response, array $args) {

    // Render index view
    return 'updateInfo';
});

