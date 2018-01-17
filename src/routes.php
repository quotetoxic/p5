<?php

use Slim\Http\Request;
use Slim\Http\Response;

include 'functions.php';

// Routes

$app->post('/login', function (Request $request, Response $response, array $args) {
    $data = $request->getParsedBody();

    if (!isset($data['email']) || !isset($data['passwd'])) {
        $error = "There is mistake in your request!";
        return $this->response->withStatus(403)->withHeader('Content-type', 'application/json')->withJson(array('error' => $error));
    }

    if ($data['email']=="" || $data['passwd']=="") {
        $error = "There is mistake in your request!";
        return $this->response->withStatus(403)->withHeader('Content-type', 'application/json')->withJson(array('error' => $error));
    }

    require_once 'dbconnect.php';
    $query = 'SELECT * FROM users WHERE email='.$data['email'].' AND pass='.$data['passwd'].'';
    $result = $mysqli->query($query);

    if ($result) {
        return json_encode(['logged'=>'in']);
    } else {
        $error = "Incorrect login/password! Please, try again...";
        return $this->response->withStatus(403)->withHeader('Content-type', 'application/json')->withJson(array('error' => $error));
    }
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

