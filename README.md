# Mondo Provider for OAuth 2.0 Client

This package provides Mondo OAuth 2.0 support for the PHP League's 
[OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```bash
composer require edcs/oauth2-mondo
```

### Authorization Code Flow

```php
$provider = new Edcs\OAuth2\Client\Provider\Mondo([
    'clientId'     => '{your-client-id}',
    'clientSecret' => '{your-client-secret}',
    'redirectUri'  => 'http://localhost:8000/',
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);
    
    // Now you can do something useful with the access token.
    var_dump($token);

    // Optional: Store the token in the session so we can refresh the page while we're testing
    $_SESSION['access_token'] = [
        'access_token' => $token->getToken(),
        'expires' => $token->getExpires(),
        'refresh_token' => $token->getRefreshToken(),
        'resource_owner_id' => $token->getResourceOwnerId()
    ];

    // Optional: Now you have a token you can look up a users profile data
    echo 'Now visit <a href="user.php">this page</a>.';
}
```


## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/edcs/oauth2-mondo/blob/master/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](https://github.com/edcs/oauth2-mondo/blob/master/LICENSE) for 
more information.
