<?php
// Application middleware
 
// e.g: $app->add(new \Slim\Csrf\Guard);
// Adding dependencies
 
use Tuupola\Middleware\HttpBasicAuthentication;

$container = $app->getContainer();
$container['logger'] = function($c) {
   $logger = new \Monolog\Logger('my_logger');
   $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
   $logger->pushHandler($file_handler);
   return $logger;
};

$container["jwt"] = function ($container) {
   return new StdClass;
};

$app->add(new \Slim\Middleware\JwtAuthentication([
"path" => "/",
   "logger" => $container['logger'],
   "secret" => "123456789helo_secret",
   "rules" => [
       new \Slim\Middleware\JwtAuthentication\RequestPathRule([
           "path" => "/",
           "passthrough" => ["/register", "/not-secure", "/verify", "/login"]
       ])
   ],
   "callback" => function ($request, $response, $arguments) use ($container) {
       $container["jwt"] = $arguments["decoded"];
   },
   "error" => function ($request, $response, $arguments) {
       $data["status"] = "error";
       $data["message"] = $arguments["message"];
       return $response
           ->withHeader("Content-Type", "application/json")
           ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
   }
]));

$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    "path" => "/secure",
    "secure" => false,
    "users" => [
        "root" => "t00r",
        "somebody" => "passw0rd"
    ]
]));


$app->add(new \Tuupola\Middleware\Cors([
   "logger" => $container["logger"],
   "origin" => ["*"],
   "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
   "headers.allow" => ["Authorization", "If-Match", "If-Unmodified-Since"],
   "headers.expose" => ["Authorization", "Etag"],
   "credentials" => true,
   "cache" => 60,
   "error" => function ($request, $response, $arguments) {
       return new UnauthorizedResponse($arguments["message"], 401);
   }
]));