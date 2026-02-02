# Yandex ID OAuth2 Provider

Yandex ID provider for `league/oauth2-client`.

## Installation

```bash
composer require nikitoktok/oauth2-yandex-id
```

## Usage (Authorization Code)

```php
<?php

use Nikitoktok\Provider\Yandex;

$provider = new Yandex([
    'clientId' => 'your-client-id',
    'clientSecret' => 'your-client-secret',
    'redirectUri' => 'https://example.com/oauth/callback',
]);

$authorizationUrl = $provider->getAuthorizationUrl([
    // Example scopes:
    // 'scope' => ['login:info', 'login:email', 'login:avatar'],
]);

$state = $provider->getState();
// Store $state in session and redirect to $authorizationUrl
```

After redirect:

```php
<?php

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

// $_GET['state'] must match the stored $state
// $_GET['code'] is returned by Yandex

try {
    $accessToken = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code'],
    ]);

    $resourceOwner = $provider->getResourceOwner($accessToken);

    $yandexId = $resourceOwner->getId();
    $email = $resourceOwner->getEmail();
    $avatarUrl = $resourceOwner->getAvatarUrl();
} catch (IdentityProviderException $e) {
    // Error while fetching token or user info
}
```

## Endpoints

- Authorization URL: `https://oauth.yandex.com/authorize`
- Token URL: `https://oauth.yandex.com/token`
- User info: `https://login.yandex.ru/info?format=json`

## Notes

- User info requests are sent with the `Authorization: OAuth <token>` header (the recommended method by Yandex).

## Scopes / permissions

Yandex ID uses permissions (scopes) configured for the OAuth app.
Typical scopes seen in examples: `login:info`, `login:email`, `login:avatar`.
Verify the available permissions for your app in the Yandex console.

## ResourceOwner helpers

- `getId()`
- `getLogin()`
- `getDisplayName()`
- `getFirstName()` / `getLastName()` / `getRealName()`
- `getEmail()` / `getEmails()`
- `getGender()` / `getBirthday()`
- `getDefaultPhone()`
- `getAvatarId()` / `getAvatarUrl()` / `isAvatarEmpty()`
- `getPsuid()`
- `toArray()`

## License

MIT
