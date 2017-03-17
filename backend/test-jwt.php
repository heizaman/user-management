<?php
require_once('./JWT.php');

$key = "uDI7krWji9jw72WCmbVXiFMEz7BgMXvi37m";
$token = array(
    /*"iss" => "http://example.org",
    "aud" => "http://example.com",
    "iat" => 1356999524,
    "nbf" => 1357000000*/
    "id" => 8
);

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 */
$jwt = JWT::encode($token, $key);
print_r($jwt."  ");
$decoded = JWT::decode($jwt, $key, array('HS256'));

print_r($decoded->id);

?>
