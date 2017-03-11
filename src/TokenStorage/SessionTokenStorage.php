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

    public function __construct(Session $session, $namespace = self::SESSION_NAMESPACE)
    {
        $this->session = $session->getSection($namespace);
    }

    /**
     * {@inheritdoc}
     */
    public function getToken($tokenId)
    {
        if (!isset($this->session[$tokenId])) {
            throw new TokenNotFoundException("The CSRF token with ID '$tokenId' does not exist.");
        }

        return (string) $this->session[$tokenId];
    }

    /**
     * {@inheritdoc}
     */
    public function setToken($tokenId, $token)
    {
        $this->session[$tokenId] = (string) $token;
    }

    /**
     * {@inheritdoc}
     */
    public function hasToken($tokenId)
    {
        return isset($this->session[$tokenId]);
    }

    /**
     * {@inheritdoc}
     */
    public function removeToken($tokenId)
    {
        $token = isset($this->session[$tokenId]) ? (string) $this->session[$tokenId] : null;
        unset($this->session[$tokenId]);

        return $token;
    }
}
