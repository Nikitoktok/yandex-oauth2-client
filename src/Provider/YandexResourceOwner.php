<?php

declare(strict_types=1);

namespace Nikitoktok\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class YandexResourceOwner implements ResourceOwnerInterface
{
    /**
     * @var array
     */
    protected array $response;

    /**
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        if (isset($this->response['id'])) {
            return (string) $this->response['id'];
        }

        if (isset($this->response['uid'])) {
            return (string) $this->response['uid'];
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getLogin(): ?string
    {
        return $this->response['login'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getDisplayName(): ?string
    {
        return $this->response['display_name'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->response['first_name'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->response['last_name'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getRealName(): ?string
    {
        return $this->response['real_name'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->response['default_email'] ?? $this->response['email'] ?? null;
    }

    /**
     * @return array|null
     */
    public function getEmails(): ?array
    {
        return $this->response['emails'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getBirthday(): ?string
    {
        return $this->response['birthday'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->response['sex'] ?? $this->response['gender'] ?? null;
    }

    /**
     * @return array|null
     */
    public function getDefaultPhone(): ?array
    {
        return $this->response['default_phone'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getAvatarId(): ?string
    {
        return $this->response['default_avatar_id'] ?? $this->response['avatar_id'] ?? null;
    }

    /**
     * @return bool|null
     */
    public function isAvatarEmpty(): ?bool
    {
        return $this->response['is_avatar_empty'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getPsuid(): ?string
    {
        return $this->response['psuid'] ?? null;
    }

    /**
     * @param string|null $size
     *
     * @return string|null
     */
    public function getAvatarUrl(?string $size = null): ?string
    {
        $avatarId = $this->getAvatarId();
        if ($avatarId === null) {
            return null;
        }

        $sizeValue = $size ?? 'islands-200';

        return 'https://avatars.yandex.net/get-yapic/' . $avatarId . '/' . $sizeValue;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->response;
    }
}
