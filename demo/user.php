<?php

session_start();

include '../vendor/autoload.php';

$provider = new Edcs\OAuth2\Client\Provider\Mondo([
    'clientId'     => '{your-client-id}',
    'clientSecret' => '{your-client-secret}',
    'redirectUri'  => 'http://localhost:8000/',
]);

$token = new \League\OAuth2\Client\Token\AccessToken($_SESSION['access_token']);

$resourceOwner = $provider->getResourceOwner($token);

?>

<table>
    <thead>
        <tr>
            <th>Thing</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Resource Owner ID</td>
            <td><?=$resourceOwner->getId() ?></td>
        </tr>
    </tbody>
</table>

<a href="index.php">Start Over</a>
