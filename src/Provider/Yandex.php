<?php

declare(strict_types=1);

namespace Nikitoktok\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Yandex extends AbstractProvider
{
    /**
     * Base URL for Yandex OAuth endpoints.
     *
     * @var string
     */
    protected string $baseUrl = 'https://oauth.yandex.com';

    /**
     * Base URL for Yandex user info endpoint.
     *
     * @var string
     */
    protected string $resourceOwnerUrl = 'https://login.yandex.ru/info';

    /**
     * @return string
     */
    public function getBaseAuthorizationUrl(): string
    {
        return $this->baseUrl . '/authorize';
    }

    /**
     * @param array $params
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params): string
    {
        return $this->baseUrl . '/token';
    }

    /**
     * @param AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return $this->resourceOwnerUrl . '?format=json';
    }

    /**
     * @return array
     */
    protected function getDefaultScopes(): array
    {
        return [];
    }

    /**
     * @return string
     */
    protected function getScopeSeparator()
    {
        return ' ';
    }

    /**
     * @param string|null $token
     *
     * @return array
     */
    protected function getAuthorizationHeaders($token = null): array
    {
        if ($token === null) {
            return [];
        }

        return [
            'Authorization' => 'OAuth ' . $token,
        ];
    }

    /**
     * @param ResponseInterface $response
     * @param array|string $data
     *
     * @return void
     *
     * @throws IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data): void
    {
        $statusCode = $response->getStatusCode();
        $error = null;
        $description = null;

        if (is_array($data)) {
            $error = $data['error'] ?? null;
            $description = $data['error_description'] ?? null;
        }

        if ($statusCode >= 400 || $error !== null) {
            $message = $description ?? $error ?? 'Unknown error';

            throw new IdentityProviderException($message, $statusCode, $data);
        }
    }

    /**
     * @param array $response
     * @param AccessToken $token
     *
     * @return YandexResourceOwner
     */
    protected function createResourceOwner(array $response, AccessToken $token): YandexResourceOwner
    {
        return new YandexResourceOwner($response);
    }
}
