<?php
return array(
    'jwt' => array(
        //bin2hex(random_bytes(64))
        'key'       => '62f638a43084dd2428068925b0e9b6b68c1053a4e40aa236402a556f1b9fc4e761ae24e075342284dc9ed69fdb66900411aca0425faee76393c78ef1a65018f2',
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