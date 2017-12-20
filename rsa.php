<?php

// Configuration for the RSA keys
$keysConfig = array(
    "digest_alg" => "sha512",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);

//Keys generation
$keys = openssl_pkey_new($config); 

//Extraction of the private key to the $privateKey variable
openssl_pkey_export($keys, $privateKey); 

// Extraction of the public key to the $publicKey variable
$publicKey = openssl_pkey_get_details($keys);
$publicKey = $publicKey['key'];
echo("Public key:\n");
echo $publicKey;
echo("\nPrivate key:\n");
echo $privateKey['key'];
echo("\n");
$data = 'hello';

// Encrypt the data to $encrypted using the public key
openssl_public_encrypt($data, $encrypted, $publicKey);
echo base64_encode($encrypted);

// Decrypt the data using the private key and store the results in $decrypted
openssl_private_decrypt($encrypted, $decrypted, $privateKey);

echo $decrypted;