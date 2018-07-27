<?php

declare(strict_types=1);

namespace Tests\Integration;

use Arachne\Codeception\Module\NetteDIModule;
use Arachne\Csrf\TokenStorage\SessionTokenStorage;
use Codeception\Test\Unit;
use Symfony\Component\Security\Csrf\Exception\TokenNotFoundException;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class SessionTokenStorageTest extends Unit
{
    /**
     * @var NetteDIModule
     */
    protected $tester;

    /**
     * @var SessionTokenStorage
     */
    private $storage;

    public function _before(): void
    {
        /** @var SessionTokenStorage $storage */
        $storage = $this->tester->grabService(TokenStorageInterface::class);
        self::assertInstanceOf(SessionTokenStorage::class, $storage);
        $this->storage = $storage;
    }

    public function testMethods(): void
    {
        self::assertFalse($this->storage->hasToken('tokenId'));
        $this->storage->setToken('tokenId', 'tokenValue');
        self::assertTrue($this->storage->hasToken('tokenId'));
        self::assertSame('tokenValue', $this->storage->getToken('tokenId'));
        self::assertTrue($this->storage->hasToken('tokenId'));
        self::assertSame('tokenValue', $this->storage->removeToken('tokenId'));
        self::assertFalse($this->storage->hasToken('tokenId'));
        self::assertNull($this->storage->removeToken('tokenId'));
    }

    public function testException(): void
    {
        try {
            $this->storage->getToken('tokenId');
            self::fail();
        } catch (TokenNotFoundException $exception) {
            self::assertSame('The CSRF token with ID "tokenId" does not exist.', $exception->getMessage());
        }
    }
}
