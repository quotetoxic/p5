<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/login/', function (Request $request, Response $response, array $args) {

    // Render index view
    return 'login';
});