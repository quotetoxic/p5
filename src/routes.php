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
    $query = 'SELECT * FROM users WHERE email="'.$data['email'].'" AND pass="'.$data['passwd'].'"';
    $result = $mysqli->query($query);

    if ($result->num_rows == null) {
        $error = "Incorrect login/password! Please, try again...";
        return $this->response->withStatus(403)->withHeader('Content-type', 'application/json')->withJson(array('error' => $error));
    } else {
        $user = $result->fetch_assoc();

        if($user['is_active'] == 0) {
            $error = "Please, verify your email first!";
            return $this->response->withStatus(403)->withHeader('Content-type', 'application/json')->withJson(array('error' => $error));
        } else {
            unset($user['pass']);
            $exp = intval(time()) + (60*60*24);
            $jwtPayload = [      
                "email" => $user['email'],
                "exp" => $exp
                ];
            $user['jwt'] = createJWT($jwtPayload);
            return json_encode($user);
        }
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
    $result = isAuthorised($request);
    if ($result == "OK") {
        require_once 'dbconnect.php';
        $data = $request->getParsedBody();
        $query = 'SELECT id, tl_id FROM users WHERE tl_id='.intval($data['tl_id']);
        $result = $mysqli->query($query);
        if ($result->num_rows == null) {
            return $this->response->withStatus(403)->withHeader('Content-type', 'application/json')->withJson(array('error' => 'not exist'));
        } else {
            return $this->response->withStatus(200)->withHeader('Content-type', 'application/json')->withJson(array('OK' => 'user exist'));
        }
    } else {
        $error = $result;
        return $this->response->withStatus(403)->withHeader('Content-type', 'application/json')->withJson(array('error' => $error));
    }
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

$app->post('/updatePersonalInfo', function (Request $request, Response $response, array $args) {

    // Render index view
    return 'updateInfo';
});

$app->post('/updateTLInfo', function (Request $request, Response $response, array $args) {
    $result = isAuthorised($request);
    if ($result == "OK") {
        require_once 'dbconnect.php';
        $data = $request->getParsedBody();
        $query = 'UPDATE users SET tl_id='.intval($data['tl_id']).' WHERE email="'.$data['email'].'"';
        $result = $mysqli->query($query);
        if ($result) {
            return $this->response->withStatus(200)->withHeader('Content-type', 'application/json')->withJson(array('OK' => 'updated'));
        } else {
            return $this->response->withStatus(403)->withHeader('Content-type', 'application/json')->withJson(array('error' => 'server error'));
        }
    } else {
        $error = $result;
        return $this->response->withStatus(403)->withHeader('Content-type', 'application/json')->withJson(array('error' => $error));
    }
});

