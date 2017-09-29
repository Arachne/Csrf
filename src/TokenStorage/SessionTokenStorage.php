<?php

namespace Arachne\Csrf\TokenStorage;

use Nette\Http\Session;
use Nette\Http\SessionSection;
use Symfony\Component\Security\Csrf\Exception\TokenNotFoundException;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class SessionTokenStorage implements TokenStorageInterface
{
    /**
     * Session section name.
     */
    const SESSION_NAMESPACE = 'Arachne.Csrf.SessionTokenStorage';

    /**
     * @var SessionSection
     */
    private $session;

    public function __construct(Session $session, string $namespace = self::SESSION_NAMESPACE)
    {
        $this->session = $session->getSection($namespace);
    }

    /**
     * {@inheritdoc}
     */
    public function getToken($tokenId): string
    {
        if (!isset($this->session[$tokenId])) {
            throw new TokenNotFoundException(sprintf('The CSRF token with ID "%s" does not exist.', $tokenId));
        }

        return $this->session[$tokenId];
    }

    /**
     * {@inheritdoc}
     */
    public function setToken($tokenId, $token): void
    {
        $this->session[$tokenId] = $token;
    }

    /**
     * {@inheritdoc}
     */
    public function hasToken($tokenId): bool
    {
        return isset($this->session[$tokenId]);
    }

    /**
     * {@inheritdoc}
     */
    public function removeToken($tokenId): ?string
    {
        $token = isset($this->session[$tokenId]) ? $this->session[$tokenId] : null;
        unset($this->session[$tokenId]);

        return $token;
    }
}
