<?php

use Slim\Http\Request;
use Slim\Http\Response;

include 'functions.php';

// Routes

$app->post('/login', function (Request $request, Response $response, array $args) {
    $parsedBody = $request->getParsedBody();
    // Render index view
    return json_encode($parsedBody);
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
    if ($request->hasHeader('Authorization')) {
        // Do something
        return json_encode(['check token'=>'needed']);
    } else {
        return json_encode(['token required'=>'error']);
    }
    // Render index view

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

