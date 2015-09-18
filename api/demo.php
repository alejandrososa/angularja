<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 15/09/2015
 * Time: 22:06
 */
include_once 'vendor/autoload.php';
use Lcobucci\JWT\Builder;

$token = (new Builder())->setIssuer('http://example.com') // Configures the issuer (iss claim)
->setAudience('http://example.org') // Configures the audience (aud claim)
->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
->setNotBefore(time() + 60) // Configures the time that the token can be used (nbf claim)
->setExpiration(time() + 3600) // Configures the expiration time of the token (nbf claim)
->set('uid', 1) // Configures a new claim, called "uid"
->set('role', 'admin') // Configures a new claim, called "uid"
->getToken(); // Retrieves the generated token


$token->getHeaders(); // Retrieves the token headers
$token->getClaims(); // Retrieves the token claims

echo $token; //