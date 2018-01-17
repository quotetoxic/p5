<?php

function createJWT($payload) {
    // base64 encodes the header json
    $encoded_header = base64_encode('{"alg": "HS256","typ": "JWT"}');

    // base64 encodes the payload json
    $encoded_payload = base64_encode(json_encode($payload));

    // base64 strings are concatenated to one that looks like this
    $header_payload = $encoded_header . '.' . $encoded_payload;

    //Setting the secret key
    $secret_key = 'MegaP5SuperSecretChatTelegam!KeyAASDSxsknlnkendksjxanQWDSA#203-04JAX';

    // Creating the signature, a hash with the s256 algorithm and the secret key. The signature is also base64 encoded.
    $signature = base64_encode(hash_hmac('sha256', $header_payload, $secret_key, true));

    // Creating the JWT token by concatenating the signature with the header and payload, that looks like this:
    $jwt_token = $header_payload . '.' . $signature;

    //listing the resulted  JWT
    return $jwt_token;
}

function isJWTok($jwt) {
    $recievedJwt = $jwt;

    $secret_key = 'MegaP5SuperSecretChatTelegam!KeyAASDSxsknlnkendksjxanQWDSA#203-04JAX';

    // Split a string by '.' 
    $jwt_values = explode('.', $recievedJwt);

    // extracting the signature from the original JWT 
    $recieved_signature = $jwt_values[2];

    // concatenating the first two arguments of the $jwt_values array, representing the header and the payload
    $recievedHeaderAndPayload = $jwt_values[0] . '.' . $jwt_values[1];

    //check exp param
    $payload = json_decode(base64_decode($jwt_values[1]));
    if (intval($payload[2]) < intval(time())) {
        $isExpOK = true;
    } else {
        $isExpOK = false;
    }

    // creating the Base 64 encoded new signature generated by applying the HMAC method to the concatenated header and payload values
    $resultedsignature = base64_encode(hash_hmac('sha256', $recievedHeaderAndPayload, $secret_key, true));

    // checking if the created signature is equal to the received signature
    if($resultedsignature == $recieved_signature) {
        if ($isExpOK) {
            return true;
        } else {
            return "Access token expired! Please, login again!";
        }
    } else {
        return "Token signature invalid";
    }
}

function isAuthorised($request) {
    if($request->hasHeader('Authorization')) {
        $headerValue = $request->getHeaderLine('Authorization');
        $headerParts = explode(" ", $headerValue);
        if ($headerParts[0]=="Bearer") {
            $jwt = $headerParts[1];
            if ($result = isJWTok($jwt)) {
                return true;
            } else {
                return $result;
            }
        } else {
            return "Wrong auth method!";
        }
        return true;
    } else {
        return "Request is not authorised!";
    }
}