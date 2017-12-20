<?php

// Configuration for the RSA keys
$keysConfig = array(
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

// Encryption of the secret to the $encryptedSecret using the public key
openssl_public_encrypt($data, $encryptedSecret, $publicKey);

// Decryption of the secret to the $decryptedSecret using the private key
openssl_private_decrypt($encrypted, $decryptedSecret, $privateKey);
