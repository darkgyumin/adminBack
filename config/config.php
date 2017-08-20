<?php
return array(
    'jwt' => array(
        'key'       => 'dj95o2BW4iQjkL75kWVFDgf7gFfFenA06hqYS96+SJJKuAuftaHhynJrEt14aKcc0A86V5zQysBDS5HF0OKszw==',	// Key for signing the JWT's, I suggest generate it with base64_encode(openssl_random_pseudo_bytes(64))
        'algorithm' => 'HS512' // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
    ),
    'database' => array(
        'user'     => 'root', // Database username
        'password' => 'admin', // Database password
        'host'     => 'localhost', // Database host
        'name'     => 'admin', // Database schema name
    ),
    'serverName' => 'localhost',
);