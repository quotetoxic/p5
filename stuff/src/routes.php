<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;
use Tuupola\Base62;

 
$app->post("/login",  function ($request, $response, $args) use ($container){
 
  	$requested_scopes = $request->getParsedBody() ?: [];
 
    $now = new DateTime();
    $future = new DateTime("+1 day");
    $server = $request->getServerParams();
    $jti = (new Base62)->encode(random_bytes(16));
    $payload = [
        "iat" => $now->getTimeStamp(),
        "exp" => $future->getTimeStamp(),
        "jti" => $jti,
        "sub" => $server["PHP_AUTH_USER"]
    ];
    $secret = "tHaT1_2iS_tHe3_4MoSt_HaRd5_6SeCrEt7_8To_9GuEsS_P5";
    $token = JWT::encode($payload, $secret, "HS256");
    $data["token"] = $token;
    $data["expires"] = $future->getTimeStamp();
    return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
 
$app->get("/secure",  function ($request, $response, $args) {
 
    $data = ["status" => 1, 'msg' => "This route is secure!"];
 
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
 
$app->get("/not-secure",  function ($request, $response, $args) {
 
    $data = ["status" => 1, 'msg' => "No need of token to access me"];
 
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});
 
$app->post("/formData",  function ($request, $response, $args) {
    $data = $request->getParsedBody();
 
    $result = ["status" => 1, 'msg' => $data];
 
    // Request with status response
    return $this->response->withJson($result, 200);
});

$app->get("/verify",  function ($request, $response, $args) {
    $data = $request->getParams();
 
    return $data['email'] . ' - ' . $data['key'];
});
 
 
$app->post('/register', function ($request, $response, $args) {
    global $db;
    $data = $request->getParams();
    $hash = md5(generateRandomString());
    $query = 'INSERT INTO users (email, pass, phone, hash, active)
              VALUES ("'.$data['email'].'","'.$data['pass'].'","'.$data['phone'].'","'.$hash.'",0);';
    $result = $db->query($query);

    if ($result) {
        sendConfirmationEmail($data['email'], $hash);
        return $response->withStatus(200);
    } else {
        return $response->withStatus(400);
    }

});

function generateRandomString() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 15; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
		$randomString .= '_';
    return $randomString;
}

function sendConfirmationEmail($email, $hash) {
        // Multiple recipients
        $to = $email; // note the comma

        // Subject
        $subject = 'Verify your identity';

        // Message
        $message = '
        <html>
        <head>
        <title>Verify your identity</title>
        </head>
        <body>
        <p>Welcome to our secure messaging app! Please, verify your email by visiting the link bellow:<br><br>
        <a href="http://p5.tritian.com/api/verify/?email='.$email.'&key='.$hash.'"><b>VERIFY MY EMAIL</b></a>
        </p>
        </body>
        </html>
        ';

        // To send HTML mail, the Content-type header must be set
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        // Mail it
        mail($to, $subject, $message, implode("\r\n", $headers));
}